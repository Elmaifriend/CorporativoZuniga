<?php

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date_time')
                    ->label("Fecha y hora")
                    ->dateTime()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('responsable.name')
                    ->label("Responsable")
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make("status")
                    ->label("Estatus")
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pendiente' => 'warning',
                        'Confirmado' => 'success',
                        'Cancelado' => 'danger',
                        'Asistio' => 'success',
                        'Reagendo' => 'primary',
                        default => 'secondary', // gris para cualquier otro valor inesperado
                    })
                    ->sortable()
                    ->searchable(),

                TextColumn::make("modality")
                    ->label("Modalidad")
                    ->badge()
                    ->color(fn (?string $modality): string => match ($modality) {
                        'Presencial' => 'primary',
                        'Online' => 'success',
                        'Llamada' => 'warning',
                        default => 'secondary',
                    })
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
