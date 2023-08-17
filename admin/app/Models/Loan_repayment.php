<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan_repayment extends Model
{
   //use HasFactory;
   protected $table = 'loan_repayments';
    protected $primaryKey = 'receipt_number';
    /* Since member_number is not auto-incrementing, set this to false. */
    public $incrementing = false;
    protected $fillable = ['receipt_number', 'amount', 'date', 'status', 'member_number'];
    protected $casts = [
        'date' => 'date',
    ];
}
