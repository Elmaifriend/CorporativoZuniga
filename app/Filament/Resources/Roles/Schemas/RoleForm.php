<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Definición del Rol')
                    ->columnSpanFull()
                    ->description('Establezca el nombre y los privilegios de acceso.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre del Rol')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('Ej. Gerente, Abogado Sr, Secretaria...')
                            ->prefixIcon('heroicon-m-shield-check')
                            ->columnSpanFull(),

                        Select::make('permissions')
                            ->label('Permisos Asignados')
                            ->multiple()
                            ->relationship('permissions', 'name')
                            ->preload()
                            ->searchable()
                            ->columnSpanFull()
                            ->helperText('Seleccione las acciones que este rol puede realizar en el sistema.'),
                    ]),
            ]);
    }
}
