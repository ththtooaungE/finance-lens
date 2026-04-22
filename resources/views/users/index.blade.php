@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
<h1>Users</h1>
@stop

@section('content')
<p>User page</p>

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
        <td>1</td>
        <td>Leo</td>
        <td>leo@example.com</td>
        <td>Yes</td>
        <td>Yes</td>
        <td>5</td>
        <td>2023-01-01</td>
        <td>
            <a href="#" class="btn btn-sm btn-primary">Edit</a>
            <a href="#" class="btn btn-sm btn-danger">Delete</a>
        </td>
    </tbody>
</table>
@stop
