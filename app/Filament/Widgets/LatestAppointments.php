<?php

namespace App\Filament\Widgets;

use App\Models\Appointments;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Colors\Color;

class LatestAppointments extends TableWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Appointments::query())
            ->columns([
                TextColumn::make('date_time')
                    ->dateTime()
                    ->label("Fecha y hora"),
                TextColumn::make('responsable.name') // Usa la relación 'responsable' y accede al campo 'name'
                    ->label("Responsable")
                    ->badge()
                    ->color("gray")
                    ->searchable() // Permite buscar por nombre de abogado
                    ->sortable(), // Permite ordenar por nombre de abogado,
                TextColumn::make("status")
                    ->label("Estatus")
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Confirmado' => 'success',
                        'Cancelada' => 'danger',
                        'Pendiente' => 'warning',
                        default => 'gray'
                    }),
                TextColumn::make("modality")
                    ->label("Modalidad")
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Online' => 'info',
                        'Presencial' => 'success',
                        'Llamada' => 'purple',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
