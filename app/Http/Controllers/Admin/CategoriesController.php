<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CreateCategoriesRequest;
use App\Http\Requests\Categories\EditCategoriesRequest;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['parent'])->withCount(['products'])->sortable()->paginate(10);

        return view('admin/categories/index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/categories/create', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoriesRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::of($data['name'])->slug()->value();

        Category::create($data);

        notify()->success("Create category '$data[name]'");

        return redirect()->route('admin.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();

        return view('admin/categories/edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCategoriesRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['slug'] = Str::of($data['name'])->slug()->value();

        $category->updateOrFail($data);

        notify()->success("Edit category '$data[name]'");

        return redirect()->route('admin.categories.index', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        $this->middleware('permission:'.config('permission.permissions.categories.delete'));
        if ($category->child()->exists()) {
            $category->child()->update(['parent_id' => null]);
        }

        $category->deleteOrFail();

        notify()->warning("Delete category '$category[name]'");

        return redirect()->route('admin.categories.index');
    }
}
