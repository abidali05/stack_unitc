<?php

namespace App\Http\Controllers;

use App\Mail\SendPasswordMail;
use App\Models\User;
use App\Services\SocialAuthService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    protected $socialAuthService;

    public function __construct(SocialAuthService $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = $this->socialAuthService->handleSocialAuth($provider);
            if ($user) {
                return redirect()->route('dashboard')->with('success', 'Login successful!');
            }
            return redirect()->route('login')->with('error', 'Authentication failed!');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
