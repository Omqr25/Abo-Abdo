<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ExpenseRepositoryInterface;
use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Expensedetails;
use App\Models\total_additional;
use Illuminate\Support\Facades\DB;

class ExpenseRepository extends BaseRepository implements ExpenseRepositoryInterface
{
    public function __construct(Expense $model)
    {
        parent::__construct($model);
    }

    /*
        this method will return the total expenses for each month
        for each month there is (total_1 & total_2):
        whene type is 1:
        total_1 :  Warehouse expenses
        total_2 : Employers Expenses
        whene type is 2:
        total_1 :  Warehouse rental
        total_2 : Taxes
    */
    public function getAll($type)
    {
        $basequery = null;
        $data = [];
        if ($type == 1) {
            $basequery = Expense::where('type', 1)->orWhere('type', 4)->orderBy('created_at', 'desc')->simplePaginate(10);
            foreach ($basequery->items() as $expense) {
                $month = $expense->created_at->format('Y-m');
                $type = $expense->type;
                $total = $expense->total;
                if (!isset($data[$month])) {
                    $data[$month] = ['date' => $month, 'total_1' => 0, 'total_2' => 0,];
                }
                if ($type == 1) {
                    $data[$month]['total_1'] += $total; // for Warehouse expenses
                } elseif ($type == 4) {
                    $data[$month]['total_2'] += $total; // for Employers Expenses
                }
            }
            $data = array_values($data);
        } else {
            $basequery = Expense::where('type', 2)->orWhere('type', 3)->orderBy('created_at', 'desc')->simplePaginate(10);
            foreach ($basequery->items() as $expense) {
                $month = $expense->created_at->format('Y-m');
                $type = $expense->type;
                $total = $expense->total;
                if (!isset($data[$month])) {
                    $data[$month] = ['date' => $month, 'total_1' => 0, 'total_2' => 0,];
                }
                if ($type == 2) {
                    $data[$month]['total_1'] += $total; // Warehouse rental
                } elseif ($type == 3) {
                    $data[$month]['total_2'] += $total; // Taxes 
                }
            }
            $data = array_values($data);
        }
        return [
            'data' => $data,
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

    public function destroy($id)
    {
        $detail = Expensedetails::find($id);
        $expense_id = $detail->expense_id;
        $expense = Expense::find($expense_id);
        $total = $expense->total;
        $total -=  $detail->cost;
        $expense->update([
            'total' => $total,
        ]);
        return $detail->delete();
    }

    public function store($data)
    {
        $record = Expense::where('type', $data['type'])->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->first();
        $expense = Expensedetails::create([
            'name' => $data['name'],
            'cost' => $data['cost'],
            'expense_id' => $record->id
        ]);
        $record->update([
            'total' => $record->total + $data['cost']
        ]);
        return $expense;
    }


    // get the details of the total expenses for a specific month
    public function getExpenseDetails($type, $date)
    {
        $date = new \DateTime($date);
        $month = $date->format('m');
        $year = $date->format('Y');
        if ($type == 4) {
            $t = DB::table('total_additionals')->join('employees', 'total_additionals.employee_id', '=', 'employees.id')->whereMonth('total_additionals.created_at', $month)->whereYear('total_additionals.created_at', $year)->select('total_additionals.id', 'total_additionals.total', 'total_additionals.salary',  DB::raw("CONCAT(employees.firstname, ' ', employees.lastname) AS employer_name"))->simplePaginate(10);

            return [
                'data' => $t->items(),
                'meta' => [
                    'per_page' => $t->perPage(),
                    'count' => $t->count(),
                    'current_page' => $t->currentPage(),
                    'path' => $t->path(),
                    'from' => $t->firstItem(),
                    'to' => $t->lastItem(),
                    'prev' => $t->previousPageUrl(),
                    'next' => $t->nextPageUrl(),
                ]
            ];
        } else {
            $expense = Expense::where('type', $type)->whereMonth('created_at', $month)->whereYear('created_at', $year)->first();
            $details = Expensedetails::where('expense_id', $expense->id)->select('name', 'cost')->get();
            return $details;
        }
    }
}
