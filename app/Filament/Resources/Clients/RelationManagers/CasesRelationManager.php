<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Actions\DissociateBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Tapp\FilamentProgressBarColumn\Tables\Columns\ProgressBarColumn; // Make sure to import this

class CasesRelationManager extends RelationManager
{
    protected static string $relationship = 'cases';

    protected static ?string $title = 'Expedientes y Casos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Caso')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('case_name')
                            ->label('Nombre del Asunto')
                            ->placeholder('Ej. Divorcio Voluntario')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-m-document-text'),

                        Grid::make(2)->schema([
                            Select::make('responsable_lawyer')
                                ->label('Abogado Responsable')
                                ->options(User::pluck('name', 'name'))
                                ->searchable()
                                ->required()
                                ->prefixIcon('heroicon-m-briefcase'),

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
                                ->native(false)
                                ->required()
                                ->prefixIcon('heroicon-m-scale'),
                        ]),
                    ]),

                Section::make('Estado y Finanzas')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->label('Estado Actual')
                            ->options([
                                'Abierto' => 'Abierto',
                                'En Proceso' => 'En Proceso',
                                'Pausado' => 'Pausado',
                                'Cerrado' => 'Cerrado',
                            ])
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-flag'),

                        TextInput::make('total_pricing')
                            ->label('Honorarios Totales')
                            ->numeric()
                            ->prefix('$')
                            ->required(),

                        DatePicker::make('start_date')
                            ->label('Fecha Inicio')
                            ->required()
                            ->native(false),

                        DatePicker::make('stimated_finish_date')
                            ->label('Cierre Estimado')
                            ->required()
                            ->native(false),
                    ]),

                Section::make('Resumen')
                    ->columnSpanFull()
                    ->collapsed()
                    ->schema([
                        RichEditor::make('resume')
                            ->hiddenLabel()
                            ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList'])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('case_name')
            ->columns([
                TextColumn::make('case_name')
                    ->label('Caso')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-folder'),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Abierto' => 'heroicon-m-lock-open',
                        'En Proceso' => 'heroicon-m-arrow-path',
                        'Pausado' => 'heroicon-m-pause-circle',
                        'Cerrado' => 'heroicon-m-check-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Abierto' => 'info',
                        'En Proceso' => 'primary',
                        'Pausado' => 'warning',
                        'Cerrado' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('case_type')
                    ->label('Materia')
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-m-scale'),

                ProgressBarColumn::make('paidPorcentage')
                    ->label('Pagado')
                    ->maxValue(100)
                    ->lowThreshold(99)
                    ->successLabel(fn($state) => $state . '%')
                    ->warningLabel(fn($state) => $state . '%')
                    ->dangerLabel(fn($state) => $state . '%')
                    ->successColor('#004c7a')
                    ->warningColor('#ea580c')
                    ->dangerColor('#dc2626')
                    ->sortable(),

                TextColumn::make('responsable_lawyer')
                    ->label('Abogado')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()->slideOver(),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->slideOver(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
