<?php

namespace App\Http\Requests\Products;
use App\Models\Product;
use App\Models\Category; // Добавьте это
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can(config('permission.permissions.products.edit'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'title' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('categories', 'name')->ignore($productId),
            ],
            'description' => ['nullable', 'string'],
            'SKU' => ['required', 'string', 'min:1', 'max:35', Rule::unique('products', 'SKU')->ignore($productId)],
            'price' => ['required', 'numeric', 'min:1'],
            'new_price' => ['nullable', 'numeric', 'min:1'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'thumbnail' => ['sometimes', 'image:jpeg,png'],
            'categories.*' => ['required', 'numeric', Rule::exists('categories', 'id')],
            'images.*' => ['sometimes', 'image:jpeg,png'],
        ];
    }
}

