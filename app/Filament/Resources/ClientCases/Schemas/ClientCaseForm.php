<?php

namespace App\Filament\Resources\ClientCases\Schemas;

use App\Models\Client;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientCaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make('Identificación del Expediente')
                    ->icon('heroicon-m-identification')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextInput::make('case_name')
                            ->label('Nombre del Caso')
                            ->placeholder('Ej. Divorcio Voluntario - Familia Pérez')
                            ->required()
                            ->columnSpan(2)
                            ->prefixIcon('heroicon-m-pencil-square'),

                        TextInput::make('external_expedient_number')
                            ->label('Número de Expediente')
                            ->placeholder('000/2026')
                            ->required()
                            ->prefixIcon('heroicon-m-hashtag'),
                    ]),

                Section::make('Asignación')
                    ->icon('heroicon-m-user-group')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('client_id')
                            ->label('Cliente')
                            ->placeholder('Seleccione un cliente registrado...')
                            ->options(Client::where('client_type', '!=', 'prospecto')->pluck('full_name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->prefixIcon('heroicon-m-user'),

                        Select::make('responsable_lawyer')
                            ->label('Abogado Responsable')
                            ->placeholder('Asigne un titular...')
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->prefixIcon('heroicon-m-briefcase'),
                    ]),

                Section::make('Clasificación Jurídica')
                    ->icon('heroicon-m-scale')
                    ->columnSpan(4)
                    ->schema([
                        Select::make('case_type')
                            ->label('Materia')
                            ->options([
                                'Criminal' => 'Criminal',
                                'Mercantil' => 'Mercantil',
                                'Laboral' => 'Laboral',
                                'Penal' => 'Penal',
                                'Familiar' => 'Familiar',
                                'Administrativo' => 'Administrativo',
                            ])
                            ->live()
                            ->native(false)
                            ->required()
                            ->prefixIcon('heroicon-m-tag'),

                        Select::make('status')
                            ->label('Estatus del Caso')
                            ->required()
                            ->options([
                                'Abierto' => 'Abierto',
                                'En Proceso' => 'En Proceso',
                                'Pausado' => 'Pausado',
                                'Cerrado' => 'Cerrado',
                            ])
                            ->native(false)
                            ->prefixIcon('heroicon-m-arrow-path'),
                    ]),

                Section::make('Presupuesto y Control')
                    ->icon('heroicon-m-currency-dollar')
                    ->columnSpan(8)
                    ->columns(2)
                    ->schema([
                        Grid::make(1)->columnSpan(1)->schema([
                            TextInput::make('total_pricing')
                                ->label('Honorarios Totales')
                                ->numeric()
                                ->prefix('$')
                                ->suffix('MXN')
                                ->required()
                                ->live(onBlur: true)
                                ->prefixIcon('heroicon-m-banknotes'),

                            TextEntry::make('financial_status')
                                ->label('Balance Actual')
                                ->state(fn($record) => $record
                                    ? "Pagado: {$record->paidPorcentage}% | Deuda: $" . number_format($record->remainingBalance, 2)
                                    : 'Defina el precio total para ver el balance.')
                                ->extraAttributes(['class' => 'text-sm text-gray-500 italic']),
                        ]),

                        Grid::make(1)->columnSpan(1)->schema([
                            DatePicker::make('start_date')
                                ->label('Fecha de Inicio')
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar'),

                            DatePicker::make('stimated_finish_date')
                                ->label('Cierre Estimado')
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar-days'),

                            DatePicker::make('real_finished_date')
                                ->label('Cierre Real')
                                ->native(false)
                                ->prefixIcon('heroicon-m-check-badge'),
                        ]),
                    ]),

                Section::make('Narrativa del Caso')
                    ->icon('heroicon-m-chat-bubble-bottom-center-text')
                    ->collapsible()
                    ->columnSpanFull()
                    ->schema([
                        RichEditor::make('resume')
                            ->hiddenLabel()
                            ->placeholder('Redacte la síntesis de los hechos y la estrategia legal...')
                            ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'link']),
                    ]),
            ]);
    }
}
