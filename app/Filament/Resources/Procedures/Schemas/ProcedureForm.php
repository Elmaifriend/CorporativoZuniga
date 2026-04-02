<?php

namespace App\Filament\Resources\Procedures\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class ProcedureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make('Identificación de la Gestión')
                    ->icon('heroicon-m-clipboard-document-list')
                    ->description('Vincule este trámite a un expediente y asigne un responsable.')
                    ->columnSpan(8)
                    ->columns(2)
                    ->schema([
                        Select::make('case_id')
                            ->label('Expediente / Caso')
                            ->relationship('clientCase', 'case_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default(request()->query('case_id'))
                            ->prefixIcon('heroicon-m-briefcase')
                            ->columnSpanFull(),

                        TextInput::make('title')
                            ->label('Título del Trámite')
                            ->placeholder('Ej. Presentación de pruebas periciales')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-pencil-square'),

                        Select::make('responsable_employee')
                            ->label('Abogado Responsable')
                            ->options(User::pluck('name', 'name'))
                            ->searchable()
                            ->required()
                            ->prefixIcon('heroicon-m-user'),
                    ]),

                Section::make('Estatus')
                    ->icon('heroicon-m-flag')
                    ->columnSpan(4)
                    ->schema([
                        Select::make('status')
                            ->label('Situación Actual')
                            ->options([
                                'pending' => 'Pendiente',
                                'in_progress' => 'En progreso',
                                'completed' => 'Finalizado',
                            ])
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-arrow-path'),

                        Select::make('priority')
                            ->label('Prioridad Legal')
                            ->options([
                                'low' => 'Baja',
                                'medium' => 'Media',
                                'high' => 'Alta',
                            ])
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-exclamation-triangle'),
                    ]),

                Section::make('Planificación de Pagos')
                    ->icon('heroicon-m-currency-dollar')
                    ->description('Calcule el esquema de cuotas según el costo total del trámite.')
                    ->columnSpan(8)
                    ->hiddenOn('edit')
                    ->columns(3)
                    ->schema([
                        TextInput::make('total_cost')
                            ->label('Honorarios Totales')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->suffix('USD')
                            ->live(onBlur: true)
                            ->prefixIcon('heroicon-m-banknotes')
                            ->afterStateUpdated(fn (Set $set, Get $get) => self::calculateInstallments($set, $get)),

                        TextInput::make('initial_cost')
                            ->label('Anticipo / Inicial')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->suffix('USD')
                            ->live(onBlur: true)
                            ->prefixIcon('heroicon-m-arrow-right-circle')
                            ->afterStateUpdated(fn (Set $set, Get $get) => self::calculateInstallments($set, $get)),

                        TextInput::make('installments')
                            ->label('Nº de Cuotas')
                            ->required()
                            ->numeric()
                            ->placeholder('Ej. 12')
                            ->live(onBlur: true)
                            ->prefixIcon('heroicon-m-calculator')
                            ->afterStateUpdated(fn (Set $set, Get $get) => self::calculateInstallments($set, $get)),

                        TextInput::make('installment_amount')
                            ->label('Monto por Cuota')
                            ->required()
                            ->prefix('$')
                            ->suffix('USD')
                            ->disabled()
                            ->dehydrated(false)
                            ->extraInputAttributes(['class' => 'font-bold text-primary-600 dark:text-primary-400']),

                        Select::make('installment_interval')
                            ->label('Periodicidad')
                            ->required()
                            ->options([
                                'weekly' => 'Semanal',
                                'biweekly' => 'Quincenal',
                                'monthly' => 'Mensual',
                                'yearly' => 'Anual',
                            ])
                            ->native(false)
                            ->prefixIcon('heroicon-m-calendar-days')
                            ->columnSpan(2),
                    ]),

                Section::make('Tiempos Legales')
                    ->icon('heroicon-m-clock')
                    ->columnSpan(fn (string $operation): int => $operation === 'edit' ? 12 : 4)
                    ->schema([
                        DatePicker::make('starting_date')
                            ->label('Fecha Apertura')
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-calendar'),

                        DatePicker::make('limit_date')
                            ->label('Plazo Fatal (Límite)')
                            ->native(false)
                            ->prefixIcon('heroicon-m-exclamation-circle'),

                        DatePicker::make('finish_date')
                            ->label('Conclusión Real')
                            ->native(false)
                            ->prefixIcon('heroicon-m-check-badge'),

                        DatePicker::make('last_update')
                            ->label('Último Seguimiento')
                            ->native(false)
                            ->disabled()
                            ->prefixIcon('heroicon-m-arrow-path-rounded-square'),
                    ]),
            ]);
    }

    private static function calculateInstallments(Set $set, Get $get): void
    {
        $total = (float) $get('total_cost');
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
