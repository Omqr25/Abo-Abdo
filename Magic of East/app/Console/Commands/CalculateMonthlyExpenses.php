<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\Expense;
use App\Models\Expensedetails;
use App\Models\total_additional;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateMonthlyExpenses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expenses:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and save monthly expenses for the previous month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Expense::create([
            'total' => 0,
            'type' => 1, // Warehouse Expenses
        ]);

        $currentDate = Carbon::now();
        $lastMonthDate = $currentDate->subMonth();
        $lastMonth = $lastMonthDate->format('m');
        $lastYear = $lastMonthDate->format('Y');
        $rentalExpense = Expense::where('type', 2)->whereMonth('created_at', $lastMonth)->whereYear('created_at', $lastYear)->first();
        $rentalExpense_total = 0;
        if ($rentalExpense) {
            $rentalExpense_total = $rentalExpense->total;
            $details = Expensedetails::where('expense_id', $rentalExpense->id)->get();
            foreach ($details as $detail) {
                $data = [];
                $data['expense_id'] = $detail->expense_id;
                $data['name'] = $detail->name;
                $data['cost'] = $detail->cost;
                Expensedetails::create($data);
            }
        }
        Expense::create([
            'total' => $rentalExpense_total,
            'type' => 2, // Warehouse Rent
        ]);
        Expense::create([
            'total' => 0,
            'type' => 3, // Warehouse Taxes
        ]);
        Expense::create([
            'total' => Employee::sum('salary'),
            'type' => 4 // Employers Expenses
        ]);
        $employees = Employee::all();
        foreach ($employees as $employee) {
            total_additional::create([
                'employee_id' => $employee->id,
                'total' => 0,
                'salary' => $employee->salary
            ]);
        }
    }
}
