<?php

namespace App\Filament\Resources\ClientCases\RelationManagers;

use App\Filament\Resources\ClientCases\ClientCaseResource;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;



class ProceduresRelationManager extends RelationManager
{
    protected static string $relationship = 'procedures';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('responsable_employee')
                    ->label('Responsable')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->sortable()
                    ->badge()
                    ->colors([
                        'secondary' => 'Pendiente',
                        'warning' => 'En Progreso',
                        'info' => 'Revisión',
                        'success' => 'Completado',
                        'danger' => 'Detenido',
                    ]),

                TextColumn::make('starting_date')
                    ->label('Fecha Inicio')
                    ->sortable(),

                TextColumn::make('limit_date')
                    ->label('Fecha Límite')
                    ->sortable(),

                TextColumn::make('finish_date')
                    ->label('Fecha Fin')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),

                Select::make('responsable_employee')
                    ->label('Responsable')
                    ->options([
                        'Abg. Pérez' => 'Abg. Pérez',
                        'Asist. Gómez' => 'Asist. Gómez',
                        'Abg. Ruiz' => 'Abg. Ruiz',
                        'Secretaria Díaz' => 'Secretaria Díaz',
                    ])
                    ->required(),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'Pendiente' => 'Pendiente',
                        'En Progreso' => 'En Progreso',
                        'Revisión' => 'Revisión',
                        'Completado' => 'Completado',
                        'Detenido' => 'Detenido',
                    ])
                    ->required(),

                DatePicker::make('starting_date')
                    ->label('Fecha de Inicio')
                    ->required(),

                DatePicker::make('limit_date')
                    ->label('Fecha Límite')
                    ->required(),

                DatePicker::make('finish_date')
                    ->label('Fecha Fin')
                    ->nullable(),

                Select::make('priority')
                    ->label('Prioridad')
                    ->options([
                        'Baja' => 'Baja',
                        'Media' => 'Media',
                        'Alta' => 'Alta',
                        'Urgente' => 'Urgente',
                    ])
                    ->required(),

                TextInput::make('order')
                    ->label('Orden')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(10)
                    ->required(),

                Textarea::make('notes')
                    ->label('Notas')
                    ->maxLength(1000)
                    ->rows(3)
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }
}
