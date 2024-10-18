<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 
        'customer_id',
        'with_delivery',
        'total_net_price',
        'total_sell_price',
        'notes',
    ];

    public function group(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }
    public function invoicegroup(): HasMany
    {
        return $this->hasMany(InvoiceGroup::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}