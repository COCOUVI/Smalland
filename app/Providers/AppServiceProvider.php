<?php

namespace App\Providers;

use App\Models\user_formation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\MasterComposer; //
use Illuminate\Pagination\Paginator;

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
        //
         Paginator::useBootstrapFive(); // 
         View::composer('space-etudiant.master', MasterComposer::class);
    }
}
