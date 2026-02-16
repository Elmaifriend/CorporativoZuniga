<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ScheduleAppointment;

Route::get('/', function () {
    return view('home');
});

Route::get('/agendar-cita', ScheduleAppointment::class)
    ->name('appointments.schedule');
