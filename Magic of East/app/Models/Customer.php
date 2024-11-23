<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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

    public function scopeName(Builder $query, $value): Builder
    {
        return $query->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", "%$value%");
    }

    // public function scopeAddress(Builder $query, $value): Builder
    // {
    //   $addresses = Address::getAddressMap();
    //   return $query->where('address', $addresses[$value]);
    // }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function invoiceGroups(): HasManyThrough
    {
        return $this->hasManyThrough(InvoiceGroup::class, Invoice::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'invoice_groups', 'customer_id', 'group_id');
    }
}