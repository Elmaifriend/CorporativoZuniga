<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use Barryvdh\DomPDF\Facade\Pdf;

class ProcedureController extends Controller
{
    public function downloadPdf(Procedure $procedure)
    {
        $procedure->load(['clientCase.client', 'payments']);
        $pdf = Pdf::loadView('procedures.pdf', compact('procedure'));
        $filename = \Illuminate\Support\Str::slug("tramite-{$procedure->title}-{$procedure->id}") . ".pdf";
        
        return $pdf->download($filename);
    }
}
