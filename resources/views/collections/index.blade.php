@extends('adminlte::page')

@section('title', 'Collections')

@section('content_header')
<div class="row">
    <div class="col-md-6">
        <h1>Collections</h1>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ route('collections.create') }}" class="btn btn-primary">Create Collection</a>
    </div>
</div>

@stop

@section('content')
<table id="collectionTable" class="table table-border table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
@stop

@section('js')
@include('partials.flash')
@include('partials.delete-confirm')
<script>
    $(document).ready(function() {
        $('#collectionTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('collections.index') }}",
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
                    data: 'description',
                    name: 'description'
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