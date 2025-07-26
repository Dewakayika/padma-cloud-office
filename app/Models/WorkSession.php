<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class WorkSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'started_at',
        'paused_at',
        'resumed_at',
        'ended_at',
        'total_paused_time',
        'total_working_time',
        'pause_reason',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'paused_at' => 'datetime',
        'resumed_at' => 'datetime',
        'ended_at' => 'datetime',
        'total_paused_time' => 'integer',
        'total_working_time' => 'integer',
    ];

    /**
     * Get the user that owns the work session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

        /**
     * Get the current working time in seconds
     */
    public function getCurrentWorkingTimeAttribute()
    {
        if ($this->status === 'completed') {
            return $this->total_working_time;
        }

        $timezone = $this->user->timezone ?? 'UTC';
        $startTime = $this->started_at;
        $currentTime = Carbon::now('UTC');

        if ($this->status === 'paused' && $this->paused_at) {
            $currentTime = $this->paused_at;
    }

        $totalDuration = $startTime->diffInSeconds($currentTime);
        return max(0, $totalDuration - $this->total_paused_time);
    }

    /**
     * Get the current working time in seconds with timezone consideration
     */
    public function getCurrentWorkingTimeWithTimezoneAttribute()
    {
        if ($this->status === 'completed') {
            return $this->total_working_time;
        }

        $timezone = session('timezone', 'UTC');
        $startTime = $this->started_at->setTimezone($timezone);
        $currentTime = Carbon::now($timezone); // Use timezone for current time

        if ($this->status === 'paused' && $this->paused_at) {
            $currentTime = $this->paused_at->setTimezone($timezone);
        }

        $totalDuration = $startTime->diffInSeconds($currentTime);
        return max(0, $totalDuration - $this->total_paused_time);
    }

    /**
     * Format working time to HH:MM:SS
     */
    public function getFormattedWorkingTimeAttribute()
    {
        $seconds = $this->current_working_time;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }

    /**
     * Check if session is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if session is paused
     */
    public function isPaused()
    {
        return $this->status === 'paused';
    }

    /**
     * Check if session is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}
