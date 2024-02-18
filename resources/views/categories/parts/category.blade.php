
<a href="{{ route('categories.show', $category )}}" class="btn btn-outline-danger custom-preview-button {{(!empty($classes) ? $classes : '')}} mb-2">
    {{ $category->name }}
</a>

