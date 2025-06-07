<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProjectLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'company_id',
        'talent_id',
        'talent_qc_id',
        'timestamp',
        'status'
    ];

    protected $casts = [
        'timestamp' => 'datetime'
    ];

    // Relationship with User (who created the log)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relationship with Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relationship with Talent (User)
    public function talent()
    {
        return $this->belongsTo(User::class, 'talent_id');
    }

    // Relationship with Talent QC (User)
    public function talentQc()
    {
        return $this->belongsTo(User::class, 'talent_qc_id');
    }

    /**
     * Calculate average project serving time for a specific user and company
     */
    public static function calculateAverageServingTime($userId, $companyId, $year = null, $projectType = null)
    {
        // Get all projects for this user and company
        $projects = \App\Models\Project::where('company_id', $companyId)
            ->when($projectType, function($query) use ($projectType) {
                $query->where('project_type_id', $projectType);
            })
            ->with(['projectLogs' => function($q) {
                $q->orderBy('timestamp', 'asc');
            }])
            ->get();

        $totalSeconds = 0;
        $completedCount = 0;

        foreach ($projects as $project) {
            $assignLog = $project->projectLogs->firstWhere('status', 'project assign');
            $doneLog = $project->projectLogs->firstWhere('status', 'done');
            $start = null;
            $end = null;
            if ($assignLog && $doneLog) {
                $start = \Carbon\Carbon::parse($assignLog->timestamp);
                $end = \Carbon\Carbon::parse($doneLog->timestamp);
            } elseif ($project->status === 'done' && $project->start_date && $project->finish_date) {
                $start = \Carbon\Carbon::parse($project->start_date);
                $end = \Carbon\Carbon::parse($project->finish_date);
            }
            if ($start && $end) {
                $duration = $end->diffInSeconds($start);
                if ($duration > 0) {
                    $totalSeconds += $duration;
                    $completedCount++;
                }
            }
        }

        if ($completedCount === 0) {
            return 'N/A';
        }

        $averageSeconds = $totalSeconds / $completedCount;
        $days = floor($averageSeconds / (24 * 3600));
        $hours = floor(($averageSeconds % (24 * 3600)) / 3600);
        $minutes = floor(($averageSeconds % 3600) / 60);
        $seconds = floor($averageSeconds % 60);

        // Pluralization
        $dayLabel = $days == 1 ? 'day' : 'days';
        $hourLabel = $hours == 1 ? 'hour' : 'hours';
        $minuteLabel = $minutes == 1 ? 'minute' : 'minutes';
        $secondLabel = $seconds == 1 ? 'second' : 'seconds';

        return sprintf('%dd %dh %dm %ds', $days, $hours, $minutes, $seconds);
    }

    /**
     * Get monthly project completion statistics by project type
     */
    public static function getMonthlyCompletionStats($companyId, $year = null, $projectType = null)
    {
        $query = self::where('company_id', $companyId)
            ->where('status', 'done')
            ->whereNotNull('timestamp');

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        if ($projectType) {
            $query->whereHas('project', function($q) use ($projectType) {
                $q->where('project_type_id', $projectType);
            });
        }

        return $query->selectRaw('
                MONTH(created_at) as month,
                COUNT(*) as total_completed
            ')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->total_completed];
            })
            ->toArray();
    }

    public static function calculateAverageCompletionTime($userId, $companyId, $year = null, $projectType = null)
    {
        // Get all projects for this company (and optionally user)
        $projects = \App\Models\Project::where('company_id', $companyId)
            ->when($userId, function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($projectType, function($query) use ($projectType) {
                $query->where('project_type_id', $projectType);
            })
            ->where('status', 'done')
            ->with(['projectLogs' => function($q) {
                $q->orderBy('timestamp', 'asc');
            }])
            ->get();

        $totalSeconds = 0;
        $completedCount = 0;

        foreach ($projects as $project) {
            $assignLog = $project->projectLogs->firstWhere('status', 'project assign');
            $doneLog = $project->projectLogs->firstWhere('status', 'done');
            if ($assignLog && $doneLog) {
                $start = \Carbon\Carbon::parse($assignLog->timestamp);
                $end = \Carbon\Carbon::parse($doneLog->timestamp);
                $duration = $end->diffInSeconds($start);
                if ($duration > 0) {
                    $totalSeconds += $duration;
                    $completedCount++;
                }
            }
        }

        if ($completedCount === 0) {
            return 'N/A';
        }

        $averageSeconds = $totalSeconds / $completedCount;
        $days = floor($averageSeconds / (24 * 3600));
        $hours = floor(($averageSeconds % (24 * 3600)) / 3600);
        $minutes = floor(($averageSeconds % 3600) / 60);
        $seconds = floor($averageSeconds % 60);

        return sprintf('%dd %dh %dm %ds', $days, $hours, $minutes, $seconds);
    }
}
