<?php

namespace App\Filament\Resources\ClientCases\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientCaseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('case_name'),
                TextEntry::make('responsable_lawyer'),
                TextEntry::make('case_type'),
                TextEntry::make('courtroom'),
                TextEntry::make('external_expedient_number'),
                TextEntry::make('resume')
                    ->columnSpanFull(),
                TextEntry::make('start_date')
                    ->dateTime(),
                TextEntry::make('stimated_finish_date')
                    ->dateTime(),
                TextEntry::make('real_finished_date')
                    ->dateTime(),
                TextEntry::make('status'),
                TextEntry::make('total_pricing'),
                TextEntry::make('paidPorcentage'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
