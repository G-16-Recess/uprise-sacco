<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan_application extends Model
{
    //use HasFactory;
    protected $table = 'loan_application';
    protected $primaryKey = 'application_no';
    /* Since member_number is not auto-incrementing, set this to false. */
    public $incrementing = false; 
    protected $fillable = ['application_no', 'member_ID', 'amount','amount_granted','repayment_period', 'status'];
   
    public $timestamps = false;
}

 