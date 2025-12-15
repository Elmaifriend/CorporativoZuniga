<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    
    public function panel(Panel $panel): Panel
    {
        $corporateBlue = [
            50 => '#e0e7ee',
            100 => '#b3c5d6',
            200 => '#85a4bd',
            300 => '#5783a5',
            400 => '#2a618c',
            500 => '#004c7a',
            600 => '#003e65', 
            700 => '#003050',
            800 => '#00213b',
            900 => '#001326',
            950 => '#000810',
        ];

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->databaseNotifications()
            ->colors([
                'primary' => $corporateBlue,
                
                // Configuraciones de fondo y texto (manteniendo el fondo claro corporativo)
                'background' => Color::hex('#ffffff'), // Fondo General Blanco
                'surface' => Color::hex('#f8f9fa'),    // Tarjetas/Superficies Blanco Suave
                
                'text' => Color::hex('#212529'),       // Texto principal (Negro oscuro)
                'text-muted' => Color::hex('#6c757d'), // Texto gris (Subtítulos)
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                //AccountWidget::class,
                //FilamentInfoWidget::class,
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
