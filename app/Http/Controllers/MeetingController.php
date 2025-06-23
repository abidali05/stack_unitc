<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Email;
use App\Models\Media;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class MeetingController extends Controller
{
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;

    public function __construct()
    {
        $this->clientId = config('setting.zoom.client_id');
        $this->clientSecret = config('setting.zoom.client_secret');
        $this->redirectUri = config('setting.zoom.redirect_uri');
    }

    public function authorizeZoom()
    {
        $authUrl = 'https://zoom.us/oauth/authorize?' . http_build_query([
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => route('zoom.callback'),
        ]);

        return redirect($authUrl);
    }

    public function handleCallback(Request $request)
    {
        $response = Http::asForm()
            ->withHeaders([
                'Authorization' => 'Basic ' . base64_encode("{$this->clientId}:{$this->clientSecret}"),
            ])
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'authorization_code',
                'code' => $request->code,
                'redirect_uri' => route('zoom.callback'),
            ]);

        $data = $response->json();

        if (isset($data['access_token'])) {
            Session::put('zoom_access_token', $data['access_token']);
            Session::put('zoom_refresh_token', $data['refresh_token']);
            return redirect()->route('meetings.index');
        }

        return back()->with('error', 'Zoom authorization failed.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();

        $emails = Email::with('receiver')->where('receiver_id', $userId)->get();
        $media = Media::where('user_id', $userId)->get();
        $users = User::get();

        $accessToken = Session::get('zoom_access_token');
        $refreshToken = Session::get('zoom_refresh_token');

        if (!$accessToken || !$refreshToken) {
            return redirect()->route('zoom.authorize')->with('error', 'Zoom not authorized.');
        }

        $meetings = [];

        // 1. Get meetings hosted by the user
        $hostedMeetingsResponse = Http::withToken($accessToken)
            ->get("https://api.zoom.us/v2/users/me/meetings");

        if ($hostedMeetingsResponse->successful()) {
            foreach ($hostedMeetingsResponse->json()['meetings'] as $meeting) {
                $meetings[] = $this->addMeetingStatus($meeting);
            }
        }

        // 2. Get meetings assigned to the user
        $assignedMeetingIds = DB::table('zoom_meeting_users')
            ->where('user_id', $userId)
            ->pluck('zoom_meeting_id')
            ->toArray();

        // Avoid duplication: filter out meetings already in $meetings
        $existingIds = collect($meetings)->pluck('id')->toArray();

        foreach ($assignedMeetingIds as $meetingId) {
            if (in_array($meetingId, $existingIds)) continue;

            $response = Http::withToken($accessToken)
                ->get("https://api.zoom.us/v2/meetings/{$meetingId}");

            if ($response->status() === 401) {
                $tokenResponse = Http::asForm()->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode(config('services.zoom.client_id') . ':' . config('services.zoom.client_secret')),
                ])->post('https://zoom.us/oauth/token', [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                ]);

                if ($tokenResponse->successful()) {
                    $tokens = $tokenResponse->json();
                    Session::put('zoom_access_token', $tokens['access_token']);
                    Session::put('zoom_refresh_token', $tokens['refresh_token']);
                    $accessToken = $tokens['access_token'];

                    $response = Http::withToken($accessToken)
                        ->get("https://api.zoom.us/v2/meetings/{$meetingId}");
                } else {
                    continue;
                }
            }

            if ($response->successful()) {
                $meetings[] = $this->addMeetingStatus($response->json());
            }
        }
        // dd($meetings);
        return view('pages.meeting', compact('emails', 'media', 'meetings', 'users'));
    }

    /**
     * Add readable status to a meeting (waiting, started, ended)
     */
    private function addMeetingStatus(array $meeting)
    {
        if (isset($meeting['start_time']) && isset($meeting['duration'])) {
            $start = Carbon::parse($meeting['start_time'])->timezone(config('app.timezone', 'Asia/Karachi'));
            $end = $start->copy()->addMinutes($meeting['duration']);
            $now = Carbon::now(config('app.timezone', 'Asia/Karachi'));

            if (isset($meeting['status']) && $meeting['status'] === 'cancelled') {
                $meeting['status'] = 'cancelled';
            } elseif ($now->lt($start)) {
                $meeting['status'] = 'waiting';
            } elseif ($now->between($start, $end)) {
                $meeting['status'] = 'started';
            } else {
                $meeting['status'] = 'ended'; // Assuming ended meetings are considered finished
            }
        } else {
            $meeting['status'] = 'unknown';
        }

        return $meeting;
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $accessToken = Session::get('zoom_access_token');
        $refreshToken = Session::get('zoom_refresh_token');

        if (!$accessToken || !$refreshToken) {
            return redirect()->route('zoom.authorize')->with('error', 'Zoom not authorized.');
        }

        $userTimezone = 'Asia/Karachi'; // Instead of America/Los_Angeles

        $startTime = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_time, $userTimezone);
        $startTimeUTC = $startTime->setTimezone('UTC');
        $formattedTime = $startTimeUTC->format('Y-m-d\TH:i:s\Z');


        // Define meeting payload
        $meetingPayload = [
            'topic'      => $request->topic,
            'type'       => 2,
            'start_time' => $formattedTime,
            'duration'   => (int)$request->duration,
            'agenda'     => $request->agenda,
            'settings'   => [
                'join_before_host' => true,
                'mute_upon_entry'  => true,
                'waiting_room'     => true,
            ],
        ];

        // Attempt meeting creation
        $response = Http::withToken($accessToken)->post('https://api.zoom.us/v2/users/me/meetings', $meetingPayload);

        // Refresh token if expired
        if ($response->status() === 401) {
            $newTokens = Http::asForm()->withHeaders([
                'Authorization' => 'Basic ' . base64_encode(config('services.zoom.client_id') . ':' . config('services.zoom.client_secret')),
            ])->post('https://zoom.us/oauth/token', [
                'grant_type'    => 'refresh_token',
                'refresh_token' => $refreshToken,
            ]);

            if ($newTokens->successful()) {
                $tokens = $newTokens->json();
                Session::put('zoom_access_token', $tokens['access_token']);
                Session::put('zoom_refresh_token', $tokens['refresh_token']);

                // Retry meeting creation with new token
                $response = Http::withToken($tokens['access_token'])->post('https://api.zoom.us/v2/users/me/meetings', $meetingPayload);
            } else {
                return redirect()->route('zoom.authorize')->with('error', 'Zoom session expired. Please authorize again.');
            }
        }

        // On success, store user assignments
        if ($response->successful()) {
            $meeting = $response->json(); // Contains Zoom meeting details like 'id'

            foreach ($request->user_ids as $userId) {
                DB::table('zoom_meeting_users')->insert([
                    'zoom_meeting_id' => $meeting['id'],
                    'user_id'         => $userId,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }

            return redirect()->route('meetings.index')->with('success', 'Meeting created and users assigned.');
        }

        return back()->with('error', 'Failed to create Zoom meeting.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Meeting $meeting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $users = User::all();

        $accessToken = Session::get('zoom_access_token');
        $response = Http::withToken($accessToken)->get("https://api.zoom.us/v2/meetings/{$id}");

        if ($response->successful()) {
            $meeting = $response->json();

            $assignedUserIds = DB::table('zoom_meeting_users')
                ->where('zoom_meeting_id', $id)
                ->pluck('user_id')
                ->toArray();

            return view('pages.meeting_edit', compact('meeting', 'users', 'assignedUserIds'));
        }

        return redirect()->route('meetings.index')->with('error', 'Unable to fetch meeting details.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $accessToken = Session::get('zoom_access_token');

        $userTimezone = 'Asia/Karachi'; // Instead of America/Los_Angeles

        $startTime = Carbon::createFromFormat('Y-m-d\TH:i', $request->start_time, $userTimezone);
        $startTimeUTC = $startTime->setTimezone('UTC');
        $formattedTime = $startTimeUTC->format('Y-m-d\TH:i:s\Z');

        $response = Http::withToken($accessToken)->patch("https://api.zoom.us/v2/meetings/{$id}", [
            'topic'      => $request->topic,
            'start_time' => $formattedTime,
            'duration'   => (int) $request->duration,
            'agenda'     => $request->agenda,
        ]);

        if ($response->successful()) {

            DB::table('zoom_meeting_users')->where('zoom_meeting_id', $id)->delete();

            foreach ($request->user_ids as $userId) {
                DB::table('zoom_meeting_users')->insert([
                    'zoom_meeting_id' => $id,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return redirect()->route('meetings.index')->with('success', 'Meeting updated.');
        }

        return back()->with('error', 'Failed to update meeting.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meeting $meeting)
    {
        //
    }
}
