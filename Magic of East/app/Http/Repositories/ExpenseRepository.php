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
        return  Expense::where('type', $type)->whereMonth('created_at', $month)->whereYear('created_at', $year)->select('name', 'cost')->simplePaginate(10);
    }

    // get the totla Employers expenses including the rewards and deductions for each employee 
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
                    'date' => $year . '/' . $month,
                    'total' => $total,
                    'details' => $details,
                ];
            }
        }
        return $results;
    }
}