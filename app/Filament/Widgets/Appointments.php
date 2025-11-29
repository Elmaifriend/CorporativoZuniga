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
                    'data' => [
                        3, 5, 1, 7, 4, 6, 2,   // Semana 1
                        4, 3, 5, 8, 6, 2, 1,   // Semana 2
                        7, 9, 4, 5, 6, 3, 2,   // Semana 3
                        5, 4, 3, 7, 8, 6, 4    // Semana 4
                    ],
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.4)',
                ],
            ],
            'labels' => [
                '01', '02', '03', '04', '05', '06', '07',
                '08', '09', '10', '11', '12', '13', '14',
                '15', '16', '17', '18', '19', '20', '21',
                '22', '23', '24', '25', '26', '27', '28'
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
