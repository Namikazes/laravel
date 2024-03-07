@extends('layouts.app')

@section('content')
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white text-center">
                            <h3>Thank you for shopping!</h3>
                        </div>
                        <div class="card-body">
                            <h4>Order Details:</h4>
                            <div class="table-responsive-md" style="min-height: 300px; overflow-y: auto;">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $order->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Surname</th>
                                        <td>{{ $order->surname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $order->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <td>{{ $order->city }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $order->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Price</th>
                                        <td>${{ $order->total }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $order->status->name }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white text-center">
                            <h3>Ordered Products:</h3>
                        </div>
                        <div class="card-body">
                            <h4>Product Info:</h4>
                            <div class="table-responsive-md" style="min-height: 300px; overflow-y: auto;">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Image</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->products as $product)
                                        <tr>
                                            <td><a href="{{ route('products.show', $product) }}">{{ $product->title }}</a></td>
                                            <td>{{ $product->pivot->single_price }} $</td>
                                            <td>{{ $product->pivot->quantity }}</td>
                                            <td class="text-center"><img src="{{ $product->thumbnailUri }}" style="max-width: 50px; max-height: 50px;" alt="{{ $product->title }}"></td>
                                            <td>{{ $product->pivot->quantity *  $product->pivot->single_price }} $</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-block" style="margin-right: 5px">Back to Home</a>
                    <a href="{{ route('invoice', $order) }}" class="btn btn-success btn-block">Invoice PDF</a>
                </div>

            </div>
        </div>
    </div>
@endsection




