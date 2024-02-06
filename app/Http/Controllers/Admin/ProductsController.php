<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateProductsRequest;
use App\Http\Requests\Products\EditProductsRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contracts\ProductsRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('categories')->sortable()->paginate(10);
        return view('admin/products/index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin/products/create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductsRequest $request, ProductsRepositoryContract $repository)
    {
        return $repository->create($request)
            ? redirect()->route('admin.products.index')
            : redirect()->back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin/products/edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditProductsRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['slug'] = Str::of($data['title'])->slug()->value();

        $product->updateOrFail($data);

        notify()->success("Edit products '$data[title]'");

        return redirect()->route('admin.products.index', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->middleware('permission:' .config('permission.permissions.products.delete'));

        $product->deleteOrFail();

        notify()->warning("Delete category '$product[title]'");

        return redirect()->route('admin.products.index');
    }
}
