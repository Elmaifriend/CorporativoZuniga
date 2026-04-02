<?php

namespace App\Filament\Resources\ClientCases\Schemas;

use App\Models\Client;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

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
                        // NIVEL 1: Categoría Principal (Migratorio / Criminal)
                        Select::make('case_type')
                            ->label('Materia Principal')
                            ->options([
                                'Migratorio' => 'Migratorio',
                                'Criminal' => 'Criminal',
                            ])
                            ->native(false)
                            ->required()
                            ->prefixIcon('heroicon-m-tag'),

                        // NIVEL 2: Sub-categoría estática
                        Select::make('case_sub_type')
                            ->label('Trámite Específico')
                            ->options([
                                'Perdón' => 'Perdón',
                                'Petición' => 'Petición',
                                'Record' => 'Record',
                                'Visa' => 'Visa',
                                'Ciudadanía' => 'Ciudadanía',
                            ])
                            ->native(false)
                            ->required()
                            ->prefixIcon('heroicon-m-queue-list'),

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
                    ->schema([
                        ToggleButtons::make('billing_mode')
                            ->label('Modelo de Facturación')
                            ->options([
                                'by_case' => 'Cobrar por Caso (Global)',
                                'by_procedure' => 'Cobrar por Trámite',
                            ])
                            ->colors([
                                'by_case' => 'info',
                                'by_procedure' => 'warning',
                            ])
                            ->icons([
                                'by_case' => 'heroicon-m-globe-alt',
                                'by_procedure' => 'heroicon-m-document-duplicate',
                            ])
                            ->default('by_case')
                            ->inline()
                            ->live()
                            ->required()
                            ->columnSpanFull(),

                        Grid::make(2)->schema([
                            // LADO IZQUIERDO: Campos financieros
                            Grid::make(1)
                                ->columnSpan(1)
                                ->visible(fn (Get $get) => $get('billing_mode') === 'by_case')
                                ->schema([
                                    TextInput::make('total_pricing')
                                        ->label('Honorarios Totales')
                                        ->numeric()
                                        ->prefix('$')
                                        ->suffix('MXN')
                                        ->required(fn (Get $get) => $get('billing_mode') === 'by_case')
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, Get $get) => self::calculateInstallments($set, $get))
                                        ->prefixIcon('heroicon-m-banknotes'),

                                    TextInput::make('initial_cost')
                                        ->label('Anticipo / Inicial')
                                        ->numeric()
                                        ->prefix('$')
                                        ->suffix('MXN')
                                        ->hiddenOn('edit')
                                        ->dehydrated(false)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, Get $get) => self::calculateInstallments($set, $get))
                                        ->prefixIcon('heroicon-m-arrow-right-circle'),

                                    TextInput::make('installments')
                                        ->label('Nº de Cuotas')
                                        ->numeric()
                                        ->hiddenOn('edit')
                                        ->dehydrated(false)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, Get $get) => self::calculateInstallments($set, $get))
                                        ->prefixIcon('heroicon-m-calculator'),

                                    TextInput::make('installment_amount')
                                        ->label('Monto por Cuota')
                                        ->prefix('$')
                                        ->suffix('MXN')
                                        ->disabled()
                                        ->hiddenOn('edit')
                                        ->dehydrated(false)
                                        ->extraInputAttributes(['class' => 'font-bold text-primary-600 dark:text-primary-400']),

                                    Select::make('installment_interval')
                                        ->label('Periodicidad')
                                        ->options([
                                            'weekly' => 'Semanal',
                                            'biweekly' => 'Quincenal',
                                            'monthly' => 'Mensual',
                                            'yearly' => 'Anual',
                                        ])
                                        ->hiddenOn('edit')
                                        ->dehydrated(false)
                                        ->native(false)
                                        ->prefixIcon('heroicon-m-calendar-days'),

                                    TextEntry::make('financial_status')
                                        ->label('Balance Actual')
                                        ->state(fn($record) => $record
                                            ? "Pagado: {$record->paidPorcentage}% | Deuda: $" . number_format($record->remainingBalance, 2)
                                            : 'Defina el precio total para ver el balance.')
                                        ->extraAttributes(['class' => 'text-sm text-gray-500 italic'])
                                        ->hiddenOn('create'),
                                ]),

                            // LADO DERECHO: Fechas
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

    private static function calculateInstallments(Set $set, Get $get): void
    {
        $total = (float) $get('total_pricing');
        $initial = (float) $get('initial_cost');
        $installments = (int) $get('installments');

        if ($installments > 0) {
            $remaining = max(0, $total - $initial);
            $set('installment_amount', number_format($remaining / $installments, 2, '.', ''));
        } else {
            $set('installment_amount', '0.00');
        }
    }
}