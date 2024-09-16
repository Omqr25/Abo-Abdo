<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\ClassificationRepositoryInterface;
use App\Http\Requests\StoreClassificationRequest;
use App\Http\Requests\UpdateClassificationRequest;
use App\Http\Resources\ClassificationResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class ClassificationController extends Controller
{
    private $classificationRepository;

    public function __construct(ClassificationRepositoryInterface $classificationRepository)
    {
        $this->classificationRepository = $classificationRepository;
    }

    public function index()
    {
        try {
            $data = $this->classificationRepository->index();
            return ApiResponse::SuccessMany($data, null, 'Records indexed successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function store(StoreClassificationRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $this->classificationRepository->store($validated);
            return ApiResponse::SuccessOne($data, ClassificationResource::class, 'Record created successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->classificationRepository->show($id);
            return ApiResponse::SuccessOne($data, ClassificationResource::class, 'Successful');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function update(UpdateClassificationRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->classificationRepository->update($id, $validated);
            return ApiResponse::SuccessOne($data, ClassificationResource::class, 'Record updated successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->classificationRepository->destroy($id);
            return ApiResponse::SuccessOne(null, null, 'Record deleted successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage(), 404);
        }
    }

    public function showDeleted()
    {
        try {
            $data = $this->classificationRepository->showDeleted();
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
                $this->classificationRepository->restore($ids);
                return ApiResponse::SuccessOne(null, null, 'restored successfully');
            } catch (Throwable $th) {
                return ApiResponse::Error(null, $th->getMessage());
            }
        }
        return ApiResponse::Error(null, 'objects must be sended');
    }
}
