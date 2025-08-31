<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TalentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CompanyOnboardingController;
use App\Http\Controllers\EwalletController;
use App\Http\Controllers\ProjectTrackingController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome');
});


// Register Portal
Route::get('/signup', function () {return view('auth.register-portal');})->name('signup');

// Register Company
Route::get('/register/company', [CompanyController::class, 'create'])->name('company.register');
Route::post('/register/company', [CompanyController::class, 'store'])->name('company.register.store');

// Register Talent
Route::get('/register/talent', [TalentController::class, 'create'])->name('talent.register');
Route::post('/register/talent', [TalentController::class, 'store'])->name('talent.register.store');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/home', function () {
        if (Auth::user()->role === 'superadmin') {
            return redirect()->route('superadmin#index');
        } elseif (Auth::user()->role === 'company') {
            return redirect()->route('company.index');
        } elseif (Auth::user()->role === 'talent'){
            return redirect()->route('talent.landing.page');
        } else {
            return redirect('/');
        }
    })->name('home');
});

// SuperAdmin Routes
Route::prefix('superadmin')->middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin#index');

    // Company Management Routes
    Route::get('/companies', [SuperAdminController::class, 'manageCompany'])->name('superadmin.companies');
    Route::get('/company/{slug}', [SuperAdminController::class, 'companyDetail'])->name('superadmin.company.detail');

    // Talent Management Routes
    Route::get('/talents', [SuperAdminController::class, 'manageTalent'])->name('superadmin.talents');
    Route::get('/talent/{slug}', [SuperAdminController::class, 'talentDetail'])->name('superadmin.talent.detail');
});

