<?php

namespace App\Filament\Resources\Procedures\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProceduresTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('clientCase.case_name')
                    ->label('Caso')
                    ->searchable(),

                TextColumn::make('title')
                    ->label('Procedimiento')
                    ->searchable()
                    ->weight('medium'),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'pending',
                        'warning' => 'in_progress',
                        'success' => 'completed',
                    ]),

                TextColumn::make('priority')
                    ->badge()
                    ->colors([
                        'gray' => 'low',
                        'warning' => 'medium',
                        'danger' => 'high',
                    ]),

                TextColumn::make('limit_date')
                    ->label('Fecha límite')
                    ->date(),

                TextColumn::make('finish_date')
                    ->label('Finalizado')
                    ->date(),

            ])
            ->defaultSort('order')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}