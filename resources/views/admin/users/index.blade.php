@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
<h1>Users</h1>
@stop

@section('content')

<table id="usersTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-center">ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Verified</th>
            <th>Register Date</th>
            <th>Actions</th>
            
        </tr>
    </thead>
</table>

@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("admin/users") }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'is_active',
                    name: 'is_active'
                },
                {
                    data: 'email_verified_at',
                    name: 'email_verified_at'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@stop