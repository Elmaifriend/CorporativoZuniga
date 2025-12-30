<?php

namespace App\Filament\Resources\ClientCases\RelationManagers;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\RelationManagers\RelationManager;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $title = 'Comentarios y Seguimiento';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Nuevo Comentario')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('body')
                            ->label('Mensaje')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Escribe aquí los detalles del seguimiento...')
                            ->maxLength(1000),

                        Select::make('assigned_to')
                            ->label('Asignar seguimiento a')
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->prefixIcon('heroicon-m-user-plus'),

                        Select::make('status')
                            ->label('Estatus del comentario')
                            ->options([
                                'Abierto' => 'Abierto',
                                'Pendiente' => 'Pendiente',
                                'Resuelto' => 'Resuelto',
                            ])
                            ->default('Abierto')
                            ->required()
                            ->native(false),

                        Hidden::make('writed_by')
                            ->default(fn() => auth()->id()),

                        DatePicker::make('solved_date')
                            ->label('Fecha Resolución')
                            ->native(false)
                            ->hidden(fn($get) => $get('status') !== 'Resuelto'),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('body')
            ->defaultSort('created_at', 'desc') // Lo más reciente primero
            ->columns([
                // Columna tipo "Chat"
                TextColumn::make('body')
                    ->label('Comentario')
                    ->wrap()
                    ->description(
                        fn($record) =>
                        $record->writedBy->name . ' • ' . $record->created_at->diffForHumans()
                    )
                    ->searchable(),

                TextColumn::make('assignedTo.name')
                    ->label('Asignado a')
                    ->icon('heroicon-m-user')
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Resuelto' => 'success',
                        'Pendiente' => 'warning',
                        'Abierto' => 'gray',
                        default => 'gray',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'Resuelto' => 'heroicon-m-check',
                        'Pendiente' => 'heroicon-m-clock',
                        default => 'heroicon-m-chat-bubble-left',
                    }),
            ])
            ->headerActions([
                CreateAction::make()
                    ->slideOver()
                    ->label('Agregar Comentario')
                    ->modalWidth('md'),
            ])
            ->recordActions([
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
