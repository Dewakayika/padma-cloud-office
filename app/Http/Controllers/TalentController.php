<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Talent;
use App\Models\Company;
use App\Models\Project;
use App\Models\ProjectLog;
use App\Models\ProjectType;
use App\Models\ProjectSop;
use App\Models\ProjectRecord;
use App\Models\Feedback;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TalentController extends Controller
{
    /**
     * Display the talent registration form.
     */
    public function create()
    {
        return view('auth.talent-register'); // Kita akan buat view ini di langkah selanjutnya
    }

    /**
     * Handle an incoming talent registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'gender' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date'],
            'id_card' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account' => ['nullable', 'string', 'max:255'],
            'swift_code' => ['nullable', 'string', 'max:20'],
            'subjected_tax' => ['nullable', 'max:20'],
            'terms' => ['required', 'accepted'],
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'talent',
        ]);

        // Create the talent profile linked to the user
        Talent::create([
            'user_id' => $user->id,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'id_card' => $request->id_card,
            'bank_name' => $request->bank_name,
            'bank_account' => $request->bank_account,
            'swift_code' => $request->swift_code,
            'subjected_tax' => $request->subjected_tax,
        ]);

        return redirect()->route('home')->with('success', 'Talent registered successfully..');
    }

    // Talent Dashboard
    public function index() {
        // Get Company List in table company Talent
        $user = auth()->user();
        $companies = Company::whereHas('companyTalent', function($query) use ($user) {
            $query->where('talent_id', $user->id);
        })->get();

        // Get Project List in table project Talent
        $projects = Project::whereHas('company', function($query) use ($user) {
            $query->whereHas('companyTalent', function($q) use ($user) {
                $q->where('talent_id', $user->id);
            });
        })
        ->where('status', 'waiting talent')
        ->get();

        return view('users.Talent.landing-page', compact('companies', 'projects'));
    }

    public function detailCompany($slug)
    {
        $user = auth()->user();
        $company = Company::where('company_name', 'LIKE', '%' . str_replace('-', ' ', $slug) . '%')
            ->orWhere('company_name', 'LIKE', '%' . ucwords(str_replace('-', ' ', $slug)) . '%')
            ->firstOrFail();

        // Score Card Data
        $onGoingProjects = Project::where('company_id', $company->id)
            ->where('talent', $user->id)
            ->whereIn('status', ['project assign', 'draf', 'qc', 'revision'])
            ->count();

        $projectQC = Project::where('company_id', $company->id)
            ->where('talent', $user->id)
            ->where('status', 'qc')
            ->count();

        $projectThisMonth = Project::where('company_id', $company->id)
            ->where('talent', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalProjects = Project::where('company_id', $company->id)
            ->where('talent', $user->id)
            ->where('status', 'completed')
            ->count();

        // Project Status Counts
        $projectAssign = Project::where('company_id', $company->id)
            ->where('talent', $user->id)
            ->where('status', 'project assign')
            ->count();

        $projectQCStatus = Project::where('company_id', $company->id)
            ->where('talent', $user->id)
            ->where('status', 'qc')
            ->count();

        $projectRevision = Project::where('company_id', $company->id)
            ->where('talent', $user->id)
            ->where('status', 'revision')
            ->count();

        $projectDone = Project::where('company_id', $company->id)
            ->where('talent', $user->id)
            ->where('status', 'done')
            ->count();

        // Project Offers (waiting talent)
        $projectOffers = Project::where('company_id', $company->id)
            ->where('status', 'waiting talent')
            ->with('projectType')
            ->paginate(5);

        // All Projects
        $allProjects = Project::where('company_id', $company->id)
            ->where('talent', $user->id)
            ->where('status', '!=', 'waiting talent')
            ->with(['projectType', 'User'])
            ->paginate(5);

        // Top 5 Last Updated Projects
        $recentProjects = Project::where('company_id', $company->id)
            ->where('talent', $user->id)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('users.Talent.index', compact(
            'company',
            'onGoingProjects',
            'projectQC',
            'projectThisMonth',
            'totalProjects',
            'projectAssign',
            'projectQCStatus',
            'projectRevision',
            'projectDone',
            'projectOffers',
            'allProjects',
            'recentProjects'
        ));
    }

    public function manageProjects(Request $request)
    {
        $user = auth()->user();

        // Base query for projects
        $query = Project::whereHas('company', function($query) use ($user) {
            $query->whereHas('companyTalent', function($q) use ($user) {
                $q->where('talent', $user->id);
            });
        })->with(['projectType', 'User']);

        // Status filtering
        $status = $request->get('status', ['project assign', 'draf', 'qc', 'revision', 'done']);
        switch ($status) {
            case 'ongoing':
                $query->whereIn('status', ['project assign', 'draft']);
                break;
            case 'qc':
                $query->where('status', 'qc');
                break;
            case 'revision':
                $query->where('status', 'revision');
                break;
            case 'completed':
                $query->where('status', 'done');
                break;
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('project_name', 'LIKE', "%{$search}%");
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('project_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('project_name', 'desc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $projects = $query->paginate(10);

        return view('users.Talent.talent-manage-projects', compact('projects'));
    }

    /**
     * Display the project detail page for a talent.
     *
     * @param  \App\Models\Project  $id
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function projectDetail(Project $id)
    {
        // Laravel's route model binding will automatically find the Project by the {id} from the route
        $project = $id;

        // Debug output
        \Log::info('Project Status:', ['status' => $project->status]);

        // Check if the authenticated user is the assigned talent for this project
        if ($project->assignedTalent && $project->assignedTalent->id !== auth()->id()) {
            abort(403, 'You are not authorized to view this project.');
        }

        // Eager load relationships, including sorting logs by timestamp
        $project->load(['company', 'projectType', 'assignedTalent', 'assignedQcAgent', 'projectLogs' => function($query) {
            $query->orderBy('timestamp');
        }]);

        // Get SOP list based on project type and company
        $sopList = ProjectSop::where('project_type_id', $project->project_type_id)
            ->where('company_id', $project->company_id)
            ->get();

        // Get project records
        $projectRecords = ProjectRecord::where('project_id', $project->id)
            ->with(['talent', 'qc'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Find the timestamp for the initial project assignment
        $assignLog = $project->projectLogs->first(function($log) {
            return $log->status === 'project assign';
        });
        $assignTimestamp = $assignLog ? $assignLog->timestamp->toISOString() : null;

        // Find the timestamp for the 'done' status (if completed)
        $doneLog = $project->projectLogs->where('status', 'done')->last();
        $doneTimestamp = $doneLog ? $doneLog->timestamp->toISOString() : null;

        // Feedback logic
        $currentUser = auth()->user();
        $talentFeedbackExists = Feedback::where('project_id', $project->id)
            ->where('from_user_id', $currentUser->id)
            ->where('role', 'talent')
            ->exists();

        $role = auth()->user()->role;
        $feedbackExists = $role === 'company' ? $companyFeedbackExists : $talentFeedbackExists;

        return view('users.Talent.talent-project-detail', compact(
            'project',
            'assignTimestamp',
            'doneTimestamp',
            'sopList',
            'projectRecords',
            'talentFeedbackExists'
        ));
    }

    public function report()
    {
        return view('users.Talent.report');
    }


    //Talen Landing Page
    public function eWallet()
    {
        return view('users.Talent.e-wallet');
    }

    public function statistic()
    {
        return view('users.Talent.statistic');
    }

    /**
     * Handle the project application by a talent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $id // Laravel will bind the Project model based on the {id} route parameter
     * @return \Illuminate\Http\RedirectResponse
     */
    public function applyProject(Request $request, Project $id)
    {

        $user = Auth::user(); // The authenticated talent

        // Update the Project table
        $id->talent = $user->id; // Using $id as the Project model instance
        $id->status = 'project assign'; // Or a status code representing 'assigned'
        $id->save();

        // Create a log entry in the ProjectLog table
        ProjectLog::create([
            'user_id' => $user->id, // The user who applied
            'project_id' => $id->id, // Using $id as the Project model instance
            'company_id' => $id->company_id, // Using $id as the Project model instance
            'talent_id' => $user->id, // The talent who applied
            'timestamp' => now(),
            'status' => 'project assign', // Or a more descriptive log status
        ]);

        return redirect()->back()->with('success', 'Successfully applied for the project!'); // Redirect back to the dashboard or project list
    }

    /**
     * Store a new project record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeProjectRecord(Request $request, Project $project)
    {
        $request->validate([
            'project_title' => 'required|string|max:255',
            'project_type' => 'required|string|max:255',
            'project_code' => 'nullable|string|max:255',
            'project_link' => 'nullable|url|max:255',
            'role' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $user = auth()->user();

        // Check if user is a talent and has access to this project
        if ($user->role !== 'talent') {
            return redirect()->back()->with('error', 'Access denied.');
        }

        // Check if talent is part of the company that owns this project
        $companyTalent = \App\Models\CompanyTalent::where('talent_id', $user->id)
            ->where('company_id', $project->company_id)
            ->first();

        if (!$companyTalent) {
            return redirect()->back()->with('error', 'You do not have access to this project.');
        }

        // Create project record
        ProjectRecord::create([
            'project_id' => $project->id,
            'talent_id' => $user->id,
            'project_title' => $request->project_title,
            'project_type' => $request->project_type,
            'project_code' => $request->project_code,
            'project_link' => $request->project_link,
            'role' => $request->role,
            'notes' => $request->notes,
            'start_at' => now(),
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Project record created successfully.');
    }

    /**
     * Save additional talent information
     */
    public function saveAdditionalInfo(Request $request)
    {
        // Validate that user is a talent
        if (auth()->user()->role !== 'talent') {
            return redirect()->back()->with('error', 'Access denied. Only talents can update this information.');
        }

        $request->validate([
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:1000',
            'gender' => 'required|string|in:male,female,other',
            'date_of_birth' => 'required|date',
            'id_card' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'swift_code' => 'nullable|string|max:20',
            'subjected_tax' => 'nullable|string|in:yes,no,exempt',
        ]);

        $user = auth()->user();
        $talent = Talent::where('user_id', $user->id)->first();


        $talent->update([
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'id_card' => $request->id_card,
            'bank_name' => $request->bank_name,
            'bank_account' => $request->bank_account,
            'swift_code' => $request->swift_code,
            'subjected_tax' => $request->subjected_tax,
        ]);

        return redirect()->back()->with('success', 'Additional information saved successfully.');
    }
}
