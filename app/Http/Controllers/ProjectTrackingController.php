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
            $timezone = session('timezone', $user->timezone ?? 'UTC');

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

            return view('users.Talent.project-tracking', compact(
                'currentWorkSession',
                'activeProjects',
                'recentProjects',
                'todayStats',
                'timezone',
            ));
        }

    /**
     * Start a new work session (stopwatch)
     */
    public function startWorkSession(Request $request)
    {
        $request->validate([
            'timezone' => 'nullable|string',
        ]);

        $user = Auth::user();
        $timezone = $request->timezone ?? session('timezone', 'UTC');

        // End any existing active session
        $existingSession = WorkSession::where('user_id', $user->id)
            ->whereIn('status', ['active', 'paused'])
            ->first();

        if ($existingSession) {
            $existingSession->update([
                'status' => 'completed',
                'ended_at' => now(), // Always use UTC
                'total_working_time' => $existingSession->current_working_time,
            ]);
        }

        // Create new work session
        $workSession = WorkSession::create([
            'user_id' => $user->id,
            'status' => 'active',
            'started_at' => now(), // Always use UTC
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
            'timezone' => 'nullable|string',
        ]);

        $user = Auth::user();
        $timezone = $request->timezone ?? session('timezone', 'UTC');

        $workSession = WorkSession::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$workSession) {
            return redirect()->back()->with('error', 'No active work session found');
        }

        $workSession->update([
            'status' => 'paused',
            'paused_at' => now(), // Always use UTC
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
        $request->validate([
            'timezone' => 'nullable|string',
        ]);

        $user = Auth::user();
        $timezone = $request->timezone ?? session('timezone', 'UTC');

        $workSession = WorkSession::where('user_id', $user->id)
            ->where('status', 'paused')
            ->first();

        if (!$workSession) {
            return redirect()->back()->with('error', 'No paused work session found');
        }

        // Calculate pause duration
        $pauseDuration = $workSession->paused_at->diffInSeconds(now()); // Always use UTC
        $newTotalPausedTime = $workSession->total_paused_time + $pauseDuration;

        $workSession->update([
            'status' => 'active',
            'resumed_at' => now(), // Always use UTC
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
        $request->validate([
            'timezone' => 'nullable|string',
        ]);

        $user = Auth::user();
        $timezone = $request->timezone ?? session('timezone', 'UTC');

        $workSession = WorkSession::where('user_id', $user->id)
            ->whereIn('status', ['active', 'paused'])
            ->first();

        if (!$workSession) {
            return redirect()->back()->with('error', 'No active work session found');
        }

        $finalWorkingTime = $workSession->current_working_time;

        $workSession->update([
            'status' => 'completed',
            'ended_at' => now(), // Always use UTC
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
            'timezone' => 'nullable|string',
        ]);

        $user = Auth::user();
        $timezone = $request->timezone ?? session('timezone', 'UTC');

        $project = ProjectTracking::create([
            'user_id' => $user->id,
            'project_type' => $request->project_type,
            'project_title' => $request->project_title,
            'project_code' => $request->project_code,
            'project_link' => $request->project_link,
            'role' => $request->role,
            'status' => 'active',
            'start_at' => now(), // Always use UTC
            'notes' => $request->notes,
        ]);

        Log::info('Project started', [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'project_title' => $request->project_title,
            'timezone' => $timezone
        ]);

        return redirect()->back()->with('success', 'Project started successfully');
    }

    /**
     * End a project
     */
    public function endProject(Request $request, $id)
    {
        $request->validate([
            'timezone' => 'nullable|string',
        ]);

        $user = Auth::user();
        $timezone = $request->timezone ?? session('timezone', 'UTC');

        $project = ProjectTracking::where('user_id', $user->id)
            ->where('id', $id)
            ->where('status', 'active')
            ->first();

        if (!$project) {
            return redirect()->back()->with('error', 'Project not found or already completed');
        }

        $workingDuration = $project->calculateWorkingDuration();

        $project->update([
            'status' => 'completed',
            'end_at' => now(), // Always use UTC
            'working_duration' => $workingDuration,
        ]);

        Log::info('Project ended', [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'project_title' => $project->project_title,
            'working_duration' => $workingDuration,
            'formatted_duration' => $project->formatted_working_duration,
            'timezone' => $timezone
        ]);

        return redirect()->back()->with('success', 'Project completed successfully. Duration: ' . $project->formatted_working_duration);
    }

    /**
     * Get current work session status (for AJAX)
     */
        public function getWorkSessionStatus()
    {
        $user = Auth::user();
        $timezone = session('timezone', $user->timezone ?? 'UTC');

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
        $timezone = session('timezone', $user->timezone ?? 'UTC');
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
        $timezone = session('timezone', $user->timezone ?? 'UTC');
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
}
