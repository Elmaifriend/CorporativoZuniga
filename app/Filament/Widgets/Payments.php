<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class Payments extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $heading = 'Pagos Mensuales';

    protected function getData(): array
    {
        $values = [1200, 500, 2200, 2000, 3100, 4500];

        return [
            'datasets' => [
                [
                    'label' => 'Ingresos',
                    'data' => $values,
                    'backgroundColor' => '#003e65',
                    'borderRadius' => 5, // UI: Rounded corners on bars
                    'barThickness' => 30, // UI: Slimmer bars look more elegant
                ],
            ],
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
