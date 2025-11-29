<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClientPaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';
    protected static ?string $recordTitleAttribute = 'amount';

    /**
     * Filtra los pagos para que solo se muestren los del cliente actual
     */
    protected function getTableQuery(): Builder
    {
        // Usamos el método temporal allPayments()
        return $this->ownerRecord->allPayments();
    }

    /**
     * Formulario para crear/editar pagos
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('amount')
                    ->label('Monto')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->columnSpan(1),

                Select::make('payment_metod')
                    ->label('Método de Pago')
                    ->required()
                    ->options([
                        'efectivo' => 'Efectivo',
                        'transferencia' => 'Transferencia',
                        'tarjeta' => 'Tarjeta',
                        'otro' => 'Otro',
                    ])
                    ->columnSpan(1),

                TextInput::make('concept')
                    ->label('Concepto')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('transaction_reference')
                    ->label('Referencia de Transacción')
                    ->columnSpanFull(),
            ]);
    }

    /**
     * Tabla para listar los pagos del cliente
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('amount')
            ->columns([
                TextColumn::make('amount')
                    ->label('Monto')
                    ->sortable()
                    ->money('MXN', true),

                TextColumn::make('payment_metod')
                    ->label('Método'),

                TextColumn::make('concept')
                    ->label('Concepto')
                    ->limit(30),

                TextColumn::make('transaction_reference')
                    ->label('Referencia')
                    ->limit(30),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
