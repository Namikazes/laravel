<div class="col">
    <div class="card shadow-sm">
        <img class="bd-placeholder-img card-img-top product-preview-image" style="background-image: url({{ $product->thumbnailUri }})" alt="{{ $product->name }}" />
        <div class="card-body">
            <h5 class="cart-title">{{ $product->title }}</h5>
            @if($product->discountPrice > 0)
                <small class="product-preview-price">Discount: <span class="text-danger">{{ $product->discountPrice }} %</span></small>
            @else
                <small style="color: #ffffff">'</small>
            @endif
            <p class="product-preview-price">{{ $product->calculatePrice }} $</p>
            <div class="d-flex justify-content-between align-items-center">
                @include('products.parts.carts_button', ['product' => $product])
            </div>
        </div>
    </div>
</div>
