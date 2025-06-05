<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // $empresa = Settings::whereNull('deleted_at')->first();
        // View::share('empresa', $empresa);
        view()->composer('layouts.sidebar', \App\Http\ViewComposers\SidebarComposer::class);
        Schema::defaultStringLength(191);
        setlocale(LC_TIME, 'es_ES');
        Carbon::setlocale('es');
        Carbon::setUTF8(true);
        Paginator::useBootstrapFive();

    }
}
