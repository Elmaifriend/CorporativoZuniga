<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use Carbon\Carbon;
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
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Actions\DissociateBulkAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\RelationManagers\RelationManager;

class AppointmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'appointments';

    protected static ?string $title = 'Agenda y Citas';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles de la Cita')
                    ->columnSpanFull()
                    ->schema([
                        DateTimePicker::make('date_time')
                            ->label('Fecha y Hora')
                            ->required()
                            ->seconds(false)
                            ->native(false)
                            ->prefixIcon('heroicon-m-clock'),

                        TextInput::make('reason')
                            ->label('Motivo / Asunto')
                            ->placeholder('Ej. Primera consulta sobre divorcio')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-chat-bubble-bottom-center-text'),

                        Select::make('responsable_lawyer')
                            ->label('Abogado Responsable')
                            // Assuming 'responsable' is a User relation
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->prefixIcon('heroicon-m-user'),
                    ])->columns(3),

                Section::make('Estatus y Logística')
                        ->columnSpanFull()
                    ->schema([
                        Select::make('status')
                            ->label('Estado Actual')
                            ->options([
                                'Pendiente' => 'Pendiente',
                                'Confirmado' => 'Confirmado',
                                'Cancelada' => 'Cancelada', // Fixed typo 'Cancelado' -> 'Cancelada' usually used in DB
                                'Asistio' => 'Asistió',
                                'Reagendo' => 'Reagendado',
                            ])
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-check-circle'),

                        Select::make('modality')
                            ->label('Modalidad')
                            ->options([
                                'Presencial' => 'Presencial (Oficina)',
                                'Online' => 'Online (Zoom/Meet)',
                                'Llamada' => 'Llamada Telefónica',
                            ])
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-video-camera'),
                    ])->columns(2),

                Section::make('Notas Internas')
                                ->columnSpanFull()
                    ->collapsed()
                    ->schema([
                        RichEditor::make('notes')
                            ->hiddenLabel()
                            ->toolbarButtons(['bold', 'italic', 'bulletList'])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('reason')
            ->defaultSort('date_time', 'desc')
            ->columns([
                TextColumn::make('date_time')
                    ->label('Fecha')
                    ->formatStateUsing(fn($state) => ucfirst(Carbon::parse($state)->translatedFormat('D d M, h:i A')))
                    ->description(fn($record) => Carbon::parse($record->date_time)->diffForHumans()) // "in 2 days"
                    ->sortable()
                    ->icon('heroicon-m-calendar'),

                TextColumn::make('reason')
                    ->label('Motivo')
                    ->limit(40)
                    ->tooltip(fn($record) => $record->reason)
                    ->searchable()
                    ->weight('medium'),

                TextColumn::make('responsable.name')
                    ->label('Abogado')
                    //->icon('heroicon-m-user-circle')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default to save space

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Confirmado' => 'heroicon-m-check-circle',
                        'Cancelada', 'Cancelado' => 'heroicon-m-x-circle',
                        'Pendiente' => 'heroicon-m-question-mark-circle',
                        'Asistio' => 'heroicon-m-arrow-path',
                        'Reagendo' => 'heroicon-m-arrow-path',
                        default => 'heroicon-m-clock',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Confirmado' => 'success',
                        'Asistio' => 'info',
                        'Cancelada', 'Cancelado' => 'danger',
                        'Reagendo' => 'warning',
                        'Pendiente' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('modality')
                    ->label('Modalidad')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Online' => 'info',
                        'Presencial' => 'primary',
                        'Llamada' => 'warning',
                        default => 'gray',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'Online' => 'heroicon-m-wifi',
                        'Presencial' => 'heroicon-m-building-office',
                        'Llamada' => 'heroicon-m-phone',
                        default => 'heroicon-m-video-camera',
                    }),
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
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
