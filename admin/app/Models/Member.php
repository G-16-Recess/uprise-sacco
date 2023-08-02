<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //use HasFactory;
    protected $table = 'members';
    protected $primaryKey = 'member_number';
    /* Since member_number is not auto-incrementing, set this to false. */
    public $incrementing = false; 
    protected $fillable = ['member_number', 'username', 'password', 'phone_number', 'account_balance', 'loan_balance'];
}
