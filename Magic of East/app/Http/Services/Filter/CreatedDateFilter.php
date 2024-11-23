<?php

namespace App\Http\Services\Filter;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Support\Carbon;

class CreatedDateFilter implements Filter
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if ($this->type === 'before') {
            return $query->where('created_at', '<=', Carbon::parse($value));
        } elseif ($this->type === 'after') {
            return $query->where('created_at', '>=', Carbon::parse($value));
        }

        return $query;
    }
}
