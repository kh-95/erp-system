<?php

namespace App\Foundation\Traits;

use App\Foundation\Classes\Helper;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImageTrait
{
    public function storeImage($image, $location, $type = null): ?string
    {
        $path = $type == 'image' ? Helper::BASE_PATH : Helper::BASE_FILE;
        if (!$image) {
            return null;
        }
        if ($type == 'image') {
            Image::make($image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
        }
        $image->store($path . '/' . $location, Helper::STORAGE_TYPE);
        return $image->hashName();
    }

    public function updateImage($newImage, $oldImage, $location): ?string
    {
        $this->deleteImage($oldImage, $location);
        return $this->storeImage($newImage, $location);
    }

    public function deleteImage($imageName, $location, $type = null): bool
    {
        $path = $type && $type == 'image' ? Helper::BASE_PATH : Helper::BASE_FILE;
        return Storage::disk(Helper::STORAGE_TYPE)->delete($path . '/' . $location . '/' . $imageName);
    }

}
