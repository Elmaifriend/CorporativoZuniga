<?php

namespace App\Filament\Resources\ClientCases\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ClientCaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                TextInput::make('case_name')
                    ->required(),
                TextInput::make('responsable_lawyer')
                    ->required(),
                TextInput::make('case_type')
                    ->required(),
                TextInput::make('courtroom')
                    ->required(),
                TextInput::make('external_expedient_number')
                    ->required(),
                Textarea::make('resume')
                    ->required()
                    ->rows(6)
                    ->columnSpanFull(),
                DateTimePicker::make('start_date')
                    ->required(),
                DateTimePicker::make('stimated_finish_date')
                    ->required(),
                DateTimePicker::make('real_finished_date')
                    ->required(),
                TextInput::make('status')
                    ->required(),
                TextInput::make('total_pricing')
                    ->prefix("$")
                    ->required(),
                TextInput::make('paidPorcentage')
                    ->label("Porcentaje pagado")
                    ->disabled()
                    ->prefix("$")
                    ->afterStateHydrated(function ($component, $state, $record) {
                        $component->state($record->paidPorcentage);
                    }),
            ]);
    }
}
