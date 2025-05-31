<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Company;
use App\Models\Project;
use App\Models\ProjectLog;
use App\Models\CompanyTalent;


use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{

     /**
     * Display the company registration form.
     */
    public function create()
    {
        return view('auth.company-register'); // Kita akan buat view ini di langkah selanjutnya
    }

    /**
     * Handle an incoming company registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_type' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'contact_person_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
            'terms' => ['required', 'accepted'],
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->contact_person_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'company',
        ]);

        // Create the company profile linked to the user
        Company::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'company_type' => $request->company_type,
            'country' => $request->country,
            'contact_person_name' => $request->contact_person_name,
        ]);

        // Log the user in (optional, depending on your flow)
        // Auth::login($user);

        // Redirect after successful registration
        return redirect()->route('home')->with('success', 'Company registered successfully');
    }


    public function index()
    {
        $companyId = auth()->user()->company_id;

        // Fetch counts for "On Going Projects" based on status for the authenticated company
        $projectCounts = Project::where('company_id', $companyId)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Prepare counts with default values if a status has no projects
        $onGoingProjects = [
            'waiting talent' => $projectCounts['waiting talent'] ?? 0,
            'assign' => $projectCounts['assign'] ?? 0,
            'qc' => $projectCounts['qc'] ?? 0,
            'draft' => $projectCounts['draft'] ?? 0,
            'revision' => $projectCounts['revision'] ?? 0,
            'completed' => $projectCounts['completed'] ?? 0,
        ];

        // Fetch monthly project statistics for the current year for the authenticated company
        $currentYear = date('Y');
        $monthlyProjects = Project::where('company_id', $companyId)
            ->whereYear('start_date', $currentYear)
            ->select(DB::raw('MONTH(start_date) as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Prepare data for the chart (full year, 0 if no projects in a month)
        $chartData = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyProjects[$i] ?? 0;
        }

        // Fetch the list of projects for the authenticated company with pagination
        $projects = Project::where('company_id', $companyId)->paginate(10);

        // Define columns for the project table
        $projectColumns = [
            ['label' => 'Project Name', 'key' => 'project_name'],
            ['label' => 'Project Type', 'key' => 'projectType.name'],
            ['label' => 'Volume', 'key' => 'project_volume'],
            ['label' => 'Rate', 'key' => 'project_rate'],
            ['label' => 'Status', 'key' => 'status'],
            ['label' => 'Start Date', 'key' => 'start_date'],
            ['label' => 'Finish Date', 'key' => 'finish_date'],

        ];

        return view('users.Company.index', [
            'user' => auth()->user(), // Pass authenticated user
            'onGoingProjects' => $onGoingProjects,
            'monthlyProjectData' => $chartData,
            'chartLabels' => $months,
            'projects' => $projects, // Pass projects to the view
            'projectColumns' => $projectColumns, // Pass column definition to the view
        ]);
    }


    // Project Store Data
    public function storeProject(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'project_volume' => 'required|string|max:255',
            'project_file' => 'nullable|string|max:255',
            'project_type_id' => 'required|exists:project_types,id',
            'talent' => 'nullable|exists:users,id',
            'qc_agent' => 'nullable|exists:users,id',
            'project_rate' => 'required|numeric|min:0',
            'qc_rate' => 'required|numeric|min:0',
            'bonuses' => 'nullable|numeric|min:0',
            'status' => 'required|max:225',
            'start_date' => 'required|date',
            'finish_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        try {
            // Add user_id and company_id
            $validated['user_id'] = auth()->id();
            $validated['company_id'] = auth()->user()->company_id;
            $validated['status'] = 'waiting talent'; // Set initial status

            // Create the project
            $project = Project::create($validated);

            // Create initial project log
            ProjectLog::create([
                'user_id' => auth()->id(),
                'project_id' => $project->id,
                'company_id' => $project->company_id,
                'talent_id' => $project->talent,
                'talent_qc_id' => $project->qc_agent,
                'timestamp' => now(),
                'status' => 'waiting talent'
            ]);

            return redirect()->back()->with('success', 'Project created successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create project: ' . $e->getMessage());
        }
    }

    // Edit Project
    public function editProject(Request $request, $id)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'project_name' => 'required|string|max:255',
                'project_volume' => 'required|string|max:255',
                'project_file' => 'nullable|string|max:255',
                'project_type_id' => 'required|exists:project_types,id',
                'talent' => 'nullable|exists:users,id',
                'qc_agent' => 'nullable|exists:users,id',
                'project_rate' => 'required|numeric|min:0',
                'qc_rate' => 'required|numeric|min:0',
                'bonuses' => 'nullable|numeric|min:0',
                'status' => 'required|max:225',
                'start_date' => 'required|date',
                'finish_date' => 'nullable|date|after_or_equal:start_date',
            ]);

            // Find the project
            $project = Project::findOrFail($id);

            // Check if user has permission to edit this project
            if ($project->company_id !== auth()->user()->company_id) {
                return redirect()->back()->with('error', 'You do not have permission to edit this project');
            }

            // Update the project
            $project->update($validated);

            // Create project log for the update
            ProjectLog::create([
                'user_id' => auth()->id(),
                'project_id' => $project->id,
                'company_id' => $project->company_id,
                'talent_id' => $project->talent,
                'talent_qc_id' => $project->qc_agent,
                'timestamp' => now(),
                'status' => $project->status
            ]);

            return redirect()->back()->with('success', 'Project updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update project: ' . $e->getMessage());
        }
    }

    // Delete Project
    public function deleteProject($id)
    {
        try {
            // Find the project
            $project = Project::findOrFail($id);

            // Check if user has permission to delete this project
            if ($project->company_id !== auth()->user()->company_id) {
                return redirect()->back()->with('error', 'You do not have permission to delete this project');
            }

            // Delete the project
            $project->delete();

            return redirect()->back()->with('success', 'Project deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete project: ' . $e->getMessage());
        }
    }

    // Detail Project
    public function detailProject($slug)
    {
        try {
            // Find the project by slug
            $id = explode('-', $slug)[0];
            $project = Project::findOrFail($id);

            // Get project logs with related dataE
            $projectLogs = $project->projectLogs()
                ->with(['user', 'talent', 'talentQc'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('users.Company.project-detail', [
                'project' => $project,
                'projectLogs' => $projectLogs
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load project details: ' . $e->getMessage());
        }
    }

    // Project Overview List
    public function projectOverview()
    {
        try {
            // Get all projects with related data
            $projects = Project::with(['projectType', 'talent', 'talentQc'])
                ->where('company_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('users.Company.project-overview', [
                'projects' => $projects
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load project overview: ' . $e->getMessage());
        }
    }

    // Users Overview
    public function usersOverview()
    {
        try {
            // Get current user's company
            $currentUser = auth()->user();
            $company = $currentUser->company;

            if (!$company) {
                return redirect()->back()->with('error', 'Company not found');
            }

            // Get all users who are either assigned as talents or have assigned talents
            $users = User::whereHas('companyTalent', function($query) use ($company) {
                    $query->where('company_id', $company->id);
                })
                ->orWhereHas('assignedTalents', function($query) use ($company) {
                    $query->where('company_id', $company->id);
                })
                ->with([
                    'companyTalent' => function($query) use ($company) {
                        $query->where('company_id', $company->id);
                    },
                    'assignedTalents' => function($query) use ($company) {
                        $query->where('company_id', $company->id);
                    }
                ])
                ->get();

            return view('users.Company.users-overview', [
                'users' => $users
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load users overview: ' . $e->getMessage());
        }
    }

    // Detail User Profile
    public function detailUser($slug)
    {
        try {
            // Find the user by slug
            $id = explode('-', $slug)[0];
            $user = User::findOrFail($id);

            // Get user's company talent
            $companyTalent = CompanyTalent::where('user_id', $user->id)->first();

            return view('users.Company.user-detail', [
                'user' => $user,
                'companyTalent' => $companyTalent
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load user details: ' . $e->getMessage());
        }
    }

    // Settings
    public function companySettings()
    {

        return view ('users.Company.settings');
    }

}
