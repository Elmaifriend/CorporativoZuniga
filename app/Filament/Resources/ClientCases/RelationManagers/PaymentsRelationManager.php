<?php

namespace App\Filament\Resources\ClientCases\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Resources\RelationManagers\RelationManager;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $title = 'Pagos y Abonos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles de la Transacción')
                    ->columnSpanFull()
                    ->description('Registre el ingreso asociado a este expediente.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('amount')
                                ->label('Monto Recibido')
                                ->numeric()
                                ->prefix('$')
                                ->placeholder('0.00')
                                ->required()
                                ->prefixIcon('heroicon-m-currency-dollar'),

                            Select::make('payment_metod')
                                ->label('Método de Pago')
                                ->options([
                                    'Transferencia' => 'Transferencia Bancaria',
                                    'Efectivo' => 'Efectivo',
                                    'Tarjeta de Crédito/Débito' => 'Tarjeta Crédito/Débito',
                                    'Cheque' => 'Cheque',
                                ])
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-credit-card'),
                        ]),

                        TextInput::make('concept')
                            ->label('Concepto / Motivo')
                            ->placeholder('Ej. Anticipo de honorarios, Pago de trámites...')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-document-text'),

                        TextInput::make('transaction_reference')
                            ->label('Referencia / Folio (Opcional)')
                            ->placeholder('Núm. de autorización o rastreo')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-qr-code'),

                        Hidden::make('client_id')
                            ->default(fn(RelationManager $livewire) => $livewire->getOwnerRecord()->client_id),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('concept')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->date('d M Y')
                    ->sortable()
                    ->icon('heroicon-m-calendar'),

                TextColumn::make('concept')
                    ->label('Concepto')
                    ->searchable()
                    ->weight('medium')
                    ->description(fn($record) => $record->transaction_reference ? 'Ref: ' . $record->transaction_reference : null)
                    ->wrap(),

                TextColumn::make('payment_metod')
                    ->label('Método')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Efectivo' => 'heroicon-m-banknotes',
                        'Transferencia' => 'heroicon-m-arrows-right-left',
                        'Cheque' => 'heroicon-m-document-currency-dollar',
                        default => 'heroicon-m-credit-card',
                    })
                    ->colors([
                        'success' => 'Efectivo',
                        'info' => 'Transferencia',
                        'warning' => 'Cheque',
                        'primary' => 'Tarjeta de Crédito/Débito',
                    ]),

                TextColumn::make('amount')
                    ->label('Monto')
                    ->money('MXN')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->alignEnd()
                    ->summarize(Sum::make()->label('Total Pagado')->money('MXN')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()->slideOver()->label('Registrar Pago'),
            ])
            ->recordActions([
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ]);
    }
}
