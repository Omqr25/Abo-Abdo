<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'name',
        'classification_id',
        'description',
        'color',  
      ];

      public function classification(): BelongsTo
    {
      return $this->belongsTo(Classification::class);
    }

    public function item(): HasMany
    {
      return $this->hasMany(Item::class);
    }
}