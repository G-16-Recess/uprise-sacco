<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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


    public function index($page)
    {
        $members = Member::all();
        $deposits = Deposit::all();
        $repayments = Loan_repayment::all();
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}", ['members'=>self::getMembers(),'deposits'=>self::getDeposits()]);
        }
        return abort(404);
    }
}
