<?php

namespace App\Filament\Resources\Messages\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;



class MessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject')
                    ->label('Asunto')
                    ->searchable(),

                TextColumn::make('sender.name')
                    ->label('Enviado por'),

                IconColumn::make('attended')
                    ->label('Atendido')
                    ->boolean()
                    ->getStateUsing(fn ($record) =>
                        $record->pivot?->attended_at !== null
                    ),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('attend')
                    ->label('Marcar como atendido')
                    ->visible(fn ($record) =>
                        $record->pivot &&
                        $record->pivot->attended_at === null
                    )
                    ->action(fn ($record) =>
                        $record->recipients()
                            ->updateExistingPivot(auth()->id(), [
                                'attended_at' => now(),
                            ])
                    ),
            ]);
    }
}
