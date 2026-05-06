@extends('adminlte::page')

@section('title', 'Collection Details')

@section('content_header')
<h3>{{ $collection->name }}</h3>
@stop

@section('content')
<p>{{ $collection->description }}</p>

<!-- Hidden table (DataTables needs this) -->
<table id="cost-table" class="d-none">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>

<!-- Cost Cards Container -->
<div id="cost-card-container" class="row" style="padding-bottom: 100px;"></div>

<!-- Cost form (for create & edit) -->
<div class="fixed-bottom mb-3">
    <div class="d-flex justify-content-center">
        <div id="costCreate" style="max-width: 500px;" class="bg-white p-3 shadow rounded">
            <form action="{{ route('costs.store') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="collection_id" value="{{ $collection->id }}">

                <!-- hidden input to store cost id when editing -->
                <input type="hidden" name="id" id="cost_id">

                <div class="d-flex flex-row gap-2">
                    <div class="flex-fill mr-2">
                        <input type="text" class="form-control" name="name" placeholder="Cost Name" value="">
                    </div>
                    <div class="flex-fill mr-2">
                        <input type="number" class="form-control" name="price" placeholder="Cost Price" value="">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('js')
<script>
    let isEdit = false;
    let currentId = null;

    function renderCards(data) {
        let container = $('#cost-card-container');
        container.empty();

        data.forEach(cost => {
            let card = `
                <div class="col-md-3 mb-1">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p>${cost.name}</p>
                                <p>$${cost.price}</p>
                            </div>

                            <div class="mt-2">
                                <button class="btn btn-sm btn-info">${cost.category ?? 'No Category'}</button>
                                <button class="edit-btn btn btn-sm btn-warning" 
                                    data-id="${cost.id}" 
                                    data-name="${cost.name}" 
                                    data-price="${cost.price}">
                                    <i class="fas fa-fw fa-pencil-alt"></i>
                                </button>                                
                                <button class="delete-btn btn btn-sm btn-danger" 
                                    data-id="${cost.id}">
                                    <i class="fas fa-fw fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            container.append(card);
        });
    }

    function handleSuccess(response, form) {
        alert(response.message); // simple for now

        form.trigger('reset'); // clear inputs

        // 🔄 refresh DataTable (this updates cards too)
        $('#cost-table').DataTable().ajax.reload(null, false);
    }

    function handleError(xhr) {
        if (xhr.status === 422) {
            let errors = xhr.responseJSON.errors;

            let messages = [];

            for (let field in errors) {
                messages.push(errors[field][0]);
            }

            alert(messages.join('\n'));
        } else {
            alert('Something went wrong!');
        }
    }

    function resetForm() {
        $('#cost_id').val('');
        $('input[name="name"]').val('');
        $('input[name="price"]').val('');

        isEdit = false;
        currentId = null;

        $('#costCreate button[type="submit"]').text('Add');
    }


    let table = $('#cost-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/user/collections/{{ $collection->id }}/costs',

        columns: [{
                data: 'name'
            },
            {
                data: 'price'
            },
            {
                data: 'category'
            },
            {
                data: 'actions',
                orderable: false,
                searchable: false
            }
        ],

        drawCallback: function(settings) {
            let data = settings.json.data;
            renderCards(data);
        }
    });

    // form submit
    $('#costCreate form').on('submit', function(e) {
        e.preventDefault(); // ❗ stop normal form submit

        let form = $(this);
        let formData = form.serialize();

        let url = form.attr('action');
        let method = 'POST';

        if (isEdit) {
            url = `/user/costs/${currentId}`;
            method = 'POST'; // Laravel needs POST + _method=PUT
            formData += '&_method=PUT';
        }

        $.ajax({
            url: url,
            method: method,
            data: formData,

            success: function(response) {
                handleSuccess(response, form);
                resetForm();
            },

            error: function(xhr) {
                handleError(xhr);
            }
        });

    });

    // edit button click
    $(document).on('click', '.edit-btn', function() {
        let btn = $(this);

        let id = btn.data('id');
        let name = btn.data('name');
        let price = btn.data('price');

        // fill form
        $('#cost_id').val(id);
        $('input[name="name"]').val(name);
        $('input[name="price"]').val(price);

        // switch mode
        isEdit = true;
        currentId = id;

        // change button text
        $('#costCreate button[type="submit"]').text('Update');
    });

    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');

        if (!confirm('Are you sure you want to delete this cost?')) return;

        $.ajax({
            url: '/user/costs/' + id,
            method: 'DELETE',
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content')
            },

            success: function(response) {
                alert(response.message);
                $('#cost-table').DataTable().ajax.reload(null, false);

            },

            error: function() {
                alert('Failed to delete cost.');
            }
        });
    });
</script>

@stop