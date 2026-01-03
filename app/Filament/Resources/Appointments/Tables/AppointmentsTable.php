<?php

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date_time')
                    ->label("Fecha")
                    ->dateTime('l d M Y, h:i A')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('appointmentable.full_name')
                    ->label("Cliente")
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user'),

                TextColumn::make('responsable.name')
                    ->label("Abogado")
                    ->badge()
                    ->color('gray')
                    ->searchable(),

                TextColumn::make("modality")
                    ->label("Modalidad")
                    ->badge()
                    ->icon(fn (string $state): string => match ($state) {
                        'Online' => 'heroicon-m-wifi',
                        'Presencial' => 'heroicon-m-building-office',
                        'Llamada' => 'heroicon-m-phone',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Presencial' => 'primary',
                        'Online' => 'info', // Changed to info for blue distinction
                        'Llamada' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make("status")
                    ->label("Estatus")
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pendiente' => 'warning',
                        'Confirmado' => 'success',
                        'Cancelado' => 'danger',
                        'Asistio' => 'success',
                        'Reagendo' => 'info',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('date_time', 'desc') // Show newest/upcoming first
            ->filters([
                // Filter 1: Quick Status check
                SelectFilter::make('status')
                    ->label('Estatus')
                    ->options([
                        'Pendiente' => 'Pendiente',
                        'Confirmado' => 'Confirmado',
                        'Cancelado' => 'Cancelado',
                    ]),

                // Filter 2: Show only future appointments
                Filter::make('future')
                    ->label('Próximas Citas')
                    ->query(fn (Builder $query): Builder => $query->where('date_time', '>=', now()))
                    ->default(), // UX: Default to showing upcoming appointments
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
