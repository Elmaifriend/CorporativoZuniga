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

        // Componentes RGB del color corporativo: #003e65 => R=0, G=62, B=101
        $corporateBlueRGBA = 'rgba(0, 62, 101, 0.8)'; // Color principal para Pagos/Ganancias

        $colors = array_map(function ($value) use ($corporateBlueRGBA) {
            return $value >= 0
                ? $corporateBlueRGBA                // AZUL CORPORATIVO para pagos positivos
                : 'rgba(248, 113, 113, 0.8)'; // Rojo suave para pérdidas/valores negativos
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