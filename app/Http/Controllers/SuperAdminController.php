<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Project;
use App\Models\ProjectLog;
use App\Models\Talent;
use App\Models\CompanyTalent;


use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index(Request $request)
    {
        $totalCompany = Company::count();
        $totalUser  = Talent::count();
        $totalProject = Project::count();
        // Group Company by Country
        $companyByCountry = Company::whereNotNull('country')
            ->distinct('country')
            ->count('country');

        // Get sorting parameters from the request
        $sortBy = $request->get('sort_by', 'company_name');
        $sortOrder = $request->get('sort_order', 'asc');

        // Validate sorting parameters to prevent potential security issues
        $validSortColumns = ['company_name', 'company_type', 'country', 'contact_person_name'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'company_name';
        }
        $sortOrder = strtolower($sortOrder) === 'desc' ? 'desc' : 'asc';

        // Fetch companies with sorting
        $company = Company::orderBy($sortBy, $sortOrder)->paginate(5);



        $projects = Project::with(['projectType', 'talentQc', 'qcAgent'])->latest()->take(10)->get();

        return view('users.SuperAdmin.index', [
            'totalCompany' => $totalCompany,
            'totalUser' => $totalUser,
            'totalProject' => $totalProject,
            'company' => $company,
            'projects' => $projects,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
            'companyByCountry' => $companyByCountry

        ]);
    }

    public function manageCompany(Request $request)
    {
        // Get sorting parameters from the request
        $sortBy = $request->get('sort_by', 'company_name'); // Default sort by company_name
        $sortOrder = $request->get('sort_order', 'asc'); // Default sort order ascending

        // Validate sorting parameters to prevent potential security issues
        $validSortColumns = ['company_name', 'company_type', 'country', 'contact_person_name'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'company_name';
        }
        $sortOrder = strtolower($sortOrder) === 'desc' ? 'desc' : 'asc';

        // Fetch companies with sorting
        $company = Company::orderBy($sortBy, $sortOrder)->paginate(10);

        return view('users.SuperAdmin.manageCompany', [
            'company' => $company,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder
        ]);
    }

    public function companyDetail($slug)
    {
        $id = explode('-', $slug)[0];
        $company = Company::find($id);

        return view('users.SuperAdmin.companyDetail', [
            'company' => $company
        ]);
    }

    public function manageTalent(Request $request)
    {
        // Get sorting parameters from the request
        $sortBy = $request->get('sort_by', 'name'); // Default sort by name
        $sortOrder = $request->get('sort_order', 'asc'); // Default sort order ascending

        // Validate sorting parameters to prevent potential security issues
        $validSortColumns = ['name', 'email', 'phone_number', 'gender'];
        if (!in_array($sortBy, $validSortColumns)) {
            $sortBy = 'name';
        }
        $sortOrder = strtolower($sortOrder) === 'desc' ? 'desc' : 'asc';

        // Fetch users with talent role and their talent data
        $talents = User::with('talent')
            ->where('role', 'talent')
            ->when(in_array($sortBy, ['name', 'email']), function ($query) use ($sortBy, $sortOrder) {
                return $query->orderBy($sortBy, $sortOrder);
            })
            ->when(in_array($sortBy, ['phone_number', 'gender']), function ($query) use ($sortBy, $sortOrder) {
                return $query->orderBy('talents.' . $sortBy, $sortOrder)
                    ->join('talents', 'users.id', '=', 'talents.user_id');
            })
            ->paginate(10);

        return view('users.SuperAdmin.manageTalent', [
            'talents' => $talents,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder
        ]);
    }

    public function talentDetail($slug)
    {
        $id = explode('-', $slug)[0];
        $talent = Talent::find($id);

        return view('users.SuperAdmin.talentDetail', [
            'talent' => $talent
        ]);
    }

}
