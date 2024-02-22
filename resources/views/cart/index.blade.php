@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row g-2 mb-5 text-center">
            <h3>Cart</h3>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 g-2 mb-5">
            <div class="col-12 col-sm-8 col-md-9">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($content as $row)
                    <tr>
                        <td>
                            <img src="{{ $row->model->thumbnailUri }}" style="height: 75px; width: 75px; margin-right: 5px">
                        </td>
                        <td>
                            <a href="{{route('products.show', $row->id) }}">{{ $row->name }} </a>
                        </td>
                        <td>
                            <form action="{{ route('cart.count.update', $row->model) }}" style="width:170px" method="POST">
                                @csrf
                                <input type="hidden" name="rowId" value="{{ $row->rowId }}"/>
                                <div class="input-group mb-3">
{{--                                    <button class="btn btn-outline-secondary" type="button" id="button-addon1">Add</button>--}}
                                    <input type="number" name="count" class="form-control counter" value="{{ $row->qty }}" max="{{ $row->model->quantity }}" min="1" >
{{--                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Del</button>--}}
                                </div>
                            </form>
                        </td>
                        <td>$ @if($row->model->new_price > 0)
                                {{ $row->model->new_price }}
                            @else
                                {{ $row->price }}
                            @endif</td>
                        <td>${{ $row->subtotal }}</td>
                        <td>
                            <form action="{{ route('cart.remove')}}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="rowId" value="{{$row->rowId}}" />
                                <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-folder-minus"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col-12 col-sm-4 col-md-3">
                <table class="table table-striped-columns">
                    <tbody>
                    <tr>
                        <td>Subtotal</td>
                        <td>$ {{ $subTotal }}</td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td>$ {{ $tax }}</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>${{ $total }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('footer-js')
    @vite(['resources/js/cart.js'])
@endpush
