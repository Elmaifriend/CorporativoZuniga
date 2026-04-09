<?php

namespace App\Filament\Resources\Procedures\Pages;

use App\Filament\Resources\Procedures\ProcedureResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\WhatsApp\WhatsApp;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class EditProcedure extends EditRecord
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

            ActionGroup::make([
                Action::make('mandarLinkDocumentos')
                    ->label('Enviar por WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->action(function () {
                        $link = route('tramite.documentos', ['procedure' => $this->record->id]);

                        // Resolvemos las relaciones inversas: Procedure -> ClientCase -> Client
                        $cliente = $this->record->clientCase->client;

                        $sent = WhatsApp::sendText(
                            $cliente->phone_number,
                            "Hola {$cliente->full_name}, por favor sube los documentos para tu trámite aquí: {$link}"
                        );

                        $this->notifyWhatsAppStatus($sent);
                    }),

                Action::make('copiarLinkDocumentos')
                    ->label('Copiar Enlace')
                    ->icon('heroicon-m-link')
                    ->action(function () {
                        $link = route('tramite.documentos', ['procedure' => $this->record->id]);
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