<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;

class ImageService extends FileBuilder
{
    public function save()
    {
        $this->provider();
        $result = Storage::disk($this->disk)->put($this->getPath(), $this->file, $this->getName());
        return $result ? $result : false;
    }
    public function deleteImage($imagePath)
    {
        if (Storage::disk($this->disk)->exists($imagePath)) {
            Storage::disk($this->disk)->delete($imagePath);
        }
    }
}
