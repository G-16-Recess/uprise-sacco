<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Deposit;
use App\Models\Loan_repayment;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($page)
    {
        $members = Member::all();
        $deposits = Deposit::all();
        $repayments = Loan_repayment::all();
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}", ['members'=>$members,'deposits'=>$deposits,'repayments'=>$repayments]);
        }
        return abort(404);
    }
}
