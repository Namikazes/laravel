<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Facades\Cart;
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
        $rowId = $this->getProductFromCart($product)?->rowId;
        $isInCart = !!$rowId;

        return view('products.show', compact('product', 'gallery', 'isInCart', 'rowId'));
    }

    protected function getProductFromCart(Product $product): CartItem | null
    {
        return Cart::instance('cart')
            ->content()
            ->where('id', '=', $product->id)
            ?->first();
    }
}
