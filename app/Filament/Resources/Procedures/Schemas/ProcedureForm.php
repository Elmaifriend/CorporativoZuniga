<?php

namespace App\Filament\Resources\Procedures\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section; // Restaurado a v4
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema; // Restaurado a v4
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use App\Models\User;

class ProcedureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([

                Section::make('Información del procedimiento')
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        Select::make('case_id')
                            ->label('Caso')
                            ->relationship('clientCase', 'case_name')
                            ->searchable()
                            ->required()
                            ->default(request()->query('case_id')),

                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),

                        Select::make('responsable_employee')
                            ->label('Responsable')
                            ->options(User::pluck('name', 'name'))
                            ->searchable()
                            ->required()
                            ->prefixIcon('heroicon-m-briefcase'),

                        Select::make('status')
                            ->label('Estado')
                            ->options([
                                'pending' => 'Pendiente',
                                'in_progress' => 'En progreso',
                                'completed' => 'Finalizado',
                            ])
                            ->required()
                            ->native(false),
                    ]),

                Section::make('Fechas')
                    ->icon('heroicon-o-calendar')
                    ->schema([

                        DatePicker::make('starting_date')
                            ->label('Inicio'),

                        DatePicker::make('limit_date')
                            ->label('Fecha límite'),

                        DatePicker::make('finish_date')
                            ->label('Fecha de finalización'),

                        DatePicker::make('last_update')
                            ->label('Última actualización'),

                    ]),

                Section::make('Organización')
                    ->icon('heroicon-o-bars-3')
                    ->schema([

                        Select::make('priority')
                            ->label('Prioridad')
                            ->options([
                                'low' => 'Baja',
                                'medium' => 'Media',
                                'high' => 'Alta',
                            ])
                            ->native(false),

                        TextInput::make('order')
                            ->label('Orden')
                            ->numeric(),
                    ]),

                Section::make('Estructura de pagos')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([

                        TextInput::make('total_cost')
                            ->label('Costo total')
                            ->numeric()
                            ->prefix('$')
                            ->suffix('USD')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, Get $get) => self::calculateInstallments($set, $get)),

                            TextInput::make('initial_cost')
                            ->label('Pago inicial')
                            ->numeric()
                            ->prefix('$')
                            ->suffix('USD')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, Get $get) => self::calculateInstallments($set, $get)),

                        TextInput::make('installments')
                            ->label('Número de cuotas')
                            ->numeric()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, Get $get) => self::calculateInstallments($set, $get)),

                        TextInput::make('installment_amount')
                            ->label('Monto por cuota')
                            ->prefix('$')
                            ->suffix('USD')
                            ->disabled()
                            ->dehydrated(false),

                        Select::make('installment_interval')
                            ->label('Frecuencia')
                            ->options([
                                'daily' => 'Diario',
                                'weekly' => 'Semanal',
                                'biweekly' => 'Quincenal',
                                'monthly' => 'Mensual',
                                'bimonthly' => 'Bimestral',
                                'yearly' => 'Anual',
                                'custom' => 'Personalizado'
                            ]),
                    ])
            ]);
    }
    
    private static function calculateInstallments(Set $set, Get $get): void
    {
        $total = (float) $get('total_cost');
        $initial = (float) $get('initial_cost');
        $installments = (int) $get('installments');

        if ($installments > 0) {
            $remaining = max(0, $total - $initial);
            $set('installment_amount', round($remaining / $installments, 2));
        } else {
            $set('installment_amount', null);
        }
    }
}