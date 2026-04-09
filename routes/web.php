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

Route::get('/cliente/{client}/imprimir', [ClientProfileController::class, 'downloadPdf'])
    ->name('cliente.imprimir');

Route::get('/caso/{clientCase}/imprimir', [\App\Http\Controllers\CaseController::class, 'downloadPdf'])
    ->name('caso.imprimir');

Route::get('/tramite/{procedure}/imprimir', [\App\Http\Controllers\ProcedureController::class, 'downloadPdf'])
    ->name('tramite.imprimir');

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