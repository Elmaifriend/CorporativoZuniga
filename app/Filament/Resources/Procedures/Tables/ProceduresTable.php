<?php

namespace App\Filament\Resources\Procedures\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Support\Carbon;

class ProceduresTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->columns([
                TextColumn::make('title')
                    ->label('Gestión / Trámite')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->clientCase?->case_name ?? 'Sin caso vinculado')
                    ->wrap(),

                TextColumn::make('responsable_employee')
                    ->label('Responsable')
                    ->icon('heroicon-m-user-circle')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Situación')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'completed' => 'Completado',
                        'in_progress' => 'En Progreso',
                        'pending' => 'Pendiente',
                        'revision' => 'En Revisión',
                        'stopped' => 'Detenido',
                        default => $state,
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'completed' => 'heroicon-m-check-circle',
                        'in_progress' => 'heroicon-m-play-circle',
                        'pending' => 'heroicon-m-clock',
                        'revision' => 'heroicon-m-arrow-path',
                        'stopped' => 'heroicon-m-no-symbol',
                        default => 'heroicon-m-information-circle',
                    })
                    ->colors([
                        'success' => 'completed',
                        'info' => 'in_progress',
                        'gray' => 'pending',
                        'warning' => 'revision',
                        'danger' => 'stopped',
                    ]),

                TextColumn::make('priority')
                    ->label('Prioridad')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'low' => 'Baja',
                        'medium' => 'Media',
                        'high' => 'Alta',
                        'urgent' => 'Urgente',
                        default => $state,
                    })
                    ->colors([
                        'gray' => 'low',
                        'warning' => 'medium',
                        'danger' => 'high',
                        'primary' => 'urgent',
                    ]),

                TextColumn::make('limit_date')
                    ->label('Vencimiento')
                    ->date('d M, Y')
                    ->sortable()
                    ->color(
                        fn($record) =>
                        $record->limit_date && $record->limit_date->isPast() && $record->status !== 'completed'
                            ? 'danger'
                            : 'gray'
                    )
                    ->icon(
                        fn($record) =>
                        $record->limit_date && $record->limit_date->isPast() && $record->status !== 'completed'
                            ? 'heroicon-m-exclamation-triangle'
                            : 'heroicon-m-calendar'
                    )
                    ->description(
                        fn($record) =>
                        $record->status !== 'completed' ? $record->limit_date?->diffForHumans() : null
                    ),

                TextColumn::make('finish_date')
                    ->label('Concluido')
                    ->date('d M, Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make()
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
