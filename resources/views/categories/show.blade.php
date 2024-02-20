@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <h1>Категорія: {{ $category->name }} </h1>

        @if ($childCategories->isNotEmpty())
            <div class="row mt-4">
                <div class="col-md-6">
                    <h2>Дочірні категорії:</h2>
                    <ul class="list-group">
                        @foreach ($childCategories as $childCategory)
                            <li class="list-group-item">{{ $childCategory->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="alert alert-info mt-4" role="alert">
                Немає дочірніх категорій для відображення.
            </div>
        @endif

        @if ($products->isNotEmpty())
            <div class="row mt-4">
                <div class="col-md-6">
                    <h2>Продукти категорії:</h2>
                    <ul class="list-group">
                        @foreach ($products as $product)
                            <li class="list-group-item">{{ $product->title }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="alert alert-info mt-4" role="alert">
                Немає продуктів для відображення.
            </div>
        @endif
    </div>
@endsection
