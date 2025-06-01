<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Company;
use App\Models\Project;
use App\Models\ProjectLog;
use App\Models\CompanyTalent;
use App\Models\ProjectType;
use App\Models\Invitation;
use App\Mail\UserInvitation;


use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
        $user = auth()->user();
        $company = Company::where('user_id', $user->id)->first();
        $companyId = Company::where('user_id', auth()->id())->value('id');

        // Fetch counts for "On Going Projects" based on status for the authenticated company
        $projectCounts = Project::where('company_id', $companyId)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Prepare counts with default values if a status has no projects
        $onGoingProjects = [
            'waiting talent' => $projectCounts['waiting talent'] ?? 0,
            'project assign' => $projectCounts['project assign'] ?? 0,
            'Project QC ' => $projectCounts['Project QC'] ?? 0,
            'Revision' => $projectCounts['Revision'] ?? 0,
            'Done' => $projectCounts['Done'] ?? 0,
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
        $projects = Project::where('company_id', $companyId)
                ->with('qcAgent')
                ->orderBy('created_at', 'asc')
                ->paginate(5);

        // New Project Fields
        $projectTypes = ProjectType::where('company_id', $companyId)->get();
        $talents = CompanyTalent::where('job_role', 'talent')
                ->where('company_id', $companyId)
                ->with('user')
                ->get();

        return view('users.Company.index', [
            'user' => auth()->user(),
            'onGoingProjects' => $onGoingProjects,
            'monthlyProjectData' => $chartData,
            'chartLabels' => $months,
            'projects' => $projects,
            'projectTypes' => $projectTypes,
            'talents' => $talents,
            'company' => $company
        ]);
    }

    // Store Project
    public function storeProject(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'project_name' => 'required|string|max:255',
                'project_volume' => 'required|numeric|min:0',
                'project_file' => 'nullable|url|max:255', // Changed to URL validation
                'project_type_id' => 'required|exists:project_types,id',
                'talent' => 'nullable|exists:users,id',
                'qc_agent' => 'nullable|exists:users,id',
                'project_rate' => 'required|numeric|min:0',
                'qc_rate' => 'required|numeric|min:0',
                'bonuses' => 'nullable|numeric|min:0',
                'start_date' => 'required|date',
                'finish_date' => 'required|date|after:start_date',
                'qc_type' => 'required|in:self,talent',
            ]);

            $user = auth()->user();
            $company = Company::where('user_id', $user->id)->first();
            $companyId = Company::where('user_id', auth()->id())->value('id');

            $validated['company_id'] = $companyId;
            $validated['user_id'] = auth()->id();
            $validated['status'] = 'waiting talent';

            // Create the project using validated data
            $project = Project::create($validated);

            // Create initial project log
            $project->projectLogs()->create([
                'user_id' => auth()->id(),
                'project_id' => $project->id,
                'company_id' => $project->company_id,
                'status' => $project->status,
                'timestamp' => now(),
                'talent_id' => $project->talent,
                'talent_qc_id' => $project->qc_agent,
            ]);

            return redirect()->back()->with('success', 'Project created successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors());
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

        // get company based on user_id
        $company = Company::where('user_id', auth()->user()->id)->first();
        $projectTypes =ProjectType::where('company_id', $company->id)->paginate(10);

        return view ('users.Company.settings', [
            'company' => $company,
            'projectTypes' => $projectTypes
        ]);
    }

    // Store Project Type
    public function storeProjectType(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'user_id' => 'required|string|max:255',
            'company_id' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'project_rate' => 'required|string|max:255',
        ]);

        try {

            ProjectType::create([
                'user_id' => $request->user_id,
                'company_id' => $request->company_id,
                'project_rate' => $request->project_rate,
                'project_name' => $request->project_name,
            ]);

            return redirect()->back()->with('success', 'Project type created successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create project type: ' . $e->getMessage());
        }
    }

    // Edit Project Type
    public function editProjectType($id)
    {
        // Find the project type
        $projectType = ProjectType::findOrFail($id);

        // Check if the authenticated user's company owns this project type
        if ($projectType->company_id !== auth()->user()->company->id) {
            abort(403, 'Unauthorized action.');
        }

        // You will need to create a view for editing project types
        // return view('users.Company.edit-project-type', ['projectType' => $projectType]);
         return redirect()->back()->with('info', 'Edit functionality not yet implemented.');
    }

    // Delete Project Type
    public function destroyProjectType($id)
    {
        try {
            // Find the project type
            $projectType = ProjectType::findOrFail($id);
            $projectType->delete();

            return redirect()->back()->with('success', 'Project type deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete project type: ' . $e->getMessage());
        }
    }

    public function inviteUserByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email', // Validate email and check if user already exists
        ]);

        $email = $request->email;
        $invitingUser = auth()->user();
        $company = Company::where('user_id', $invitingUser->id)->first();
        // $companyId = Company::where('user_id', auth()->id())->value('id');
        // $invitingUser = auth()->user();
        // $company = $invitingUser->company;

        if (!$company) {
            return response()->json(['message' => 'User is not associated with a company.'], 400);
        }

        // Check if an invitation already exists for this email and company
        $existingInvitation = Invitation::where('email', $email)->where('company_id', $company->id)->first();
        if ($existingInvitation) {
             return response()->json(['message' => 'An invitation has already been sent to this email for this company.'], 409);
        }


        // 1. Generate a unique invitation token
        $token = Str::random(60); // Or use UUIDs

        // 2. Store the invitation details in a database table (you'll need an 'invitations' table)
        // This table should store email, token, company_id, inviting_user_id, and potentially expiration
        $invitation = Invitation::create([
            'email' => $email,
            'token' => $token,
            'company_id' => $company->id,
            'inviting_user_id' => $invitingUser->id,
            'expires_at' => now()->addDays(7), // Example: expire in 7 days
        ]);

        // 3. Send an email to the invited user with a link containing the token
        // You'll need to create a Mailable class (e.g., App\Mail\UserInvitation)
        // And a view for the email content
        // The link should point to a route that handles invitation acceptance/registration
        $invitationLink = url('/register?token=' . $token); // Example link structure
        Mail::to($email)->send(new UserInvitation($invitationLink, $invitingUser, $company));

        // Success response
        return response()->json(['message' => 'Invitation email sent to ' . $email], 200);
    }

}
