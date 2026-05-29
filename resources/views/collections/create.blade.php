@extends('adminlte::page')

@section('title', 'Create Collection')

@section('content')

<div class="row">
    <div class="col-md-9 mt-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Create A New Collection</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('collections.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">

                        @error('name')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                        @error('description')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category_ids">Categories</label>
                        <select name="category_ids[]" id="category_ids" class="custom-select" size="7" multiple>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" class="p-1 m-1 rounded-lg"
                                @foreach(old('category_ids', []) as $selectedCategoryId)
                                {{ $selectedCategoryId == $category->id ? 'selected' : '' }}
                                @endforeach>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_ids')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <a href="{{ route('collections.index') }}" class="btn btn-outline-secondary" style="min-width: 75px;">Cancel</a>
                    <button type="submit" class="btn btn-outline-primary" style="min-width: 75px;">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop