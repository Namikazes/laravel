<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class RemoveImageController extends Controller
{
    public function __invoke(Image $image): \Illuminate\Http\JsonResponse {
     try {
         $image->delete();
         return response()->json(['message' => 'Image was removed']);
     }catch(\Exception $exception) {
        logs()->error($exception);
        return response(status: 422)->json(['message' => $exception->getMessage()]);
        }
    }
}
