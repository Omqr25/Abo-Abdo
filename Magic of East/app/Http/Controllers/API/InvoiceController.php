<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\InvoiceRepositoryInterface;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class InvoiceController extends Controller
{
    use ApiResponse;

    private $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function index()
    {
        try {
            $data = $this->invoiceRepository->index();
            return $this->SuccessMany($data, InvoiceResource::class, 'Invoices indexed successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function store(StoreInvoiceRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $this->invoiceRepository->store($validated);
            return $this->SuccessOne($data, null, 'Invoice created successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->invoiceRepository->show($id);
            return $this->SuccessOne($data, InvoiceResource::class, 'Successful');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function update(UpdateInvoiceRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->invoiceRepository->update($id, $validated);
            return $this->SuccessOne($data, InvoiceResource::class, 'Invoice updated successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->invoiceRepository->destroy($id);
            return $this->SuccessOne(null, null, 'Invoice deleted successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage(), 404);
        }
    }

    public function showDeleted()
    {
        try {
            $data = $this->invoiceRepository->showDeleted();
            return $this->SuccessMany($data, null, 'Invoices indexed successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function restore(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids != null) {
            try {
                $this->invoiceRepository->restore($ids);
                return $this->SuccessOne(null, null, 'restored successfully');
            } catch (Throwable $th) {
                return $this->Error(null, $th->getMessage());
            }
        }
        return $this->Error(null, 'Invoices must be provided');
    }
}
