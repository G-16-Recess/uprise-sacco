<?php

namespace App\Http\Controllers;
use App\Models\Deposit;
use PDF;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public  function index(){
        $deposits= Deposit::all();
        return view('exports.deposits',['deposits'=>$deposits]);
    }

    public  function export_deposit_pdf(){
        $deposits= Deposit::all();
        $pdf= PDF::loadview('exports.depositspdf.deposits', [
            'deposits'=>$deposits
        ]);
        return $pdf->download('deposits.pdf');
    }

}
