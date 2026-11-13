<?php

namespace App\Http\Middleware;

use App\Services\DriverVerificationService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards the "available jobs" pool only (driver-booking). A driver with a
 * required document that's expired or rejected can still log in, see their
 * already-accepted jobs through to completion, and manage their account -
 * they just can't pick up anything new until it's fixed. See
 * DriverVerificationService::blocksNewJobs().
 */
class EnsureDriverCanTakeJobs
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && app(DriverVerificationService::class)->blocksNewJobs($user)) {
            return redirect()->route('driver.docs.index')->with(
                'error',
                'One or more of your required documents need attention (expired, rejected, or missing). '
                . 'You can\'t take new jobs until this is resolved - any jobs you\'ve already accepted are unaffected.'
            );
        }

        return $next($request);
    }
}
