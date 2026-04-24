@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
<h1>Users</h1>
@stop

@section('content')
<p>User page</p>

@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Active</th>
            <th>Verified</th>
            <th>No of Collections</th>
            <th>Register Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->is_active }}</td>
            <td>{{ !is_null($user->email_verified_at) ? 1 : 0 }}</td>
            <td>{{ 5 }}</td>
            <td>{{ $user->created_at }}</td>
            <td>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <a href="#" class="btn btn-sm btn-danger">Delete</a>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
@stop