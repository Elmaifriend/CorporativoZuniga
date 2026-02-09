<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\User;
use App\Services\WhatsappApiNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsappMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $messageId,
        public int $userId,
    ) {}

    public function handle(WhatsappApiNotificationService $whatsapp): void
    {
        $message = Message::find($this->messageId);
        $user = User::find($this->userId);

        if (! $message || ! $user || ! $user->chat_id) {
            return;
        }

        $success = $whatsapp->sendTemplate(
            chatId: $user->phone_number,
            templateName: 'internal_message',
            parameters: [
                'sender' => $message->sender->name,
                'subject' => $message->subject,
            ],
            lang: 'es'
        );

        if (! $success) {
            Log::warning('Falló envío WhatsApp', [
                'message_id' => $this->messageId,
                'user_id' => $this->userId,
            ]);
        }
    }
}
