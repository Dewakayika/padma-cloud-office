<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectType;
use App\Models\User;

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
