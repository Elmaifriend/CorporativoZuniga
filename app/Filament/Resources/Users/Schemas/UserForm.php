<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de Acceso')
                    ->columnSpanFull()
                    ->description('Datos para iniciar sesión en el sistema.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre Completo')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-m-user'),

                                TextInput::make('email')
                                    ->label('Correo Electrónico')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-m-at-symbol'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('password')
                                    ->label('Contraseña')
                                    ->password()
                                    ->revealable()
                                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                    ->dehydrated(fn($state) => filled($state))
                                    ->required(fn(string $operation): bool => $operation === 'create')
                                    ->prefixIcon('heroicon-m-key'),

                                TextInput::make('password_confirmation')
                                    ->label('Confirmar Contraseña')
                                    ->password()
                                    ->revealable()
                                    ->required(fn(string $operation): bool => $operation === 'create')
                                    ->same('password')
                                    ->dehydrated(false)
                                    ->prefixIcon('heroicon-m-check-circle'),
                            ]),
                    ]),

                Section::make('Permisos y Seguridad')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('roles')
                            ->label('Roles Asignados')
                            ->multiple()
                            ->relationship('roles', 'name')
                            ->preload()
                            ->searchable()
                            //->required()
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-shield-check')
                            ->helperText('Define qué acciones puede realizar este usuario.'),
                    ]),
            ]);
    }
}
