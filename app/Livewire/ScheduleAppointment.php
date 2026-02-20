<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\Appointments;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\NuevaCitaNotification;
use App\Enums\AppointmentStatus;

class ScheduleAppointment extends Component
{
    public $phone_number = '';
    public $client = null;
    public $isExisting = false;

    public $full_name = '';
    public $email = '';

    public $date = '';
    public $time = '';

    public $reason = 'Consulta inicial';
    public $modality = 'Presencial';
    public $notes = '';

    public $success = false;

    public function checkPhone()
    {
        if(strlen($this->phone_number) < 10) {
            $this->isExisting = false;
            return;
        }

        $client = Client::where('phone_number', $this->phone_number)->first();

        if($client){
            $this->client = $client;
            $this->isExisting = true;
            $this->full_name = $client->full_name;
            $this->email = $client->email;
        } else {
            $this->client = null;
            $this->isExisting = false;
        }
    }


    public function confirmAppointment()
    {
        $this->validate([
            'phone_number' => 'required|min:10',
            'date' => 'required',
            'time' => 'required',
        ]);

        if(!$this->isExisting){
            $this->validate([
                'full_name' => 'required',
                'email' => 'required|email'
            ]);

            $this->client = Client::create([
                'full_name' => $this->full_name,
                'phone_number' => $this->phone_number,
                'email' => $this->email,
                "client_type" => "Prospecto",   
            ]);
        }

        $dateTime = Carbon::parse($this->date . ' ' . $this->time);

        $appointment = Appointments::create([
            'appointmentable_id' => $this->client->id,
            'appointmentable_type' => Client::class,
            'date_time' => $dateTime,
            'reason' => $this->reason,
            'status' => AppointmentStatus::Pending,
            'modality' => $this->modality,
            'notes' => $this->notes,
        ]);

        $this->success = true;

        $users = User::all();

        foreach ($users as $user) {
            $user->notify(new NuevaCitaNotification($appointment));
        }
    }

    public function render()
    {
        return view('livewire.schedule-appointment');
    }
}
