@extends('adminlte::page')

@section('title', 'Create Collection')

@section('content_header')
<h1>Create Collection</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Create New Collection</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('collections.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="category_ids">Categories</label>
                        <select name="category_ids[]" id="category_ids" class="custom-select" multiple>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" class="p-1 m-1 rounded-lg">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Collection</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop