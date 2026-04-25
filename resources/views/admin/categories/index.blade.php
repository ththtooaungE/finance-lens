@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
<h3>Categories</h3>
@stop

@section('content')
<table class="table">

    <thead>
        <tr>
            <td scope="col">Name</td>
            <td scope="col">Active</td>
            <td scope="col">Owner</td>
            <td scope="col">Created Time</td>
            <td scope="col">Actions</td>
        </tr>
    </thead>

    <tbody>
        @foreach($categories as $category)
        <tr>
            <td scope="row">{{ $category->name }}</td>
            <td>{{ $category->is_active ? 'true' : 'false' }}</td>
            <td>{{ $category->user_id }}</td>
            <td>{{ $category->created_at }}</td>
            <td>
                <a
                    href="{{ route('admin.categories.edit', $category->id) }}"
                    class="btn btn-sm btn-primary">Edit</a>
                <a href="#" class="btn btn-sm btn-danger">Delete</a>

            </td>
        </tr>
        @endforeach

    </tbody>
</table>
@stop