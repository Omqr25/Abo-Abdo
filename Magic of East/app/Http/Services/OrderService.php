<?php

namespace App\Http\Services;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Group;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public static function employee()
    {
        $data = Employee::orderBy('firstname')->orderBy('lastname')
            ->simplePaginate(10);
        return $data;
    }
    public static function customer()
    {
        $data = Customer::orderBy('firstname')->orderBy('lastname')
            ->simplePaginate(10);
        return $data;
    }

    public static function group()
    {
        $data = Group::orderByRaw("CASE WHEN state = 'available' THEN 0 ELSE 1 END")
            ->simplePaginate(10);
        return $data;
    }
}
