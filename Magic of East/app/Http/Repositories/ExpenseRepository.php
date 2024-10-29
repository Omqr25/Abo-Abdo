<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ExpenseRepositoryInterface;
use App\Models\Expense;

class ExpenseRepository extends BaseRepository implements ExpenseRepositoryInterface
{
    public function __construct(Expense $model)
    {
        parent::__construct($model);
    }
}
