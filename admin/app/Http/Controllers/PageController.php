<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

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


    public function index($page)
    {
        $members = Member::all();
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}", ['members'=>$members,'deposits'=>self::getDeposits()]);
        }
        return abort(404);
    }
}
