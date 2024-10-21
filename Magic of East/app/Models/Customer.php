<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory , SoftDeletes, CascadeSoftDeletes;
    protected $fillable = [
        'firstname',
        'lastname',
        'phonenumber',
        'address'
    ];

    public function invoice(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}