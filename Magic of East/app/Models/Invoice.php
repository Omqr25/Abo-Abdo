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
        'notes',
        'with_delivery',
        'total_net_price',
        'total_sell_price',
    ];

    protected $casts = [
        'total_net_price' => 'integer',
        'total_sell_price' => 'integer',
    ];

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'invoice_groups');
    }
    public function invoiceGroups(): HasMany
    {
        return $this->hasMany(InvoiceGroup::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}