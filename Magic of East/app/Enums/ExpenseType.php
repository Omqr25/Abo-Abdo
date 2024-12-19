<?php

namespace App\Enums;

enum ExpenseType: int
{
    case  WareHouseExpense = 1;
    case WareHouseRent = 2;
    case tax = 3;

    case EmployerExpense = 4;

    public function name(): string
    {
        return match ($this) {
            self::WareHouseExpense => "WareHouseExpense",
            self::WareHouseRent => "WareHouseRent",
            self::tax => "tax",
            self::EmployerExpense => "EmployerExpense"
        };
    }
}
