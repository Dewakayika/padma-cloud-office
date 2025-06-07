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
use App\Models\ProjectSop;
use App\Models\ProjectRecord;
use App\Models\Feedback;


use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

        if (!$company) {
            return redirect()->route('home')->with('error', 'Company not found.');
        }

        // Get filter parameters
        $year = request('year', date('Y'));
        $projectType = request('project_type');

        // Base query function to apply filters
        $baseQuery = function($query) use ($year, $projectType) {
            $query->whereYear('created_at', $year);
            if ($projectType) {
                $query->where('project_type_id', $projectType);
            }
        };

        // Calculate average serving time with filters
        $averageServingTime = ProjectLog::calculateAverageServingTime(
            $user->id,
            $company->id,
            $year,
            $projectType
        );

        // Get monthly completion stats with filters
        $monthlyStats = ProjectLog::getMonthlyCompletionStats(
            $company->id,
            $year,
            $projectType
        );

        // Get on-going projects with filters
        $onGoingProjects = Project::where('company_id', $company->id)
            ->where('status', 'on-going')
            ->when($projectType, function($query) use ($projectType) {
                $query->where('project_type_id', $projectType);
            })
            ->count();

        // Get total projects with filters
        $totalProjects = Project::where('company_id', $company->id)
            ->when($projectType, function($query) use ($projectType) {
                $query->where('project_type_id', $projectType);
            })
            ->count();

        // Get total volume with filters
        $totalVolume = Project::where('company_id', $company->id)
            ->when($projectType, function($query) use ($projectType) {
                $query->where('project_type_id', $projectType);
            })
            ->sum('project_volume');

        // Get project types for the company
        $projectTypes = ProjectType::where('company_id', $company->id)->get();

        // Get talents for the company
        $talents = User::whereHas('companyTalent', function($query) use ($company) {
            $query->where('company_id', $company->id)
                  ->where('job_role', 'talent');
        })->get();

        // Get projects with pagination and filters
        $projects = Project::where('company_id', $company->id)
            ->when($projectType, function($query) use ($projectType) {
                $query->where('project_type_id', $projectType);
            })
            ->when($year, function($query) use ($year) {
                $query->whereYear('created_at', $year);
            })
            ->with(['projectType', 'qcAgent'])
            ->latest()
            ->paginate(10);

        // Get project type statistics for each month
        if (!$projectType) {
            $projectTypeStats = Project::where('company_id', $company->id)
                ->whereYear('created_at', $year)
                ->where('status', 'done')
                ->selectRaw('MONTH(created_at) as month, project_type_id, COUNT(*) as count')
                ->groupBy('month', 'project_type_id')
                ->get()
                ->groupBy('month');

            // Initialize monthly stats array with all months
            $monthlyStatsArray = [];
            for ($month = 1; $month <= 12; $month++) {
                $monthlyStatsArray[$month] = [
                    'count' => $monthlyStats[$month] ?? 0,
                    'types' => []
                ];
            }

            // Merge project type stats into monthly stats
            foreach ($projectTypeStats as $month => $stats) {
                $monthlyStatsArray[$month]['types'] = $stats->mapWithKeys(function($item) {
                    return [$item->project_type_id => $item->count];
                })->toArray();
            }

            $monthlyStats = $monthlyStatsArray;
        }

        return view('users.Company.index', compact(
            'company',
            'averageServingTime',
            'monthlyStats',
            'onGoingProjects',
            'totalProjects',
            'totalVolume',
            'projects',
            'projectTypes',
            'talents'
        ));
    }

    // Store Project
    public function storeProject(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'project_name' => 'required|string|max:255',
                'project_volume' => 'required|numeric|min:0',
                'project_file' => 'nullable|url|max:255',
                'project_type_id' => 'required|exists:project_types,id',
                'talent' => 'nullable|exists:users,id',
                'qc_agent' => 'nullable|exists:users,id',
                'project_rate' => 'required|numeric|min:0',
                'qc_rate' => 'required|numeric|min:0',
                'bonuses' => 'nullable|numeric|min:0',
                'qc_type' => 'required|in:self,talent',
            ]);

            $user = auth()->user();
            $company = Company::where('user_id', $user->id)->first();
            $companyId = Company::where('user_id', auth()->id())->value('id');

            $validated['start_date'] = now();
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

            // Find the project by slug
            $id = explode('-', $slug)[0];
            $project = Project::with([
                'projectType',
                'assignedQcAgent',
                'projectLogs' => function($query) {
                    $query->orderBy('timestamp', 'asc');
                },
                'projectRecords' => function($query) {
                    $query->orderBy('created_at', 'asc');
                },
                'user',
                'company'
            ])->findOrFail($id);

            // Get the company
            $company = Company::where('user_id', auth()->id())->first();

            if (!$company || $project->company_id !== $company->id) {
                return redirect()->route('company.manage.projects')
                    ->with('error', 'Project not found or unauthorized access.');
            }

            // Get assign and done timestamps
            $assignTimestamp = $project->projectLogs
                ->where('status', 'project assign')
                ->first()?->timestamp;

            $doneTimestamp = $project->projectLogs
                ->where('status', 'done')
                ->first()?->timestamp;

            // Calculate total time if project is done
            if ($project->status === 'done' && $assignTimestamp && $doneTimestamp) {
                $totalTime = $assignTimestamp->diffInSeconds($doneTimestamp);
                $days = floor($totalTime / (24 * 3600));
                $hours = floor(($totalTime % (24 * 3600)) / 3600);
                $minutes = floor(($totalTime % 3600) / 60);
                $seconds = $totalTime % 60;

                $project->total_time = [
                    'days' => $days,
                    'hours' => $hours,
                    'minutes' => $minutes,
                    'seconds' => $seconds,
                    'total_seconds' => $totalTime,
                    'start_date' => $assignTimestamp,
                    'end_date' => $doneTimestamp
                ];
            }

            // Get project records
            $projectRecords = $project->projectRecords()
                ->with(['talent', 'qc'])
                ->orderBy('created_at', 'asc')
                ->get();

            // Add status timeline data
            $project->status_timeline = $project->projectLogs->map(function($log) {
                return [
                    'status' => $log->status,
                    'timestamp' => $log->timestamp,
                    'user' => $log->user->name ?? 'System',
                    'message' => $log->message
                ];
            });

            // Feedback logic
            $currentUser = auth()->user();
            $companyFeedbackExists = Feedback::where('project_id', $project->id)
                ->where('from_user_id', $currentUser->id)
                ->where('role', 'company')
                ->exists();
            $talentFeedbackExists = Feedback::where('project_id', $project->id)
                ->where('from_user_id', $currentUser->id)
                ->where('role', 'talent')
                ->exists();

            return view('users.Company.company-project-detail', compact(
                'project',
                'assignTimestamp',
                'doneTimestamp',
                'projectRecords',
                'companyFeedbackExists',
                'talentFeedbackExists'
            ));

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
        $projectTypes = ProjectType::where('company_id', $company->id)->paginate(5);

        // Get team members
        $teamMembers = User::whereHas('companyTalent', function($query) use ($company) {
            $query->where('company_id', $company->id)
                  ->whereIn('job_role', ['talent', 'talent_qc']); // Filter by the correct job roles
        })
        ->with(['companyTalent' => function($query) use ($company) {
            $query->where('company_id', $company->id)
                  ->select('id', 'company_id', 'user_id', 'talent_id', 'job_role'); // Select necessary columns
        }])
        ->paginate(5);

        return view('users.Company.settings', [
            'company' => $company,
            'projectTypes' => $projectTypes,
            'teamMembers' => $teamMembers
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
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:talent,talent_qc',
        ]);

        $email = $request->email;
        $invitingUser = auth()->user();
        $company = Company::where('user_id', $invitingUser->id)->first();

        if (!$company) {
            return redirect()->back()->with('error', 'User is not associated with a company.');
        }

        // Check if an invitation already exists for this email and company
        $existingInvitation = Invitation::where('email', $email)
            ->where('company_id', $company->id)
            ->first();

        if ($existingInvitation) {
            return redirect()->back()->with('warning', 'An invitation has already been sent to this email for this company.');
        }

        // Generate a unique invitation token
        $token = Str::random(60);

        try {
            // Store the invitation details
            $invitation = Invitation::create([
                'email' => $email,
                'role' => $request->role,
                'token' => $token,
                'company_id' => $company->id,
                'inviting_user_id' => $invitingUser->id,
                'expires_at' => now()->addDays(7),
            ]);

            // Send invitation email
            $invitationLink = url('/register?token=' . $token);
            Mail::to($email)->send(new UserInvitation($invitationLink, $invitingUser, $company));

            return redirect()->back()->with('success', 'Invitation email sent to ' . $email);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send invitation');
        }
    }

    // Project SOPs
    public function getProjectSops($projectTypeId)
    {
        try {
            // Get the company ID from the authenticated user
            $companyId = auth()->user()->company->id;

            // Log the request parameters
            \Log::info('Fetching SOPs for project type', [
                'project_type_id' => $projectTypeId,
                'company_id' => $companyId,
                'user_id' => auth()->id()
            ]);

            // First verify the project type belongs to the company
            $projectType = ProjectType::where('id', $projectTypeId)
                ->where('company_id', $companyId)
                ->first();

            if (!$projectType) {
                \Log::warning('Project type not found or not authorized', [
                    'project_type_id' => $projectTypeId,
                    'company_id' => $companyId
                ]);
                return response()->json(['error' => 'Project type not found or not authorized'], 404);
            }

            // Get the SOPs with detailed logging
            $sops = ProjectSop::where('project_type_id', $projectTypeId)
                ->where('company_id', $companyId)
                ->get();

            \Log::info('SOPs query details', [
                'sql' => ProjectSop::where('project_type_id', $projectTypeId)
                    ->where('company_id', $companyId)
                    ->toSql(),
                'bindings' => [
                    'project_type_id' => $projectTypeId,
                    'company_id' => $companyId
                ]
            ]);

            \Log::info('SOPs fetched successfully', [
                'count' => $sops->count(),
                'project_type_id' => $projectTypeId,
                'sops' => $sops->toArray()
            ]);

            return response()->json($sops);

        } catch (\Exception $e) {
            \Log::error('Error fetching SOPs', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'project_type_id' => $projectTypeId
            ]);
            return response()->json(['error' => 'Failed to fetch SOPs: ' . $e->getMessage()], 500);
        }
    }

    public function storeProjectSop(Request $request)
    {
        try {
            $validated = $request->validate([
            'project_type_id' => 'required|exists:project_types,id',
                'sop_formula' => 'required|string|min:1',
            'description' => 'nullable|string',
        ]);

        $user = auth()->user();
        $company = Company::where('user_id', $user->id)->first();

        if (!$company) {
                return response()->json(['error' => 'User is not associated with a company.'], 403);
        }

        // Find the project type and ensure it belongs to the company
         $projectType = ProjectType::where('id', $request->project_type_id)
                                  ->where('company_id', $company->id)
                                  ->first();

        if (!$projectType) {
                return response()->json(['error' => 'Project type not found for this company.'], 404);
        }

            $sop = ProjectSop::create([
                'user_id' => $user->id,
                'company_id' => $company->id,
                'project_type_id' => $validated['project_type_id'],
                'sop_formula' => $validated['sop_formula'],
                'description' => $validated['description'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Project SOP added successfully.',
                'sop' => $sop
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add project SOP: ' . $e->getMessage()
            ], 500);
        }
    }

    // Show SOPs for a specific project type
    public function showProjectTypeSops($id)
    {
        try {
            $user = auth()->user();
            $company = Company::where('user_id', $user->id)->first();

            if (!$company) {
                return redirect()->back()->with('error', 'User is not associated with a company.');
            }

            $projectType = ProjectType::where('id', $id)
                                    ->where('company_id', $company->id)
                                    ->first();

            if (!$projectType) {
                return redirect()->back()->with('error', 'Project type not found or not authorized.');
            }

            $sops = ProjectSop::where('project_type_id', $id)
                             ->where('company_id', $company->id)
                             ->with('user')
                             ->paginate(10);

            return view('users.Company.sop-details', [
                'projectType' => $projectType,
                'sops' => $sops
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load SOPs: ' . $e->getMessage());
        }
    }

    // Get a specific SOP
    public function getSop($id)
    {
        try {
            $user = auth()->user();
            $company = Company::where('user_id', $user->id)->first();

            if (!$company) {
                return response()->json(['error' => 'User is not associated with a company.'], 403);
            }

            $sop = ProjectSop::where('id', $id)
                            ->where('company_id', $company->id)
                            ->first();

            if (!$sop) {
                return response()->json(['error' => 'SOP not found or not authorized.'], 404);
            }

            return response()->json([
                'id' => $sop->id,
                'sop_formula' => $sop->sop_formula,
                'description' => $sop->description,
                'project_type_id' => $sop->project_type_id
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch SOP: ' . $e->getMessage()], 500);
        }
    }

    // Update a SOP
    public function updateSop(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'sop_formula' => 'required|string|min:1',
                'description' => 'nullable|string',
            ]);

            $user = auth()->user();
            $company = Company::where('user_id', $user->id)->first();

            if (!$company) {
                return response()->json(['error' => 'User is not associated with a company.'], 403);
            }

            $sop = ProjectSop::where('id', $id)
                            ->where('company_id', $company->id)
                            ->first();

            if (!$sop) {
                return response()->json(['error' => 'SOP not found or not authorized.'], 404);
            }

            // Log the incoming data for debugging
            \Log::info('Updating SOP', [
                'id' => $id,
                'request_data' => $request->all(),
                'validated_data' => $validated
            ]);

            $sop->update([
                'sop_formula' => $validated['sop_formula'],
                'description' => $validated['description'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'SOP updated successfully.',
                'sop' => $sop
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error updating SOP', [
                'id' => $id,
                'errors' => $e->errors()
            ]);
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error updating SOP', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update SOP: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete a SOP
    public function deleteSop($id)
    {
        try {
            $user = auth()->user();
            $company = Company::where('user_id', $user->id)->first();

            if (!$company) {
                return response()->json(['error' => 'User is not associated with a company.'], 403);
            }

            $sop = ProjectSop::where('id', $id)
                            ->where('company_id', $company->id)
                            ->first();

            if (!$sop) {
                return response()->json(['error' => 'SOP not found or not authorized.'], 404);
            }

            $sop->delete();

            return response()->json(['success' => true, 'message' => 'SOP deleted successfully.']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete SOP: ' . $e->getMessage()], 500);
        }
    }

    public function statistics()
    {
        $user = auth()->user();
        $company = Company::where('user_id', $user->id)->first();

        if (!$company) {
            return redirect()->route('home')->with('error', 'Company not found.');
        }

        // Get filter parameters
        $year = request('year', date('Y'));
        $projectType = request('project_type');

        // Get project types for the company
        $projectTypes = ProjectType::where('company_id', $company->id)
            ->select('id', 'project_name', 'project_rate')
            ->get();

        // Get monthly completion stats with filters
        $monthlyStats = ProjectLog::getMonthlyCompletionStats(
            $company->id,
            $year,
            $projectType
        );

        // Get project type statistics
        $projectTypeStats = Project::where('company_id', $company->id)
            ->whereYear('created_at', $year)
            ->when($projectType, function($query) use ($projectType) {
                $query->where('project_type_id', $projectType);
            })
            ->selectRaw('project_type_id, COUNT(*) as total_projects, SUM(project_volume) as total_volume')
            ->groupBy('project_type_id')
            ->with('projectType')
            ->get();

        // Get status distribution
        $statusDistribution = Project::where('company_id', $company->id)
            ->whereYear('created_at', $year)
            ->when($projectType, function($query) use ($projectType) {
                $query->where('project_type_id', $projectType);
            })
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Get average completion time by project type
        $completionTimeByType = ProjectLog::where('project_logs.company_id', $company->id)
            ->whereYear('project_logs.timestamp', $year)
            ->where('project_logs.status', 'done')
            ->when($projectType, function($query) use ($projectType) {
                $query->whereHas('project', function($q) use ($projectType) {
                    $q->where('project_type_id', $projectType);
                });
            })
            ->join('projects', 'project_logs.project_id', '=', 'projects.id')
            ->selectRaw('projects.project_type_id, AVG(TIMESTAMPDIFF(MINUTE, project_logs.created_at, project_logs.timestamp)) as avg_time')
            ->groupBy('projects.project_type_id')
            ->with('project.projectType')
            ->get()
            ->keyBy('project_type_id');

        // Get talent statistics
        $talentStats = ProjectLog::where('project_logs.company_id', $company->id)
            ->whereYear('project_logs.timestamp', $year)
            ->when($projectType, function($query) use ($projectType) {
                $query->whereHas('project', function($q) use ($projectType) {
                    $q->where('project_type_id', $projectType);
                });
            })
            ->join('users', 'project_logs.user_id', '=', 'users.id')
            ->join('company_talent', function($join) use ($company) {
                $join->on('users.id', '=', 'company_talent.talent_id')
                    ->where('company_talent.company_id', '=', $company->id);
            })
            ->selectRaw('
                users.id,
                users.name,
                company_talent.job_role,
                COUNT(CASE WHEN project_logs.status = "done" THEN 1 END) as completed_projects,
                COUNT(CASE WHEN project_logs.status = "pending" THEN 1 END) as pending_projects,
                COUNT(CASE WHEN project_logs.status = "in_progress" THEN 1 END) as in_progress_projects,
                AVG(CASE WHEN project_logs.status = "done"
                    THEN TIMESTAMPDIFF(MINUTE, project_logs.created_at, project_logs.timestamp)
                    END) as avg_completion_time
            ')
            ->groupBy('users.id', 'users.name', 'company_talent.job_role')
            ->get();

        return view('users.Company.statistics', compact(
            'company',
            'year',
            'projectType',
            'projectTypes',
            'projectTypeStats',
            'monthlyStats',
            'statusDistribution',
            'completionTimeByType',
            'talentStats'
        ));
    }

    public function manageProjects(Request $request)
    {
        try {
            $user = auth()->user();
            $company = Company::where('user_id', $user->id)->first();

            if (!$company) {
                return redirect()->route('home')->with('error', 'Company not found.');
            }

            // Base query for projects
            $query = Project::where('company_id', $company->id)
                ->with(['projectType', 'User']);

            // Status filtering
            $status = $request->get('status', 'all');
            switch ($status) {
                case 'ongoing':
                    $query->whereIn('status', ['project assign', 'draft']);
                    break;
                case 'qc':
                    $query->where('status', 'qc');
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

            return view('users.Company.company-manage-project', compact('projects'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load projects: ' . $e->getMessage());
        }
    }

    public function manageTalents(Request $request)
    {
        try {
            $user = auth()->user();
            $company = Company::where('user_id', $user->id)->first();

            if (!$company) {
                return redirect()->route('home')->with('error', 'Company not found.');
            }

            // Base query for talents
            $query = User::whereHas('companyTalent', function($query) use ($company) {
                $query->where('company_id', $company->id);
            })->with(['companyTalent' => function($query) use ($company) {
                $query->where('company_id', $company->id);
            }]);

            // Role filtering
            $role = $request->get('role', 'all');
            if ($role !== 'all') {
                $query->whereHas('companyTalent', function($query) use ($role) {
                    $query->where('job_role', $role);
                });
            }

            // Search functionality
            if ($request->has('search')) {
                $search = $request->get('search');
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
                });
            }

            // Sorting
            $sort = $request->get('sort', 'name_asc');
            switch ($sort) {
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default: // name_asc
                    $query->orderBy('name', 'asc');
                    break;
            }

            $talents = $query->paginate(10);

            // Get statistics for each talent
            $talentStats = [];
            foreach ($talents as $talent) {
                $talentStats[$talent->id] = [
                    'total_projects' => Project::where('talent', $talent->id)
                        ->where('company_id', $company->id)
                        ->count(),
                    'completed_projects' => Project::where('talent', $talent->id)
                        ->where('company_id', $company->id)
                        ->where('status', 'done')
                        ->count(),
                    'average_completion_time' => ProjectLog::where('talent_id', $talent->id)
                        ->where('company_id', $company->id)
                        ->where('status', 'done')
                        ->avg(DB::raw('TIMESTAMPDIFF(MINUTE, created_at, timestamp)'))
                ];
            }

            return view('users.Company.manage-talents', compact('talents', 'talentStats'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load talents: ' . $e->getMessage());
        }
    }

    public function talentDetail($id)
    {
        try {
            $user = auth()->user();
            $company = Company::where('user_id', $user->id)->first();

            if (!$company) {
                return redirect()->route('home')->with('error', 'Company not found.');
            }

            // Get the talent user
            $talent = User::with(['talent', 'companyTalent' => function($query) use ($company) {
                $query->where('company_id', $company->id);
            }])->findOrFail($id);

            // Verify the talent is associated with the company
            if (!$talent->companyTalent->contains('company_id', $company->id)) {
                return redirect()->route('company.manage.talents')
                    ->with('error', 'Talent not found in your company.');
            }

            // Get project statistics
            $projectStats = [
                'total' => Project::where('talent', $talent->id)
                    ->where('company_id', $company->id)
                    ->count(),
                'completed' => Project::where('talent', $talent->id)
                    ->where('company_id', $company->id)
                    ->where('status', 'done')
                    ->count(),
                'in_progress' => Project::where('talent', $talent->id)
                    ->where('company_id', $company->id)
                    ->whereIn('status', ['project assign', 'draft'])
                    ->count(),
                'in_qc' => Project::where('talent', $talent->id)
                    ->where('company_id', $company->id)
                    ->where('status', 'qc')
                    ->count()
            ];

            // Get all completed projects with their logs
            $completedProjects = Project::where('talent', $talent->id)
                ->where('company_id', $company->id)
                ->where('status', 'done')
                ->with(['projectLogs' => function($query) {
                    $query->orderBy('created_at', 'asc');
                }])
                ->get();

            // Calculate completion times for all projects
            $completionTimes = $completedProjects->map(function($project) {
                if ($project->projectLogs->isNotEmpty()) {
                    $firstLog = $project->projectLogs->first();
                    $lastLog = $project->projectLogs->last();
                    return $firstLog->created_at->diffInSeconds($lastLog->timestamp);
                }
                return null;
            })->filter();

            // Calculate average completion time
            $formattedCompletionTime = null;
            if ($completionTimes->isNotEmpty()) {
                $totalSeconds = $completionTimes->sum();
                $projectCount = $completionTimes->count();
                $averageSeconds = $totalSeconds / $projectCount;

                $days = floor($averageSeconds / (24 * 3600));
                $hours = floor(($averageSeconds % (24 * 3600)) / 3600);
                $minutes = floor(($averageSeconds % 3600) / 60);
                $seconds = $averageSeconds % 60;

                $formattedCompletionTime = [
                    'days' => $days,
                    'hours' => $hours,
                    'minutes' => $minutes,
                    'seconds' => $seconds,
                    'total_projects' => $projectCount,
                    'total_seconds' => $totalSeconds,
                    'average_seconds' => $averageSeconds,
                    'min_seconds' => $completionTimes->min(),
                    'max_seconds' => $completionTimes->max()
                ];
            }

            // Get recent projects
            $recentProjects = Project::where('talent', $talent->id)
                ->where('company_id', $company->id)
                ->with(['projectType', 'projectLogs' => function($query) {
                    $query->orderBy('created_at', 'asc');
                }])
                ->latest()
                ->take(5)
                ->get()
                ->map(function($project) {
                    if ($project->status === 'done' && $project->projectLogs->isNotEmpty()) {
                        $firstLog = $project->projectLogs->first();
                        $lastLog = $project->projectLogs->last();
                        $completionTime = $firstLog->created_at->diffInSeconds($lastLog->timestamp);

                        $days = floor($completionTime / (24 * 3600));
                        $hours = floor(($completionTime % (24 * 3600)) / 3600);
                        $minutes = floor(($completionTime % 3600) / 60);
                        $seconds = $completionTime % 60;

                        $project->formatted_completion_time = [
                            'days' => $days,
                            'hours' => $hours,
                            'minutes' => $minutes,
                            'seconds' => $seconds,
                            'total_seconds' => $completionTime
                        ];
                    } else {
                        $project->formatted_completion_time = null;
                    }
                    return $project;
                });

            // Get monthly project completion stats
            $monthlyStats = ProjectLog::where('talent_id', $talent->id)
                ->where('company_id', $company->id)
                ->where('status', 'done')
                ->whereYear('timestamp', date('Y'))
                ->selectRaw('MONTH(timestamp) as month, COUNT(*) as count')
                ->groupBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();

            // Fill in missing months with 0
            for ($i = 1; $i <= 12; $i++) {
                if (!isset($monthlyStats[$i])) {
                    $monthlyStats[$i] = 0;
                }
            }
            ksort($monthlyStats);

            return view('users.Company.talent-detail', compact(
                'talent',
                'projectStats',
                'formattedCompletionTime',
                'recentProjects',
                'monthlyStats'
            ));

        } catch (\Exception $e) {
            return redirect()->route('company.manage.talents')
                ->with('error', 'Failed to load talent details: ' . $e->getMessage());
        }
    }

    public function storeQcReview(Request $request, Project $project)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'qc_status' => 'required|in:approved,revision,rejected',
                'passed_sops' => 'required|string',
                'qc_message' => 'required|string',
                'project_link' => 'required|url'
            ]);

            // Check if the user is the assigned QC agent
            if (!$project->assignedQcAgent || $project->assignedQcAgent->id !== auth()->id()) {
                return redirect()->back()->with('error', 'You are not authorized to submit QC review for this project.');
            }

            // Create project record
            $projectRecord = ProjectRecord::create([
                'user_id' => auth()->id(),
                'project_link' => $validated['project_link'],
                'project_id' => $project->id,
                'talent_id' => $project->talent,
                'company_id' => $project->company_id,
                'qc_id' => auth()->id(),
                'qc_status' => 'draf',
                'passed_sops' => $validated['passed_sops'],
                'qc_message' => $validated['qc_message']
            ]);

            // Update project status based on QC status
            $project->update([
                'status' => 'draf',
                'project_link' => $validated['project_link']
            ]);

            // Create project log
            ProjectLog::create([
                'user_id' => auth()->id(),
                'project_id' => $project->id,
                'talent_qc_id' => auth()->id(),
                'talent_id' => $project->talent,
                'company_id' => $project->company_id,
                'status' => 'draf',
                'timestamp' => now(),
            ]);

            return redirect()->back()->with('success', 'QC review submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit QC review: ' . $e->getMessage());
        }
    }

    public function storeProjectRevision(Request $request, Project $project)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'project_link' => 'required|url',
                'revise_message' => 'required|string',
            ]);

            // Check if the user is the assigned QC agent
            if (!$project->assignedQcAgent || $project->assignedQcAgent->id !== auth()->id()) {
                return redirect()->back()->with('error', 'You are not authorized to submit revision for this project.');
            }

            // Create project record
            $projectRecord = ProjectRecord::create([
                'user_id' => auth()->id(),
                'project_link' => $validated['project_link'],
                'project_id' => $project->id,
                'talent_id' => $project->talent,
                'company_id' => $project->company_id,
                'qc_id' => auth()->id(),
                'status' => 'revision',
                'qc_message' => $validated['revise_message']
            ]);

            // Update project status
            $project->update([
                'status' => 'revision',
                'project_link' => $validated['project_link']
            ]);

            // Create project log
            ProjectLog::create([
                'user_id' => auth()->id(),
                'project_id' => $project->id,
                'talent_qc_id' => auth()->id(),
                'talent_id' => $project->talent,
                'company_id' => $project->company_id,
                'status' => 'revision',
                'timestamp' => now(),
                'message' => $validated['revise_message']
            ]);

            return redirect()->back()->with('success', 'Project revision submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit project revision: ' . $e->getMessage());
        }
    }

    public function completeProject(Request $request, Project $project)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'completion_message' => 'nullable|string|max:1000',
            ]);

            // Get the user's company
            $userCompany = Company::where('user_id', auth()->id())->first();

            // Check if the user is authorized to complete this project
            if (!$userCompany || $project->company_id !== $userCompany->id) {
                return redirect()->back()->with('error', 'You are not authorized to complete this project.');
            }

            // Check if project is in draft status
            if ($project->status !== 'draf') {
                return redirect()->back()->with('error', 'Only draft projects can be marked as done.');
            }

            // Get the latest project record
            $latestRecord = $project->projectRecords()->latest()->first();

            // Create new project record
            $projectRecord = ProjectRecord::create([
                'user_id' => auth()->id(),
                'project_link' => $latestRecord ? $latestRecord->project_link : $project->project_link,
                'project_id' => $project->id,
                'talent_id' => $project->talent,
                'company_id' => $project->company_id,
                'qc_id' => $project->qc_agent,
                'status' => 'done',
                'qc_message' => $validated['completion_message'] ?? 'Project marked as completed'
            ]);

            // Update project status
            $project->update([
                'status' => 'done',
                'finish_date' => now()
            ]);

            // Create project log with done status
            ProjectLog::create([
                'user_id' => auth()->id(),
                'project_id' => $project->id,
                'talent_qc_id' => $project->qc_agent,
                'talent_id' => $project->talent,
                'company_id' => $project->company_id,
                'status' => 'done',
                'timestamp' => now(),
                'message' => $validated['completion_message'] ?? 'Project marked as completed'
            ]);

            return redirect()->back()->with('success', 'Project has been marked as completed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to complete project: ' . $e->getMessage());
        }
    }

    /**
     * Store feedback from company to talent
     */
    public function storeCompanyFeedback(Request $request, Project $project)
    {
        $user = auth()->user();
        // Only allow if user is company and project is done
        if ($user->role !== 'company' || $project->status !== 'done') {
            return redirect()->back()->with('error', 'Unauthorized or project not completed.');
        }
        // Prevent duplicate feedback
        $existing = Feedback::where('project_id', $project->id)
            ->where('from_user_id', $user->id)
            ->where('role', 'company')
            ->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Feedback already submitted.');
        }
        $request->validate([
            'feedback_text' => 'required|string|max:2000',
        ]);
        Feedback::create([
            'project_id' => $project->id,
            'from_user_id' => $user->id,
            'to_user_id' => $project->talent,
            'role' => 'company',
            'feedback_text' => $request->feedback_text,
        ]);
        return redirect()->back()->with('success', 'Feedback submitted for talent.');
    }

    /**
     * Store feedback from talent to project
     */
    public function storeTalentFeedback(Request $request, Project $project)
    {
        $user = auth()->user();
        // Only allow if user is talent and project is done
        if ($user->role !== 'talent' || $project->status !== 'done' || $project->talent != $user->id) {
            return redirect()->back()->with('error', 'Unauthorized or project not completed.');
        }
        // Prevent duplicate feedback
        $existing = Feedback::where('project_id', $project->id)
            ->where('from_user_id', $user->id)
            ->where('role', 'talent')
            ->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Feedback already submitted.');
        }
        $request->validate([
            'feedback_text' => 'required|string|max:2000',
            'project_rate' => 'required|integer|min:1|max:5',
        ]);
        Feedback::create([
            'project_id' => $project->id,
            'from_user_id' => $user->id,
            'to_user_id' => null,
            'role' => 'talent',
            'feedback_text' => $request->feedback_text,
            'project_rate' => $request->project_rate,
        ]);
        return redirect()->back()->with('success', 'Feedback and rating submitted for project.');
    }

}

