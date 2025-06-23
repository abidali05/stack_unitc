<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\SendPasswordMail;

class SocialAuthService
{
    public function handleSocialAuth($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::where("{$provider}_id", $socialUser->id)
                    ->orWhere('email', $socialUser->email)
                    ->first();

        if ($user) {
            if (!$user->{"{$provider}_id"}) {
                $user->{"{$provider}_id"} = $socialUser->id;
                $user->save();
            }
            Auth::login($user);
            return $user;
        } else {
            $randomPassword = Str::random(12);
            $userData = User::create([
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'password' => Hash::make($randomPassword),
                "{$provider}_id" => $socialUser->id,
            ]);

            if ($userData) {
                Mail::to($socialUser->email)->send(new SendPasswordMail($socialUser->email, $randomPassword));
                Auth::login($userData);
                return $userData;
            }
        }

        return null;
    }
}
