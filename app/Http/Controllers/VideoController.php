<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class VideoController extends Controller
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
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUri,
        ]);

        return redirect($authUrl);
    }

    public function handleCallback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route('video.authorize')->with('error', 'Missing authorization code.');
        }

        $response = Http::asForm()
            ->withHeaders([
                'Authorization' => 'Basic ' . base64_encode("{$this->clientId}:{$this->clientSecret}"),
            ])
            ->post('https://zoom.us/oauth/token', [
                'grant_type'   => 'authorization_code',
                'code'         => $request->code,
                'redirect_uri' => $this->redirectUri,
            ]);

        $data = $response->json();

        if (isset($data['access_token'])) {
            Session::put('zoom_access_token', $data['access_token']);
            Session::put('zoom_refresh_token', $data['refresh_token']);
            Session::put('zoom_token_expires_at', now()->addSeconds($data['expires_in']));
            return redirect()->route('video.create');
        }

        return back()->with('error', 'Zoom authorization failed.');
    }

    public function createMeeting()
    {
        $accessToken  = Session::get('zoom_access_token');
        $refreshToken = Session::get('zoom_refresh_token');
        $expiresAt    = Session::get('zoom_token_expires_at');

        if (!$accessToken || !$refreshToken || !$expiresAt) {
            return redirect()->route('video.authorize')->with('error', 'Zoom not authorized.');
        }

        // Refresh token if expired
        if (now()->gte($expiresAt)) {
            $newTokens = Http::asForm()
                ->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode("{$this->clientId}:{$this->clientSecret}"),
                ])
                ->post('https://zoom.us/oauth/token', [
                    'grant_type'    => 'refresh_token',
                    'refresh_token' => $refreshToken,
                ]);

            if ($newTokens->successful()) {
                $tokens = $newTokens->json();
                Session::put('zoom_access_token', $tokens['access_token']);
                Session::put('zoom_refresh_token', $tokens['refresh_token']);
                Session::put('zoom_token_expires_at', now()->addSeconds($tokens['expires_in']));
                $accessToken = $tokens['access_token']; // Update local var
            } else {
                return redirect()->route('video.authorize')->with('error', 'Zoom session expired. Please authorize again.');
            }
        }

        // Prepare meeting payload
        $meetingPayload = [
            'topic'      => 'Zoom Meeting',
            'type'       => 2,
            'start_time' => now()->addMinutes(5)->toIso8601String(),
            'duration'   => 30,
            'agenda'     => 'Zoom Meeting',
            'settings'   => [
                'join_before_host' => true,
                'mute_upon_entry'  => true,
                'waiting_room'     => true,
            ],
        ];

        // Attempt meeting creation
        $response = Http::withToken($accessToken)
            ->post('https://api.zoom.us/v2/users/me/meetings', $meetingPayload);

        if ($response->successful()) {
            $meeting = $response->json();
            $joinUrl = "https://zoom.us/wc/{$meeting['id']}/join?prefer=1";
            return redirect()->away($joinUrl)->with('success', 'Meeting created successfully.');
        }

        return back()->with('error', 'Failed to create Zoom meeting.');
    }
}
