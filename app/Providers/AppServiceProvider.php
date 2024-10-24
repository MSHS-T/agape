<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
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
            fn() => view('components.filament.contact-link')
        );
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $languages = config('agape.languages');
            $flagOverrides = config('agape.flags');
            $flags = collect($languages)->mapWithKeys(fn($lang) => [
                $lang => asset('vendor/blade-country-flags/1x1-' . ($flagOverrides[$lang] ?? $lang) . '.svg')
            ])->all();
            $switch->locales($languages)
                ->renderHook('panels::user-menu.before')
                ->flags($flags)
                ->circular();
        });
        \Sentry\configureScope(function (\Sentry\State\Scope $scope): void {
            $user = auth()->user();
            if ($user) {
                $scope->setUser([
                    'email' => $user->email,
                    'id'    => $user->id,
                    'role'  => $user->getRoleNames()->implode(','),
                    'name'  => $user->name,
                ]);
            }
        });
    }
}
