<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Models\Client;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles del Ingreso')
                    ->columnSpanFull()
                    ->description('Registre la información del pago recibido.')
                    ->schema([
                        Select::make('client_id')
                            ->label('Cliente')
                            ->relationship('client', 'full_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->prefixIcon('heroicon-m-user')
                            ->columnSpanFull()
                            ->helperText('Seleccione el cliente que realiza el pago.'),

                        Grid::make(2)->schema([
                            TextInput::make('amount')
                                ->label('Monto Recibido')
                                ->numeric()
                                ->prefix('$')
                                ->placeholder('0.00')
                                ->required(),

                            Select::make('payment_metod')
                                ->label('Método de Pago')
                                ->options([
                                    'Efectivo' => 'Efectivo',
                                    'Transferencia' => 'Transferencia Bancaria',
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
                            ->placeholder('Ej. Honorarios iniciales, Gastos de gestión...')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-document-text'),

                        TextInput::make('transaction_reference')
                            ->label('Referencia / Folio')
                            ->placeholder('Opcional: Núm. de autorización, rastreo SPEI...')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-qr-code'),
                    ]),
            ]);
    }
}
