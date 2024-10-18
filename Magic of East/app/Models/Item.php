<?php

namespace App\Models;

use App\Enums\ItemColor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'group_id',
    ];

    protected $casts = [
        'color' => ItemColor::class,
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }
}