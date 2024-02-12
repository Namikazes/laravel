<?php

namespace App\Observers;

use App\Models\Image;
use App\Services\Contract\FileStorageServicesContract;

class ImageObserver
{
    public function deleted(Image $image): void
    {
        app(FileStorageServicesContract::class)->remove($image->path);
    }
}
