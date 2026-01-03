<?php

namespace App\Filament\Resources\ClientCases\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Tapp\FilamentProgressBarColumn\Tables\Columns\ProgressBarColumn;

class ClientCasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('case_name')
                    ->label('Caso')
                    ->description(fn($record) => $record->external_expedient_number)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('client.full_name')
                    ->label("Cliente")
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user'),

                TextColumn::make('responsable_lawyer')
                    ->label("Abogado")
                    ->badge()
                    ->color('gray')
                    ->searchable(),

                TextColumn::make('case_type')
                    ->label('Materia')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Civil'          => 'heroicon-m-home-modern',
                        'Mercantil'      => 'heroicon-m-banknotes',
                        'Laboral'        => 'heroicon-m-briefcase',
                        'Penal'          => 'heroicon-m-scale',
                        'Familiar'       => 'heroicon-m-user-group',
                        'Administrativo' => 'heroicon-m-document-text',
                        default          => 'heroicon-m-folder',
                    })
                    ->color("info")
                    ->sortable()
                    ->searchable()
                    ->width('1%'),

                TextColumn::make('status')
                    ->label('Estatus')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Abierto'    => 'heroicon-m-sparkles',
                        'En Proceso' => 'heroicon-m-arrow-path',
                        'Pausado'    => 'heroicon-m-pause-circle',
                        'Cerrado'    => 'heroicon-m-check-circle',
                        default      => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Abierto'    => 'info',
                        'En Proceso' => 'primary',
                        'Pausado'    => 'warning',
                        'Cerrado'    => 'success',
                        default      => 'gray',
                    })
                    ->searchable()
                    ->sortable()
                    ->width('1%'),

                ProgressBarColumn::make('paidPorcentage')
                    ->label('Progreso de Pago')
                    ->maxValue(100)
                    ->lowThreshold(20)
                    ->successColor('#004c7a')
                    ->warningColor('#ea580c')
                    ->dangerColor('#dc2626')
                    ->successLabel(fn($state) => $state . '%')
                    ->warningLabel(fn($state) => $state . '%')
                    ->dangerLabel(fn($state) => $state . '%')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('case_type')
                    ->label('Materia')
                    ->options([
                        'Civil' => 'Civil',
                        'Mercantil' => 'Mercantil',
                        'Laboral' => 'Laboral',
                        'Penal' => 'Penal',
                        'Familiar' => 'Familiar',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'Abierto' => 'Abierto',
                        'Cerrado' => 'Cerrado',
                    ]),
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
