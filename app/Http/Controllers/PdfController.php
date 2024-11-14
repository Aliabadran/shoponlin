<?php

namespace App\Http\Controllers;

use PDF;

use App\Models\Order;
use Illuminate\Http\Request;

class PdfController extends Controller
{

    public function generatePdf()
    {


           $data = ['title' => 'PDF Generation with Laravel 11'];
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf_view', $data);

            return $pdf->download('example.pdf');

    }

    public function generateAllOrdersPDF()
    {
        // Fetch all orders with their related items
        $orders = Order::with('items')->get();

        // Pass the orders data to the view
        $data = [
            'orders' => $orders
        ];

        // Load the view and generate the PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.all_orders', $data);

        // Download the generated PDF file
        //return $pdf->download('all_orders.pdf');
        return $pdf->stream('order_' .'-' . '.pdf'); // Stream to browser
    
    }



}
