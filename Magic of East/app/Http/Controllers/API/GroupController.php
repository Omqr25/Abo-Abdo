<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\GroupRepositoryInterface;
use App\Http\Requests\Group\StoreGroupRequest;
use App\Http\Requests\Group\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Responses\ApiResponse;
use App\Models\Classification;
use Illuminate\Http\Request;
use Throwable;

class GroupController extends Controller
{
    private $groupRepository;

    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function index()
    {
        try {
            $data = $this->groupRepository->index();
            return ApiResponse::SuccessMany($data, null, 'Groups indexed successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function store(StoreGroupRequest $request)
    {
        try {
            $validated = $request->validated();
            if (!(Classification::find($validated['classification_id'])))
                return ApiResponse::Error(null, 'Classification not found', 404);
            $data = $this->groupRepository->store($validated);
            return ApiResponse::SuccessOne($data, GroupResource::class, 'Group created successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->groupRepository->show($id);
            return ApiResponse::SuccessOne($data, GroupResource::class, 'Successful');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function update(UpdateGroupRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->groupRepository->update($id, $validated);
            return ApiResponse::SuccessOne($data, GroupResource::class, 'Group updated successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->groupRepository->destroy($id);
            return ApiResponse::SuccessOne(null, null, 'Group deleted successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage(), 404);
        }
    }

    public function showDeleted()
    {
        try {
            $data = $this->groupRepository->showDeleted();
            return ApiResponse::SuccessMany($data, null, 'Groups indexed successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function restore(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids != null) {
            try {
                $this->groupRepository->restore($ids);
                return ApiResponse::SuccessOne(null, null, 'restored successfully');
            } catch (Throwable $th) {
                return ApiResponse::Error(null, $th->getMessage());
            }
        }
        return ApiResponse::Error(null, 'Groups must be provided');
    }
}
