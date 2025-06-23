<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($validator->validated())) {
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone_num' => 'required|numeric',
        ]);

        if ($validatedData->fails()) {
            return back()->withErrors($validatedData)->withInput();
        }

        $validatedData = $validatedData->validated();
        $validatedData['country_id'] = 231;

        $user  = User::create($validatedData);
        if ($user) {
            return redirect()->route('dashboard')->with('success', 'Registration successful!');
        }

        return redirect()->route('register.index')->with('error', 'Registration failed. Please try again.');
    }

    public function forgotPassword(Request $request)
    {
        // dd($request->all());
        $validatedData = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validatedData->fails()) {
            return back()->withErrors($validatedData)->withInput();
        }

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)])->withInput();
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login.form')->with('status', __($status))
            : back()->withErrors(['password' => [__($status)]])->withInput();
    }
}
