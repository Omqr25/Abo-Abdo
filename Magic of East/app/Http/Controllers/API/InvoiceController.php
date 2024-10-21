<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\InvoiceRepositoryInterface;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class InvoiceController extends Controller
{
    private $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function index()
    {
        try {
            $data = $this->invoiceRepository->index();
            return ApiResponse::SuccessMany($data, null, 'Invoices indexed successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function store(StoreInvoiceRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $this->invoiceRepository->store($validated);
            return ApiResponse::SuccessOne($data, InvoiceResource::class, 'Invoice created successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->invoiceRepository->show($id);
            return ApiResponse::SuccessOne($data, InvoiceResource::class, 'Successful');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function update(UpdateInvoiceRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->invoiceRepository->update($id, $validated);
            return ApiResponse::SuccessOne($data, InvoiceResource::class, 'Invoice updated successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->invoiceRepository->destroy($id);
            return ApiResponse::SuccessOne(null, null, 'Invoice deleted successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage(), 404);
        }
    }

    public function showDeleted()
    {
        try {
            $data = $this->invoiceRepository->showDeleted();
            return ApiResponse::SuccessMany($data, null, 'Invoices indexed successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function restore(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids != null) {
            try {
                $this->invoiceRepository->restore($ids);
                return ApiResponse::SuccessOne(null, null, 'restored successfully');
            } catch (Throwable $th) {
                return ApiResponse::Error(null, $th->getMessage());
            }
        }
        return ApiResponse::Error(null, 'Invoices must be provided');
    }
}