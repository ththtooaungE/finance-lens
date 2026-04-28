@extends('adminlte::page')

@section('title', 'User Edit')

@section('content_header')
<h3>User Edit</h3>
@endsection

@section('content')

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

            <div class="mb-3 row">
                <label for="is_active" class="col-form-label col-sm-2">Active</label>
                <input
                    type="text"
                    name="is_active"
                    id="is_active"
                    value="{{ $user->is_active ? 1 : 0 }}"
                    class="col-sm-10 form-control">
                @error('name', 'updateUser')
                <span>{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <button type="submit" class="btn btn-primary mr-2">Update</button>
                <button class="btn btn-secondary">Cancel</button>
            </div>

        </form>
    </div>
</div>

@endsection