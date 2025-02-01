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
            return $this->SuccessMany($data, ClassificationResource::class, 'Classifications indexed successfully');
        } catch (Throwable $th) {
            $code = 500;
            if ($th->getCode() != 0) $code = $th->getCode();
            return $this->Error(null, $th->getMessage(), $code);
        }
    }

    public function store(StoreClassificationRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $this->classificationRepository->store($validated);
            return $this->SuccessOne($data, ClassificationResource::class, 'Classification created successfully');
        } catch (Throwable $th) {
            $code = 500;
            if ($th->getCode() != 0) $code = $th->getCode();
            return $this->Error(null, $th->getMessage(), $code);
        }
    }

    public function show($id)
    {
        try {
            $data = $this->classificationRepository->show($id);
            return $this->SuccessOne($data, ClassificationResource::class, 'Successful');
        } catch (Throwable $th) {
            $code = 500;
            if ($th->getCode() != 0) $code = $th->getCode();
            return $this->Error(null, $th->getMessage(), $code);
        }
    }

    public function update(UpdateClassificationRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->classificationRepository->update($id, $validated);
            return $this->SuccessOne($data, ClassificationResource::class, 'Classification updated successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->classificationRepository->destroy($id);
            return $this->SuccessOne(null, null, 'Classification deleted successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage(), 404);
        }
    }

    public function showDeleted()
    {
        try {
            $data = $this->classificationRepository->showDeleted();
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
                $this->classificationRepository->restore($ids);
                return $this->SuccessOne(null, null, 'restored successfully');
            } catch (Throwable $th) {
                return $this->Error(null, $th->getMessage());
            }
        }
        return $this->Error(null, 'Classifications must be provided');
    }

    public function getGroups()
    {
        try {
            $data = $this->classificationRepository->getGroups();
            return $this->SuccessOne($data, null, "Get Groups For Classifications done Successfully", 200);
        } catch (Throwable $th) {
            $code = 500;
            if ($th->getCode() != 0) $code = $th->getCode();
            return $this->Error(null, $th->getMessage(), $code);
        }
    }
}
