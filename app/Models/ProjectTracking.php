<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ProjectTracking extends Model
{
    use HasFactory;

    protected $table = 'project_tracking';

    protected $fillable = [
        'user_id',
        'project_type',
        'project_title',
        'project_code',
        'project_link',
        'role',
        'status',
        'start_at',
        'end_at',
        'working_duration',
        'notes',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'working_duration' => 'integer',
    ];

    /**
     * Get the user that owns the project tracking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted working duration
     */
    public function getFormattedWorkingDurationAttribute()
    {
        $seconds = $this->working_duration;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }

    /**
     * Check if project is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if project is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Calculate working duration from start to end
     */
    public function calculateWorkingDuration()
    {
        if (!$this->start_at) {
            return 0;
        }

        // For completed projects, use the stored end_at time
        if ($this->status === 'completed' && $this->end_at) {
            return $this->start_at->diffInSeconds($this->end_at);
        }

        // For active projects, calculate from start to now using UTC
        $endTime = Carbon::now('UTC');
        return $this->start_at->diffInSeconds($endTime);
    }
}
