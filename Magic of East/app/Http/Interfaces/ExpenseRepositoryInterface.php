<?php

namespace App\Http\Interfaces;

interface ExpenseRepositoryInterface extends BaseRepositoryInterface
{
    public function getAll($type);
    public function getExpenseDetails($type, $date);
}
