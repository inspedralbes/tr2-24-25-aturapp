<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
    public function generatePDF(Request $request)
    {
        $data = $request->validate([
            'alumne' => 'required|string|max:255',
            'profesor' => 'required|string|max:255',
            'tipoIncidencia' => 'required|string|max:50',
            'descripcion' => 'required|string|max:1000',
            'medidas' => 'required|string|max:500',
            'contacto' => 'required|string|in:si,no',
        ]);

        $pdf = PDF::loadView('pdf.incidencia', $data);

        $content = base64_encode($pdf->output());

        return response()->json([
            'status' => 'success',
            'filename' => 'incidencia_' . now()->format('YmdHis') . '.pdf',
            'content' => $content
        ]);
    }
}
