<?php

namespace App\Enums;

enum ExpenseType: string
{
    case  whe = "WareHouseExpense";
    case whr = "WareHouseRent";
    case tax = "tax";
}
