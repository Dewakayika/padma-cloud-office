<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SetUserTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get user's timezone from session or user model
        $userTimezone = session('timezone');

        // Always ensure we have a valid timezone
        if ($userTimezone && !empty($userTimezone) && in_array($userTimezone, timezone_identifiers_list())) {
            // Use the helper to set timezone
            \App\Helpers\TimezoneHelper::setAppTimezone($userTimezone);
            Log::info('Timezone set via middleware', ['timezone' => $userTimezone]);
        } else {
            // Set default timezone if invalid or empty
            \App\Helpers\TimezoneHelper::setAppTimezone('UTC');
            Log::info('Invalid or empty timezone detected, using UTC', ['attempted_timezone' => $userTimezone]);

            // Clear any invalid timezone from session
            if (empty($userTimezone)) {
                session()->forget('timezone');
            }
        }

        return $next($request);
    }
}
