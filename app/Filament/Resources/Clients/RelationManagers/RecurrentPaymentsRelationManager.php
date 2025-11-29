<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use App\Models\Payment;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\AssociateAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Schema;

class RecurrentPaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'recurrentPayments';
    protected static ?string $recordTitleAttribute = 'title';

    // FORMULARIO
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Descripción')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                TextInput::make('amount')
                    ->label('Monto')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->columnSpan(1),

                Select::make('frecuency')
                    ->label('Frecuencia')
                    ->required()
                    ->options([
                        'Mensual' => 'Mensual',
                        'Bimestral' => 'Bimestral',
                        'Trimestral' => 'Trimestral',
                        'Anual' => 'Anual',
                    ])
                    ->columnSpan(1),

                TextInput::make('agreed_payment_day')
                    ->label('Día de pago acordado')
                    ->numeric()
                    ->min(1)
                    ->max(28)
                    ->columnSpan(1),

                Select::make('status')
                    ->label('Estado')
                    ->required()
                    ->options([
                        'Activo' => 'Activo',
                        'Pausado' => 'Pausado',
                        'Finalizado' => 'Finalizado',
                        'Cancelado' => 'Cancelado',
                    ])
                    ->columnSpan(1),
            ]);
    }

    // TABLA
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Título')->searchable()->sortable(),
                TextColumn::make('amount')->label('Monto')->sortable()->money('MXN', true),
                TextColumn::make('frecuency')->label('Frecuencia')->sortable(),
                TextColumn::make('status')->label('Estado')->sortable(),
                TextColumn::make('agreed_payment_day')->label('Día de pago'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
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

    // RELACIÓN: Mostrar también los pagos asociados al pago recurrente
    public function paymentsTable(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount')->label('Monto')->money('MXN', true),
                TextColumn::make('payment_metod')->label('Método'),
                TextColumn::make('concept')->label('Concepto')->limit(30),
                TextColumn::make('transaction_reference')->label('Referencia')->limit(30),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
