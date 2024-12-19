<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AdditionalRepositoryInterface;
use App\Models\Additional;
use App\Models\Expense;
use App\Models\total_additional;

class AdditionalRepository extends BaseRepository implements AdditionalRepositoryInterface
{
    public function __construct(Additional $model)
    {
        parent::__construct($model);
    }

    public function store($data)
    {
        $t = total_additional::where('employee_id', $data['employee_id'])->orderBy('created_at', 'desc') // or use the specific timestamp column you are using  
            ->first();
        $old_total = $t->total;
        $t->update([
            'total' => $old_total + $data['amount']
        ]);
        $expense = Expense::where('type', 4)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->first();
        $expense->update([
            'total' => $expense->total + $data['amount']
        ]);
        return Additional::create([
            'amount' => abs($data['amount']),
            'total_additional_id' => $t->id,
            'type' => $data['type']
        ]);
    }

    public function destroy($id)
    {
        $additional = Additional::find($id);
        $t = total_additional::find($additional->total_additional_id);
        $expense = Expense::where('type', 4)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->first();
        $expense->update([
            'total' => $expense->total - ($additional->type == 1 ? $additional->amount : -$additional->amount)
        ]);
        $old_total = $t->total;
        $t->update([
            'total' => $old_total - ($additional->type == 1 ? $additional->amount : -$additional->amount)
        ]);
        $additional->delete();
    }
}
