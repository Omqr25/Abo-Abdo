<?php

namespace App\Http\Interfaces;

interface ExpenseRepositoryInterface extends BaseRepositoryInterface
{
    public function getMonthlyWarehouseExpenses($type);

    public function getMonthlyEmployersExpenses();
}
