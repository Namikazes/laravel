<div class="col">
    <div class="card shadow-sm">
        <img class="bd-placeholder-img card-img-top product-preview-image" style="background-image: url({{ $product->thumbnailUri }})" alt="{{ $product->name }}" />
        <div class="card-body">
            <h5 class="cart-title">{{ $product->title }}</h5>
            <p class="product-preview-price">{{ $product->price }} $</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group  product-preview-button-container">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-dark">Show</a>
                    <a class="btn btn-sm btn-outline-success">Buy</a>
                </div>
            </div>
        </div>
    </div>
</div>
