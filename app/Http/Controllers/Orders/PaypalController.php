<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    public function __invoke(Order $order)
    {

        $order->loadMissing(['user', 'transaction', 'products']);

        Cart::instance('cart')->destroy();

        return view('payment/paypal-thank-you', compact('order'));
    }
}
