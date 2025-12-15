<?php

namespace App\Notifications;

use App\Models\Message;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Notifications\Notification as LaravelNotification;

class MessageReceived extends LaravelNotification
{
    public function __construct(
        protected Message $message
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return Notification::make()
            ->title('Nuevo mensaje')
            ->body('Tienes un nuevo mensaje')
            ->actions([
                Action::make('ver')
                    ->label('Ver mensaje')
                    ->url(route('filament.admin.resources.messages.index')),
            ])
            ->getDatabaseMessage();
    }
}
