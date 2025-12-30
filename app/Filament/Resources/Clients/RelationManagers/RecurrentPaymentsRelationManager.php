<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Actions\DissociateBulkAction;
use Filament\Resources\RelationManagers\RelationManager;

class RecurrentPaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'recurrentPayments';

    protected static ?string $title = 'Planes de Pago Recurrentes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles del Plan')
                    ->columnSpanFull()
                    ->description('Configure la periodicidad y montos del cobro automático.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Nombre del Plan')
                            ->placeholder('Ej. Igualada Mensual 2025')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-tag')
                            ->columnSpanFull(),

                        Grid::make(3)->schema([
                            TextInput::make('amount')
                                ->label('Monto Recurrente')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->placeholder('0.00'),

                            Select::make('frecuency')
                                ->label('Frecuencia')
                                ->required()
                                ->options([
                                    'Mensual' => 'Mensual',
                                    'Bimestral' => 'Bimestral',
                                    'Trimestral' => 'Trimestral',
                                    'Anual' => 'Anual',
                                ])
                                ->native(false)
                                ->prefixIcon('heroicon-m-clock'),

                            TextInput::make('agreed_payment_day')
                                ->label('Día de Corte')
                                ->numeric()
                                ->prefix('Día')
                                ->suffix('del mes')
                                ->minValue(1)
                                ->maxValue(28)
                                ->required(),
                        ]),

                        Select::make('status')
                            ->label('Estado Actual')
                            ->required()
                            ->options([
                                'Activo' => 'Activo',
                                'Pausado' => 'Pausado',
                                'Finalizado' => 'Finalizado',
                                'Cancelado' => 'Cancelado',
                            ])
                            ->default('Activo')
                            ->native(false)
                            ->prefixIcon('heroicon-m-flag'),

                        Textarea::make('description')
                            ->label('Notas / Condiciones')
                            ->rows(2)
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->defaultSort('status', 'asc')
            ->columns([
                TextColumn::make('title')
                    ->label('Plan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Monto')
                    ->money('MXN')
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),

                TextColumn::make('frecuency')
                    ->label('Frecuencia')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-arrow-path'),

                TextColumn::make('agreed_payment_day')
                    ->label('Día de Pago')
                    ->prefix('Día ')
                    ->sortable()
                    ->icon('heroicon-m-calendar-days'),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Activo' => 'heroicon-m-play-circle',
                        'Pausado' => 'heroicon-m-pause-circle',
                        'Finalizado' => 'heroicon-m-check-circle',
                        'Cancelado' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Activo' => 'success',
                        'Pausado' => 'warning',
                        'Finalizado' => 'primary',
                        'Cancelado' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()->slideOver()->label('Nuevo Plan'),
            ])
            ->recordActions([
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
