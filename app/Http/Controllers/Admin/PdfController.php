<?php

namespace App\Http\Controllers\Admin;

use App;
use PDF;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PdfController extends Controller
{
    public function getContractPdfFile(Request $request, $id) 
    {  		
    	// return view('pdf');
  		// $pdf = PDF::loadView('pdf');
		// return $pdf->download('invoice.pdf');

		// $snappy = App::make('snappy.pdf');
		// $html = View::make('pdf');
		// return new Response(
		//     $snappy->getOutputFromHtml($html),
		//     200,
		//     array(
		//         'Content-Type'          => 'application/pdf',
		//         'Content-Disposition'   => 'attachment; filename="file.pdf"'
		//     )
		// );

		$pdf = App::make('snappy.pdf.wrapper');
		$html = View::make('pdf');
		$pdf->loadHTML($html);
		return $pdf->inline();
    }

    public function viewContractPdfFile(Request $request, $id) 
    {  		
    	return view('pdf');    	
    }
}
