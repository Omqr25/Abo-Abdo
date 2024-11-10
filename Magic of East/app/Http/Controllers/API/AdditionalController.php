<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\AdditionalRepositoryInterface;
use App\Http\Requests\Additional\StoreAdditionalRequest;
use App\Http\Resources\AdditionalResource;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class AdditionalController extends Controller
{

    use ApiResponse;
    private $AdditionalRepository;
    public function __construct(AdditionalRepositoryInterface $AdditionalRepository)
    {
        $this->AdditionalRepository = $AdditionalRepository;
    }

    public function store(StoreAdditionalRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $this->AdditionalRepository->store($validated);
            return $this->SuccessOne($data, AdditionalResource::class, 'Additional created successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->AdditionalRepository->destroy($id);
            return $this->SuccessOne(null, null, 'Additional deleted successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage(), 404);
        }
    }
}
