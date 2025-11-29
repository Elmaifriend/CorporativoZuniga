<?php

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;

class AppointmentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('date_time')
                    ->label('Fecha y hora')
                    ->required()
                    ->columnSpan(1),

                Select::make('status')
                    ->label('Estatus')
                    ->options([
                        'Pendiente' => 'Pendiente',
                        'Confirmado' => 'Confirmado',
                        'Cancelado' => 'Cancelado',
                        'Asistio' => 'Asistio',
                        'Reagendo' => 'Reagendo',
                    ])
                    ->required()
                    ->columnSpan(1),

                Select::make('modality')
                    ->label('Modalidad')
                    ->options([
                        'Presencial' => 'Presencial',
                        'Online' => 'Online',
                        'Llamada' => 'Llamada',
                    ])
                    ->required()
                    ->columnSpan(1),

                Select::make('responsable_lawyer')
                    ->label('Abogado responsable')
                    ->relationship('responsable', 'name')
                    ->required()
                    ->columnSpan(1),

                Select::make('case_id')
                    ->label('Caso')
                    ->relationship('case', 'case_name')
                    ->columnSpan(1),

                Select::make('appointmentable_id')
                    ->label('Cliente')
                    ->relationship('appointmentable', 'full_name')
                    ->required()
                    ->columnSpan(1),

                Textarea::make('reason')
                    ->label('Motivo')
                    ->required()
                    ->columnSpan(2)
                    ->rows(6), 

                Textarea::make('notes')
                    ->label('Notas')
                    ->columnSpan(2)
                    ->rows(8), 
            ]);
    }
}
