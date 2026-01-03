<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;

class ClientsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información Personal')
                    ->columnSpanFull()
                    ->description('Datos básicos de identificación.')
                    ->schema([
                        TextInput::make('full_name')
                            ->label('Nombre Completo / Razón Social')
                            ->required()
                            ->placeholder('Ej. Juan Pérez Hernández')
                            ->prefixIcon('heroicon-m-user')
                            ->columnSpanFull(),

                        Grid::make(3)->schema([
                            Select::make('person_type')
                                ->label('Tipo de Persona')
                                ->options([
                                    'persona_fisica' => 'Persona Física',
                                    'persona_moral' => 'Persona Moral',
                                ])
                                ->required()
                                ->native(false),

                            TextInput::make('occupation')
                                ->label('Ocupación / Giro')
                                ->placeholder('Ej. Abogado, Constructor...')
                                ->prefixIcon('heroicon-m-briefcase'),

                            DatePicker::make('date_of_birth')
                                ->label('Fecha de Nacimiento')
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar'),
                        ]),
                    ]),

                Section::make('Datos de Contacto')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('phone_number')
                                ->label('Teléfono Móvil')
                                ->tel()
                                ->required()
                                ->placeholder('55-1234-5678')
                                ->prefixIcon('heroicon-m-device-phone-mobile'),

                            TextInput::make('email')
                                ->label('Correo Electrónico')
                                ->email()
                                ->placeholder('cliente@ejemplo.com')
                                ->prefixIcon('heroicon-m-at-symbol'),
                        ]),

                        Textarea::make('address')
                            ->label('Dirección Completa')
                            ->rows(3)
                            ->placeholder('Calle, Número, Colonia, Ciudad, Código Postal')
                            ->columnSpanFull(),
                    ]),

                Section::make('Documentación Fiscal')
                    ->columnSpanFull()
                    ->collapsed() // Opcional: Ocultar para limpiar la vista si no siempre se llena
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('rfc')
                                ->label('RFC')
                                ->placeholder('ABCD010101XXX')
                                ->prefixIcon('heroicon-m-identification')
                                ->maxLength(13),

                            TextInput::make('curp')
                                ->label('CURP')
                                ->placeholder('ABCD010101HDFRLL01')
                                ->prefixIcon('heroicon-m-finger-print')
                                ->maxLength(18),

                            TextInput::make('ine_id')
                                ->label('Clave INE / Pasaporte')
                                ->prefixIcon('heroicon-m-credit-card'),
                        ]),
                    ]),
            ]);
    }
}
