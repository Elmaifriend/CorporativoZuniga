<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;

class ClientsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(6) // Definimos un grid de 6 columnas para mejor control
            ->components([

                /** Nombre completo: ocupa toda la fila */
                TextInput::make('full_name')
                    ->label("Nombre completo")
                    ->required()
                    ->placeholder("Ej. Juan Pérez Hernández")
                    ->columnSpanFull(),

                /** Contacto: teléfono, correo y fecha de nacimiento en la misma fila */
                TextInput::make('phone_number')
                    ->label("Teléfono")
                    ->required()
                    ->placeholder("Ej. 55-1234-5678")
                    ->columnSpan(2),

                TextInput::make("email")
                    ->label("Correo electrónico")
                    ->email()
                    ->placeholder("correo@ejemplo.com")
                    ->columnSpan(2),

                DatePicker::make('date_of_birth')
                    ->label("Fecha de nacimiento")
                    ->columnSpan(2),

                /** Tipo de persona y ocupación */
                Select::make('person_type')
                    ->label("Tipo de persona")
                    ->required()
                    ->options([
                        'persona_fisica' => 'Persona Física',
                        'persona_moral' => 'Persona Moral',
                    ])
                    ->columnSpan(2),

                TextInput::make("occupation")
                    ->label("Ocupación")
                    ->placeholder("Ej. Abogado, Contador...")
                    ->columnSpan(4),

                /** Identificaciones: CURP, RFC, INE */
                TextInput::make("curp")
                    ->label("CURP")
                    ->required()
                    ->placeholder("Ej. ABCD010101HDFRLL01")
                    ->columnSpan(2),

                TextInput::make("rfc")
                    ->label("RFC")
                    ->placeholder("Ej. ABCD010101XXX")
                    ->columnSpan(2),

                TextInput::make("ine_id")
                    ->label("INE")
                    ->columnSpan(2),

                /** Dirección: ocupa toda la fila */
                Textarea::make("address")
                    ->label("Dirección")
                    ->rows(4)
                    ->placeholder("Calle, Número, Colonia, Ciudad, Estado, CP")
                    ->columnSpanFull(),
            ]);
    }
}
