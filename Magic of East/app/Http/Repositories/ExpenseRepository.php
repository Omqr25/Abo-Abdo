<?php

namespace App\Http\Repositories;

use App\Enums\EmployerExpenseType;
use App\Http\Interfaces\ExpenseRepositoryInterface;
use App\Models\Additional;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\RewardDeduction;
use Illuminate\Support\Facades\DB;

class ExpenseRepository extends BaseRepository implements ExpenseRepositoryInterface
{
    public function __construct(Expense $model)
    {
        parent::__construct($model);
    }

    public function getMonthlyWarehouseExpenses()
    {

        $currentYear = now()->year;
        $currentMonth = now()->month;
        $monthlyExpenses = $this->model::where('type', 1)
            ->select('name', 'cost', DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        $results = [];
        $startYear = $monthlyExpenses->first()->year ?? $currentYear;
        $startMonth = $monthlyExpenses->first()->month ?? 1;

        for ($year = $startYear; $year <= $currentYear; $year++) {
            for ($month = $year == $startYear ? $startMonth : 1; $month <= ($year == $currentYear ? $currentMonth : 12); $month++) {
                $monthlyDetails = $monthlyExpenses->filter(function ($expense) use ($year, $month) {
                    return $expense->year == $year && $expense->month == $month;
                });
                $total = 0;
                $details = [];
                foreach ($monthlyDetails as $expense) {
                    $total += $expense->cost;
                    $details[] = [
                        'name' => $expense->name,
                        'cost' => $expense->cost,
                    ];
                }
                $results[] = [
                    'year' => $year,
                    'month' => $month,
                    'total' => $total,
                    'details' => $details,
                ];
            }
        }
        return $results;
    }

    public function getMonthlyEmployersExpenses()
    {
        $currentYear = now()->year;
        $currentMonth = now()->month;
        $monthlySalary = Employee::select('*', DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        $results = [];
        $startYear = $monthlySalary->first()->year ?? $currentYear;
        $startMonth = $monthlySalary->first()->month ?? 1;
        for ($year = $startYear; $year <= $currentYear; $year++) {
            for ($month = $year == $startYear ? $startMonth : 1; $month <= ($year == $currentYear ? $currentMonth : 12); $month++) {
                $monthlyDetails = $monthlySalary->filter(function ($employer) use ($year, $month) {
                    return $employer->year == $year && $employer->month == $month;
                });
                $total = 0;
                $details = [];
                foreach ($monthlyDetails as $employer) {
                    $deductionsSum = $employer->deductions($month, $year)->get()->sum('amount');
                    $rewardSum =  $employer->rewards($month, $year)->get()->sum('amount');
                    $total += $employer->salary;
                    $total += $rewardSum;
                    $total -= $deductionsSum;
                    $details[] = [
                        'name' => $employer->firstname . " " . $employer->lastname,
                        'salary' => $employer->salary,
                        'deductions' => $rewardSum,
                        'rewards' => $deductionsSum,
                    ];
                }
                $results[] = [
                    'year' => $year,
                    'month' => $month,
                    'total' => $total,
                    'details' => $details,
                ];
            }
        }
        return $results;
    }
}
