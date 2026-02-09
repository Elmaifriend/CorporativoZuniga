<?php

namespace App\Filament\Resources\InternalAnnouncements\Pages;

use App\Filament\Resources\InternalAnnouncements\InternalAnnouncementResource;
use App\Jobs\SendAnnouncementWhatsappJob;
use App\Models\User;
use App\Notifications\InternalAnnouncementCreated;
use Filament\Resources\Pages\CreateRecord;

class CreateInternalAnnouncement extends CreateRecord
{
    protected static string $resource = InternalAnnouncementResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $notifyWhatsapp = $this->data['notify_whatsapp'] ?? false;

        User::query()->each(function (User $user) use ($notifyWhatsapp) {

            $user->notify(
                new InternalAnnouncementCreated($this->record)
            );

            if ($notifyWhatsapp && $user->phone_number) {
                SendAnnouncementWhatsappJob::dispatch( announcementId: $this->record->id, userId: $user->id );
            }
        });
    }
}
