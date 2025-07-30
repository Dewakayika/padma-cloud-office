<?php

namespace App\Http\Controllers;

use App\Models\WorkSession;
use App\Models\ProjectTracking;
use App\Models\ProjectType;
use App\Models\CompanyTalent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProjectTrackingController extends Controller
{
    /**
     * Display the project tracking page
     */
    public function index()
    {
        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        // Get current active work session
        $currentWorkSession = WorkSession::where('user_id', $user->id)
            ->whereIn('status', ['active', 'paused'])
            ->latest()
            ->first();

        // Get active projects
        $activeProjects = ProjectTracking::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->get();

        // Get recent completed projects
        $recentProjects = ProjectTracking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->latest()
            ->limit(10)
            ->get();

        // Get today's statistics
        $todayStats = $this->getTodayStatsForView();

        // Get basic statistics
        $basicStats = $this->getBasicStats($user->id);
        $allCompletedProjects = ProjectTracking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('end_at', 'desc')
            ->get();

        // Get project types for the user's validated company
        $projectTypes = collect();
        $currentCompany = null;

        if ($user->role === 'talent') {
            // Get the talent's company association
            $companyTalent = \App\Models\CompanyTalent::where('talent_id', $user->id)
                ->with('company')
                ->first();

            if ($companyTalent && $companyTalent->company) {
                $currentCompany = $companyTalent->company;

                // Validate company by slug and get project types
                $companySlug = $currentCompany->slug;

                // Get project types from the validated company
                $projectTypes = \App\Models\ProjectType::where('company_id', $currentCompany->id)->get();

                Log::info('Project types fetched for talent', [
                    'user_id' => $user->id,
                    'company_id' => $currentCompany->id,
                    'company_name' => $currentCompany->company_name,
                    'company_slug' => $companySlug,
                    'project_types_count' => $projectTypes->count()
                ]);
            }
        }

        return view('users.Talent.project-tracking', compact(
            'currentWorkSession',
            'activeProjects',
            'recentProjects',
            'todayStats',
            'basicStats',
            'allCompletedProjects',
            'timezone',
            'projectTypes',
            'currentCompany',
        ));
    }

    /**
     * Start a new work session (stopwatch)
     */
    public function startWorkSession(Request $request)
    {
        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        // End any existing active session
        $existingSession = WorkSession::where('user_id', $user->id)
            ->whereIn('status', ['active', 'paused'])
            ->first();

        if ($existingSession) {
            $existingSession->update([
                'status' => 'completed',
                'ended_at' => Carbon::now('UTC'),
                'total_working_time' => $existingSession->current_working_time,
            ]);
        }

        // Create new work session - store in UTC but display in user timezone
        $workSession = WorkSession::create([
            'user_id' => $user->id,
            'status' => 'active',
            'started_at' => Carbon::now('UTC'),
        ]);

        Log::info('Work session started', [
            'user_id' => $user->id,
            'session_id' => $workSession->id,
            'timezone' => $timezone
        ]);

        return redirect()->back()->with('success', 'Work session started successfully');
    }

    /**
     * Pause the current work session
     */
    public function pauseWorkSession(Request $request)
    {
        $request->validate([
            'pause_reason' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        $workSession = WorkSession::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$workSession) {
            return redirect()->back()->with('error', 'No active work session found');
        }

        $workSession->update([
            'status' => 'paused',
            'paused_at' => Carbon::now('UTC'),
            'pause_reason' => $request->pause_reason,
        ]);

        Log::info('Work session paused', [
            'user_id' => $user->id,
            'session_id' => $workSession->id,
            'pause_reason' => $request->pause_reason,
            'timezone' => $timezone
        ]);

        return redirect()->back()->with('success', 'Work session paused successfully');
    }

    /**
     * Resume the current work session
     */
    public function resumeWorkSession(Request $request)
    {
        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        $workSession = WorkSession::where('user_id', $user->id)
            ->where('status', 'paused')
            ->first();

        if (!$workSession) {
            return redirect()->back()->with('error', 'No paused work session found');
        }

        // Calculate pause duration
        $pauseDuration = $workSession->paused_at->diffInSeconds(Carbon::now('UTC'));
        $newTotalPausedTime = $workSession->total_paused_time + $pauseDuration;

        $workSession->update([
            'status' => 'active',
            'resumed_at' => Carbon::now('UTC'),
            'total_paused_time' => $newTotalPausedTime,
            'paused_at' => null,
        ]);

        Log::info('Work session resumed', [
            'user_id' => $user->id,
            'session_id' => $workSession->id,
            'pause_duration' => $pauseDuration,
            'timezone' => $timezone
        ]);

        return redirect()->back()->with('success', 'Work session resumed successfully');
    }

    /**
     * End the current work session
     */
    public function endWorkSession(Request $request)
    {
        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        $workSession = WorkSession::where('user_id', $user->id)
            ->whereIn('status', ['active', 'paused'])
            ->first();

        if (!$workSession) {
            return redirect()->back()->with('error', 'No active work session found');
        }

        $finalWorkingTime = $workSession->current_working_time;

        $workSession->update([
            'status' => 'completed',
            'ended_at' => Carbon::now('UTC'),
            'total_working_time' => $finalWorkingTime,
        ]);

        Log::info('Work session ended', [
            'user_id' => $user->id,
            'session_id' => $workSession->id,
            'total_working_time' => $finalWorkingTime,
            'formatted_time' => $workSession->formatted_working_time,
            'timezone' => $timezone
        ]);

        return redirect()->back()->with('success', 'Work session ended successfully. Total time: ' . $workSession->formatted_working_time);
    }

    /**
     * Start a new project
     */
    public function startProject(Request $request)
    {
        $request->validate([
            'project_type' => 'required|string|max:255',
            'project_title' => 'required|string|max:255',
            'project_code' => 'nullable|string|max:100',
            'project_link' => 'nullable|url|max:500',
            'role' => 'required|in:talent,talent_qc',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        try {
            $project = ProjectTracking::create([
                'user_id' => $user->id,
                'project_type' => $request->project_type,
                'project_title' => $request->project_title,
                'project_code' => $request->project_code,
                'project_link' => $request->project_link,
                'role' => $request->role,
                'status' => 'active',
                'start_at' => Carbon::now('UTC'),
                'notes' => $request->notes,
            ]);

            // Send data to Google Apps Script if API is enabled
            $apiResult = $project->sendToGoogleAppsScript();

            Log::info('Project started successfully', [
                'user_id' => $user->id,
                'project_id' => $project->id,
                'project_title' => $request->project_title,
                'project_type' => $request->project_type,
                'timezone' => $timezone,
                'api_sent' => $apiResult['success'],
                'api_url' => $apiResult['url'],
                'created_at' => $project->created_at
            ]);

            // Store API URL in session for opening in new tab
            if ($apiResult['success'] && $apiResult['url']) {
                session(['api_url_to_open' => $apiResult['url']]);
            }

            return redirect()->back()->with('success', 'Project started successfully');
        } catch (\Exception $e) {
            Log::error('Failed to start project', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()->with('error', 'Failed to start project. Please try again.');
        }
    }

    /**
     * End a project
     */
    public function endProject(Request $request, $id)
    {
        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        $project = ProjectTracking::where('user_id', $user->id)
            ->where('id', $id)
            ->where('status', 'active')
            ->first();

        if (!$project) {
            return redirect()->back()->with('error', 'Project not found or already completed');
        }

        // Set the end time using UTC for storage
        $endTime = Carbon::now('UTC');

        // Calculate duration using the actual end time
        $workingDuration = $project->start_at->diffInSeconds($endTime);

        $project->update([
            'status' => 'completed',
            'end_at' => $endTime,
            'working_duration' => $workingDuration,
        ]);

        // Send data to Google Apps Script if API is enabled
        $apiResult = $project->sendToGoogleAppsScript();

        Log::info('Project ended', [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'project_title' => $project->project_title,
            'working_duration' => $workingDuration,
            'formatted_duration' => $project->formatted_working_duration,
            'timezone' => $timezone,
            'api_sent' => $apiResult['success'],
            'api_url' => $apiResult['url']
        ]);

        // Store API URL in session for opening in new tab
        if ($apiResult['success'] && $apiResult['url']) {
            session(['api_url_to_open' => $apiResult['url']]);
        }

        return redirect()->back()->with('success', 'Project completed successfully. Duration: ' . $project->formatted_working_duration);
    }

    /**
     * Get current work session status (for AJAX)
     */
        public function getWorkSessionStatus()
    {
        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        $workSession = WorkSession::where('user_id', $user->id)
            ->whereIn('status', ['active', 'paused'])
            ->first();

        if (!$workSession) {
            return response()->json([
                'success' => true,
                'status' => 'no_session',
                'message' => 'No active work session'
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => $workSession->status,
            'session' => [
                'id' => $workSession->id,
                'started_at' => $workSession->started_at,
                'paused_at' => $workSession->paused_at,
                'total_paused_time' => $workSession->total_paused_time,
                'current_working_time' => $workSession->current_working_time,
                'formatted_working_time' => $workSession->formatted_working_time,
                'timezone' => $timezone,
            ]
        ]);
    }

    /**
     * Get today's statistics
     */
    public function getTodayStats()
    {
        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';
        $today = Carbon::now($timezone)->startOfDay();

        // Get all work sessions (completed and active) for today
        $todayWorkSessions = WorkSession::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'active', 'paused'])
            ->whereDate('started_at', $today)
            ->get();

        // Get all projects (completed and active) for today
        $todayProjects = ProjectTracking::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'active'])
            ->whereDate('start_at', $today)
            ->get();

        // Calculate total work time including active sessions
        $totalWorkTime = 0;
        foreach ($todayWorkSessions as $session) {
            if ($session->status === 'completed') {
                $totalWorkTime += $session->total_working_time;
            } else {
                $totalWorkTime += $session->current_working_time;
            }
        }

        // Calculate total project time including active projects
        $totalProjectTime = 0;
        foreach ($todayProjects as $project) {
            if ($project->status === 'completed') {
                $totalProjectTime += $project->working_duration;
            } else {
                $totalProjectTime += $project->calculateWorkingDuration();
            }
        }

        $totalTime = $totalWorkTime + $totalProjectTime;
        $totalSessions = $todayWorkSessions->count() + $todayProjects->count();

        return response()->json([
            'success' => true,
            'total_time' => $this->formatTime($totalTime),
            'total_sessions' => $totalSessions,
            'work_sessions' => $todayWorkSessions->count(),
            'projects' => $todayProjects->count(),
        ]);
    }

    /**
     * Get today's statistics for the view
     */
    private function getTodayStatsForView()
    {
        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';
        $today = Carbon::now($timezone)->startOfDay();

        // Get all work sessions (completed and active) for today
        $todayWorkSessions = WorkSession::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'active', 'paused'])
            ->whereDate('started_at', $today)
            ->get();

        // Get all projects (completed and active) for today
        $todayProjects = ProjectTracking::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'active'])
            ->whereDate('start_at', $today)
            ->get();

        // Calculate total work time including active sessions
        $totalWorkTime = 0;
        foreach ($todayWorkSessions as $session) {
            if ($session->status === 'completed') {
                $totalWorkTime += $session->total_working_time;
            } else {
                $totalWorkTime += $session->current_working_time;
            }
        }

        // Calculate total project time including active projects
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
            'total_sessions' => $todayWorkSessions->count() + $todayProjects->count(),
            'work_sessions' => $todayWorkSessions->count(),
            'projects' => $todayProjects->count(),
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
     * Get basic statistics for a user
     */
    private function getBasicStats($userId)
    {
        // Get all completed work sessions
        $workSessions = WorkSession::where('user_id', $userId)
            ->where('status', 'completed')
            ->get();

        // Calculate average daily working duration
        $totalWorkingTime = $workSessions->sum('total_working_time');
        $workDays = $workSessions->groupBy(function($session) {
            return $session->started_at->format('Y-m-d');
        })->count();

        $avgDailyDuration = $workDays > 0 ? $totalWorkingTime / $workDays : 0;

        return [
            'avg_daily_duration' => $this->formatTime($avgDailyDuration),
        ];
    }

    /**
     * Validate company by slug
     */
    private function validateCompanyBySlug($slug)
    {
        return \App\Models\Company::where('company_name', 'like', '%' . str_replace('-', ' ', $slug) . '%')
            ->orWhere('company_name', 'like', '%' . str_replace('_', ' ', $slug) . '%')
            ->first();
    }

    /**
     * Get project types by company slug (for API use)
     */
    public function getProjectTypesByCompanySlug($companySlug)
    {
        $user = Auth::user();

        // Validate that the user is a talent
        if ($user->role !== 'talent') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Find company by slug
        $company = $this->validateCompanyBySlug($companySlug);

        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        // Validate that the talent belongs to this company
        $companyTalent = \App\Models\CompanyTalent::where('talent_id', $user->id)
            ->where('company_id', $company->id)
            ->first();

        if (!$companyTalent) {
            return response()->json(['error' => 'You are not authorized to access this company'], 403);
        }

        // Get project types for the validated company
        $projectTypes = \App\Models\ProjectType::where('company_id', $company->id)->get();

        return response()->json([
            'success' => true,
            'company' => [
                'id' => $company->id,
                'name' => $company->company_name,
                'slug' => $company->slug,
            ],
            'project_types' => $projectTypes->map(function($type) {
                return [
                    'id' => $type->id,
                    'name' => $type->project_name,
                    'rate' => $type->project_rate,
                    'qc_rate' => $type->qc_rate,
                ];
            })
        ]);
    }
}
