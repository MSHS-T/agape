<?php

namespace App\Providers\Filament;

use App\Livewire\FilamentProfilePersonalInfo;
use App\Livewire\FilamentProfileTwoFactor;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;

class ApplicantPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('applicant')
            ->path('applicant')
            ->colors([
                'primary' => Color::Blue,
                'danger'  => Color::Red,
                'warning' => Color::Orange,
                'success' => Color::Green,
                'info'    => Color::Cyan
            ])
            ->discoverResources(in: app_path('Filament/Applicant/Resources'), for: 'App\\Filament\\Applicant\\Resources')
            ->discoverPages(in: app_path('Filament/Applicant/Pages'), for: 'App\\Filament\\Applicant\\Pages')
            ->brandLogo(fn () => asset(env('APP_BANNER')))
            ->brandLogoHeight('2.5rem')
            ->discoverWidgets(in: app_path('Filament/Applicant/Widgets'), for: 'App\\Filament\\Applicant\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->topNavigation()
            ->plugins([
                BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                        shouldRegisterNavigation: false, // Adds a main navigation item for the My Profile page (default = false)
                        hasAvatars: false, // Enables the avatar upload form component (default = false)
                        slug: 'profile' // Sets the slug for the profile page (default = 'my-profile')
                    )
                    ->myProfileComponents([
                        'personal_info' => FilamentProfilePersonalInfo::class,
                        'two_factor_authentication' => FilamentProfileTwoFactor::class // optionally, use a custom 2FA page
                    ])
                    ->enableTwoFactorAuthentication(false)
                //     force: false, // force the user to enable 2FA before they can use the application (default = false)
                //     action: FilamentProfileTwoFactor::class // optionally, use a custom 2FA page
                // )
            ])
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
