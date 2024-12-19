<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\ExpenseRepositoryInterface;
use App\Models\Expense;
use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Http\Requests\Expense\UpdateExpenseRequest;
use App\Http\Resources\ExpenseDetails\ExpenseDetailsResource;
use App\Http\Resources\ExpenseResource;
use App\Trait\ApiResponse;
use Throwable;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ApiResponse;

    private $expenseRepository;

    public function __construct(ExpenseRepositoryInterface $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }
    public function index()
    {
        try {
            $data = $this->expenseRepository->index();
            return $this->SuccessMany($data, ExpenseResource::class, 'Expenses indexed successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function getAll($type)
    {
        try {
            $data = $this->expenseRepository->getAll($type);
            $response = ['message' => "Expense Details indexed successfully", 'status' => 200];
            $response = array_merge(['meta' => $data['meta']], $response);
            $response = array_merge(['data' => $data['data']], $response);
            return response()->json($response, 200);
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $this->expenseRepository->store($validated);
            return $this->SuccessOne($data, ExpenseDetailsResource::class, 'Expense created successfully', 200);
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = $this->expenseRepository->show($id);
            return $this->SuccessOne($data, ExpenseResource::class, 'Expense Fetched successfully', $data['type']);
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->expenseRepository->update($id, $validated);
            return $this->SuccessOne($data, ExpenseResource::class, 'Expense updated successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->expenseRepository->destroy($id);
            return $this->SuccessOne(null, null, 'Expense deleted successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage(), 404);
        }
    }


    public function getExpenseDetails($type, $date)
    {
        try {
            $data = $this->expenseRepository->getExpenseDetails($type, $date);
            $response = ['message' => "Expense Details indexed successfully", 'status' => 200];
            if (isset($data['meta'])) {
                $response = array_merge(['meta' => $data['meta']], $response);
                $response = array_merge(['data' => $data['data']], $response);
            } else $response = array_merge(['data' => $data], $response);
            return response()->json($response, 200);
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage(), 404);
        }
    }
}
