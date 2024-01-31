@extends('layouts.admin')

@section('content')

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col" style="color: black !important">@sortablelink('id', '#')</th>
            <th scope="col">Image</th>
            <th scope="col">@sortablelink('title', 'Title')</th>
            <th scope="col">Categories</th>
            <th scope="col">@sortablelink('SKU', 'SKU')</th>
            <th scope="col">@sortablelink('price', 'price')</th>
            <th scope="col">@sortablelink('quantity', 'quantity')</th>
            <th scope="col">Created</th>
            <th scope="col">Modified</th>
            <th scope="col">Edit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td><img src="{{$product->thumbnailUri}}" alt="{{$product->title}}" width="100" height="100"></td>
                <td>{{$product->title}}</td>
                <td></td>
                <td>{{$product->SKU}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->created_at}}</td>
                <td>{{$product->updated_at}}</td>
                <td>
                    <form method="POST" action="{{route('admin.products.destroy', $product)}}">
                        @csrf
                        @method('DELETE')
                    <a class="btn btn-warning" href="{{route('admin.products.edit', $product)}}"><i class="fa-solid fa-file-pen"></i></a>
                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$products->links()}}

@endsection
