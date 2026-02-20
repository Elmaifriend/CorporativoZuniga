<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ScheduleAppointment;
use App\Http\Controllers\ClientProfileController;

Route::get('/', function () {
    return view('home');
});

Route::get('/agendar-cita', ScheduleAppointment::class)
    ->name('appointments.schedule');

Route::middleware('signed')->group(function () {
    
});

Route::get('/cliente/{client}/editar-perfil', [ClientProfileController::class, 'edit'])
        ->name('cliente.editar-perfil');

    Route::post('/cliente/{client}/editar-perfil', [ClientProfileController::class, 'update'])
        ->name('cliente.editar-perfil.update');