<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Email;
use App\Models\Media;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Google\Service\Calendar as GoogleCalendar;
use Google\Service\Calendar\Event as GoogleEvent;
use Google\Service\Calendar\EventDateTime as GoogleEventDateTime;

class MeetingController extends Controller
{
    protected $client;
    protected $calendarService;

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect_uri'));
        $this->client->addScope(GoogleCalendar::CALENDAR_EVENTS);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
    }

    public function authorizeGoogle()
    {
        $authUrl = $this->client->createAuthUrl();
        return redirect($authUrl);
    }

    public function handleCallback(Request $request)
    {
        Log::info('Google OAuth Callback', [
            'query_params' => $request->all(),
            'has_code' => $request->has('code'),
            'has_error' => $request->has('error'),
        ]);



        if ($request->has('error')) {
            $error = $request->error;
            $errorDescription = $request->error_description ?? 'Unknown error';
            return redirect()->route('meetings.index')
                ->with('error', "Google authorization failed: $error - $errorDescription");
        }

        if (!$request->has('code')) {
            return redirect()->route('meetings.index')
                ->with('error', 'Authorization code not received from Google.');
        }

        try {
            $token = $this->client->fetchAccessTokenWithAuthCode($request->code);

            if (isset($token['access_token'])) {
                Session::put('google_access_token', $token['access_token']);

                // Store refresh token if provided
                if (isset($token['refresh_token'])) {
                    Session::put('google_refresh_token', $token['refresh_token']);
                }

                // Store token expiration time
                if (isset($token['expires_in'])) {
                    $expiresAt = now()->addSeconds($token['expires_in'] - 60); // 1 minute buffer
                    Session::put('google_token_expires', $expiresAt);
                }

                return redirect()->route('meetings.index')
                    ->with('success', 'Google authorization successful.');
            } else {
                $error = $token['error'] ?? 'Unknown error';
                $errorDescription = $token['error_description'] ?? 'No description';
                return redirect()->route('meetings.index')
                    ->with('error', "Failed to get access token: $error - $errorDescription");
            }
        } catch (\Exception $e) {
            return redirect()->route('meetings.index')
                ->with('error', 'Error during authentication: ' . $e->getMessage());
        }
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

        $accessToken = Session::get('google_access_token');
        $refreshToken = Session::get('google_refresh_token');

        // If not authorized, redirect to Google authorization
        if (!$accessToken) {
            return redirect()->route('google.authorize')->with('error', 'Google not authorized.');
        }

        $meetings = [];

        try {
            // Set the access token
            $this->client->setAccessToken($accessToken);

            // Create Calendar service
            $this->calendarService = new GoogleCalendar($this->client);

            // Get meetings from Google Calendar
            $calendarId = 'primary';
            $optParams = array(
                'maxResults' => 20,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date('c', strtotime('-1 month')),
                'timeMax' => date('c', strtotime('+3 months')),
            );

            $results = $this->calendarService->events->listEvents($calendarId, $optParams);
            $googleEvents = $results->getItems();

            foreach ($googleEvents as $googleEvent) {
                if ($this->isGoogleMeetEvent($googleEvent)) {
                    $meetings[] = $this->formatGoogleEvent($googleEvent);
                }
            }

            // Also get meetings from database
            $dbMeetings = Meeting::with(['user', 'participants'])
                ->where('user_id', $userId)
                ->orWhereHas('participants', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get();

            foreach ($dbMeetings as $dbMeeting) {
                $meetings[] = $this->formatDatabaseMeeting($dbMeeting);
            }
        } catch (\Exception $e) {
            // Token might be expired, try to refresh
            if ($refreshToken) {
                try {
                    $newToken = $this->client->refreshToken($refreshToken);
                    Session::put('google_access_token', $newToken['access_token']);
                    Session::put('google_refresh_token', $newToken['refresh_token'] ?? $refreshToken);

                    // Retry the request
                    return $this->index();
                } catch (\Exception $refreshException) {
                    return redirect()->route('google.authorize')->with('error', 'Session expired. Please reauthorize.');
                }
            } else {
                return redirect()->route('google.authorize')->with('error', 'Google authorization required.');
            }
        }

        return view('pages.meeting', compact('emails', 'media', 'meetings', 'users'));
    }

    /**
     * Check if event is a Google Meet event
     */
    private function isGoogleMeetEvent($event)
    {
        return !empty($event->getHangoutLink()) ||
            (strpos($event->getDescription() ?? '', 'meet.google.com') !== false);
    }

    /**
     * Format Google Calendar event for display
     */
    private function formatGoogleEvent($googleEvent)
    {
        $start = $googleEvent->getStart();
        $end = $googleEvent->getEnd();

        $startTime = $start->getDateTime() ? Carbon::parse($start->getDateTime()) : Carbon::parse($start->getDate());
        $endTime = $end->getDateTime() ? Carbon::parse($end->getDateTime()) : Carbon::parse($end->getDate());

        $duration = $startTime->diffInMinutes($endTime);

        $now = Carbon::now(config('app.timezone', 'Asia/Karachi'));

        if ($googleEvent->getStatus() === 'cancelled') {
            $status = 'cancelled';
        } elseif ($now->lt($startTime)) {
            $status = 'waiting';
        } elseif ($now->between($startTime, $endTime)) {
            $status = 'started';
        } else {
            $status = 'ended';
        }

        return [
            'id' => $googleEvent->getId(),
            'topic' => $googleEvent->getSummary(),
            'start_time' => $startTime,
            'duration' => $duration,
            'agenda' => $googleEvent->getDescription(),
            'join_url' => $googleEvent->getHangoutLink(),
            'status' => $status,
            'type' => 'google',
            'host' => $googleEvent->getCreator() ? $googleEvent->getCreator()->getEmail() : 'Unknown'
        ];
    }

    /**
     * Format database meeting for display
     */
    private function formatDatabaseMeeting($meeting)
    {
        $startTime = Carbon::parse($meeting->start_time);
        $endTime = $startTime->copy()->addMinutes($meeting->duration);
        $now = Carbon::now(config('app.timezone', 'Asia/Karachi'));

        if ($meeting->cancelled_at) {
            $status = 'cancelled';
        } elseif ($now->lt($startTime)) {
            $status = 'waiting';
        } elseif ($now->between($startTime, $endTime)) {
            $status = 'started';
        } else {
            $status = 'ended';
        }

        return [
            'id' => $meeting->id,
            'topic' => $meeting->topic,
            'start_time' => $startTime,
            'duration' => $meeting->duration,
            'agenda' => $meeting->agenda,
            'join_url' => $meeting->meeting_url,
            'status' => $status,
            'type' => 'database',
            'host' => $meeting->user->name
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $accessToken = Session::get('google_access_token');
        $refreshToken = Session::get('google_refresh_token');

        if (!$accessToken) {
            return redirect()->route('google.authorize')->with('error', 'Google not authorized.');
        }

        $request->validate([
            'topic' => 'required|string|max:255',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:1',
            'agenda' => 'nullable|string',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        try {
            $this->client->setAccessToken($accessToken);
            $this->calendarService = new GoogleCalendar($this->client);

            // Create Google Calendar event with Google Meet
            $event = new GoogleEvent([
                'summary' => $request->topic,
                'description' => $request->agenda,
                'start' => [
                    'dateTime' => Carbon::parse($request->start_time)->toRfc3339String(),
                    'timeZone' => config('app.timezone', 'Asia/Karachi'),
                ],
                'end' => [
                    'dateTime' => Carbon::parse($request->start_time)->addMinutes($request->duration)->toRfc3339String(),
                    'timeZone' => config('app.timezone', 'Asia/Karachi'),
                ],
                'conferenceData' => [
                    'createRequest' => [
                        'requestId' => uniqid(),
                        'conferenceSolutionKey' => [
                            'type' => 'hangoutsMeet'
                        ]
                    ]
                ],
                'attendees' => array_map(function ($userId) {
                    $user = User::find($userId);
                    return ['email' => $user->email];
                }, $request->user_ids),
            ]);

            $calendarId = 'primary';
            $event = $this->calendarService->events->insert($calendarId, $event, [
                'conferenceDataVersion' => 1
            ]);

            // Also store in our database
            $meeting = Meeting::create([
                'user_id' => auth()->id(),
                'google_event_id' => $event->getId(),
                'topic' => $request->topic,
                'start_time' => $request->start_time,
                'duration' => $request->duration,
                'agenda' => $request->agenda,
                'meeting_url' => $event->getHangoutLink(),
            ]);

            $meeting->participants()->attach($request->user_ids);

            return redirect()->route('meetings.index')->with('success', 'Google Meet created successfully.');
        } catch (\Exception $e) {
            // Token might be expired, try to refresh
            if ($refreshToken) {
                try {
                    $newToken = $this->client->refreshToken($refreshToken);
                    Session::put('google_access_token', $newToken['access_token']);
                    Session::put('google_refresh_token', $newToken['refresh_token'] ?? $refreshToken);

                    // Retry the request
                    return $this->store($request);
                } catch (\Exception $refreshException) {
                    return redirect()->route('google.authorize')->with('error', 'Session expired. Please reauthorize.');
                }
            } else {
                return redirect()->route('google.authorize')->with('error', 'Google authorization required.');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $users = User::all();
        $meeting = Meeting::with('participants')->findOrFail($id);

        $assignedUserIds = $meeting->participants->pluck('id')->toArray();

        return view('pages.meeting_edit', compact('meeting', 'users', 'assignedUserIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $accessToken = Session::get('google_access_token');
        $refreshToken = Session::get('google_refresh_token');

        if (!$accessToken) {
            return redirect()->route('google.authorize')->with('error', 'Google not authorized.');
        }

        $request->validate([
            'topic' => 'required|string|max:255',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:1',
            'agenda' => 'nullable|string',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        $meeting = Meeting::findOrFail($id);

        try {
            $this->client->setAccessToken($accessToken);
            $this->calendarService = new GoogleCalendar($this->client);

            // Update Google Calendar event
            if ($meeting->google_event_id) {
                $event = $this->calendarService->events->get('primary', $meeting->google_event_id);

                $event->setSummary($request->topic);
                $event->setDescription($request->agenda);
                $event->setStart([
                    'dateTime' => Carbon::parse($request->start_time)->toRfc3339String(),
                    'timeZone' => config('app.timezone', 'Asia/Karachi'),
                ]);
                $event->setEnd([
                    'dateTime' => Carbon::parse($request->start_time)->addMinutes($request->duration)->toRfc3339String(),
                    'timeZone' => config('app.timezone', 'Asia/Karachi'),
                ]);

                // Update attendees
                $attendees = array_map(function ($userId) {
                    $user = User::find($userId);
                    return ['email' => $user->email];
                }, $request->user_ids);
                $event->setAttendees($attendees);

                $this->calendarService->events->update('primary', $event->getId(), $event);
            }

            // Update local database
            $meeting->update([
                'topic' => $request->topic,
                'start_time' => $request->start_time,
                'duration' => $request->duration,
                'agenda' => $request->agenda,
            ]);

            $meeting->participants()->sync($request->user_ids);

            return redirect()->route('meetings.index')->with('success', 'Meeting updated successfully.');
        } catch (\Exception $e) {
            // Token might be expired, try to refresh
            if ($refreshToken) {
                try {
                    $newToken = $this->client->refreshToken($refreshToken);
                    Session::put('google_access_token', $newToken['access_token']);
                    Session::put('google_refresh_token', $newToken['refresh_token'] ?? $refreshToken);

                    // Retry the request
                    return $this->update($request, $id);
                } catch (\Exception $refreshException) {
                    return redirect()->route('google.authorize')->with('error', 'Session expired. Please reauthorize.');
                }
            } else {
                return redirect()->route('google.authorize')->with('error', 'Google authorization required.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $accessToken = Session::get('google_access_token');
        $refreshToken = Session::get('google_refresh_token');

        $meeting = Meeting::findOrFail($id);

        try {
            // Delete from Google Calendar if it exists
            if ($meeting->google_event_id && $accessToken) {
                $this->client->setAccessToken($accessToken);
                $this->calendarService = new GoogleCalendar($this->client);

                $this->calendarService->events->delete('primary', $meeting->google_event_id);
            }

            // Delete from local database
            $meeting->participants()->detach();
            $meeting->delete();

            return redirect()->route('meetings.index')->with('success', 'Meeting deleted successfully.');
        } catch (\Exception $e) {
            // If Google deletion fails, still delete from local database
            $meeting->participants()->detach();
            $meeting->delete();

            return redirect()->route('meetings.index')->with('success', 'Meeting deleted from local database.');
        }
    }
}
