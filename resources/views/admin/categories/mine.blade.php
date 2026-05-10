@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
<div class="row d-flex justify-content-between">
    <div class="col-md-6">
        <h2>Categories</h2>
    </div>
    <div class="">
        <a href="{{ $createUrl }}" class="btn btn-primary">Create Category</a>
    </div>
</div>
@stop

@section('content')
<table id="categoryTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <td scope="col">No</td>
            <td scope="col">Name</td>
            <td scope="col">Color</td>
            <td scope="col">Active</td>
            <td scope="col">Created Time</td>
            <td scope="col">Actions</td>
        </tr>
    </thead>
</table>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#categoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ $ajaxUrl }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'color',
                    name: 'color'
                },
                {
                    data: 'is_active',
                    name: 'is_active'
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