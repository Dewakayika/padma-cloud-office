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
});

// Talent Routes
Route::prefix('talent')->middleware(['auth', 'talent'])->group(function () {
    Route::get('/', [TalentController::class, 'index'])->name('talent.landing.page');
    Route::get('/company/{slug}', [TalentController::class, 'detailCompany'])->name('[talent#company');
    Route::get('/manage-projects', [TalentController::class, 'manageProjects'])->name('talent.manage.projects');
    Route::get('/project-detail/{id}', [TalentController::class, 'projectDetail'])->name('talent.project.detail');
    Route::get('/report', [TalentController::class, 'report'])->name('talent.report');
    Route::get('/e-wallet', [TalentController::class, 'eWallet'])->name('talent.e-wallet');
    Route::get('/statistic', [TalentController::class, 'statistic'])->name('talent.statistic');
    Route::post('/talent/project/{id}', [TalentController::class, 'applyProject'])->name('talent.projects.apply');
    Route::post('/projects/{project}/records', [TalentController::class, 'storeProjectRecord'])->name('talent.project-records.store');
});

// Add this new route for invitation acceptance
Route::get('/register/{token}', [RegisteredUserController::class, 'showInvitationRegistrationForm'])->middleware('guest')->name('register.invitation');
Route::post('/register/store', [RegisteredUserController::class, 'store'])->middleware('guest')->name('register.invitation.store');


