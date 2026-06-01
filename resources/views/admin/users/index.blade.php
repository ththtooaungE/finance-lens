@extends('adminlte::page')

@section('title', 'Users')

@section('content')

<table id="usersTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-center">No</th>
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
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'toggle-status',
                    name: 'toggle-status',
                    orderable: false,
                    searchable: false
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

    $(document).on('change', '.toggle-status', function() {
        let id = $(this).data('id');

        let status = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: `/admin/users/${id}/status-toggle`,
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
        })
    });
</script>
@stop