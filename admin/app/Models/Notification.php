<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'reference_number';
    /* Since member_number is not auto-incrementing, set this to false. */
    public $incrementing = false; 
    protected $fillable = ['reference_number', 'category', 'receipt_number', 'member_number', 'status'];

}
