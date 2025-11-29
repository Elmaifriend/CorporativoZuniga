<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        return [
            Stat::make('Casos Activos', '42')
                ->description('Casos en proceso actualmente')
                ->descriptionIcon('heroicon-o-briefcase')
                ->color('info')
                ->icon('heroicon-o-briefcase')
                ->chart([12, 14, 18, 20, 22, 25, 30]),

            Stat::make('Casos Ganados', '128')
                ->description('Índice de éxito del 92%')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success')
                ->icon('heroicon-o-check-badge')
                ->chart([8, 10, 12, 13, 15, 16, 18]),

            Stat::make('Ingresos Mensuales', '$45,200')
                ->description('Basado en honorarios recientes')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('warning')
                ->icon('heroicon-o-banknotes')
                ->chart([4000, 6000, 8000, 9000, 10500, 11500, 12500]),

            Stat::make('Clientes Activos', '67')
                ->description('Clientes con contratos vigentes')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('primary')
                ->icon('heroicon-o-user-group')
                ->chart([5, 8, 15, 22, 30, 45, 67]),
        ];
    }
}
