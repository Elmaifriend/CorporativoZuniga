<?php

namespace App\Filament\Resources\Messages\Pages;

use App\Filament\Resources\Messages\MessageResource;
use App\WhatsApp\WhatsApp;
use Filament\Resources\Pages\CreateRecord;

class CreateMessage extends CreateRecord
{
    protected static string $resource = MessageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['sender_id'] = auth()->id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $notifyWhatsapp = $this->data['notify_whatsapp'] ?? false;

        if (! $notifyWhatsapp) {
            return;
        }

        $senderName = auth()->user()->name;

        $this->record->recipients->each(function ($user) use ($senderName) {

            if ($user->has_wa && $user->phone_number) {
                $message = "📩 *MENSAJE NUEVO* de _{$senderName}_\n" .
                    "Asunto: *{$this->record->subject}*\n\n" .
                    "Puedes revisarlo en el sistema.";

                WhatsApp::sendText($user->phone_number, $message);
            }
        });
    }
}
