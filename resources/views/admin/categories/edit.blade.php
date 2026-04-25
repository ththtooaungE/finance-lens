@extends('adminlte::page')

@section('title', 'Category Editing')

@section('content_header')
<h3>Editing Category</h3>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">Editing Category</div>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('admin.categories.update', $category->id) }}">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    id="id"
                    value="{{ old('name', $category->name) }}"
                    class="form-control">

                @error('name')
                <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3 form-check form-switch">
                <input type="hidden" name="is_active" value="0">
                <input
                    type="checkbox"
                    name="is_active"
                    id="is_active"
                    value="1"
                    class="form-check-input"
                    {{ old('is_active', $category->is_active ?? 1) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Check if the category is active</label>

                @error('is_active')
                <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

@stop