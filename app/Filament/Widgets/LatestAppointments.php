<?php

namespace App\Filament\Widgets;

use App\Models\Appointments;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Carbon;

class LatestAppointments extends TableWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn() => Appointments::query()->latest('date_time')->limit(20))
            ->columns([
                TextColumn::make('date_time')
                    ->label("Fecha y hora")
                    ->dateTime('d M Y, h:i A')
                    ->description(fn(Appointments $record) => Carbon::parse($record->date_time)->diffForHumans())
                    ->sortable(),

                TextColumn::make('responsable.name')
                    ->label("Responsable")
                    ->icon('heroicon-m-user-circle')
                    ->sortable(),

                TextColumn::make("status")
                    ->label("Estatus")
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Confirmado' => 'success',
                        'Cancelado' => 'danger',
                        'Pendiente' => 'warning',
                        default => 'gray'
                    }),

                TextColumn::make("modality")
                    ->label("Modalidad")
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Online' => 'info',
                        'Presencial' => 'primary',
                        default => 'gray',
                    }),
            ]);
    }
}
