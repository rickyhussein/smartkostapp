<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class authController extends Controller
{
    public function login()
    {
        $title = "Log In";
        return view('auth.login', compact(
            'title'
        ));
    }

    public function storeLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $remember_me = $request->has('remember') ? true : false;

        if (Auth::attempt($credentials, $remember_me)) {
            $request->session()->regenerate();
            if (auth()->user()->hasAnyPermission(['dashboard_admin'])) {
                return redirect()->intended('/dashboard');
            } else if (auth()->user()->hasAnyPermission(['dashboard_owner'])) {
                return redirect()->intended('/dashboard/owner');
            } else {
                return redirect()->intended('/dashboard/user');
            }
        }

        Alert::error('Failed', 'Username / Password Salah');
        return back();
    }

    public function register()
    {
        $title = "Register";
        return view('auth.register', compact(
            'title'
        ));
    }

    public function userRegister()
    {
        $title = 'SMART KOS';
        return view('auth.userRegister', compact(
            'title',
        ));
    }

    public function storeUserRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email:dns|unique:users',
            'phone_number' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        $user->assignRole('user');
        Auth::loginUsingId($user->id);
        return redirect('/dashboard/user')->with('success', 'Register Berhasil!');
    }

    public function ownerRegister()
    {
        $title = 'SMART KOS';
        return view('auth.ownerRegister', compact(
            'title',
        ));
    }

    public function storeOwnerRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email:dns|unique:users',
            'phone_number' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        $user->assignRole('owner');
        Auth::loginUsingId($user->id);
        return redirect('/dashboard/owner')->with('success', 'Register Berhasil!');
    }

    public function forgotPassword()
    {
        $title = 'SMART KOS';
        return view('auth.forgot-password', compact(
            'title'
        ));
    }

    public function forgotPasswordLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __('Link reset password berhasil dikirim ke email anda')])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        $title = 'SMART KOS';
        return view('auth.showResetForm', compact(
            'token',
            'title'
        ));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __('Password berhasil diganti'))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function switch(Request $request, $id)
    {
        Auth::loginUsingId($id);
        return redirect()->to('/');
    }
}
