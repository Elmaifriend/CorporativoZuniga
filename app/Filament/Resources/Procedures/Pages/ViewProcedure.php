<?php

namespace App\Filament\Resources\Procedures\Pages;

use App\Filament\Resources\Procedures\ProcedureResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProcedure extends ViewRecord
{
    protected static string $resource = ProcedureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('imprimir')
                ->label('Imprimir PDF')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->url(fn() => route('tramite.imprimir', $this->record))
                ->openUrlInNewTab(),
            EditAction::make(),
        ];
    }
}
