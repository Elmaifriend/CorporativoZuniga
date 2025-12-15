<?php

namespace App\Filament\Resources\Clients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label("Nombre Completo"),
                TextColumn::make("phone_number")
                    ->label("Numero de Telefono"),
                TextColumn::make("person_type")
                    ->label("Tipo de persona")
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'persona_fisica' => 'primary',
                        'persona_moral' => 'info',
                    })
                    ->formatStateUsing(function(string $state){
                        switch( $state ){
                            case "persona_fisica":
                                return "Persona Fisica";
                                break;
                            case "persona_moral":
                                return "Persona Moral";
                                break;
                        }
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
