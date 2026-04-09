<?php

namespace App\Http\Controllers;

use App\Models\ClientCase;
use Illuminate\Http\Request;

class ClientCaseDocumentRequestController extends Controller
{
    public function create(ClientCase $clientCase)
    {
        // Opciones homologadas con el Relation Manager de Casos
        $documentTypes = [
            'contrato_servicios' => 'Contrato de Prestación de Servicios',
            'poder_notarial' => 'Poder Notarial / Carta Poder',
            'estrategia_legal' => 'Estrategia Legal (Interno)',
            'documental_publica' => 'Prueba Documental Pública',
            'documental_privada' => 'Prueba Documental Privada',
            'material_multimedia' => 'Fotos / Audio / Video',
            'acuerdos' => 'Acuerdos / Convenios',
            'sentencia_definitiva' => 'Sentencia Definitiva',
            'otro' => 'Otro documento',
        ];

        return view('client_cases.documents', compact('clientCase', 'documentTypes'));
    }

    public function store(Request $request, ClientCase $clientCase)
    {
        $request->validate([
            'documents.*.type' => 'required|string',
            'documents.*.file' => 'required|file|max:10240', // 10MB máximo
        ]);

        foreach ($request->documents as $doc) {
            
            // Usamos la misma carpeta centralizada para mantener el estándar
            $path = $doc['file']->store('documents', 'public');

            // Usamos la relación polimórfica de ClientCase
            $clientCase->documents()->create([
                'name' => $doc['type'], 
                'file_path' => $path,
            ]);
        }

        return back()->with('success', 'Documentos del caso enviados correctamente.');
    }
}