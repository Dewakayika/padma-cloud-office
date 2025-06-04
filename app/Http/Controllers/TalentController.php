<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Talent;
use App\Models\Company;
use App\Models\Project;
use App\Models\ProjectLog;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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
            ->whereIn('status', ['in_progress', 'qc', 'revision'])
            ->count();

        $projectQC = Project::where('company_id', $company->id)
            ->where('status', 'qc')
            ->count();

        $projectThisMonth = Project::where('company_id', $company->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalProjects = Project::where('company_id', $company->id)
            ->where('status', 'completed')
            ->count();

        // Project Status Counts
        $projectAssign = Project::where('company_id', $company->id)
            ->where('status', 'in_progress')
            ->count();

        $projectQCStatus = Project::where('company_id', $company->id)
            ->where('status', 'qc')
            ->count();

        $projectRevision = Project::where('company_id', $company->id)
            ->where('status', 'revision')
            ->count();

        $projectDone = Project::where('company_id', $company->id)
            ->where('status', 'completed')
            ->count();

        // Project Offers (waiting talent)
        $projectOffers = Project::where('company_id', $company->id)
            ->where('status', 'waiting talent')
            ->with('projectType')
            ->paginate(5);

        // All Projects
        $allProjects = Project::where('company_id', $company->id)
            ->where('status', '!=', 'waiting talent')
            ->with(['projectType', 'User'])
            ->paginate(5);

        // Top 5 Last Updated Projects
        $recentProjects = Project::where('company_id', $company->id)
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
                $q->where('talent_id', $user->id);
            });
        })->with(['projectType', 'User']);

        // Status filtering
        $status = $request->get('status', 'all');
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

    public function projectDetail()
    {
        return view('users.Talent.project-detail');
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
}
