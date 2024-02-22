@extends('layouts.app')

@section('content')
        <div class="container mt-5">
            <div class="row row-cols-1 row-cols-sm-2 g-2 mb-5">
                <div class="col col-sm-4">
                    <img src="{{ $product->thumbnailUri }}" alt="{{ $product->title }}" class="w-100"/>
                </div>
                <div class="col col-sm-8">
                    <div class="d-flex flex-column align-items-start justify-content-center ms-5">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h4 class="mb-5">{{ $product->title }}</h4>
                            <small class="mb-2">{{ $product->SKU }}</small>
                        </div>
                        <div class="d-flex flex-column justify-content-start align-items-start w-100">
                            <p>Categories: </p>
                            <div>
                                @each('categories.parts.category', $product->categories, 'category')
                            </div>
                        </div>
                        <p class="mb-2">Quantity: {{ $product->quantity }}</p>
                        <div class="price-container d-flex justify-content-end align-items-center w-100">
                            <p class="me-2 mb-0">{{ $product->price }} $</p>
                        @if($isInCart)
                                @include('cart.parts.remove_button', ['product' => $product, 'rowId' => $rowId])
                            @else
                                @include('cart.parts.add_button', ['product' => $product])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <hr class="col-12">
                <div class="col text-center fs-5">
                    <p>{{ $product->description }}</p>
                </div>
                <hr class="col-12">
                <div class="col-sm-4 slider-container">
                    <div id="carouselExampleDark" class="carousel carousel-dark slide">
                        <div class="carousel-indicators">
                            @foreach($gallery as $key => $image)
                                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="{{ $key }}" class="{{ $key === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $key + 1 }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach($gallery as $key => $image)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                    <img src="{{ $image }}" class="d-block w-100" alt="...">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
            </div>
        </div>
@endsection
