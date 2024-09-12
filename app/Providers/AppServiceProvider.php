<?php

namespace App\Providers;

use App\Services\ReservationService;
use App\Services\TimeSlotService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TimeSlotService::class, function ($app) {
            return new TimeSlotService();
        });

        $this->app->singleton(ReservationService::class, function ($app) {
            return new ReservationService(new TimeSlotService());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
