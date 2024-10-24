<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\ItemRepositoryInterface;
use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Group;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class ItemController extends Controller
{
    use ApiResponse;

    private $itemRepository;

    public function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function index()
    {
        try {
            $data = $this->itemRepository->index();
            return $this->SuccessMany($data, ItemResource::class, 'Items indexed successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function store(StoreItemRequest $request)
    {
        try {
            $validated = $request->validated();
            if (!(Group::find($validated['group_id'])))
                return $this->Error(null, 'Group not found', 404);
            $data = $this->itemRepository->store($validated);
            return $this->SuccessOne($data, ItemResource::class, 'Item created successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->itemRepository->show($id);
            return $this->SuccessOne($data, ItemResource::class, 'Successful');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function update(UpdateItemRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->itemRepository->update($id, $validated);
            return $this->SuccessOne($data, ItemResource::class, 'Item updated successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->itemRepository->destroy($id);
            return $this->SuccessOne(null, null, 'Item deleted successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage(), 404);
        }
    }

    public function showDeleted()
    {
        try {
            $data = $this->itemRepository->showDeleted();
            return $this->SuccessMany($data, null, 'Items indexed successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    public function restore(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids != null) {
            try {
                $this->itemRepository->restore($ids);
                return $this->SuccessOne(null, null, 'restored successfully');
            } catch (Throwable $th) {
                return $this->Error(null, $th->getMessage());
            }
        }
        return $this->Error(null, 'Items must be provided');
    }
}