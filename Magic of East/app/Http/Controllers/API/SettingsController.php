<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\SettingsRepositoryInterface;
use App\Http\Requests\Settings\UpdateSettingsRequest;
use App\Http\Resources\SettingsResource;
use App\Models\Settings;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Throwable;

class SettingsController extends Controller
{
    
    use ApiResponse;

    private $settingRepository;

    public function __construct(SettingsRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }
    
    public function index()
    {
        try {
            $data = $this->settingRepository->index();
            return $this->SuccessMany($data, SettingsResource::class, 'settings indexed successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingsRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $data = $this->settingRepository->update($id, $validated);
            return $this->SuccessOne($data, SettingsResource::class, 'settings updated successfully');
        } catch (Throwable $th) {
            return $this->Error(null, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
