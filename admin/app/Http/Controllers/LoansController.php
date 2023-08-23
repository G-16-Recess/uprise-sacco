<?php

namespace App\Http\Controllers;
use App\Models\Loans;
use Illuminate\Http\Request;
use PDF;

class LoansController extends Controller
{
    public  function export_Loans_pdf(){
        $Loans= Loans::all();
        $pdf= PDF::loadview('exports.Loanspdf.Loans', [
            'Loans'=>$Loans
        ]);
        return $pdf->download('Loans.pdf');
    }

    public  function index(){
        $Loans= Loans::all();
        return view('exports.Loans',['Loans'=>$Loans]);
    }
}
