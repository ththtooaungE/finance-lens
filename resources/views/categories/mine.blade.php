@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
<div class="row d-flex justify-content-between">
    <div>
        <h2>My Categories</h2>
    </div>
    <div>
        <a href="{{ $createUrl }}" class="btn btn-primary"><i class="fas fa-plus-square"></i> Category</a>
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
            <td scope="col">Date Time</td>
            <td scope="col">Actions</td>
        </tr>
    </thead>
</table>
@stop

@section('js')
@include('partials.flash')
@include('partials.delete-confirm')

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
                    data: 'toggle-status',
                    name: 'toggle-status',
                    orderable: false,
                    searchable: false
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

    $(document).on('change', '.toggle-status', function() {

        let id = $(this).data('id');

        let status = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: `/categories/${id}/status-toggle`,
            method: 'PATCH',

            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                is_active: status
            },

            success: function(response) {
                console.log(response);
            },

            error: function(xhr) {
                alert('Something went wrong');
            }
        });

    });
</script>
@stop