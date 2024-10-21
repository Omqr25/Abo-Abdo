<?php

namespace App\Models;

use App\Enums\EmployerExpenseType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RewardDeduction extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [ 
        'type',
        'amount',
        'employer_id',
    ];

    protected $casts = [
        'type' => EmployerExpenseType::class,
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}