<?php

namespace App\Foundation\Traits;

use App\Foundation\Classes\Helper;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait FileTrait
{

    protected function baseByType($type)
    {
        if ($type == 'image') {
            $base = Helper::BASE_PATH;
        } elseif ($type == 'video') {
            $base = Helper::BASE_VIDEO;
        } elseif ($type == 'audio') {
            $base = Helper::BASE_AUDIO;
        } else {
            $base = Helper::BASE_FILE;
        }
        return $base;
    }

    public function storeFile($file, $type, $location): ?string
    {
        if (!$file) {
            return null;
        }

        if ($type == 'image') {
            Image::make($file)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
        }

        $file->store($this->baseByType($type) . '/' . $location, Helper::STORAGE_TYPE);
        return $file->hashName();
    }

    public function updateFile($newFile, $oldFile, $type, $location): ?string
    {
        $this->deleteFile($oldFile, $type, $location);
        return $this->storeFile($newFile, $type, $location);
    }

    public function deleteFile($fileName, $type, $location): bool
    {
        return Storage::disk(Helper::STORAGE_TYPE)->delete($this->baseByType($type) . '/' . $location . '/' . $fileName);
    }

}
