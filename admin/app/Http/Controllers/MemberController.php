<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Http\Request;
use PDF;
class MemberController extends Controller
{
    public  function export_user_pdf(){
        $users= Member::all();
        $pdf= PDF::loadview('exports.pdf.users', [
            'users'=>$users
        ]);
        return $pdf->download('users.pdf');
    }

    public  function index(){
        $users= Member::all();
        return view('exports.users',['users'=>$users]);
    }

    
}
