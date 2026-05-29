@extends('adminlte::page')

@section('title', 'Collections')

@section('content_header')
<div class="row">
    <div class="col-6">
        <h1>Collections</h1>
    </div>
    <div class="col-6 text-right">
        <a href="{{ route('collections.create') }}" class="btn btn-primary"><i class="fas fa-plus-square"></i> Collection</a>
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


@section('css')
<style>
    .action-icon {
        font-size: 16px;
        transition: 0.2s;
    }

    .action-icon:hover {
        background-color: #EFF6FF;
        opacity: 0.7;
        color: red;
    }
</style>
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
                    name: 'description',
                    render: function(data) {
                        if (data.length > 100) {
                            return data.substring(0, 100) + '...';
                        }

                        return data;
                    }
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