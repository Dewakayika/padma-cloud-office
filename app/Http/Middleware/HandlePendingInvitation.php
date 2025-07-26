<?php

namespace App\Http\Middleware;

use App\Models\Invitation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HandlePendingInvitation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and there's a pending invitation
        if (Auth::check() && session('pending_invitation_token')) {
            $token = session('pending_invitation_token');
            $invitation = Invitation::where('token', $token)
                ->where('expires_at', '>', now())
                ->first();

            if ($invitation && Auth::user()->email === $invitation->email) {
                // Clear the session token
                session()->forget('pending_invitation_token');

                // Redirect to invitation acceptance page
                return redirect()->route('invitations.show', $token)
                    ->with('info', 'Please review and accept the company invitation.');
            } else {
                // Clear invalid token
                session()->forget('pending_invitation_token');
            }
        }

        return $next($request);
    }
}
