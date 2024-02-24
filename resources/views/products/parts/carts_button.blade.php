<form action="{{ route('cart.add', $product) }}" method="post" class="w-80 btn-group  product-preview-button-container">
    @csrf
    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-dark">Show</a>
    <button type="submit" class="btn btn-sm btn-outline-success">Buy</button>
</form>
