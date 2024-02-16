<div class="col">
    <div class="card shadow-sm">
{{--        <img class="bd-placeholder-img card-img-top" src="{{ $product->thumbnailUri }}" alt="{{ $product->title }}" />--}}
        <div class="bd-placeholder-img card-img-top product-preview-img" style="background-image: url('{{  $product->thumbnailUri  }}')"></div>
            <div class="card-body">
            <h5 class="cart-title">{{ $product->title }}</h5>
             <p class="text-body-secondary product-preview-price">{{ $product->price }} $</p>
                <div class="d-flex justify-content-between align-items-center">
                 <div class="btn-group product-preview-button-container" >
                     <button type="button" class="btn btn-sm btn-outline-secondary">Show</button>
                    <button type="button" class="btn btn-sm btn-outline-success">Buy</button>
                 </div>
            </div>
        </div>
    </div>
</div>
