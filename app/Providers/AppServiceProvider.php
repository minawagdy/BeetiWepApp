<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Countries;
use Illuminate\Support\Facades\View;
use Session;
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
        $countries = Countries::all();
        $country   = Countries::first();
        Session::put('country', $country->id);
        View::share([
            'countries' =>  $countries,
        ]);
    }
}
