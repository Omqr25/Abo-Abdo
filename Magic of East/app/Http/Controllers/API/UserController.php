<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserRepositoryInterface;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        try {
            $data = $this->userRepository->index();
            return ApiResponse::SuccessMany($data, null, 'Users indexed successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $this->userRepository->store($validated);
            return ApiResponse::SuccessOne($data, UserResource::class, 'User created successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = $this->userRepository->show($id);
            return ApiResponse::SuccessOne($data, UserResource::class, 'Successful');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->userRepository->update($id, $validated);
            return ApiResponse::SuccessOne($data, UserResource::class, 'User updated successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->userRepository->destroy($id);
            return ApiResponse::SuccessOne(null, null, 'User deleted successfully');
        } catch (Throwable $th) {
            return ApiResponse::Error(null, $th->getMessage(), 404);
        }
    }

    public function showDeleted()
    {
        try {
            $data = $this->userRepository->showDeleted();
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
                $this->userRepository->restore($ids);
                return ApiResponse::SuccessOne(null, null, 'restored successfully');
            } catch (Throwable $th) {
                return ApiResponse::Error(null, $th->getMessage());
            }
        }
        return ApiResponse::Error(null, 'Users must be provided');
    }
}
