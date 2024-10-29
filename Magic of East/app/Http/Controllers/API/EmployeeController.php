<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Interfaces\EmployeeRepositoryInterface;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Trait\ApiResponse;
use Throwable;

class EmployeeController extends Controller
{
    use ApiResponse;
    private $employeeRepository;
    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }
    public function index()
    {
        try {
            $data = $this->employeeRepository->index();
            return $this->SuccessMany($data, EmployeeResource::class, 'Employees indexed successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function store(StoreEmployeeRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $this->employeeRepository->store($validated);
            return $this->SuccessOne($data, EmployeeResource::class, 'Employee created successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->employeeRepository->show($id);
            return $this->SuccessOne($data, EmployeeResource::class, 'Successful');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->employeeRepository->update($id, $validated);
            return $this->SuccessOne($data, EmployeeResource::class, 'Employee updated successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->employeeRepository->destroy($id);
            return $this->SuccessOne(null, null, 'Employee deleted successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage(), 404);
        }
    }
}