<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'path',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
