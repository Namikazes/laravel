<?php

namespace App\Http\Controllers\Ajax\PayPal;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrdersRequest;
use App\Services\Contract\PayPalServicesContract;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    public function create(CreateOrdersRequest $request)
    {
        return app(PayPalServicesContract::class)->create($request);
    }

    public function capture(string $vendorOrderId)
    {
        return app(PayPalServicesContract::class)->capture($vendorOrderId);
    }
}
