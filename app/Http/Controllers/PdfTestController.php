<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfTestController extends Controller
{
    public function testPdf()
    {
        $pdf = Pdf::loadView('pdf.test');
        return $pdf->download('test.pdf');
    }
}
