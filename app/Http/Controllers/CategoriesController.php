<?php


namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }
    public function show(Category $category)
    {
        $childCategories = $category->child()->get();
        $products = $category->products()->get();

        return view('categories.show', compact('category', 'childCategories', 'products'));
    }
}
