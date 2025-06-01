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

    public function index()
    {
        return view('users.Talent.index');
    }

    public function manageProjects()
    {
        return view('users.Talent.talent-manage-projects');
    }

    public function projectDetail()
    {
        return view('users.Talent.project-detail');
    }

    public function report()
    {
        return view('users.Talent.report');
    }
}
