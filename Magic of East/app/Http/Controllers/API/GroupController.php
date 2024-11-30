<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\GroupRepositoryInterface;
use App\Http\Requests\Group\StoreGroupRequest;
use App\Http\Requests\Group\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Classification;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class GroupController extends Controller
{
    use ApiResponse;

    private $groupRepository;

    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function index()
    {
        try {
            $data = $this->groupRepository->index(['media', 'classification']);
            return $this->SuccessMany($data, GroupResource::class, 'Groups indexed successfully');
        } catch (Throwable $th) {
            $code = 200;
            if ($th->getCode() != 0) $code = $th->getCode();
            return $this->Error(null, $th->getMessage(), $code);
        }
    }

    public function store(StoreGroupRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['workshop_id'] = 1;
            if (!(Classification::find($validated['classification_id'])))
                return $this->Error(null, 'Classification not found', 404);
            $data = $this->groupRepository->store($validated);
            return $this->SuccessOne($data, null, 'Group created successfully');
        } catch (Throwable $th) {
            $code = 200;
            if ($th->getCode() != 0) $code = $th->getCode();
            return $this->Error(null, $th->getMessage(), $code);
        }
    }

    public function show($id)
    {
        try {
            $data = $this->groupRepository->show($id, ['media', 'classification']);
            return $this->SuccessOne($data, GroupResource::class, 'Successful');
        } catch (Throwable $th) {
            $code = 200;
            if ($th->getCode() != 0) $code = $th->getCode();
            return $this->Error(null, $th->getMessage(), $code);
        }
    }

    public function update(UpdateGroupRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $validated['workshop_id'] = 1;
            $data = $this->groupRepository->update($id, $validated);
            return $data;
            return $this->SuccessOne($data, GroupResource::class, 'Group updated successfully');
        } catch (Throwable $th) {
            $code = 200;
            if ($th->getCode() != 0) $code = $th->getCode();
            return $this->Error(null, $th->getMessage(), $code);
        }
    }

    public function destroy($id)
    {
        try {
            $this->groupRepository->destroy($id);
            return $this->SuccessOne(null, null, 'Group deleted successfully');
        } catch (Throwable $th) {
            $code = 200;
            if ($th->getCode() != 0) $code = $th->getCode();
            return $this->Error(null, $th->getMessage(), $code);
        }
    }

    public function showDeleted()
    {
        try {
            $data = $this->groupRepository->showDeleted();
            return $this->SuccessMany($data, null, 'Groups indexed successfully');
        } catch (Throwable $th) {
            $code = 200;
            if ($th->getCode() != 0) $code = $th->getCode();
            return $this->Error(null, $th->getMessage(), $code);
        }
    }

    public function restore(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids != null) {
            try {
                $this->groupRepository->restore($ids);
                return $this->SuccessOne(null, null, 'restored successfully');
            } catch (Throwable $th) {
                $code = 200;
                if ($th->getCode() != 0) $code = $th->getCode();
                return $this->Error(null, $th->getMessage(), $code);
            }
        }
        return $this->Error(null, 'Groups must be provided', 422);
    }
}
