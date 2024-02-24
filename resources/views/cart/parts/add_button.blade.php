<form action="{{ route('cart.add', $product) }}" method="post" class="w-25">
    @csrf
    <button class="btn btn-outline-success w-100" type="submit">Buy</button>
</form>