// Company Routes
Route::middleware(['auth', 'company'])->group(function () {
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/company/projects', [CompanyController::class, 'manageProjects'])->name('company.manage.projects');
    Route::get('/company/statistics', [CompanyController::class, 'statistics'])->name('company.statistics');
    Route::get('/company/settings', [CompanyController::class, 'companySettings'])->name('company.settings');
    Route::get('/company/manage-talents', [CompanyController::class, 'manageTalents'])->name('company.manage.talents');
    Route::get('/company/talent/{id}', [CompanyController::class, 'talentDetail'])->name('company.talent.detail');
    Route::get('/company/project/{slug}', [CompanyController::class, 'detailProject'])->name('company.project.detail');
    Route::get('/company/user/{slug}', [CompanyController::class, 'detailUser'])->name('company.user.detail');
    Route::get('/company/users', [CompanyController::class, 'usersOverview'])->name('company.users.overview');
    Route::get('/company/project-overview', [CompanyController::class, 'projectOverview'])->name('company.project.overview');
    Route::post('/company/project', [CompanyController::class, 'storeProject'])->name('company.project.store');
    Route::post('/company/project/{id}', [CompanyController::class, 'editProject'])->name('company.project.edit');
    Route::delete('/company/project/{id}', [CompanyController::class, 'deleteProject'])->name('company.project.delete');
    Route::post('/company/project-type', [CompanyController::class, 'storeProjectType'])->name('company.project.type.store');
    Route::get('/company/project-type/{id}/edit', [CompanyController::class, 'editProjectType'])->name('company.project.type.edit');
    Route::delete('/company/project-type/{id}', [CompanyController::class, 'destroyProjectType'])->name('company.project.type.destroy');
    Route::post('/company/invite', [CompanyController::class, 'inviteUserByEmail'])->name('company.invite.user');
    Route::get('/company/project-type/{id}/sops', [CompanyController::class, 'showProjectTypeSops'])->name('company.project.type.sops');
    Route::get('/company/project-type/{projectTypeId}/sops', [CompanyController::class, 'getProjectSops'])->name('company.project.type.sops.get');
    Route::post('/company/project-sop', [CompanyController::class, 'storeProjectSop'])->name('company.project.sop.store');
    Route::get('/company/sop/{id}', [CompanyController::class, 'getSop'])->name('company.sop.get');
    Route::put('/company/sop/{id}', [CompanyController::class, 'updateSop'])->name('company.sop.update');
    Route::delete('/company/sop/{id}', [CompanyController::class, 'deleteSop'])->name('company.sop.delete');
    Route::post('/company/notification-settings', [App\Http\Controllers\CompanyController::class, 'saveNotificationSettings'])->name('company.notification-settings.save');
    Route::post('/company/notification-settings/test', [App\Http\Controllers\CompanyController::class, 'testNotificationWebhook'])->name('company.notification-settings.test');
    Route::get('/company/sop-template/csv', [App\Http\Controllers\CompanyController::class, 'downloadSopCsvTemplate'])->name('company.sop.csv.template');

    // Developer Mode Routes
    Route::post('/company/developer/api-config', [App\Http\Controllers\Company\DeveloperModeController::class, 'saveApiConfig'])->name('company.developer.api-config.save');
    Route::post('/company/developer/api-test', [App\Http\Controllers\Company\DeveloperModeController::class, 'testApi'])->name('company.developer.api-test');
    Route::post('/company/developer/api-disable', [App\Http\Controllers\Company\DeveloperModeController::class, 'disableApi'])->name('company.developer.api-disable');
    Route::get('/company/developer/api-status', [App\Http\Controllers\Company\DeveloperModeController::class, 'getApiStatus'])->name('company.developer.api-status');

    // Project Management Routes
    Route::get('/company/manage/projects', [CompanyController::class, 'manageProjects'])->name('company.manage.projects');
    Route::get('/company/project/{slug}', [CompanyController::class, 'detailProject'])->name('company.project.detail');
    Route::post('/company/project/{project}/qc', [CompanyController::class, 'storeQcReview'])->name('company.project.qc.store');
    Route::post('/company/project/{project}/revise', [CompanyController::class, 'storeProjectRevision'])->name('company.project.revise');
    Route::post('/projects/{project}/complete', [CompanyController::class, 'completeProject'])->name('company.project.complete');

    // Feedback routes
    Route::post('/projects/{project}/feedback/company', [CompanyController::class, 'storeCompanyFeedback'])->name('company.project.feedback');
    Route::get('/company/ewallet', [EwalletController::class, 'eWallet'])->name('company.e-wallet');

    // Project Tracking Monitor Routes
    Route::get('/company/project-tracking-monitor', [App\Http\Controllers\Company\ProjectTrackingMonitorController::class, 'index'])->name('company.project-tracking.monitor');
    Route::get('/company/project-tracking-monitor/realtime', [App\Http\Controllers\Company\ProjectTrackingMonitorController::class, 'getRealTimeData'])->name('company.project-tracking.realtime');

    // Company Onboarding Routes
    Route::get('/onboarding/{step}', [CompanyOnboardingController::class, 'showStep'])->name('company.onboarding.step');
    Route::post('/onboarding/{step}', [CompanyOnboardingController::class, 'postStep'])->name('company.onboarding.step.post');

    // Project Management Routes
    Route::get('/company/manage/projects', [CompanyController::class, 'manageProjects'])->name('company.manage.projects');
    Route::get('/company/project/{slug}', [CompanyController::class, 'detailProject'])->name('company.project.detail');
    Route::get('/company/project/{project}/qc', [CompanyController::class, 'storeQcReview'])->name('company.project.qc.store');
    Route::post('/company/invitation/{id}/resend', [CompanyController::class, 'resendInvitation'])->name('company.invitation.resend');
    Route::delete('/company/invitation/{id}/cancel', [CompanyController::class, 'cancelInvitation'])->name('company.invitation.cancel');

    // Onboarding Routes
    Route::get('/onboarding', [CompanyOnboardingController::class, 'showOnboarding'])->name('company.start.onboarding');
    Route::get('/onboarding/{step?}', [CompanyOnboardingController::class, 'showStep'])->name('company.onboarding.step');
    Route::post('/onboarding/{step}', [CompanyOnboardingController::class, 'postStep'])->name('company.onboarding.step.post');
});


