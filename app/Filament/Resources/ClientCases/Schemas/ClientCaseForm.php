<?php

namespace App\Filament\Resources\ClientCases\Schemas;

use App\Models\User;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;

class ClientCaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make('Descripción y Hechos')
                    ->description('Narrativa principal y definición del asunto.')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('case_name')
                            ->label('Asunto / Nombre del Caso')
                            ->placeholder('Ej. Divorcio Voluntario - Familia Pérez')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-document-text'),
                        RichEditor::make('resume')
                            ->hiddenLabel()
                            ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'link'])
                            ->columnSpanFull(),
                    ]),

                Section::make('Partes Involucradas')
                    ->columnSpanFull()
                    ->columns(2)
                    ->description('Cliente y abogado responsable asignado.')
                    ->schema([
                        Select::make('client_id')
                            ->relationship('client', 'full_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Cliente')
                            ->prefixIcon('heroicon-m-user'),

                        Select::make('responsable_lawyer')
                            ->label('Abogado Responsable')
                            ->options(User::pluck('name', 'name'))
                            ->searchable()
                            ->required()
                            ->prefixIcon('heroicon-m-briefcase'),
                    ]),

                Section::make('Datos Judiciales')
                    ->columnSpan(4)
                    ->columns(1)
                    ->schema([
                        Select::make('case_type')
                            ->label('Materia')
                            ->options([
                                'Civil' => 'Civil',
                                'Mercantil' => 'Mercantil',
                                'Laboral' => 'Laboral',
                                'Penal' => 'Penal',
                                'Familiar' => 'Familiar',
                                'Administrativo' => 'Administrativo',
                            ])
                            ->required()
                            ->prefixIcon('heroicon-m-scale'),

                        Select::make('status')
                            ->label('Estatus Actual')
                            ->options([
                                'Abierto' => 'Abierto',
                                'En Proceso' => 'En Proceso',
                                'Pausado' => 'Pausado',
                                'Cerrado' => 'Cerrado',
                            ])
                            ->default('Abierto')
                            ->required()
                            ->native(false),

                        TextInput::make('external_expedient_number')
                            ->label('Num. Expediente')
                            ->placeholder('000/2025')
                            ->required()
                            ->prefixIcon('heroicon-m-hashtag'),

                        TextInput::make('courtroom')
                            ->label('Juzgado Asignado')
                            ->placeholder('Juzgado Primero de lo Familiar...')
                            ->required()
                            ->prefixIcon('heroicon-m-building-library'),
                    ]),

                Section::make('Cronograma y Presupuesto')
                    ->columnSpan(8)
                    ->columns(3)
                    ->schema([
                        Group::make()
                            ->columnSpan(1)
                            ->schema([
                                TextInput::make('total_pricing')
                                    ->label('Honorarios Totales')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required()
                                    ->helperText('Monto total acordado con el cliente.'),
                            ]),

                        Group::make()
                        ->columnSpan(2)
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        DatePicker::make('start_date')
                                            ->label('Fecha Inicio')
                                            ->required()
                                            ->native(false)
                                            ->prefixIcon('heroicon-m-calendar'),

                                        DatePicker::make('stimated_finish_date')
                                            ->label('Cierre Estimado')
                                            ->native(false)
                                            ->prefixIcon('heroicon-m-calendar-days'),

                                        DatePicker::make('real_finished_date')
                                            ->label('Cierre Real')
                                            ->native(false)
                                            ->prefixIcon('heroicon-m-check-circle')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
