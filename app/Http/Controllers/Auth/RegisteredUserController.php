<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\CompanyTalent;
use App\Models\User;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the invitation registration form.
     */
    public function showInvitationRegistrationForm($token)
    {
        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation || $invitation->expires_at < now()) {
            return redirect()->route('register')->with('error', 'Invalid or expired invitation link.');
        }

        return view('auth.invitation-register', [
            'invitation' => $invitation,
            'email' => $invitation->email,
            'company' => $invitation->company,
        ]);
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
            'invitation_token' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();


            $invitation = Invitation::where('email', $request->email)->first();

            if (!$invitation) {
                throw new \Exception('No invitation found for this email.');
            }

            // Create the user with the role from invitation
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'talent',
            ]);

            // Create CompanyTalent record
            $companyTalent = CompanyTalent::create([
                'company_id' => $invitation->company_id,
                'user_id' => $invitation->inviting_user_id,
                'talent_id' => $user->id,
                'job_role' => $invitation->role,
            ]);

            // Delete the invitation after successful registration
            $invitation->delete();

            event(new Registered($user));
            Auth::login($user);
            DB::commit();

            return redirect()->route('home')->with('success', 'Registration successful.');

    }
}
