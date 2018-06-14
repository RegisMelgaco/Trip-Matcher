<?php

namespace App\Providers;

use App\Services\ByndService;
use App\Services\IIntentionService;
use App\Services\TripCalculator;
use App\Services\TripMatcher;
use App\Trip;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IIntentionService::class, function (){
            $username = config('services.bynd.username');
            $password = config('services.bynd.password');
            $baseUrl = config('services.bynd.base_url');

            return new ByndService($baseUrl, $username, $password);
        });
    }
}
