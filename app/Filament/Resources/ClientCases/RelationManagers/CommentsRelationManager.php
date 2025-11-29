<?php

namespace App\Filament\Resources\ClientCases\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn\MoneyColumn;
use Filament\Tables\Table;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('body')
                    ->label('Comentario')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull()
                    ->maxLength(1000),

                Select::make('writed_by')
                    ->label('Escrito por')
                    ->relationship('writedBy', 'name') // asumiendo relación con User
                    ->required(),

                Select::make('assigned_to')
                    ->label('Asignado a')
                    ->relationship('assignedTo', 'name') // asumiendo relación con User
                    ->required(),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'Abierto' => 'Abierto',
                        'Pendiente' => 'Pendiente',
                        'Resuelto' => 'Resuelto',
                    ])
                    ->required(),

                Select::make('attended_by')
                    ->label('Atendido por')
                    ->relationship('attendedBy', 'name') // asumiendo relación con User
                    ->nullable(),

                DatePicker::make('solved_date')
                    ->label('Fecha de resolución')
                    ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('body')
            ->columns([
                TextColumn::make('body')
                    ->label('Comentario')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('writedBy.name')
                    ->label('Escrito por')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('assignedTo.name')
                    ->label('Asignado a')
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'success' => 'Resuelto',
                        'warning' => 'Pendiente',
                        'secondary' => 'Abierto',
                    ])
                    ->sortable(),

                TextColumn::make('attendedBy.name')
                    ->label('Atendido por')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('solved_date')
                    ->label('Fecha Resuelto')
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
