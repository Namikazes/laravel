
<button href="{{ route('categories.show', $category )}}" class="btn btn-outline-danger {{(!empty($classes) ? $classes : '')}} mb-2">
    {{ $category->name }}
</button>
