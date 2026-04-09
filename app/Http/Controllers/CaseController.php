<?php

namespace App\Http\Controllers;

use App\Models\ClientCase;
use Barryvdh\DomPDF\Facade\Pdf;

class CaseController extends Controller
{
    public function downloadPdf(ClientCase $clientCase)
    {
        $clientCase->load(['client', 'procedures', 'payments']);
        $pdf = Pdf::loadView('cases.pdf', compact('clientCase'));
        $filename = \Illuminate\Support\Str::slug("caso-{$clientCase->case_name}-{$clientCase->id}") . ".pdf";
        
        return $pdf->download($filename);
    }
}
