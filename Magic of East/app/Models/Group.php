<?php

namespace App\Models;

use App\Enums\ItemColor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'name',
        'description',
        'color',  
        'classification_id',
      ];

      protected $casts = [
        'color' => ItemColor::class,
    ];

      public function classification(): BelongsTo
    {
      return $this->belongsTo(Classification::class);
    }

    public function items(): HasMany
    {
      return $this->hasMany(Item::class);
    }

    public function invoiceGroups(): HasMany
    {
      return $this->hasMany(InvoiceGroup::class);
    }

    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class);
    }
}