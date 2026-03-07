<?php

namespace App\Filament\Resources\Procedures\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                
                // Asumiendo que tu modelo Client tiene un campo 'name' o similar.
                // Cámbialo por la columna correcta si usas otra (ej. 'full_name')
                Select::make('client_id')
                    ->label('Cliente')
                    ->relationship('client', 'id') 
                    ->searchable()
                    ->required(),

                TextInput::make('concept')
                    ->label('Concepto')
                    ->required()
                    ->maxLength(255),

                TextInput::make('amount')
                    ->label('Monto')
                    ->required()
                    ->numeric()
                    ->prefix('$'),

                TextInput::make('payment_metod') // Manteniendo tu ortografía exacta
                    ->label('Método / Estado')
                    ->required()
                    ->maxLength(255),

                TextInput::make('transaction_reference')
                    ->label('Referencia de Transacción')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('concept')
            ->columns([
                
                TextColumn::make('concept')
                    ->label('Concepto')
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Monto')
                    ->money('USD') // Puedes ajustarlo a 'MXN' u otra moneda
                    ->sortable(),

                TextColumn::make('payment_metod')
                    ->label('Estado / Método')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pendiente' => 'warning',
                        'Completado', 'Pagado', 'Efectivo', 'Transferencia' => 'success',
                        'Cancelado' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),

                TextColumn::make('transaction_reference')
                    ->label('Referencia')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                // Removí AssociateAction porque al ser una relación polimórfica (MorphMany),
                // lo normal es crear el pago directamente asociado al trámite.
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}