<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\CompanyTalent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InvitationController extends Controller
{
    /**
     * Accept invitation for existing user
     */
    public function accept(Request $request, $token)
    {
        try {
            // Find the invitation by token
            $invitation = Invitation::where('token', $token)
                ->where('expires_at', '>', now())
                ->first();

            if (!$invitation) {
                return redirect()->route('home')->with('error', 'Invalid or expired invitation.');
            }

            // Check if user is logged in
            if (!Auth::check()) {
                // Store invitation token in session and redirect to login
                session(['pending_invitation_token' => $token]);
                return redirect()->route('login')->with('info', 'Please log in to accept the invitation.');
            }

            $user = Auth::user();

            // Check if user email matches invitation email
            if ($user->email !== $invitation->email) {
                return redirect()->route('home')->with('error', 'This invitation is for a different email address.');
            }

            // Check if user is already part of this company
            $existingMembership = CompanyTalent::where('company_id', $invitation->company_id)
                ->where('talent_id', $user->id)
                ->first();

            if ($existingMembership) {
                // Delete the invitation since user is already a member
                $invitation->delete();
                return redirect()->route('home')->with('info', 'You are already a member of this company.');
            }

            // Create CompanyTalent record
            CompanyTalent::create([
                'company_id' => $invitation->company_id,
                'user_id' => $invitation->inviting_user_id,
                'talent_id' => $user->id,
                'job_role' => $invitation->role,
            ]);

            // Delete the invitation
            $invitation->delete();

            Log::info('User accepted company invitation', [
                'user_id' => $user->id,
                'company_id' => $invitation->company_id,
                'role' => $invitation->role
            ]);

            return redirect()->route('home')->with('success', 'You have successfully joined the company!');

        } catch (\Exception $e) {
            Log::error('Error accepting invitation', [
                'token' => $token,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('home')->with('error', 'An error occurred while accepting the invitation.');
        }
    }

    /**
     * Decline invitation
     */
    public function decline(Request $request, $token)
    {
        try {
            $invitation = Invitation::where('token', $token)->first();

            if (!$invitation) {
                return redirect()->route('home')->with('error', 'Invalid invitation.');
            }

            // Check if user is logged in and email matches
            if (Auth::check() && Auth::user()->email === $invitation->email) {
                $invitation->delete();
                return redirect()->route('home')->with('info', 'Invitation declined.');
            }

            return redirect()->route('home')->with('error', 'You can only decline invitations sent to your email address.');

        } catch (\Exception $e) {
            Log::error('Error declining invitation', [
                'token' => $token,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('home')->with('error', 'An error occurred while declining the invitation.');
        }
    }

    /**
     * Show invitation details page
     */
    public function show($token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('expires_at', '>', now())
            ->with('company')
            ->first();

        if (!$invitation) {
            return redirect()->route('home')->with('error', 'Invalid or expired invitation.');
        }

        return view('invitations.show', compact('invitation'));
    }
}
