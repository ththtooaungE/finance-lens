@extends('adminlte::page')

@section('title', 'Editng Collection')

@section('content')
<div class="row">
    <div class="col-md-9 mt-3">
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
                        @error('name')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description', $collection->description) }}</textarea>
                        @error('description')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category_ids">Categories</label>
                        <select name="category_ids[]" id="category_ids" class="custom-select" size="7" multiple>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" class="p-1 m-1 rounded-lg"
                                @foreach($collection->categories as $collectionCategory)
                                {{ $collectionCategory->id == $category->id ? 'selected' : '' }}
                                @endforeach
                                >{{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_ids')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <a href="{{ route('collections.index') }}" class="btn btn-secondary" style="min-width: 75px;">Go Back</a>
                    <button type="submit" class="btn btn-primary" style="min-width: 75px;">Save</button>

                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
@include('partials.flash')
@stop