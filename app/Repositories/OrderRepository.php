<?php

namespace App\Repositories;

use App\Enums\PaymentSystem;
use App\Enums\TransactionStatus;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Repositories\Contracts\OrderRepositoryContract;
use Gloudemans\Shoppingcart\Facades\Cart;

class OrderRepository implements Contracts\OrderRepositoryContract
{

    public function create(array $data): Order|bool
    {
        $status = OrderStatus::default()->first();
        $data = array_merge($data, ['status_id' => $status->id]);
        $order = auth()->user()->orders()->create($data);
        $this->addOrderToProducts($order);

        return $order;
    }

    public function setTransaction(string $vendorOrderId, PaymentSystem $system, TransactionStatus $status): Order
    {
        $order = Order::where('vendor_order_id', $vendorOrderId)->firstOrFail();
        $order->transaction()->create([
            'payment_system' =>$system->value,
            'status' => $status->value
        ]);

        $status = match ($status->value) {
            TransactionStatus::Success->value => OrderStatus::paid()->first(),
            TransactionStatus::Canceled->value => OrderStatus::canceled()->first(),
            default => OrderStatus::default()->first()
        };

         $order->update([
             'status_id' => $status->id
         ]);

        return $order;
    }

    protected function addOrderToProducts(Order $order)
    {
        Cart::instance('cart')->content()->each(function ($item) use ($order) {
            $product = $item->model;

            $order->products()->attach($product, [
                'quantity' => $item->qty,
                'single_price' => $item->price,
                'name' => $product->title
            ]);

            $quantity = $product->quantity - $item->qty;

            if (!$product->update(compact('quantity'))) {
                throw new \Exception("Smth went wrong with quantity update on product [id: {$item->id}]");
            }
        });
    }
}
