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
        <form method="post" action="{{ $updateUrl }}">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $category->name) }}"
                    class="form-control">

                @error('name')
                <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="color" class="form-control-label">Color</label><br>
                <div class="d-flex">
                    <input
                        type="text"
                        name="color"
                        id="color"
                        class="form-control"
                        value="{{ old('color', $category->color ?? '#ffffff') }}"
                        title="Enter hex color or pick a color">

                    <input
                        type="color"
                        id="color-picker"
                        value="{{ old('color', $category->color ?? '#ffffff') }}"
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
                    {{ old('is_active', $category->is_active ?? 1) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Check if the category is active</label>

                @error('is_active')
                <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <br>
            <a href="{{ route('user.categories.mine') }}" class="btn btn-secondary" style="min-width: 75px;">Go Back</a>
            <button type="submit" class="btn btn-primary" style="min-width: 75px;">Save</button>
        </form>
    </div>
</div>

@stop

@section('js')
@include('partials.flash')
<script>
    $(document).on('input change', '#color-picker', function() {
        let color = $(this).val();

        $('#color').val(color);
    })

    $(document).on('input', '#color', function() {
        let color = $(this).val();

        // Accept only valid hex colors
        if (/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(color)) {
            $('#color-picker').val(color);
        }
    });
</script>
@stop