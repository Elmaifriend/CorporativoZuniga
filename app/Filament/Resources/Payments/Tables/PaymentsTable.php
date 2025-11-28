<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([  
                TextColumn::make('client.full_name')
                    ->label("Nombre del cliente"),
                TextColumn::make("amount")
                    ->label("Cantidad")
                    ->prefix('$'),
                TextColumn::make("payment_metod")
                    ->label("Metodo de pago") 
                    ->badge(),
            ])
            ->filters([
                //
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
