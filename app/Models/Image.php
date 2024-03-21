<?php

namespace App\Models;

use App\Services\Contract\FileStorageServicesContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    public $fillable = ['path', 'imageble_id', 'imageble_type'];

    public function imagebal():MorphTo
    {
        return $this->morphTo();
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: function() {
                $key = "products.images.{$this->attributes['path']}";

                if(!Cache::has($key)) {
                    $link = Storage::temporaryUrl($this->attributes['path'], now()->addMinutes(10));
                    Cache::put($key, $link, 570);
                }

                return Cache::get($key);
            }
        );
    }

    public function setPathAttribute($path)
    {
        $this->attributes['path'] = app(FileStorageServicesContract::class)->upload(
            $path['image'],
            $path['directory'] ?? null
        );
    }
}
