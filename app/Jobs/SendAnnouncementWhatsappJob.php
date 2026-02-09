<?php

namespace App\Jobs;

use App\Models\InternalAnnouncement;
use App\Models\User;
use App\Services\WhatsappApiNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAnnouncementWhatsappJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $announcementId,
        public int $userId,
    ) {}

    public function handle(WhatsappApiNotificationService $whatsapp): void
    {
        $announcement = InternalAnnouncement::find($this->announcementId);
        $user = User::find($this->userId);

        if (! $announcement || ! $user || ! $user->chat_id) {
            return;
        }

        $whatsapp->sendTemplate(
            chatId: $user->chat_id,
            templateName: 'internal_announcement',
            parameters: [
                'title' => $announcement->title,
            ],
            lang: 'es'
        );
    }
}