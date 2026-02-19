<?php

namespace App\Filament\Resources\Clients\Pages;

use App\Filament\Resources\Clients\ClientsResource;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ViewClients extends ViewRecord
{
    protected static string $resource = ClientsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //EditAction::make(),
            DeleteAction::make(),

            Action::make('convertirACliente')
                ->label('Convertir a cliente')
                ->icon('heroicon-o-arrow-path')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->client_type === 'prospecto')
                ->action(function () {
                    $this->record->update([
                        'client_type' => 'cliente',
                    ]);

                    $this->refreshFormData([
                        'client_type',
                    ]);

                    Notification::make()
                        ->title('Convertido a cliente')
                        ->success()
                        ->send();
                }),
        ];
    }
}
