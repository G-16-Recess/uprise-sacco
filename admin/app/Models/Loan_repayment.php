<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan_repayment extends Model
{
   //use HasFactory;
   protected $table = 'loan_repayments';
    protected $primaryKey = 'id';
    /* Since member_number is not auto-incrementing, set this to false. */
    public $incrementing = false;
    protected $fillable = ['id', 'application_number', 'member_number', 'amount', 'due_date','status'];
  
    public $timestamps = false;
}
