<?php

namespace App\Http\Controllers;
use App\LoanRequest;
use App\Models\RequestLoan;
use Illuminate\Http\Request;
use PDF; // Import the PDF class

class LoanRequestController extends Controller
{
    public function export_loanRequest_pdf()
    {
        $LoanRequests = RequestLoan::all();
        $pdf = PDF::loadView('exports.LoanRequestspdf.LoanRequests', [
            'LoanRequests' => $LoanRequests
        ]);
        return $pdf->download('LoanRequestspdf.pdf'); 
    }

    public function index()
    {
        $LoanRequests = RequestLoan::all();
        return view('exports.LoanRequests', ['LoanRequests' => $LoanRequests]);
    }
}
