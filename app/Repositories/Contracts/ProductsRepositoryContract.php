<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Products\CreateProductsRequest;
use App\Models\Product;

interface ProductsRepositoryContract
{
    public function create(CreateProductsRequest $request): Product|false;
}
