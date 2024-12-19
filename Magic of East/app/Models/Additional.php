<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Additional extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['type', 'total_additional_id', 'amount'];

    public function total_additional(): BelongsTo
    {
        return $this->belongsTo(total_additional::class);
    }
}