// Talent Routes
Route::prefix('talent')->middleware(['auth', 'talent'])->group(function () {
    // Talent Landing Page (shows all companies)
    Route::get('/', [TalentController::class, 'index'])->name('talent.landing.page');
    Route::post('/additional-info/save', [TalentController::class, 'saveAdditionalInfo'])->name('talent.additional-info.save');
    Route::get('/e-wallet', [TalentController::class, 'eWallet'])->name('talent.e-wallet');

    // Company-specific routes - all routes now include company slug
    Route::prefix('company/{companySlug}')->group(function () {
        // Company detail view
        Route::get('/', [TalentController::class, 'detailCompany'])->name('talent.company');

        // Project management routes
        Route::get('/manage-projects', [TalentController::class, 'manageProjects'])->name('talent.manage-projects');
        Route::get('/project/{id}', [TalentController::class, 'projectDetail'])->name('talent.project.detail');
        Route::post('/project/{id}/apply', [TalentController::class, 'applyProject'])->name('talent.project.apply');
        Route::post('/project/{project}/record', [TalentController::class, 'storeProjectRecord'])->name('talent.project.record');

        // Reporting and statistics
        Route::get('/report', [TalentController::class, 'report'])->name('talent.report');
        Route::get('/statistic', [TalentController::class, 'statistic'])->name('talent.statistic');

        // Project tracking routes
        Route::get('/project-tracking', [ProjectTrackingController::class, 'index'])->name('talent.project-tracking');
        Route::post('/work-session/start', [ProjectTrackingController::class, 'startWorkSession'])->name('talent.work-session.start');
        Route::post('/work-session/pause', [ProjectTrackingController::class, 'pauseWorkSession'])->name('talent.work-session.pause');
        Route::post('/work-session/resume', [ProjectTrackingController::class, 'resumeWorkSession'])->name('talent.work-session.resume');
        Route::post('/work-session/end', [ProjectTrackingController::class, 'endWorkSession'])->name('talent.work-session.end');
        Route::get('/work-session/status', [ProjectTrackingController::class, 'getWorkSessionStatus'])->name('talent.work-session.status');
        Route::post('/project/start', [ProjectTrackingController::class, 'startProject'])->name('talent.project.start');
        Route::post('/project/{id}/end', [ProjectTrackingController::class, 'endProject'])->name('talent.project.end');
        Route::get('/today-stats', [ProjectTrackingController::class, 'getTodayStats'])->name('talent.today-stats');
        Route::get('/project-types', [ProjectTrackingController::class, 'getProjectTypesByCompanySlug'])->name('talent.project-types.by-company');

        // Feedback route
        Route::post('/project/{project}/feedback', [TalentController::class, 'storeTalentFeedback'])->name('talent.project.feedback');

        // Debug route to test basic functionality
        Route::get('/debug', function() {
            return response()->json(['message' => 'Talent route working', 'user' => auth()->user()]);
        })->name('talent.debug');
    });

    // Clear API URL from session
    Route::post('/clear-api-url', function() {
        session()->forget('api_url_to_open');
        return response()->json(['success' => true]);
    })->name('clear.api.url');
});

// Invitation Routes (Public - no company middleware required)
Route::get('/invitations/{token}', [App\Http\Controllers\InvitationController::class, 'show'])->name('invitations.show');
Route::get('/invitations/accept/{token}', [App\Http\Controllers\InvitationController::class, 'accept'])->name('invitations.accept');
Route::post('/invitations/decline/{token}', [App\Http\Controllers\InvitationController::class, 'decline'])->name('invitations.decline');

// Registration routes for invitations
Route::get('/register/{token}', [RegisteredUserController::class, 'showInvitationRegistrationForm'])->middleware('guest')->name('register.invitation');
Route::post('/register/store', [RegisteredUserController::class, 'store'])->middleware('guest')->name('register.invitation.store');

// Timezone setting route
Route::post('/set-timezone', function (\Illuminate\Http\Request $request) {
    $request->validate(['timezone' => 'required|string']);
    $timezone = $request->timezone;

    // Validate timezone is valid
    if (!empty($timezone) && in_array($timezone, timezone_identifiers_list())) {
        // Store in session
        session(['timezone' => $timezone]);

        // Update user's timezone in database
        if (Auth::check()) {
            Auth::user()->update(['timezone' => $timezone]);
        }

        // Set application timezone using helper
        \App\Helpers\TimezoneHelper::setAppTimezone($timezone);

        return response()->json(['success' => true, 'timezone' => $timezone]);
    } else {
        // If invalid timezone, use UTC
        session(['timezone' => 'UTC']);
        \App\Helpers\TimezoneHelper::setAppTimezone('UTC');

        return response()->json(['success' => false, 'message' => 'Invalid timezone, using UTC', 'timezone' => 'UTC']);
    }
})->name('set.timezone');

// Get all available timezones
Route::get('/timezones', function () {
    return response()->json([
        'timezones' => \App\Helpers\TimezoneHelper::getAllTimezones(),
        'all_php_timezones' => \App\Helpers\TimezoneHelper::getAllPhpTimezones()
    ]);
})->name('timezones.list');

// Profile timezone update route
Route::post('/profile/timezone', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'timezone' => 'required|string|max:100'
    ]);

    $timezone = $request->timezone;

    // Validate timezone is valid
    if (!in_array($timezone, timezone_identifiers_list())) {
        return redirect()->back()->with('error', 'Invalid timezone selected!');
    }

    $user = Auth::user();
    $user->update(['timezone' => $timezone]);

    // Update session timezone
    session(['timezone' => $timezone]);

    // Set application timezone
    \App\Helpers\TimezoneHelper::setAppTimezone($timezone);

    return redirect()->back()->with('success', 'Timezone updated successfully!');
})->middleware(['auth'])->name('profile.timezone.update');



