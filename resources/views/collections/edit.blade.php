@extends('adminlte::page')

@section('title', 'Editng Collection')

@section('content_header')
<h1>Editing Collection</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Collection</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('collections.update', $collection->id) }}" method="post">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name', $collection->name) }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $collection->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@stop