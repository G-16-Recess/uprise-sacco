<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Deposit;
use App\Models\Loan_repayment;
use App\Models\Loan_application;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private static function getDeposits () {
        return [
            ['receipt_number'=> 101, 'amount' => 23000.00, 'status' => 'Pending', 'date'=>'2023-07-20', 'member_number' => 102],
            ['receipt_number'=> 201, 'amount' => 23000.00, 'status' => 'Pending', 'date'=>'2023-07-20', 'member_number' => 102],
            ['receipt_number'=> 301, 'amount' => 23000.00, 'status' => 'Pending', 'date'=>'2023-07-20', 'member_number' => 102],
            ['receipt_number'=> 401, 'amount' => 23000.00, 'status' => 'Pending', 'date'=>'2023-07-20', 'member_number' => 102],
            ['receipt_number'=> 501, 'amount' => 23000.00, 'status' => 'Pending', 'date'=>'2023-07-20', 'member_number' => 102]
        ];
    }
    
    public function updateAmount(Request $request, $applicationNumber) {
        
        $newAmount = $request->input('newAmount');

        $loanApplication = Loan_application::where('application_number', $applicationNumber)->first();
        if($loanApplication){
            $loanApplication->update(['amount_granted' => $newAmount]);
            return response()->json(['message' => 'Amount updated successfully']);

        }else { 
            return response()->json(['message' => 'Loan application not fount'], 404);

        }
    }
    public function approveApplication($applicationNumber) {
    $loanApplication = Loan_application::where('application_number', $applicationNumber)->first();
    
    if ($loanApplication) {
        $loanApplication->update(['status' => 'Approved']);
        return response()->json(['message' => 'Loan application approved successfully']);
    } else { 
        return response()->json(['message' => 'Loan application not found'], 404);
    }
}   
    public function rejectApplication($applicationNumber) {
    $loanApplication = Loan_application::where('application_number', $applicationNumber)->first();
    
    if ($loanApplication) {
        $loanApplication->update(['status' => 'rejected']);
        return response()->json(['message' => 'Loan application rejected successfully']);
    } else { 
        return response()->json(['message' => 'Loan application not found'], 404);
    }
}
    public function loanDelete($applicationNumber) {
    $loanRepayment = Loan_repayment::where('application_number', $applicationNumber)->first();
    
    if ($loanRepayment) {
        $loanRepayment->update(['status' => 'Deleted']);
        return response()->json(['message' => 'Loan application has been deleted']);
    } else { 
        return response()->json(['message' => 'Loan application not found'], 404);
    }
}


   
    public function index($page)
    {
        $members = Member::all();
        $deposits = Deposit::all();
        $loans = Loan_repayment::where('status','pending')->get();
        $repayments = Loan_repayment::where('status','paid')->get();
        $loan_requests = Loan_application::where('status','processing')->get();
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}", ['members'=>$members,'deposits'=>$deposits,'loans'=>$loans,'repayments'=>$repayments,'loan_applications'=>$loan_requests]);
        }
        return abort(404);
    }
}
