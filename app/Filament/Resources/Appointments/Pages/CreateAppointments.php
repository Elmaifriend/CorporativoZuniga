<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointments extends CreateRecord
{
    protected static string $resource = AppointmentsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($this->data['appointment_mode'] === 'prospect') {

            $client = \App\Models\Client::create([
                'full_name'      => $this->data['prospect_full_name'],
                'person_type'    => 'persona_fisica',
                'client_type'    => 'prospecto',
                'phone_number'   => $this->data['prospect_phone'] ?? 'N/A',
                'email'          => $this->data['prospect_email'] ?? null,
                'curp'           => null,
                'rfc'            => null,
                'address'        => null,
                'ine_id'         => null,
                'occupation'     => null,
                'date_of_birth'  => null,
            ]);

            $data['appointmentable_id']   = $client->id;
            $data['appointmentable_type'] = \App\Models\Client::class;
        }

        if ($this->data['appointment_mode'] === 'client') {
            $data['appointmentable_type'] = \App\Models\Client::class;
        }

        return $data;
    }


}
