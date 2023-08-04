<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan_request_approval extends Model
{
    //use HasFactory;
    protected $table = 'loan_request_approvals';
    protected $primaryKey = 'application_no';
    /* Since member_number is not auto-incrementing, set this to false. */
    public $incrementing = false; 
    protected $fillable = ['application_no', 'member_number', 'amount', 'repayment_period', 'status'];
}
