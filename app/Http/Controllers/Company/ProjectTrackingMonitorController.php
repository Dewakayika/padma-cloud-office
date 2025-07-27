<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\WorkSession;
use App\Models\ProjectTracking;
use App\Models\User;
use App\Models\CompanyTalent;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProjectTrackingMonitorController extends Controller
{
    /**
     * Display the real-time project tracking monitoring dashboard for company
     */
    public function index()
    {
        $user = Auth::user();
        $company = \App\Models\Company::where('user_id', $user->id)->first();
        $timezone = session('timezone', $user->timezone ?? 'UTC');

        if (!$company) {
            \Log::error('Company not found for user', ['user_id' => $user->id]);
            return redirect()->back()->with('error', 'Company not found');
        }

        // Get all talents from this company through company_talent relationship
        $talents = User::where('role', 'talent')
            ->whereHas('companyTalent', function($query) use ($company) {
                $query->where('company_id', $company->id);
            })
            ->with(['workSessions' => function($query) {
                $query->whereIn('status', ['active', 'paused'])->latest();
            }, 'projectTracking' => function($query) {
                $query->where('status', 'active')->latest();
            }])
            ->get();

        // Debug: Log the data for troubleshooting
        \Log::info('Company Monitor Debug', [
            'user_id' => $user->id,
            'company_id' => $company->id,
            'company_name' => $company->company_name,
            'talents_count' => $talents->count(),
            'talents' => $talents->map(function($talent) {
                return [
                    'id' => $talent->id,
                    'name' => $talent->name,
                    'work_sessions_count' => $talent->workSessions->count(),
                    'project_tracking_count' => $talent->projectTracking->count(),
                ];
            })
        ]);

        // Get selected month (default to current month)
        $selectedMonth = request('month', Carbon::now()->format('Y-m'));

        // Get today's statistics for all talents in this company
        $todayStats = $this->getTodayStatsForCompanyTalents($company->id);

        // Get talent statistics for the selected month
        $talentStats = $this->getTalentStatistics($company->id, $selectedMonth);

        // Get available months for filtering
        $availableMonths = $this->getAvailableMonths();

        // Get project types for this company
        $projectTypes = ProjectType::where('company_id', $company->id)->get();

        return view('users.Company.project-tracking-monitor', compact(
            'talents',
            'todayStats',
            'talentStats',
            'availableMonths',
            'selectedMonth',
            'projectTypes',
            'timezone'
        ));
    }

    /**
     * Get real-time data for AJAX updates
     */
    public function getRealTimeData()
    {
        $user = Auth::user();
        $company = \App\Models\Company::where('user_id', $user->id)->first();
        $timezone = session('timezone', $user->timezone ?? 'UTC');

        if (!$company) {
            return response()->json(['success' => false, 'error' => 'Company not found']);
        }

        // Get all active work sessions for talents in this company
        $activeWorkSessions = WorkSession::whereIn('status', ['active', 'paused'])
            ->whereHas('user.companyTalent', function($query) use ($company) {
                $query->where('company_id', $company->id);
            })
            ->with('user')
            ->get();

        // Get all active projects for talents in this company
        $activeProjects = ProjectTracking::where('status', 'active')
            ->whereHas('user.companyTalent', function($query) use ($company) {
                $query->where('company_id', $company->id);
            })
            ->with('user')
            ->get();

        // Debug: Log real-time data
        \Log::info('Real-time Data Debug', [
            'user_id' => $user->id,
            'company_id' => $company->id,
            'company_name' => $company->company_name,
            'active_work_sessions_count' => $activeWorkSessions->count(),
            'active_projects_count' => $activeProjects->count(),
            'work_sessions' => $activeWorkSessions->map(function($session) {
                return [
                    'id' => $session->id,
                    'user_id' => $session->user_id,
                    'user_name' => $session->user->name ?? 'Unknown',
                    'status' => $session->status,
                ];
            }),
            'projects' => $activeProjects->map(function($project) {
                return [
                    'id' => $project->id,
                    'user_id' => $project->user_id,
                    'user_name' => $project->user->name ?? 'Unknown',
                    'project_type' => $project->project_type,
                ];
            })
        ]);

        // Calculate current working times
        $workSessionsData = $activeWorkSessions->map(function($session) use ($timezone) {
            return [
                'id' => $session->id,
                'user_id' => $session->user_id,
                'user_name' => $session->user->name,
                'status' => $session->status,
                'started_at' => $session->started_at,
                'current_working_time' => $session->current_working_time,
                'formatted_working_time' => $session->formatted_working_time,
                'timezone' => $timezone,
            ];
        });

        $projectsData = $activeProjects->map(function($project) use ($timezone) {
            return [
                'id' => $project->id,
                'user_id' => $project->user_id,
                'user_name' => $project->user->name,
                'project_type' => $project->project_type,
                'project_title' => $project->project_title,
                'start_at' => $project->start_at,
                'working_duration' => $project->calculateWorkingDuration(),
                'formatted_duration' => $project->formatted_working_duration,
                'timezone' => $timezone,
            ];
        });

        return response()->json([
            'success' => true,
            'work_sessions' => $workSessionsData,
            'projects' => $projectsData,
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Get today's statistics for all talents in the company
     */
    private function getTodayStatsForCompanyTalents($companyId)
    {
        $today = Carbon::now()->startOfDay();

        // Get all work sessions for today from talents in this company
        $todayWorkSessions = WorkSession::whereDate('started_at', $today)
            ->whereHas('user.companyTalent', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->get();

        // Get all projects for today from talents in this company
        $todayProjects = ProjectTracking::whereDate('start_at', $today)
            ->whereHas('user.companyTalent', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->get();

        // Calculate totals
        $totalWorkTime = 0;
        foreach ($todayWorkSessions as $session) {
            if ($session->status === 'completed') {
                $totalWorkTime += $session->total_working_time;
            } else {
                $totalWorkTime += $session->current_working_time;
            }
        }

        $totalProjectTime = 0;
        foreach ($todayProjects as $project) {
            if ($project->status === 'completed') {
                $totalProjectTime += $project->working_duration;
            } else {
                $totalProjectTime += $project->calculateWorkingDuration();
            }
        }

        $totalTime = $totalWorkTime + $totalProjectTime;

        return [
            'total_time' => $this->formatTime($totalTime),
            'total_sessions' => $todayWorkSessions->count(),
            'total_projects' => $todayProjects->count(),
            'active_talents' => $todayWorkSessions->where('status', 'active')->count() +
                               $todayProjects->where('status', 'active')->count(),
        ];
    }

    /**
     * Format time in seconds to HH:MM:SS
     */
    private function formatTime($seconds)
    {
        $seconds = max(0, $seconds);
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }

    /**
     * Get talent statistics for a specific month
     */
    private function getTalentStatistics($companyId, $selectedMonth)
    {
        $startDate = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', $selectedMonth)->endOfMonth();

        $talents = User::where('role', 'talent')
            ->whereHas('companyTalent', function($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->get();

        $talentStats = [];

        foreach ($talents as $talent) {
            // Get work sessions for the month
            $workSessions = WorkSession::where('user_id', $talent->id)
                ->where('status', 'completed')
                ->whereBetween('started_at', [$startDate, $endDate])
                ->get();

            // Get projects for the month
            $projects = ProjectTracking::where('user_id', $talent->id)
                ->where('status', 'completed')
                ->whereBetween('start_at', [$startDate, $endDate])
                ->get();

            // Calculate average working time
            $totalWorkingTime = $workSessions->sum('total_working_time');
            $workDays = $workSessions->groupBy(function($session) {
                return $session->started_at->format('Y-m-d');
            })->count();

            $avgWorkingTime = $workDays > 0 ? $totalWorkingTime / $workDays : 0;
            $avgWorkingHours = $avgWorkingTime / 3600; // Convert to hours

            // Calculate average projects per day
            $totalProjects = $projects->count();
            $avgProjectsPerDay = $workDays > 0 ? round($totalProjects / $workDays, 1) : 0;

            // Calculate best speed (fastest project completion)
            $bestSpeed = $projects->min('working_duration') ?? 0;

            // Calculate total sessions and projects
            $totalSessions = $workSessions->count();

            // Calculate daily working time data for chart
            $dailyWorkingTime = [];
            $workSessionsByDay = $workSessions->groupBy(function($session) {
                return $session->started_at->format('Y-m-d');
            });

            $projectsByDay = $projects->groupBy(function($project) {
                return $project->start_at->format('Y-m-d');
            });

            // Get all unique days
            $allDays = $workSessionsByDay->keys()->merge($projectsByDay->keys())->unique()->sort();

            foreach ($allDays as $day) {
                $dayWorkTime = 0;

                // Add work session time for this day
                if ($workSessionsByDay->has($day)) {
                    $dayWorkTime += $workSessionsByDay[$day]->sum('total_working_time');
                }

                // Add project time for this day
                if ($projectsByDay->has($day)) {
                    $dayWorkTime += $projectsByDay[$day]->sum('working_duration');
                }

                $dailyWorkingTime[] = [
                    'date' => $day,
                    'hours' => round($dayWorkTime / 3600, 1),
                    'formatted' => $this->formatTime($dayWorkTime)
                ];
            }

            $talentStats[$talent->id] = [
                'avg_working_time' => $this->formatTime($avgWorkingTime),
                'avg_working_hours' => $avgWorkingHours,
                'avg_projects_per_day' => $avgProjectsPerDay,
                'best_speed' => $this->formatTime($bestSpeed),
                'total_sessions' => $totalSessions,
                'total_projects' => $totalProjects,
                'work_days' => $workDays,
                'daily_working_time' => $dailyWorkingTime,
            ];
        }

        return $talentStats;
    }

    /**
     * Get available months for filtering
     */
    private function getAvailableMonths()
    {
        $months = [];
        $currentDate = Carbon::now();

        // Generate last 12 months
        for ($i = 0; $i < 12; $i++) {
            $date = $currentDate->copy()->subMonths($i);
            $value = $date->format('Y-m');
            $label = $date->format('F Y');

            $months[] = [
                'value' => $value,
                'label' => $label,
                'selected' => $i === 0 // Current month is selected by default
            ];
        }

        return $months;
    }
}
