<?php

namespace App\Http\Controllers;


use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $content = Cart::instance('cart')->content();
        $subTotal = Cart::instance('cart')->subtotal();
        $tax = Cart::instance('cart')->tax();
        $total = Cart::instance('cart')->total();

        return view('checkout/index', ['user' => auth()->user()], compact('content', 'subTotal', 'tax', 'total'));
    }
}
