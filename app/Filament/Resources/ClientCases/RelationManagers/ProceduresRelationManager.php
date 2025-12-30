<?php

namespace App\Filament\Resources\ClientCases\RelationManagers;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\RelationManagers\RelationManager;

class ProceduresRelationManager extends RelationManager
{
    protected static string $relationship = 'procedures';

    protected static ?string $title = 'Trámites y Gestiones';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Trámite')
                    ->columnSpanFull()
                    ->description('Detalles principales de la gestión a realizar.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título de la Gestión')
                            ->placeholder('Ej. Presentación de demanda inicial')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-clipboard-document-list'),

                        Grid::make(3)->schema([
                            Select::make('responsable_employee')
                                ->label('Responsable')
                                ->options([
                                    'Abg. Pérez' => 'Abg. Pérez',
                                    'Asist. Gómez' => 'Asist. Gómez',
                                    'Abg. Ruiz' => 'Abg. Ruiz',
                                    'Secretaria Díaz' => 'Secretaria Díaz',
                                ])
                                ->native(false)
                                ->required()
                                ->prefixIcon('heroicon-m-user'),

                            Select::make('priority')
                                ->label('Prioridad')
                                ->options([
                                    'Baja' => 'Baja',
                                    'Media' => 'Media',
                                    'Alta' => 'Alta',
                                    'Urgente' => 'Urgente',
                                ])
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-exclamation-triangle'),

                            TextInput::make('order')
                                ->label('Orden')
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(50)
                                ->default(1)
                                ->required()
                                ->prefixIcon('heroicon-m-list-bullet'),
                        ]),
                    ]),

                Section::make('Estado y Tiempos')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('status')
                            ->label('Estado Actual')
                            ->options([
                                'Pendiente' => 'Pendiente',
                                'En Progreso' => 'En Progreso',
                                'Revisión' => 'Revisión',
                                'Completado' => 'Completado',
                                'Detenido' => 'Detenido',
                            ])
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-flag')
                            ->columnSpanFull(),

                        Grid::make(3)->schema([
                            DatePicker::make('starting_date')
                                ->label('Fecha Inicio')
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar'),

                            DatePicker::make('limit_date')
                                ->label('Fecha Límite')
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar-days')
                                ->helperText('Fecha máxima legal o interna.'),

                            DatePicker::make('finish_date')
                                ->label('Fecha Fin')
                                ->placeholder('Sin finalizar')
                                ->native(false)
                                ->prefixIcon('heroicon-m-check-circle'),
                        ]),
                    ]),

                Section::make('Bitácora')
                    ->columnSpanFull()
                    ->collapsed()
                    ->schema([
                        RichEditor::make('notes')
                            ->hiddenLabel()
                            ->placeholder('Observaciones relevantes...')
                            ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'link'])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width('1%'),

                TextColumn::make('title')
                    ->label('Trámite')
                    ->description(fn($record) => $record->priority . ' Prioridad')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('responsable_employee')
                    ->label('Responsable')
                    ->icon('heroicon-m-user')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->colors([
                        'gray' => 'Pendiente',
                        'info' => 'En Progreso',
                        'warning' => 'Revisión',
                        'success' => 'Completado',
                        'danger' => 'Detenido',
                    ]),

                TextColumn::make('limit_date')
                    ->label('Vence')
                    ->date('d M Y')
                    ->sortable()
                    ->color(
                        fn($record) =>
                        $record->limit_date && Carbon::parse($record->limit_date)->endOfDay()->isPast() && $record->status !== 'Completado'
                            ? 'danger'
                            : 'gray'
                    )
                    ->iconColor('danger')
                    ->icon(
                        fn($record) =>
                        $record->limit_date && Carbon::parse($record->limit_date)->endOfDay()->isPast() && $record->status !== 'Completado'
                            ? 'heroicon-m-exclamation-triangle'
                            : null
                    ),
            ])
            ->headerActions([
                CreateAction::make()->slideOver(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->slideOver(),
            ]);
    }
}
