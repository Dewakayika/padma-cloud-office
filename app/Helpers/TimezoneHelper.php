<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimezoneHelper
{
    /**
     * Get all available timezones
     */
    public static function getAllTimezones()
    {
        return [
            'UTC' => 'UTC',
            'Asia/Jakarta' => 'Asia/Jakarta (WIB)',
            'Asia/Makassar' => 'Asia/Makassar (WITA)',
            'Asia/Jayapura' => 'Asia/Jayapura (WIT)',
            'America/New_York' => 'America/New_York (EST)',
            'America/Chicago' => 'America/Chicago (CST)',
            'America/Denver' => 'America/Denver (MST)',
            'America/Los_Angeles' => 'America/Los_Angeles (PST)',
            'Europe/London' => 'Europe/London (GMT)',
            'Europe/Paris' => 'Europe/Paris (CET)',
            'Europe/Berlin' => 'Europe/Berlin (CET)',
            'Asia/Tokyo' => 'Asia/Tokyo (JST)',
            'Asia/Shanghai' => 'Asia/Shanghai (CST)',
            'Asia/Singapore' => 'Asia/Singapore (SGT)',
            'Australia/Sydney' => 'Australia/Sydney (AEDT)',
            'Australia/Perth' => 'Australia/Perth (AWST)',
            'Pacific/Auckland' => 'Pacific/Auckland (NZDT)',
        ];
    }

    /**
     * Get all PHP supported timezones
     */
    public static function getAllPhpTimezones()
    {
        return \DateTimeZone::listIdentifiers();
    }

    /**
     * Convert UTC timestamp to user's timezone for display
     */
    public static function toUserTimezone($utcTimestamp, $userTimezone = null)
    {
        if (!$utcTimestamp) {
            return null;
        }

        $timezone = $userTimezone ?? session('timezone', 'UTC');
        return Carbon::parse($utcTimestamp)->setTimezone($timezone);
    }

    /**
     * Get current time in UTC
     */
    public static function nowUTC()
    {
        return Carbon::now('UTC');
    }

    /**
     * Get current time in user's timezone
     */
    public static function nowUserTimezone($userTimezone = null)
    {
        $timezone = $userTimezone ?? session('timezone', 'UTC');
        return Carbon::now($timezone);
    }

    /**
     * Format timestamp for display in user's timezone
     */
    public static function formatForDisplay($utcTimestamp, $format = 'M d, H:i', $userTimezone = null)
    {
        $converted = self::toUserTimezone($utcTimestamp, $userTimezone);
        return $converted ? $converted->format($format) : 'N/A';
    }

            /**
     * Set application timezone dynamically
     */
    public static function setAppTimezone($timezone)
    {
        // Ensure we have a valid timezone
        $validTimezone = 'UTC';

        if ($timezone && !empty($timezone) && in_array($timezone, timezone_identifiers_list())) {
            $validTimezone = $timezone;
            \Log::info('App timezone set successfully', ['timezone' => $timezone]);
        } else {
            \Log::warning('Invalid timezone provided, using UTC', ['attempted_timezone' => $timezone]);
        }

        // Always set a valid timezone
        config(['app.timezone' => $validTimezone]);
        date_default_timezone_set($validTimezone);
    }

    /**
     * Get timezone offset from UTC
     */
    public static function getTimezoneOffset($timezone)
    {
        $dateTime = new \DateTime('now', new \DateTimeZone($timezone));
        return $dateTime->format('P');
    }
}
