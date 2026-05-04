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
                    <button type="submit" class="btn btn-primary">Create Collection</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop