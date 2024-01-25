@extends('layouts.admin')

@section('content')

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col" style="color: black !important">@sortablelink('id', '#')</th>
            <th scope="col">@sortablelink('name', 'Name')</th>
            <th scope="col">@sortablelink('parent_id', 'Parent')</th>
            <th scope="col">@sortablelink('products_count', 'Products')</th>
            <th scope="col">Created</th>
            <th scope="col">Modified</th>
            <th scope="col">Edit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>
                    @if($category->parent)
                        <a href="{{route('admin.categories.edit', $category->parent)}}">{{$category->parent->name}}</a>
                    @else
                        -
                    @endif
                </td>
                <td>{{$category->products_count}}</td>
                <td>{{$category->created_at}}</td>
                <td>{{$category->updated_at}}</td>
                <td>
                    <form method="POST" action="{{route('admin.categories.destroy', $category)}}">
                        @csrf
                        @method('DELETE')
                    <a class="btn btn-warning" href="{{route('admin.categories.edit', $category)}}"><i class="fa-solid fa-file-pen"></i></a>
                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$categories->links()}}

@endsection
