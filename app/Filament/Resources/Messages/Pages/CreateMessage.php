<?php

namespace App\Filament\Resources\Messages\Pages;

use App\Filament\Resources\Messages\MessageResource;
use Filament\Resources\Pages\CreateRecord;
use App\Notifications\MessageReceived;


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
        $this->record->recipients->each(function ($user) {
            $user->notify(new MessageReceived($this->record));
        });
    }
}
