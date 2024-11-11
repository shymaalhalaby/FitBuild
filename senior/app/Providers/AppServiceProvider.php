<?php

namespace App\Providers;
use Filament\Facades\Filament;
use filament\FilamentServiceProvider;
use Illuminate\Support\ServiceProvider;
use App\Filament\Fitbuild\Resources\AcceptedCoachRequestResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register any services or bindings here if needed.
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Ensure Filament resource is registered.
      //  filament::registerResource(AcceptedCoachRequestResource::class);
    }
}
