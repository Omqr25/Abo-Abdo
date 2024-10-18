<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'firstname',
        'lastname',
        'salary',
        'address',
        'phonenumber',
        'position',
        'reward',
        'deduction'
    ];

}
