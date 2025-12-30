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
                ->description('3 nuevos esta semana')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->chart([12, 14, 18, 20, 22, 25, 30]),

            Stat::make('Casos Ganados', '128')
                ->description('Incremento del 12%')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success') // VISUAL: Green indicates success
                ->chart([8, 10, 12, 13, 15, 16, 18]),

            Stat::make('Ingresos Mensuales', '$45,200')
                ->description('Comparado con mes anterior')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary')
                ->chart([4000, 6000, 8000, 9000, 10500, 11500, 12500]),

            Stat::make('Clientes Activos', '67')
                ->description('5 contratos por renovar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning') // VISUAL: Orange to highlight attention needed
                ->chart([5, 8, 15, 22, 30, 45, 67]),
        ];
    }
}
