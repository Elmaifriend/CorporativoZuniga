<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class Appointments extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $heading = 'Citas agendadas este mes';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Citas por día',
                    'data' => [3, 5, 1, 7, 4, 6, 2, 4, 3, 5, 8, 6, 2, 1, 7, 9, 4, 5, 6, 3, 2, 5, 4, 3, 7, 8, 6, 4],
                    'borderColor' => '#003e65',
                    'backgroundColor' => 'rgba(0, 62, 101, 0.1)', // UI: Lighter opacity for a cleaner look
                    'fill' => true, // UI: Fills the area under the line
                    'tension' => 0.4, // UI: Makes the line curved/smooth instead of jagged
                ],
            ],
            'labels' => range(1, 28), // Simplified for brevity
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
