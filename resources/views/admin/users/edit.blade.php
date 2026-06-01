@extends('adminlte::page')

@section('title', 'User Edit')

@section('content')

<div class="row">
    <div class="col-md-9 mt-3">

        <div class="card">
            <div class="card-header">
                <div class="card-title">User Editing</div>
            </div>

            <div class="card-body">
                <form method="post" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('put')

                    <div class="mb-3 row">
                        <label for="name" class="col-form-label col-sm-2">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ $user->name }}"
                            class="col-sm-10 form-control">
                        @error('name', 'updateUser')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input
                            type="radio"
                            name="is_active"
                            id="is_active"
                            value="1"
                            {{ old('is_active', $user->is_active ?? 1) ? 'checked' : '' }}>
                        <label for="is_inactive" class="form-check-label mr-3">Active</label>


                        <input
                            type="radio"
                            name="is_active"
                            id="is_inactive"
                            value="0"
                            {{ old('is_active', $user->is_active ?? 1) ? '' : 'checked' }}>
                        <label for="is_inactive" class="form-check-label">Inactive</label>
                        @error('is_active', 'updateUser')
                        <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary" style="min-width: 75px;">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection