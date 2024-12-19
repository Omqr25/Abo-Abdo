<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class total_additional extends Model
{
    use HasFactory;
    protected $fillable = [
        'total',
        'employee_id',
        'salary'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    public function rewards(): HasMany
    {
        return $this->hasMany(Additional::class)->where('type', 1);
    }

    public function deductions(): HasMany
    {
        return $this->hasMany(Additional::class)->where('type', 2);
    }
}
