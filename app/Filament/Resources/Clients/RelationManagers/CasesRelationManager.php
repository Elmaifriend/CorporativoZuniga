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
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;

class CasesRelationManager extends RelationManager
{
    protected static string $relationship = 'cases';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('case_name')
                    ->label('Nombre del Caso')
                    ->required()
                    ->maxLength(255),

                TextInput::make('responsable_lawyer')
                    ->label('Abogado Responsable')
                    ->required()
                    ->maxLength(255),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'Abierto' => 'Abierto',
                        'En Proceso' => 'En Proceso',
                        'Pausado' => 'Pausado',
                        'Cerrado' => 'Cerrado',
                    ])
                    ->required(),

                Select::make('case_type')
                    ->label('Tipo de Caso')
                    ->options([
                        'Civil' => 'Civil',
                        'Mercantil' => 'Mercantil',
                        'Laboral' => 'Laboral',
                        'Penal' => 'Penal',
                        'Familiar' => 'Familiar',
                        'Administrativo' => 'Administrativo',
                    ])
                    ->required(),

                DatePicker::make('start_date')
                    ->label('Fecha de Inicio')
                    ->required(),

                DatePicker::make('stimated_finish_date')
                    ->label('Fecha Estimada de Cierre')
                    ->required(),

                TextInput::make('total_pricing')
                    ->label('Precio Total')
                    ->numeric()
                    ->required(),

                Textarea::make('resume')
                    ->label('Resumen')
                    ->rows(3)
                    ->maxLength(1000)
                    ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('case_name')
            ->columns([
                TextColumn::make('case_name')
                    ->label('Nombre del Caso')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('responsable_lawyer')
                    ->label('Abogado Responsable')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->colors([
                        'success' => 'Cerrado',
                        'warning' => 'En Proceso',
                        'secondary' => 'Abierto',
                        'danger' => 'Pausado',
                    ])
                    ->sortable(),

                TextColumn::make('case_type')
                    ->label('Tipo de Caso')
                    ->sortable(),

                TextColumn::make('paidPorcentage')
                    ->label('Porcentaje Pagado')
                    ->suffix('%')
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Inicio')
                    ->date()
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
                EditAction::make(),
                ViewAction::make(),
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
