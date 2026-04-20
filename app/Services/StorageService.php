<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function upload($file, $folder = 'ciiclo')
    {
        $path = Storage::disk('s3')->put($folder, $file);

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('s3');

        return $disk->url($path);
    }
}
