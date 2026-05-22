<?php

namespace App\Services;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    protected string $diskName;
    public function __construct()
    {
        $this->diskName = config('filesystems.default', 's3');
    }
    public function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk($this->diskName);

        return $disk->put($folder, $file);
    }
    public function delete(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk($this->diskName);

        if ($disk->exists($path)) {
            return $disk->delete($path);
        }

        return false;
    }
    public function url(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk($this->diskName);
        return $disk->url($path);
    }
}