<?php

namespace App\Filament\Resources\Procedures\RelationManagers;

use App\Enums\PaymentStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Model;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $title = 'Pagos del Trámite';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Pago')
                    ->icon('heroicon-m-banknotes')
                    ->columns(2)
                    ->schema([
                        TextInput::make('amount')
                            ->label('Monto')
                            ->numeric()
                            ->prefix('$')
                            ->required()
                            ->prefixIcon('heroicon-m-currency-dollar'),

                        Select::make('payment_status')
                            ->label('Estado')
                            ->options(PaymentStatus::options())
                            ->required()
                            ->native(false),

                        TextInput::make('concept')
                            ->label('Concepto')
                            ->placeholder('Ej. Cuota 1 de 5')
                            ->required()
                            ->columnSpanFull(),

                        Select::make('payment_method')
                            ->label('Método de Pago')
                            ->required()
                            ->options([
                                'Efectivo' => 'Efectivo',
                                'Transferencia' => 'Transferencia',
                                'Tarjeta' => 'Tarjeta',
                            ])
                            ->native(false),

                        DatePicker::make('due_date')
                            ->label('Fecha de Vencimiento')
                            ->native(false)
                            ->prefixIcon('heroicon-m-calendar'),
                    ]),

                Section::make('Configuración')
                    ->collapsed()
                    ->schema([
                        Toggle::make('is_notification_enabled')
                            ->label('¿Enviar recordatorios por WhatsApp?')
                            ->default(true),

                        TextInput::make('transaction_reference')
                            ->label('Referencia de Transacción'),

                        Hidden::make('client_id')
                            ->default(fn ($livewire) => $livewire->getOwnerRecord()->clientCase->client_id),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('concept')
            ->defaultSort('due_date', 'asc')
            ->columns([
                TextColumn::make('due_date')
                    ->label('Vencimiento')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn ($record) => $record->due_date?->isPast() && $record->payment_status !== PaymentStatus::Paid ? 'danger' : 'gray'),

                TextColumn::make('concept')
                    ->label('Concepto')
                    ->description(fn ($record) => $record->payment_method)
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Monto')
                    ->money('MXN')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('payment_status')
                    ->label('Estado')
                    ->formatStateUsing(fn (PaymentStatus $state): string => $state->label())
                    ->color(fn (PaymentStatus $state) => $state->color())
                    ->badge(),

                ToggleColumn::make('is_notification_enabled')
                    ->label('Notificaciones')
                    ->onIcon('heroicon-m-bell-alert')
                    ->offIcon('heroicon-m-bell-slash'),

                TextColumn::make('created_at')
                    ->label('Registro')
                    ->date('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Registrar Pago')
                    ->slideOver(),
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

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->billing_mode == 'by_procedure';
    }
}
