<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthWebAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->fc_role != "ADMIN") {
            Auth::logout();
            Auth::getSession()->invalidate();
            Auth::getSession()->regenerateToken();
            return redirect()->route('webLogin');
        }

        return $next($request);
    }
}
