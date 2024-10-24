<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\EmployeeRepositoryInterface;
use App\Models\Employee;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }
}