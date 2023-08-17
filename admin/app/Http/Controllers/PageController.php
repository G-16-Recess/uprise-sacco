<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan_application;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private static function getMembers () {
        return [
            ['id'=> 1, 'username' => 'erwakasiisi@gmail.com', 'phonenumber' => '+256756342045', 'accountbalance' => 0.00, 'loanbalance' => 2000.00],
            ['id'=> 2, 'username' => 'taras@gmail.com', 'phonenumber' => '+256755343045', 'accountbalance' => 0.00, 'loanbalance' => 2000.00],
            ['id'=> 3, 'username' => 'vanessa@gmail.com', 'phonenumber' => '+256756342045', 'accountbalance' => 0.00, 'loanbalance' => 2000.00],
            ['id'=> 4, 'username' => 'steka@gmail.com', 'phonenumber' => '+256756342045', 'accountbalance' => 0.00, 'loanbalance' => 2000.00],
            ['id'=> 5, 'username' => 'allan@gmail.com', 'phonenumber' => '+256756342045', 'accountbalance' => 0.00, 'loanbalance' => 2000.00]
        ];
    }

    private static function getDeposits () {
        return [
            ['receipt_number'=> 101, 'amount' => 23000.00, 'status' => 'Pending', 'date'=>'2023-07-20', 'member_number' => 102],
            ['receipt_number'=> 201, 'amount' => 23000.00, 'status' => 'Pending', 'date'=>'2023-07-20', 'member_number' => 102],
            ['receipt_number'=> 301, 'amount' => 23000.00, 'status' => 'Pending', 'date'=>'2023-07-20', 'member_number' => 102],
            ['receipt_number'=> 401, 'amount' => 23000.00, 'status' => 'Pending', 'date'=>'2023-07-20', 'member_number' => 102],
            ['receipt_number'=> 501, 'amount' => 23000.00, 'status' => 'Pending', 'date'=>'2023-07-20', 'member_number' => 102]
        ];
    }
    
    private static function getloan_forapproval(){
        $loanRequests = Loan_application::where('status','processing')->get();
        return $loanRequests;

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

   
    public function index($page)
    {
        if (view()->exists("pages.{$page}")) {
           
                $members = self::getMembers();
                $deposits = self::getDeposits();
                $loan_applications = self::getloan_forapproval();

            return view("pages.{$page}", compact('members', 'deposits', 'loan_applications'));
        }
        return abort(404);
    }
}
