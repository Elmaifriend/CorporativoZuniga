<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class AppointmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'appointments';

    // Formulario para crear/editar citas
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('date_time')
                    ->label('Fecha y Hora')
                    ->required(),

                TextInput::make('reason')
                    ->label('Motivo')
                    ->required()
                    ->maxLength(255),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'Pendiente' => 'Pendiente',
                        'Confirmado' => 'Confirmado',
                        'Cancelado' => 'Cancelado',
                        'Asistio' => 'Asistió',
                        'Reagendo' => 'Reagendado',
                    ])
                    ->required(),

                Select::make('responsable_lawyer')
                    ->label('Abogado Responsable')
                    ->relationship('responsable', 'name')
                    ->required(),

                Select::make('modality')
                    ->label('Modalidad')
                    ->options([
                        'Presencial' => 'Presencial',
                        'Online' => 'Online',
                        'Llamada' => 'Llamada',
                    ])
                    ->required(),

                Textarea::make('notes')
                    ->label('Notas')
                    ->rows(3)
                    ->maxLength(1000)
                    ->nullable(),
            ]);
    }

    // Tabla para mostrar citas
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date_time')
            ->columns([
                TextColumn::make('date_time')
                    ->label('Fecha y Hora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('reason')
                    ->label('Motivo')
                    ->limit(50)
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'secondary' => 'Pendiente',
                        'success' => 'Confirmado',
                        'danger' => 'Cancelado',
                        'info' => 'Asistio',
                        'warning' => 'Reagendo',
                    ])
                    ->sortable(),

                TextColumn::make('responsable.name')
                    ->label('Abogado Responsable')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('modality')
                    ->label('Modalidad')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DissociateAction::make(),
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
