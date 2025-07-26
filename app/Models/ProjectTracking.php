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

    /**
     * Send project tracking data to Google Apps Script
     */
    public function sendToGoogleAppsScript()
    {
        try {
            // Get the company through user's company talent relationship
            $company = $this->user->companyTalent->first()->company ?? null;

            if (!$company || !$company->gas_api_enabled) {
                return false;
            }

            $gasService = app(\App\Services\GoogleAppsScriptService::class);
            $data = $gasService->generateProjectTrackingData($this);

            $result = $gasService->sendToGoogleAppsScript(
                $company->gas_deployment_id,
                $company->gas_hmac_key,
                $data
            );

            // Log the result
            \Log::info('ProjectTracking GAS API call', [
                'project_id' => $this->id,
                'company_id' => $company->id,
                'result' => $result
            ]);

            return $result['success'];

        } catch (\Exception $e) {
            \Log::error('Error sending to GAS', [
                'project_id' => $this->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
