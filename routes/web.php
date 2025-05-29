<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TalentController;
use Illuminate\Support\Facades\Auth;

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

});

// Company Routes
Route::prefix('company')->middleware(['auth', 'company'])->group(function () {
    Route::get('/', [CompanyController::class, 'index'])->name('company#index');

});

// Talent Routes
Route::prefix('talent')->middleware(['auth', 'talent'])->group(function () {
    Route::get('/', [TalentController::class, 'index'])->name('talent#index');
});

