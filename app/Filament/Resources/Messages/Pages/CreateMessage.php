<?php

namespace App\Filament\Resources\Messages\Pages;

use App\Filament\Resources\Messages\MessageResource;
use Filament\Resources\Pages\CreateRecord;
use App\Notifications\MessageReceived;
use App\Jobs\SendWhatsappMessageJob;


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

        $this->record->recipients->each(function ($user) use ($notifyWhatsapp) {

            //DB notification
            $user->notify(new MessageReceived($this->record));

            // WhatsApp notification
            if ($notifyWhatsapp && $user->phone_number) {
                SendWhatsappMessageJob::dispatch( messageId: $this->record->id, userId: $user->id );
            }
        });
    }
}
