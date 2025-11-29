<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class Payments extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Pagos';

    protected function getData(): array
    {
        $values = [1200, 500, 2200, 2000, 3100, 4500];

        $colors = array_map(function ($value) {
            return $value >= 0
                ? 'rgba(56, 189, 248, 0.8)'   // azul para ganancias
                : 'rgba(248, 113, 113, 0.8)'; // rojo para pérdidas
        }, $values);

        return [
            'datasets' => [
                [
                    'label' => 'Pagos mensuales',
                    'data' => $values,
                    'backgroundColor' => $colors,
                    'borderWidth' => 0,
                ],
            ],
            'labels' => [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
