<?php

namespace App\Filament\Resources\Messages\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;


class MessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('subject')
                ->required(),

                Textarea::make('body')
                    ->required()
                    ->columnSpanFull(),

                Select::make('recipients')
                    ->label('Destinatarios')
                    ->multiple()
                    ->relationship('recipients', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
