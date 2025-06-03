<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TalentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome');
});

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
            return redirect()->route('company#index');
        } elseif (Auth::user()->role === 'talent'){
            return redirect()->route('talent#index');
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
Route::prefix('company')->middleware(['auth', 'company'])->group(function () {
    Route::get('/', [CompanyController::class, 'index'])->name('company#index');
    Route::get('/company/dashboard', [CompanyController::class, 'index'])->name('company.dashboard');

    // User Management Routes
    Route::get('/company/users', [CompanyController::class, 'usersOverview'])->name('company.users');
    Route::get('/company/user/{slug}', [CompanyController::class, 'detailUser'])->name('company.user.detail');

    // Project Management Routes
    Route::post('/company/project/store', [CompanyController::class, 'storeProject'])->name('company.project.store');
    Route::put('/company/project/{id}/edit', [CompanyController::class, 'editProject'])->name('company.project.edit');
    Route::delete('/company/project/{id}/delete', [CompanyController::class, 'deleteProject'])->name('company.project.delete');
    Route::get('/company/project/{slug}', [CompanyController::class, 'detailProject'])->name('company.project.detail');
    Route::get('/company/projects', [CompanyController::class, 'projectOverview'])->name('company.projects');

    // Company Settings
    Route::get('/settings', [CompanyController::class, 'companySettings'])->name('company.settings');
    Route::post('/company/project-type/store', [CompanyController::class, 'storeProjectType'])->name('company.projectType.store');
    Route::delete('/company/project-type/{id}/edit', [CompanyController::class, 'editProjectType'])->name('company.project.type.edit');
    Route::delete('/company/project-type/{id}/destroy', [CompanyController::class, 'destroyProjectType'])->name('company.project.type.destroy');

    // Project SOP Routes
    Route::get('/project-sops/{projectTypeId}', [CompanyController::class, 'getProjectSops'])->name('company.project.sops.get');
    Route::post('/project-sop/store', [CompanyController::class, 'storeProjectSop'])->name('company.project.sop.store');
    Route::get('/project-type/{id}/sops', [CompanyController::class, 'showProjectTypeSops'])->name('company.project.type.sops');
    Route::get('/project-sop/{id}', [CompanyController::class, 'getSop'])->name('company.project.sop.get');
    Route::put('/project-sop/{id}', [CompanyController::class, 'updateSop'])->name('company.project.sop.update');
    Route::delete('/project-sop/{id}', [CompanyController::class, 'deleteSop'])->name('company.project.sop.delete');

    // SOP Routes
    Route::get('/company/project-type/{id}/sop-form', [CompanyController::class, 'getSopForm'])->name('company.project.type.sop.form');
    Route::post('/company/project-sop/store', [CompanyController::class, 'storeProjectSop'])->name('company.project.sop.store');
    Route::get('/company/project-type/{id}/sops', [CompanyController::class, 'showProjectTypeSops'])->name('company.project.type.sops');
    Route::get('/company/project-sop/{id}', [CompanyController::class, 'getSop'])->name('company.project.sop.get');
    Route::put('/company/project-sop/{id}', [CompanyController::class, 'updateSop'])->name('company.project.sop.update');
    Route::delete('/company/project-sop/{id}', [CompanyController::class, 'deleteSop'])->name('company.project.sop.delete');

    // Add this new route for sending invitations
    Route::post('/company/invite-user', [CompanyController::class, 'inviteUserByEmail'])->name('company.invite.user');

});

// Talent Routes
Route::prefix('talent')->middleware(['auth', 'talent'])->group(function () {
    Route::get('/', [TalentController::class, 'index'])->name('talent#index');
    Route::get('/manage-projects', [TalentController::class, 'manageProjects'])->name('talent.manage.projects');
    Route::get('/project-detail', [TalentController::class, 'projectDetail'])->name('talent.project.detail');
    Route::get('/report', [TalentController::class, 'report'])->name('talent.report');
});

// Add this new route for invitation acceptance
Route::get('/register/{token}', [RegisteredUserController::class, 'showInvitationRegistrationForm'])->middleware('guest')->name('register.invitation');
Route::post('/register/store', [RegisteredUserController::class, 'store'])->middleware('guest')->name('register.invitation.store');

