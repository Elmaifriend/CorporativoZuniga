<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash;


class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label("Nombre")
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->label("Correo Electronico"),
                Select::make('status')
                    ->options([
                        'draft' => 'Abogado',
                        'reviewing' => 'Contador',
                        'published' => 'Administrador',
                    ]),
                TextInput::make('password')
                    ->label("Contraseña")
                    ->password()
                    ->maxLength(50)
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->confirmed()
                    ->columnSpanFull(),
                TextInput::make('password_confirmation')
                    ->label('Confirmar Contraseña')
                    ->password()
                    ->required()
                    ->maxLength(50)
                    ->same('password')
                    ->columnSpanFull(),
            ]);
    }
}
