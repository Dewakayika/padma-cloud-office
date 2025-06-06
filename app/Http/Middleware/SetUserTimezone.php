<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;

class SetUserTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('timezone')) {
            if ($position = Location::get()) {
                // Get timezone based on user's location
                $timezone = $this->getTimezoneFromLocation($position->latitude, $position->longitude);
                Session::put('timezone', $timezone);
            } else {
                // Fallback to default timezone if location detection fails
                Session::put('timezone', config('app.timezone'));
            }
        }

        // Set the timezone for this request
        date_default_timezone_set(Session::get('timezone'));

        return $next($request);
    }

    /**
     * Get timezone based on coordinates
     *
     * @param float $latitude
     * @param float $longitude
     * @return string
     */
    private function getTimezoneFromLocation($latitude, $longitude)
    {
        $timezone = timezone_name_from_abbr('', (int)(($longitude + 7.5) / 15) * 3600, 0);
        return $timezone ?: config('app.timezone');
    }
}