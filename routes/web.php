<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ScheduleAppointment;
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\ClientDocumentRequestController;
use App\Http\Controllers\ProcedureDocumentRequestController;
use App\Http\Controllers\ClientCaseDocumentRequestController;

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

Route::get('/cliente/{client}/documentos', [ClientDocumentRequestController::class, 'create'])
    ->name('cliente.documentos');

Route::post('/cliente/{client}/documentos', [ClientDocumentRequestController::class, 'store'])
    ->name('cliente.documentos.store');

//Store ProcedureResource documents sended by the client
Route::get('/tramite/{procedure}/documentos', [ProcedureDocumentRequestController::class, 'create'])
    ->name('tramite.documentos');

Route::post('/tramite/{procedure}/documentos', [ProcedureDocumentRequestController::class, 'store'])
    ->name('tramite.documentos.store');

//Store ClientCaseResource documents sended by the user
Route::get('/caso/{clientCase}/documentos', [ClientCaseDocumentRequestController::class, 'create'])
    ->name('caso.documentos');

Route::post('/caso/{clientCase}/documentos', [ClientCaseDocumentRequestController::class, 'store'])
    ->name('caso.documentos.store');