<?php

namespace App\Services\Contract;

use App\Models\Order;
use LaravelDaily\Invoices\Invoice;

interface InvoiceServicesContract
{
    public function ganerete(Order $order):Invoice;
}
