@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
<h3>Categories</h3>
@stop

@section('content')
<table id="categoryTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <td scope="col">No</td>
            <td scope="col">Name</td>
            <td scope="col">Owner</td>
            <td scope="col">Created Time</td>            
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
                data: 'user.name',
                name: 'user.name'
            },
            {
                data: 'created_at',
                name: 'created_at'
            }]
        });
    });
</script>
@stop