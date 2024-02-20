<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::avalible()->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {

        $gallery = $product->images->map(fn($image) => $image->url);

        return view('products.show', compact('product', 'gallery'));
    }
}
