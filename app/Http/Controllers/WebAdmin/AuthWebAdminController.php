<?php

namespace App\Http\Controllers\WebAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthWebAdminController extends Controller
{
    public function login()
    {
        if (Auth::check() && Auth::user()->fc_role == "ADMIN")
            return redirect()->route('dashboard');

        return view('apps.loginwebadmin');
    }

    public function authentication(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt($credential)) {
            if (Auth::user()->fc_role == "ADMIN") {
                $request->session()->regenerate();
                return redirect()->route('dashboard')
                    ->withSuccess('You have successfully logged in!');
            }

            $this->forceLogout();
            return back()->withErrors([
                'email' => 'You are not Admin, please use another Apps',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match',
        ])->onlyInput('email');
    }

    public function logout()
    {
        $this->forceLogout();
        return redirect()->route('webLogin')
            ->withSuccess('You have logged out successfully!');;
    }

    private function forceLogout()
    {
        Auth::logout();
        Auth::getSession()->invalidate();
        Auth::getSession()->regenerateToken();
    }
}
