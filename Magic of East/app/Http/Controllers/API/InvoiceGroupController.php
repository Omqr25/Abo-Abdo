<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\InvoiceGroupRepositoryInterface;
use App\Http\Requests\InvoiceGroup\StoreInvoiceGroupRequest;
use App\Http\Requests\InvoiceGroup\UpdateInvoiceGroupRequest;
use App\Http\Resources\InvoiceGroupResource;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class InvoiceGroupController extends Controller
{
    use ApiResponse;

    private $invoiceGroupRepository;

    public function __construct(InvoiceGroupRepositoryInterface $invoiceGroupRepository)
    {
        $this->invoiceGroupRepository = $invoiceGroupRepository;
    }

    public function index()
    {
        try {
            $data = $this->invoiceGroupRepository->index();
            return $this->SuccessMany($data, InvoiceGroupResource::class, 'Invoice groups indexed successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function store(StoreInvoiceGroupRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $this->invoiceGroupRepository->store($validated);
            return $this->SuccessOne($data, InvoiceGroupResource::class, 'Invoice Group created successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->invoiceGroupRepository->show($id);
            return $this->SuccessOne($data, InvoiceGroupResource::class, 'Successful');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function update(UpdateInvoiceGroupRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->invoiceGroupRepository->update($id, $validated);
            return $this->SuccessOne($data, InvoiceGroupResource::class, 'Invoice group updated successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->invoiceGroupRepository->destroy($id);
            return $this->SuccessOne(null, null, 'Invoice group deleted successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage(), 404);
        }
    }

    public function showDeleted()
    {
        try {
            $data = $this->invoiceGroupRepository->showDeleted();
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
                $this->invoiceGroupRepository->restore($ids);
                return $this->SuccessOne(null, null, 'restored successfully');
            } catch (Throwable $th) {
                return $this->Error(null, $th->getMessage());
            }
        }
        return $this->Error(null, 'Invoice groups must be provided');
    }
}