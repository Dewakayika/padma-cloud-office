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
        $query = self::where('user_id', $userId)
            ->where('company_id', $companyId)
            ->whereNotNull('timestamp')
            ->where('status', 'done');

        if ($year) {
            $query->whereYear('timestamp', $year);
        }

        if ($projectType) {
            $query->whereHas('project', function($q) use ($projectType) {
                $q->where('project_type_id', $projectType);
            });
        }

        $logs = $query->get();

        if ($logs->isEmpty()) {
            return '0:00:00';
        }

        $totalMinutes = $logs->sum(function($log) {
            $start = Carbon::parse($log->timestamp);
            $end = Carbon::parse($log->end_time);
            return $end->diffInMinutes($start);
        });

        $averageMinutes = $totalMinutes / $logs->count();

        // Convert to days, hours, minutes
        $days = floor($averageMinutes / (24 * 60));
        $remainingMinutes = $averageMinutes % (24 * 60);
        $hours = floor($remainingMinutes / 60);
        $minutes = round($remainingMinutes % 60);

        return sprintf('%d:%02d:%02d', $days, $hours, $minutes);
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
}
