<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::take(12)->get();
        $products = Product::orderByDesc('id')->avalible()->take(12)->get();

        return view('home', compact('products', 'categories'));
    }
}
