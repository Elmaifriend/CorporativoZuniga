<?php

namespace App\Filament\Resources\ClientCases\Pages;

use App\Filament\Resources\ClientCases\ClientCaseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\WhatsApp\WhatsApp;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Notifications\Notification;

class EditClientCase extends EditRecord
{
    protected static string $resource = ClientCaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('imprimir')
                ->label('Imprimir PDF')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->url(fn() => route('caso.imprimir', $this->record))
                ->openUrlInNewTab(),

            ActionGroup::make([
                Action::make('mandarLinkDocumentos')
                    ->label('Enviar por WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->action(function () {
                        $link = route('caso.documentos', ['clientCase' => $this->record->id]);

                        // Resolvemos la relación directa: ClientCase -> Client
                        $cliente = $this->record->client;

                        $sent = WhatsApp::sendText(
                            $cliente->phone_number,
                            "Hola {$cliente->full_name}, por favor sube los documentos para tu caso '{$this->record->case_name}' aquí: {$link}"
                        );

                        $this->notifyWhatsAppStatus($sent);
                    }),

                Action::make('copiarLinkDocumentos')
                    ->label('Copiar Enlace')
                    ->icon('heroicon-m-link')
                    ->action(function () {
                        $link = route('caso.documentos', ['clientCase' => $this->record->id]);
                        $this->js("navigator.clipboard.writeText('{$link}');");
                        Notification::make()->title('Enlace de carga copiado')->success()->send();
                    }),
            ])
            ->label('Pedir Documentos')
            ->icon('heroicon-m-document-plus')
            ->button()
            ->color('gray')
            ->outlined(),

            DeleteAction::make(),
        ];
    }

    protected function notifyWhatsAppStatus(bool $sent): void
    {
        Notification::make()
            ->title($sent ? 'Notificación enviada con éxito' : 'Fallo en el servicio de WhatsApp')
            ->color($sent ? 'success' : 'danger')
            ->icon($sent ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-circle')
            ->send();
    }
}