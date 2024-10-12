<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\InvoiceItemRepositoryInterface;
use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\UpdateInvoiceItemRequest;
use App\Http\Resources\InvoiceItemResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class InvoiceItemController extends Controller
{
    private $invoiceItemRepository;

    public function __construct(InvoiceItemRepositoryInterface $invoiceItemRepository)
    {
        $this->invoiceItemRepository = $invoiceItemRepository;
    }

    public function index()
    {
        try {
            $data = $this->invoiceItemRepository->index();
            return ApiResponse::SuccessMany($data, null, 'Invoice items indexed successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function store(StoreInvoiceItemRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $this->invoiceItemRepository->store($validated);
            return ApiResponse::SuccessOne($data, InvoiceItemResource::class, 'Invoice item created successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->invoiceItemRepository->show($id);
            return ApiResponse::SuccessOne($data, InvoiceItemResource::class, 'Successful');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function update(UpdateInvoiceItemRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->invoiceItemRepository->update($id, $validated);
            return ApiResponse::SuccessOne($data, InvoiceItemResource::class, 'Invoice item updated successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->invoiceItemRepository->destroy($id);
            return ApiResponse::SuccessOne(null, null, 'Invoice item deleted successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage(), 404);
        }
    }

    public function showDeleted()
    {
        try {
            $data = $this->invoiceItemRepository->showDeleted();
            return ApiResponse::SuccessMany($data, null, 'Records indexed successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function restore(Request $request)
    { 
        $ids = $request->input('ids');
        if ($ids != null) {
            try {
                $this->invoiceItemRepository->restore($ids);
                return ApiResponse::SuccessOne(null, null, 'restored successfully');
            } catch (Throwable $th) {
                return ApiResponse::Error(null, $th->getMessage());
            }
        }
        return ApiResponse::Error(null, 'Invoice items must be provided');
    }
}
