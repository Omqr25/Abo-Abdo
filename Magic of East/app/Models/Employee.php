<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function reward(): HasMany
    {
        return $this->hasMany(RewardDeduction::class)->where('type' , '=' , 'reward');
    }

    public function deduction(): HasMany
    {
        return $this->hasMany(RewardDeduction::class)->where('type' , '=' , 'deduction');
    }

}