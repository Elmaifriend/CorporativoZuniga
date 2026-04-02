<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use Illuminate\Http\Request;

class ProcedureDocumentRequestController extends Controller
{
    public function create(Procedure $procedure)
    {
        // Opciones homologadas con el Relation Manager de Trámites
        $documentTypes = [
            'demanda' => 'Demanda / Escrito Inicial',
            'contestacion' => 'Contestación',
            'pruebas' => 'Pruebas / Peritajes',
            'sentencia' => 'Resolución / Sentencia',
            'amparo' => 'Amparo',
            'pago_derechos' => 'Comprobante de pago de derechos',
            'acuses' => 'Acuses de recibo',
            'citatorio' => 'Citatorios / Notificaciones',
            'otro' => 'Otro documento',
        ];

        return view('procedures.documents', compact('procedure', 'documentTypes'));
    }

    public function store(Request $request, Procedure $procedure)
    {
        $request->validate([
            'documents.*.type' => 'required|string',
            'documents.*.file' => 'required|file|max:10240', // 10MB max
        ]);

        foreach ($request->documents as $doc) {
            
            // Usamos la misma carpeta centralizada
            $path = $doc['file']->store('documents', 'public');

            // Usamos la relación morph
            $procedure->documents()->create([
                'name' => $doc['type'], 
                'file_path' => $path,
            ]);
        }

        return back()->with('success', 'Documentos del trámite enviados correctamente.');
    }
}