<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\API\InvoiceController;
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
        return $this->hasMany(InvoiceController::class);
    }
}
