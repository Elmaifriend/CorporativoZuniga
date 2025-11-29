<?php

namespace App\Filament\Resources\ClientCases\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientCasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('case_name')
                    ->label('Caso')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('responsable_lawyer')
                    ->label('Abogado')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('case_type')
                    ->label('Tipo')
                    ->badge()
                    ->colors([
                        'primary' => 'Civil',
                        'success' => 'Mercantil',
                        'warning' => 'Laboral',
                        'danger' => 'Penal',
                        'info' => 'Familiar',
                        'purple' => 'Administrativo',
                    ])
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Estatus')
                    ->badge()
                    ->colors([
                        'success' => 'Abierto',
                        'purple' => 'En Proceso',
                        'danger' => 'Pausado',
                        'primary' => 'Cerrado',
                    ])
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Inicio')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('real_finished_date')
                    ->label('Finalizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
