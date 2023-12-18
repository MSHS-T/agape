<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if (env('APP_FORCE_HTTPS', false) === true) {
            URL::forceScheme('https');
        }
        FilamentView::registerRenderHook(
            'panels::user-menu.before',
            fn () => view('components.filament.contact-link')
        );
    }
}
