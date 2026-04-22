@extends('adminlte::page')

@section('title', 'Collections')

@section('content_header')
<h1>Collections</h1>
@stop

@section('content')
<table class="table table-border table-striped">

    <head>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>No of Records</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>
    </head>

    <body>
        <tr>
            <td>1</td>
            <td>Collection 1</td>
            <td>Description for Collection 1</td>
            <td>10</td>
            <td>2023-01-01 00:00:00</td>
            <td>2023-01-01 00:00:00</td>
            <td>
                <a href="#" class="btn btn-sm btn-warning">Details</a>
                <a href="#" class="btn btn-sm btn-primary">Edit</a>
                <a href="#" class="btn btn-sm btn-danger">Delete</a>
            </td>
        </tr>
    </body>
</table>
@stop