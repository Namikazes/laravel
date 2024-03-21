<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileStorageServices implements Contract\FileStorageServicesContract
{

    /**
     * @throws FileNotFoundException
     */

    public function upload(string|UploadedFile $file, string $additionalPath = ''): string
    {
        if (is_string($file)) {
            return str_replace('public/storage', '', $file);
        }

        $additionalPath = !empty($additionalPath) ? $additionalPath . '/' : '';

        $filePath = "public/$additionalPath" . Str::random() . '_' . time() . '.' . $file->getClientOriginalExtension();
        Storage::disk('s3')->put($filePath, File::get($file));
        Storage::setVisibility($filePath, 'public');

        return $filePath;
    }

    public function remove(string $filePath): void
    {
        Storage::delete($filePath);
    }
}
