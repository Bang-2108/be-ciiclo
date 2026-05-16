<?php
namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
class StorageService
{
    protected string $diskName;
    public function __construct()
    {
        $this->diskName = config('filesystems.default', 'public');
    }
    public function upload($file, ?string $folder = 'uploads'): string
    {
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk($this->diskName);
        return $disk->put($folder, $file);
    }
    public function delete(?string $path): bool
    {
        if (!$path) return false;
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk($this->diskName);
        if ($disk->exists($path)) {
            return $disk->delete($path);
        }
        return false;
    }
}