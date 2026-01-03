<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Resources\RelationManagers\RelationManager;

class ClientPaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $title = 'Historial de Pagos';

    protected function getTableQuery(): Builder
    {
        return $this->getOwnerRecord()->allPayments();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Registro de Pago')
                    ->columnSpanFull()
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
                                    'Efectivo' => 'Efectivo',
                                    'Transferencia' => 'Transferencia Electrónica',
                                    'Tarjeta de Crédito/Débito' => 'Tarjeta Crédito/Débito',
                                    'Cheque' => 'Cheque',
                                    'Otro' => 'Otro',
                                ])
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-credit-card'),
                        ]),

                        TextInput::make('concept')
                            ->label('Concepto')
                            ->placeholder('Ej. Mensualidad, Asesoría, Trámite...')
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

                        // IMPORTANTE: Al crear un pago desde aquí, aseguramos que el client_id se llene.
                        // Filament intentará llenar 'paymentable' automáticamente, pero 'client_id' es una columna separada.
                        Hidden::make('client_id')
                            ->default(fn(RelationManager $livewire) => $livewire->getOwnerRecord()->id),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('concept')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('concept')
                    ->label('Concepto')
                    ->searchable()
                    ->description(fn($record) => $record->transaction_reference ? 'Ref: ' . $record->transaction_reference : null)
                    ->wrap(),

                TextColumn::make('payment_metod')
                    ->label('Método')
                    ->badge()
                    ->icon(fn(string $state): string => match (strtolower($state)) { // strtolower para evitar errores de mayúsculas
                        'efectivo' => 'heroicon-m-banknotes',
                        'transferencia' => 'heroicon-m-arrows-right-left',
                        'cheque' => 'heroicon-m-document-currency-dollar',
                        'tarjeta', 'tarjeta de crédito/débito' => 'heroicon-m-credit-card',
                        default => 'heroicon-m-currency-dollar',
                    })
                    ->colors([
                        'success' => fn($state) => in_array(strtolower($state), ['efectivo', 'transferencia']),
                        'primary' => fn($state) => str_contains(strtolower($state), 'tarjeta'),
                        'warning' => 'Cheque',
                        'gray' => 'Otro',
                    ]),

                TextColumn::make('amount')
                    ->label('Monto')
                    ->money('MXN')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->alignEnd()
                    // Sumariza el total de pagos al final de la tabla
                    ->summarize(Sum::make()->label('Total')->money('MXN')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()->slideOver()->label('Registrar Abono'),
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
