<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\CustomerRepositoryInterface;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class CustomerController extends Controller
{
    use ApiResponse;

    private $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        try {
            $data = $this->customerRepository->index();
            return $this->SuccessMany($data, CustomerResource::class, 'Customers indexed successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function store(StoreCustomerRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $this->customerRepository->store($validated);
            return $this->SuccessOne($data, CustomerResource::class, 'Customer created successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->customerRepository->show($id);
            return $this->SuccessOne($data, CustomerResource::class, 'Successful');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->customerRepository->update($id, $validated);
            return $this->SuccessOne($data, CustomerResource::class, 'Customer updated successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->customerRepository->destroy($id);
            return $this->SuccessOne(null, null, 'Customer deleted successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage(), 404);
        }
    }

    public function showDeleted()
    {
        try {
            $data = $this->customerRepository->showDeleted();
            return $this->SuccessMany($data, null, 'Records indexed successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function restore(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids != null) {
            try {
                $this->customerRepository->restore($ids);
                return $this->SuccessOne(null, null, 'restored successfully');
            } catch (Throwable $th) {
                return $this->Error(null, $th->getMessage());
            }
        }
        return $this->Error(null, 'Customers must be provided');
    }
}