@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
<h3>Create Category</h3>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">Create Category</div>
    </div>

    <div class="card-body">
        <form method="post" action="{{ $storeUrl }}">
            @csrf
            @method('post')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    id="id"
                    value="{{ old('name') }}"
                    class="form-control">

                @error('name')
                <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="color">Color</label>

                <div class="d-flex align-items-center">
                    <input
                        type="text"
                        name="color"
                        id="color"
                        value="{{ old('color', '#ffffff') }}"
                        class="form-control mr-2"
                        title="Enter hex color or pick a color">

                    <input
                        type="color"
                        id="color-picker"
                        value="{{ old('color', '#ffffff') }}"
                        style="width: 60px; height: 38px; border: none; background: transparent;">

                </div>
                @error('color')
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
                    {{ old('is_active', 1) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Check if the category is active</label>

                @error('is_active')
                <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <br>
            <a href="{{ route('user.categories.index') }}" class="btn btn-secondary" style="min-width: 75px;">Cancel</a>
            <button type="submit" class="btn btn-primary" style="min-width: 75px;">Save</button>
        </form>
    </div>
</div>

@stop

@section('js')
@include('partials.flash')

<script>
    // Color picker -> text input
    $(document).on('input change', '#color-picker', function() {
        let color = $(this).val();

        $('#color').val(color);
    });

    // Text input -> color picker
    $(document).on('input', '#color', function() {
        let color = $(this).val();

        // Accept only valid hex colors
        if (/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(color)) {
            $('#color-picker').val(color);
        }
    });
</script>
@stop