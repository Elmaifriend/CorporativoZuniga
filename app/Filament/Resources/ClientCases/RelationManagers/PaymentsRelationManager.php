<?php

namespace App\Filament\Resources\ClientCases\RelationManagers;

use App\Enums\PaymentStatus;
use App\Enums\PaymentNotificationStatus;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle; // Nuevo: Para control de notificaciones
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Resources\RelationManagers\RelationManager;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $title = 'Pagos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Registro de Movimiento')
                    ->icon('heroicon-m-credit-card')
                    ->description('Administre el estado del pago y las notificaciones automáticas.')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('amount')
                                ->label('Monto')
                                ->numeric()
                                ->prefix('$')
                                ->placeholder('0.00')
                                ->required()
                                ->prefixIcon('heroicon-m-banknotes')
                                ->extraInputAttributes(['class' => 'font-bold text-lg']),

                            Select::make('payment_status')
                                ->label('Estado del Pago')
                                ->options(PaymentStatus::options())
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-check-circle'),

                            Select::make('payment_method')
                                ->label('Medio de Pago')
                                ->options([
                                    'Transferencia' => 'Transferencia Bancaria',
                                    'Efectivo' => 'Efectivo',
                                    'Tarjeta de Crédito/Débito' => 'Tarjeta Crédito/Débito',
                                    'Cheque' => 'Cheque',
                                ])
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-wallet'),
                        ]),

                        TextInput::make('concept')
                            ->label('Concepto')
                            ->placeholder('Ej. Mensualidad Marzo, Pago de Peritaje...')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-chat-bubble-bottom-center-text'),

                        Grid::make(2)->schema([
                            TextInput::make('transaction_reference')
                                ->label('Referencia / Folio')
                                ->placeholder('Núm. de ticket o transferencia')
                                ->prefixIcon('heroicon-m-ticket'),

                            Toggle::make('is_notification_enabled')
                                ->label('Activar Recordatorios')
                                ->default(true)
                                ->inline(false)
                                ->onIcon('heroicon-m-bell-alert')
                                ->offIcon('heroicon-m-bell-slash'),
                        ]),

                        Hidden::make('client_id')
                            ->default(fn(RelationManager $livewire) => $livewire->getOwnerRecord()->client_id),
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
                    ->label('Registro')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color('gray')
                    ->size('sm'),

                TextColumn::make('concept')
                    ->label('Detalle')
                    ->searchable()
                    ->weight('medium')
                    ->description(fn($record) => $record->transaction_reference
                        ? "Ref: {$record->transaction_reference}"
                        : null
                    )
                    ->wrap(),

                TextColumn::make('payment_status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn(PaymentStatus $state) => $state->label())
                    ->color(fn(PaymentStatus $state) => $state->color())
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Método de Pago')
                    ->badge()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('amount')
                    ->label('Importe')
                    ->money('MXN')
                    ->sortable()
                    ->weight('bold')
                    ->alignEnd()
                    ->color(fn($record) => $record->payment_status->value === 'paid' ? 'success' : 'warning')
                    ->summarize(
                        Sum::make()
                            ->label('Recaudado')
                            ->money('MXN')
                    ),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Nuevo Cobro')
                    ->icon('heroicon-m-plus-circle')
                    ->slideOver(),
            ])
            ->recordActions([
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ]);
    }
}
