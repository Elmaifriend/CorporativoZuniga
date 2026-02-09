<?php

namespace App\Notifications;

use App\Models\InternalAnnouncement;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Notifications\Notification as LaravelNotification;

class InternalAnnouncementCreated extends LaravelNotification
{
    public function __construct(
        protected InternalAnnouncement $announcement
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return Notification::make()
            ->title('Nuevo anuncio interno')
            ->body($this->announcement->title)
            ->icon('heroicon-o-megaphone')
            ->iconColor('primary')
            ->actions([
                Action::make('ver')
                    ->label('Ver anuncio')
                    ->url(
                        route(
                            'filament.admin.resources.internal-announcements.edit',
                            $this->announcement
                        )
                    ),
            ])
            ->getDatabaseMessage();
    }
}
