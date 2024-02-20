@extends('layouts.app')

@section('content')

<div class="mb-2 text-center">
    @foreach($categories as $category)
        <button class="btn btn-outline-danger">{{ $category->name }}</button>
    @endforeach
</div>

@endsection
