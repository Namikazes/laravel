<?php

namespace App\Services\Contract;

use App\Http\Requests\CreateOrdersRequest;

interface PayPalServicesContract
{
    public function create(CreateOrdersRequest $request);

    public function capture(string $vendorOrderId);
}
