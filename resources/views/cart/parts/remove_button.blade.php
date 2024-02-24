<form action="{{ route('cart.remove', $product) }}" method="post" class="w-25">
    @csrf
    @method('delete')
    <input type="hidden" name="rowId" value="{{ $rowId }}">
    <button class="btn btn-outline-danger ml-4-3 w-100" type="submit">Remove</button>
</form>
