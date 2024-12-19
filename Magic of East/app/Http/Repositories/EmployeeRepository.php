<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\EmployeeRepositoryInterface;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\total_additional;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    public function store($data)
    {
        $employee = Employee::create($data);
        total_additional::create([
            'employee_id' => $employee->id,
            'total' => 0,
            'salary' => $employee->salary
        ]);
        $e = Expense::where('type', 4)->last();
        $e->update([
            'total' => $e->total + $employee->salary
        ]);
    }

    public function update($id, array $data)
    {
        $employee = Employee::find($id);
        if (isset($data['salary'])) {
            $t = total_additional::where('employee_id', $id)->last();
            $t->update([
                'salary' => $data['salary'],
            ]);
            $e = Expense::where('type', 4)->last();
            $e->update([
                'total' => $e->total + ($data['salary'] - $employee->salary)
            ]);
        }
        $employee->update($data);
    }
}
