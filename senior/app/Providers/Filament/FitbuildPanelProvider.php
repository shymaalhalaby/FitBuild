<?php

namespace App\Providers\Filament;

use App\Models\gym;
use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\fitbuild\Pages\Tenancy\Registergym;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\fitbuild\Pages\Tenancy\EditgymProfile;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class FitbuildPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('fitbuild')
            ->path('fitbuild')
            ->login()
            ->default()
            ->tenant(gym::class)
            ->registration()
            ->tenantRegistration(Registergym::class)
            ->tenantProfile(EditgymProfile::class)
            ->registration()
            ->colors([
                'primary' => [
                    50 => '238, 242, 255',
                    100 => '224, 231, 255',
                    200 => '199, 210, 254',
                    300 => '165, 180, 252',
                    400 => '129, 140, 248',
                    500 => '99, 102, 241',
                    600 => '79, 70, 229',
                    700 => '67, 56, 202',
                    800 => '55, 48, 163',
                    900 => '49, 46, 129',
                    950 => '30, 27, 75',
                ],
            ])
            ->discoverResources(in: app_path('Filament/Fitbuild/Resources'), for: 'App\\Filament\\Fitbuild\\Resources')
            ->discoverPages(in: app_path('Filament/Fitbuild/Pages'), for: 'App\\Filament\\Fitbuild\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Fitbuild/Widgets'), for: 'App\\Filament\\Fitbuild\\Widgets')
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
            ]);
    }
}
