<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Keeps drivers whose account isn't active out of the working area
 * (bookings, profile, password ...). Applicants who are still waiting for
 * verification are sent to their documents; anyone else who is inactive is
 * logged out.
 */
class ActiveDriver
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && (int) $user->status !== 1) {
            if ($user->isPendingDriverApplicant()) {
                return redirect()->route('driver.docs.index');
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/driver-login')->with('error', 'Your account is not active.');
        }

        return $next($request);
    }
}
