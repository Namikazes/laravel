<?php

namespace App\Models;

use App\Services\Contract\FileStorageServicesContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use HasFactory, Sortable;

    protected $fillable = ['slug', 'title', 'description', 'SKU', 'price', 'new_price', 'quantity', 'thumbnail'];

    public $sortable = ['id', 'title', 'SKU', 'price', 'quantity'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageble');
    }

    public function thumbnailUri(): Attribute
    {
        return Attribute::make(
            get: function () {
                if(Storage::has($this->attributes['thumbnail'])){
                    Storage::url($this->attributes['thumbnail']);
                }

                return $this->attributes['thumbnail'];
});
    }

    public function setThumbnailAttribute($image)
    {
        $fileStorage = app(FileStorageServicesContract::class);

        if (!empty($this->attributes['thumbnail'])) {
            $fileStorage->remove($this->attributes['thumbnail']);
        }

        $this->attributes['thumbnail'] = $fileStorage->upload(
            $image,
            $this->attributes['slug']
        );
    }
}
