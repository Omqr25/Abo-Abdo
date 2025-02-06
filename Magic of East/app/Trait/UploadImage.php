<?php

namespace App\Trait;

use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Encoders\AutoEncoder;
use Throwable;

trait UploadImage
{
    public static function upload($image)
    {
        try {
            if ($image instanceof \Illuminate\Http\UploadedFile) {
                $image_name = $image->hashName();
                if ($image->getSize() > 2100000) { // 2MB in bytes
                    $image = Image::read($image)->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode(new AutoEncoder(quality: (int)((100 * 2100000) / $image->getSize())))
                        ->save(public_path('storage/images/' . $image_name));
                } else {
                    $image->storeAs('images', $image_name, 'public');
                }
                $path = 'storage/images/' . $image_name;
                return $path;
            } else {
                throw new \Exception("Uploaded file is not a valid instance.");
            }
        } catch (Throwable $th) {
            return response()->json("an error occured in UploadImage trait :" . $th->getMessage(), 500);
        }
    }
}
