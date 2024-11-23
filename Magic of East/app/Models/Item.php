<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'height',
        'width',
        'depth',
        'group_id',
    ];

    // public function height(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => (float)$value/10,
    //         set: fn (string $value) => (float)round($value,1)*10,
    //     );
    // }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}