<?php

namespace App\Models;

use App\Services\Contract\FileStorageServicesContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
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
                if (Storage::has($this->attributes['path'])) {
                    return Storage::url($this->attributes['path']);
                }

                return $this->attributes['path'];
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
