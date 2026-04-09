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

    protected static ?string $title = 'Notas del Caso';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles del Seguimiento')
                    ->description('Registre los avances, llamadas o acuerdos relacionados con el caso.')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('body')
                            ->label('Nota de Seguimiento')
                            ->placeholder('Ej: Se realizó llamada con el cliente para solicitar documentación faltante...')
                            ->required()
                            ->rows(4)
                            ->autosize()
                            ->columnSpanFull()
                            ->maxLength(1000),

                        Select::make('assigned_to')
                            ->label('Asignar a')
                            ->placeholder('Responsable...')
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->preload(),

                        Select::make('status')
                            ->label('Estado de la Nota')
                            ->options([
                                'Abierto' => 'Abierto',
                                'Pendiente' => 'Pendiente',
                                'Resuelto' => 'Resuelto',
                            ])
                            ->default('Abierto')
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-flag'),

                        Hidden::make('writed_by')
                            ->default(fn() => auth()->id()),

                        DatePicker::make('solved_date')
                            ->label('Fecha de Resolución')
                            ->native(false)
                            ->hidden(fn($get) => $get('status') !== 'Resuelto')
                            ->required(fn($get) => $get('status') === 'Resuelto'),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('body')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('body')
                    ->label('Nota / Comentario')
                    ->wrap()
                    ->searchable()
                    ->description(function ($record) {
                        $author = $record->writedBy?->name ?? 'Sistema';
                        $date = $record->created_at->diffForHumans();
                        return "Escrito por {$author} • {$date}";
                    })
                    ->extraAttributes(['class' => 'py-2']),

                TextColumn::make('assignedTo.name')
                    ->label('Asignado a')
                    ->placeholder('Sin asignar')
                    ->icon('heroicon-m-user-circle')
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Resuelto' => 'success',
                        'Pendiente' => 'warning',
                        'Abierto' => 'info',
                        default => 'gray',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'Resuelto' => 'heroicon-m-check-circle',
                        'Pendiente' => 'heroicon-m-clock',
                        'Abierto' => 'heroicon-m-chat-bubble-bottom-center-text',
                        default => 'heroicon-m-minus-circle',
                    }),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Nueva Nota')
                    ->icon('heroicon-m-plus-circle')
                    ->slideOver()
                    ->modalWidth('md'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Editar')
                    ->icon('heroicon-m-pencil-square')
                    ->slideOver(),
                DeleteAction::make()
                    ->icon('heroicon-m-trash'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
