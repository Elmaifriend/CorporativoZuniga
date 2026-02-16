<?php

namespace App\Notifications;

use App\Models\Appointments;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Notifications\Notification as LaravelNotification;

class NuevaCitaNotification extends LaravelNotification
{
    public function __construct(
        protected Appointments $cita
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return FilamentNotification::make()
            ->title('Nueva cita registrada')
            ->body(
                'Nueva cita para ' . 
                $this->cita->date_time->format('d/m/Y H:i')
            )
            ->actions([
                Action::make('ver')
                    ->label('Ver cita')
                    ->url(
                        route(
                            'filament.admin.resources.appointments.view',
                            $this->cita->id
                        )
                    )
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }
}
