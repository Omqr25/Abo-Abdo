<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ExpenseRepositoryInterface;
use App\Models\Employee;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class ExpenseRepository extends BaseRepository implements ExpenseRepositoryInterface
{
    public function __construct(Expense $model)
    {
        parent::__construct($model);
    }

    // get the total expenses for all monthes from the oldest expense till now
    public function getMonthlyWarehouseExpenses($type)
    {
        $currentYear = now()->year;
        $currentMonth = now()->month;
        $monthlyExpenses = $this->model::where('type', $type)
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'), DB::raw('SUM(cost) as total'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        $results = [];
        $startYear = $monthlyExpenses->first()->year ?? $currentYear;
        $startMonth = $monthlyExpenses->first()->month ?? 1;

        for ($year = $startYear; $year <= $currentYear; $year++) {
            for ($month = $year == $startYear ? $startMonth : 1; $month <= ($year == $currentYear ? $currentMonth : 12); $month++) {
                $total = 0;
                if ($monthlyExpenses->where('month', $month)->where('year', $year)->first->total != null) {
                    $total = $monthlyExpenses->where('month', $month)->where('year', $year)->first()->total;
                }
                $results[] = [
                    'date' => $year . '/' . $month,
                    'total' => $total,
                ];
            }
        }
        return $results;
    }

    // get the details of the total expenses for a specific month
    public function getExpenseDetails($type, $month, $year)
    {
        $basequery = null;
        if ($type == 4) {
            $basequery = Employee::with([
                'rewards' => function ($query) use ($month, $year) {
                    $query->selectRaw('employee_id, SUM(amount) as total_rewards')
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->groupBy('employee_id');
                },
                'deductions' => function ($query) use ($month, $year) {
                    $query->selectRaw('employee_id, SUM(amount) as total_deductions')
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->groupBy('employee_id');
                }
            ])
                ->select('id', 'firstname', 'lastname', 'salary')
                ->simplePaginate(10);

            $basequery = $basequery->through(function ($employee) {
                $totalRewards = $employee->rewards->isNotEmpty() ? $employee->rewards[0]->total_rewards : 0;
                $totalDeductions = $employee->deductions->isNotEmpty() ? $employee->deductions[0]->total_deductions : 0;
                return [
                    'id' => $employee->id,
                    'firstname' => $employee->firstname,
                    'lastname' => $employee->lastname,
                    'salary' => $employee->salary,
                    'rewards' => $totalRewards,
                    'deductions' => $totalDeductions,
                ];
            });
        } else
            $basequery = Expense::where('type', $type)->whereMonth('created_at', $month)->whereYear('created_at', $year)->select('id', 'name', 'cost')->simplePaginate(10);
        return [
            'data' => $basequery->items(),
            'meta' => [
                'per_page' => $basequery->perPage(),
                'count' => $basequery->count(),
                'current_page' => $basequery->currentPage(),
                'path' => $basequery->path(),
                'from' => $basequery->firstItem(),
                'to' => $basequery->lastItem(),
                'prev' => $basequery->previousPageUrl(),
                'next' => $basequery->nextPageUrl(),
            ]
        ];
    }


    public function getMonthlyEmployersExpenses()
    {
        $currentYear = now()->year;
        $currentMonth = now()->month;
        $monthlySalary = Employee::select('*', DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        $total_salary = $monthlySalary->sum('salary');
        $results = [];
        $startYear = $monthlySalary->first()->year ?? $currentYear;
        $startMonth = $monthlySalary->first()->month ?? 1;
        for ($year = $startYear; $year <= $currentYear; $year++) {
            for ($month = $year == $startYear ? $startMonth : 1; $month <= ($year == $currentYear ? $currentMonth : 12); $month++) {
                $total = $total_salary;
                foreach ($monthlySalary as $employer) {
                    $deductionsSum = $employer->deductions($month, $year)->get()->sum('amount');
                    $rewardSum =  $employer->rewards($month, $year)->get()->sum('amount');
                    $total += $rewardSum;
                    $total -= $deductionsSum;
                }
                $results[] = [
                    'date' => $year . '/' . $month,
                    'total' => $total,
                ];
            }
        }
        return $results;
    }

    public function getMonthlyExpenses($type)
    {
        $results = [];
        if ($type == 1) {
            $employeesResults = $this->getMonthlyEmployersExpenses();
            $WarehouseExpenses = $this->getMonthlyWarehouseExpenses(1);
            $results = [
                'total_1' => $employeesResults,
                'total_2' => $WarehouseExpenses,
            ];
        } else {
            $WarehouseRental = $this->getMonthlyWarehouseExpenses(2);
            $WarehouseTaxes = $this->getMonthlyWarehouseExpenses(3);
            $results = [
                'total_1' => $WarehouseRental,
                'total_2' => $WarehouseTaxes,
            ];
        }
        return $results;
    }
}
