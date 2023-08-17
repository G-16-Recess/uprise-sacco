<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan_application extends Model
{
    //use HasFactory;
    protected $table = 'loan_application';
    protected $primaryKey = 'application_number';
    
    public $incrementing = false; 
    protected $fillable = ['application_number', 'member_number', 'amount','amount_granted','repayment_period', 'status'];
   
    public $timestamps = false;
}

 