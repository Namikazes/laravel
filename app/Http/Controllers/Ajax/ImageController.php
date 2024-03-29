<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ajax\UploadImageRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(UploadImageRequest $request, Product $product)
    {
        try {
            $data = $request->validated();
            $image = $product->images()->create([
                'path' => [
                    'image' => $data['image'],
                    'directory' => $product->slug
                ]
            ]);

            return response()->json(['url' => $image->url, 'id' => $image->id]);
        } catch (\Exception $exception) {
            logs()->error($exception);
            return response(status: 422)
                ->json([
                    'message' => $exception->getMessage()
                ]);
        }
    }
}
