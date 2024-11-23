<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Http\Requests\Media\StoreMediaRequest;
use App\Trait\ApiResponse;
use App\Trait\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\AutoEncoder;
use Throwable;
use Intervention\Image\Laravel\Facades\Image;

class MediaController extends Controller
{
    use ApiResponse;
    use UploadImage;

    public function index($group){
        try{
            $data = Media::where('group_id', $group)->get()->makeHidden(['created_at', 'updated_at']);
            if(sizeof($data) > 0)
                return response()->json([
                    'data' => $data,
                    'message' => 'Images indexed successfully',
                    'status' => 200
                ]);
            return $this->Error(null, 'There is no images for the specified group');
        }
        catch(Throwable $th){
            return $this->Error(null, $th->getMessage());
        }
    }

    public function upload(StoreMediaRequest $request)
    {
        try{
            $validated = $request->validated();
            $path = UploadImage::upload($validated['image']);
            Media::create([ 'group_id' => $validated['group_id'], 'path' => $path]);
            return $this->SuccessOne($path,null,"Image uploaded successfully");
        }
        catch(Throwable $th){
            return $this->Error(null, $th->getMessage());
        }
    }

    public function show($name){
        try{
            $name = 'images/' . $name;
            return Storage::disk('public')->get($name);
        }
        catch(Throwable $th){
            return $this->Error(null, $th->getMessage());
        }
    }

    public function delete(Request $request){
        try{
            Media::where('path', $request->path)->delete();
            Storage::disk('public')->delete($request->path);
            return $this->SuccessOne(null,null,"Image deleted successfully");
        }
        catch(Throwable $th){
            return $this->Error(null, $th->getMessage());
        } 
    }
}