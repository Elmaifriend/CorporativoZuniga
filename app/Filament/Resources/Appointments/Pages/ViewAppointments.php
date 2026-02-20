<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentsResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Actions\Action;
use App\Enums\AppointmentStatus;

class ViewAppointments extends ViewRecord
{
    protected static string $resource = AppointmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Action::make('accept')
                ->label('Aceptar')
                ->icon('heroicon-o-check')
                ->color('success')
                //->visible(fn () => $this->record->status === AppointmentStatus::Pending)
                ->action(function () {
                    $this->record->update([
                        'status' => AppointmentStatus::Confirmed,
                    ]);

                    $this->refreshFormData([
                        'status',
                    ]);
                }),

            Action::make('reject')
                ->label('Rechazar')
                ->icon('heroicon-o-x-mark')
                ->color('danger')
                //->visible(fn () => $this->record->status === AppointmentStatus::Pending)
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update([
                        'status' => AppointmentStatus::Rejected,
                    ]);

                    $this->refreshFormData([
                        'status',
                    ]);
                }),

            Action::make('reschedule')
                ->label('Reagendar')
                ->icon('heroicon-o-arrow-path')
                ->color('info')
                //->visible(fn () => $this->record->status === AppointmentStatus::Pending)
                ->action(function () {

                    $this->record->update([
                        'status' => AppointmentStatus::RescheduleProposed,
                        'reschedule_proposed_at' => now(),
                    ]);

                    // Redirige a editar
                    $this->redirect(
                        AppointmentsResource::getUrl('edit', [
                            'record' => $this->record,
                        ])
                    );
                }),

            EditAction::make(),
        ];
    }
}
