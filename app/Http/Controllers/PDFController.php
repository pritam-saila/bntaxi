<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        $val['book'] = Book::join('users','books.user_id','=','users.id')->where(['books.status' => 'Active','books.id' => $id])->select('books.*', 'users.name as username','users.phone as userphone','users.address as useraddress')->first();
        $val['book']['addonssoft'] = unserialize($val['book']['addons']);
        // Fetch the view content
        $html = View::make('pdf.invoice',$val)->render();

        // Create a new Dompdf instance
        $dompdf = new Dompdf();

        // Load HTML content
        $dompdf->loadHtml($html);

        // Render PDF (optional settings)
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $name = 'invoice_'.time().'.pdf';
        // Output the generated PDF to Browser
        return $dompdf->stream($name);
    }
}
