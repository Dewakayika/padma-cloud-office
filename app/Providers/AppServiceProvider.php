<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectType;
use App\Models\User;
use App\Models\Company;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('user', auth()->user());

            // Share company slug for talent users
            if (auth()->check() && auth()->user()->role === 'talent') {
                $companySlug = null;
                if (request()->segment(1) === 'talent' && request()->segment(2) === 'company') {
                    $companySlug = request()->segment(3);
                } else {
                    // Get the first company associated with the talent
                    $company = Company::whereHas('companyTalent', function($query) {
                        $query->where('talent_id', auth()->id());
                    })->first();

                    if ($company) {
                        $companySlug = str_replace(' ', '-', strtolower($company->company_name));
                    }
                }
                $view->with('companySlug', $companySlug);
            }
        });

        // // Add function get project_type
        // View::composer('components.create-project', function ($view) {
        //     $project_type = ProjectType::where('user_id', auth()->user()->id)->get();
        //     $view->with('projectTypes', $project_type);
        // });

        // // Add function to get user who role "talent"
        // View::composer('components.create-project', function ($view) {
        //     $talent = User::where('role', 'talent')->get();
        //     $view->with('talents', $talent);
        // });
    }
}
