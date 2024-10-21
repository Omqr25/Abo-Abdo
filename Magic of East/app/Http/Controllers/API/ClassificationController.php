<?php

namespace App\Http\Controllers\API;

use App\Trait\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Interfaces\ClassificationRepositoryInterface;
use App\Http\Requests\Classification\StoreClassificationRequest;
use App\Http\Requests\Classification\UpdateClassificationRequest;
use App\Http\Resources\ClassificationResource;

use Illuminate\Http\Request;
use Throwable;

class ClassificationController extends Controller
{
    use ApiResponse;
    private $classificationRepository;

    public function __construct(ClassificationRepositoryInterface $classificationRepository)
    {
        $this->classificationRepository = $classificationRepository;
    }

    public function index()
    {
        try {
            $data = $this->classificationRepository->index();
            return self::SuccessMany($data, ClassificationResource::class, 'Classifications indexed successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function store(StoreClassificationRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $this->classificationRepository->store($validated);
            return self::SuccessOne($data, ClassificationResource::class, 'Classification created successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->classificationRepository->show($id);
            return self::SuccessOne($data, ClassificationResource::class, 'Successful');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function update(UpdateClassificationRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->classificationRepository->update($id, $validated);
            return self::SuccessOne($data, ClassificationResource::class, 'Classification updated successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->classificationRepository->destroy($id);
            return self::SuccessOne(null, null, 'Classification deleted successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage(), 404);
        }
    }

    public function showDeleted()
    {
        try {
            $data = $this->classificationRepository->showDeleted();
            return self::SuccessMany($data, null, 'Records indexed successfully');
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
                return self::SuccessOne(null, null, 'restored successfully');
            } catch (Throwable $th) {
                return ApiResponse::Error(null, $th->getMessage());
            }
        }
        return ApiResponse::Error(null, 'Classifications must be provided');
    }
}