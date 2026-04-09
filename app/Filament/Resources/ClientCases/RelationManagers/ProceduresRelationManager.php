<?php

namespace App\Filament\Resources\ClientCases\RelationManagers;

use App\Filament\Resources\Procedures\ProcedureResource;
use App\Models\User;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class ProceduresRelationManager extends RelationManager
{
    protected static string $relationship = 'procedures';

    protected static ?string $title = 'Trámites del Caso';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información del Trámite')
                    ->icon('heroicon-m-clipboard-document-check')
                    ->columnSpanFull()
                    ->description('Defina el título, responsable y la prioridad de esta gestión.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título de la Gestión')
                            ->placeholder('Ej: Interposición de Recurso de Apelación')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-document-text'),

                        Grid::make(3)->schema([
                            Select::make('responsable_employee')
                                ->label('Funcionario Asignado')
                                ->placeholder('Seleccione...')
                                ->options([
                                    'Abg. Pérez' => 'Abg. Pérez',
                                    'Asist. Gómez' => 'Asist. Gómez',
                                    'Abg. Ruiz' => 'Abg. Ruiz',
                                    'Secretaria Díaz' => 'Secretaria Díaz',
                                ])
                                ->native(false)
                                ->required()
                                ->prefixIcon('heroicon-m-user-circle'),

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
                                ->prefixIcon('heroicon-m-exclamation-circle'),

                            TextInput::make('order')
                                ->label('Orden Secuencial')
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(50)
                                ->default(1)
                                ->required()
                                ->prefixIcon('heroicon-m-bars-3-bottom-left'),
                        ]),
                    ]),

                Section::make('Estado y Tiempos Legales')
                    ->icon('heroicon-m-clock')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('status')
                            ->label('Estatus del Trámite')
                            ->options([
                                'pending' => 'Pendiente',
                                'in_progress' => 'En Progreso',
                                'review' => 'Revisión',
                                'completed' => 'Completado',
                                'stopped' => 'Detenido',
                            ])
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-arrow-path-rounded-square')
                            ->columnSpanFull(),

                        Grid::make(3)->schema([
                            DatePicker::make('starting_date')
                                ->label('Apertura')
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar'),

                            DatePicker::make('limit_date')
                                ->label('Vencimiento Legal')
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-m-calendar-days')
                                ->helperText('Fecha límite fatal según términos procesales.'),

                            DatePicker::make('finish_date')
                                ->label('Conclusión Real')
                                ->placeholder('Pendiente...')
                                ->native(false)
                                ->prefixIcon('heroicon-m-check-badge'),
                        ]),
                    ]),

                Section::make('Notas de Seguimiento')
                    ->icon('heroicon-m-chat-bubble-left-ellipsis')
                    ->columnSpanFull()
                    ->collapsed()
                    ->schema([
                        RichEditor::make('notes')
                            ->hiddenLabel()
                            ->placeholder('Registre incidencias, acuerdos o detalles de la gestión...')
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
                    ->width('1%')
                    ->color('gray'),

                TextColumn::make('title')
                    ->label('Asunto del Trámite')
                    ->description(function ($record) {
                        $priority = match ($record->priority) {
                            'low' => 'Baja',
                            'medium' => 'Media',
                            'high' => 'Alta',
                            default => $record->priority,
                        };

                        return "Prioridad: {$priority}";
                    })
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium'),

                TextColumn::make('responsable_employee')
                    ->label('Responsable')
                    ->icon('heroicon-m-user')
                    ->color('gray')
                    ->size('sm')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'in_progress' => 'info',
                        'review' => 'warning',
                        'completed' => 'success',
                        'stopped' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state) => match ($state) {
                        'pending' => 'Pendiente',
                        'in_progress' => 'En Progreso',
                        'review' => 'En Revisión',
                        'completed' => 'Completado',
                        'stopped' => 'Detenido',
                        default => $state,
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'completed' => 'heroicon-m-check-circle',
                        'stopped' => 'heroicon-m-no-symbol',
                        'in_progress' => 'heroicon-m-play-circle',
                        default => 'heroicon-m-clock',
                    }),

                TextColumn::make('limit_date')
                    ->label('Plazo')
                    ->date('d M, Y')
                    ->sortable()
                    ->color(
                        fn($record) =>
                        $record->limit_date && Carbon::parse($record->limit_date)->isPast() && $record->status !== 'completed'
                            ? 'danger'
                            : 'gray'
                    )
                    ->icon(
                        fn($record) =>
                        $record->limit_date && Carbon::parse($record->limit_date)->isPast() && $record->status !== 'completed'
                            ? 'heroicon-m-exclamation-triangle'
                            : null
                    ),
            ])
            ->headerActions([
                Actions\Action::make('create_procedure')
                    ->label('Nuevo Trámite')
                    ->icon('heroicon-m-plus-circle')
                    ->button()
                    ->url(fn($livewire) => ProcedureResource::getUrl('create', [
                        'case_id' => $livewire->getOwnerRecord()->id,
                    ])),
            ])
            ->recordUrl(
                fn($record): string => ProcedureResource::getUrl('edit', ['record' => $record])
            )
            ->recordActions([
                DeleteAction::make(),
            ]);
    }
}
