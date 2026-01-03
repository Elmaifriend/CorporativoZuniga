<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\Client;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MorphToSelect; // <--- Importante
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DateTimePicker;

class AppointmentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make(12)
                    ->schema([
                        Section::make('Participantes y Estado')
                            ->columnSpan(4)
                            ->schema([
                                Select::make('status')
                                    ->label('Estatus')
                                    ->options([
                                        'Pendiente' => 'Pendiente',
                                        'Confirmado' => 'Confirmado',
                                        'Cancelado' => 'Cancelado',
                                        'Asistio' => 'Asistió',
                                        'Reagendo' => 'Reagendó',
                                    ])
                                    ->required()
                                    ->native(false),

                                Select::make('responsable_lawyer')
                                    ->label('Abogado Responsable')
                                    ->relationship('responsable', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->prefixIcon('heroicon-m-briefcase'),

                                MorphToSelect::make('appointmentable')
                                    ->label('Cliente / Relación')
                                    ->types([
                                        MorphToSelect\Type::make(Client::class)
                                            ->label('Cliente')
                                            ->titleAttribute('full_name'),
                                    ])
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('case_id')
                                    ->label('Expediente / Caso')
                                    ->relationship('case', 'case_name')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Opcional'),
                            ]),

                        Section::make('Detalles de la Cita')
                            ->columnSpan(8)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        DateTimePicker::make('date_time')
                                            ->label('Fecha y hora')
                                            ->required()
                                            ->native(false)
                                            ->prefixIcon('heroicon-m-calendar')
                                            ->columnSpan(1),

                                        Select::make('modality')
                                            ->label('Modalidad')
                                            ->options([
                                                'Presencial' => 'Presencial',
                                                'Online' => 'Online',
                                                'Llamada' => 'Llamada',
                                            ])
                                            ->required()
                                            ->native(false)
                                            ->prefixIcon('heroicon-m-video-camera')
                                            ->columnSpan(1),
                                    ]),

                                Textarea::make('reason')
                                    ->label('Motivo / Asunto')
                                    ->required()
                                    ->rows(2)
                                    ->autosize()
                                    ->placeholder('Describe brevemente el motivo de la cita...'),

                                RichEditor::make('notes')
                                    ->label('Notas Internas')
                                    ->placeholder('Observaciones privadas para el abogado...'),
                            ]),
                    ]),
            ]);
    }
}
