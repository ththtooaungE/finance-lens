@extends('adminlte::page')

@section('title', 'Collection Details')

@section('content_header')
<h3>{{ $collection->name }}</h3>
@stop

@section('content')

<div class="row gap-3 mb-1">
    <div class="col-md-6" style="text-align: justify;">
        <p>{{ $collection->description }}</p>
    </div>

    <!-- Collection's Categories -->
    <div class="col-md-6">
        <h5 class="d-inline-block">Categories:</h5>

        @if($collection->categories->isEmpty())
        <p>No categories assigned.</p>
        @else
        <div class="d-inline-block mb-3">
            @foreach($collection->categories as $category)
            <span class="badge" style="background-color: {{ $category->color }};">{{ $category->name }}</span>
            @endforeach
        </div>
        @endif
    </div>
</div>


<!-- Hidden table (DataTables needs this) -->
<table id="cost-table" class="d-none">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>

<div class="card">
    <div class="card-body row">
        <div class="btn-group mr-3">
            <button
                id="sort-price-desc"
                class="btn btn-sm btn-info"
                style="border-top-left-radius:25px; border-bottom-left-radius:25px; margin-right: 2px;">Hightest</button>
            <button
                id="sort-date"
                class="btn btn-sm btn-info"
                style="margin-right: 2px;">Latest</button>
            <button
                id="sort-category"
                class="btn btn-sm btn-info"
                style="border-top-right-radius:25px; border-bottom-right-radius:25px;">Category</button>

        </div>
        <div id="costCreate" class="col-xl-6">
            <!-- Cost form (for create & edit) -->
            <form action="{{ route('costs.store') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="collection_id" value="{{ $collection->id }}">

                <!-- hidden input to store cost id when editing -->
                <input type="hidden" name="id" id="cost_id">

                <div class="d-flex flex-row gap-2">
                    <!-- Combined input -->
                    <div class="flex-fill w-auto mr-2 ">
                        <input
                            type="text"
                            id="combined_input"
                            name="combined_input"
                            class="form-control"
                            placeholder="Enter Price and Cost Name" value="" autofocus>
                    </div>

                    <div id="category-wrapper" class="mr-2">
                        <select
                            name="category_id"
                            class="custom-select w-auto"
                            size="1"
                            value="Select Category">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" class="p-1 rounded-lg">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="">
            <p
                id="grand-total-cost"
                class="btn m-0"></p>
        </div>

    </div>
</div>

<!-- Cost Cards Container -->
<div id="cost-card-container" class="row" style="padding-bottom: 100px;"></div>

@stop
@section('css')
<style>
    .cost-actions {
        display: none;
        transform: translateY(-4px);
        transition: 0.2s;
    }

    .cost-card:hover .cost-actions {
        display: inline;
        transform: translateY(0);
    }

    .edit-btn,
    .delete-btn {
        cursor: pointer;
        opacity: 0.5;
    }

    .edit-btn:hover,
    .delete-btn:hover {
        opacity: 1;
    }
</style>
@stop
@section('js')
<script>
    let isEdit = false;
    let currentId = null;
    let showCategoryColor = false;

    function renderCards(data, showCategoryColor) {
        let container = $('#cost-card-container');
        container.empty();
        let grandTotalCost = 0;

        data.forEach(cost => {
            // Add to get Grand Total Cost
            grandTotalCost += parseFloat(cost.price);

            let card = `
            <div class="col-lg-3 col-md-4 p-1">
                <div 
                    style="
                        border: 1px solid #ddd;
                        ${showCategoryColor ? `
                            background: linear-gradient(
                                to right,
                                ${cost.categoryColor ?? '#ffffff'},
                                rgba(255, 255, 255, 0)
                            );
                        ` : ''}
                    "
                    class="cost-card
                    rounded-pill py-2 px-3 mb-3
                    d-flex align-items-center justify-content-between">
                        
                        <div class="flexfill">
                            <span class="mr-1 text-secondary">${cost.name.charAt(0).toUpperCase() + cost.name.slice(1)}</span>

                            <div style="display: inline-block;">
                                <div class="cost-actions">
                                    <span class="edit-btn px-1" 
                                        data-id="${cost.id}" 
                                        data-name="${cost.name}" 
                                        data-price="${cost.price}"
                                        data-category="${cost.category ?? ''}">       
                                        <i class="fas fa-edit"></i>
                                    </span>               
                                    <span class="delete-btn px-1" 
                                        data-id="${cost.id}">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </div>
                            </div>
                            
                        </div>

                        <span>${cost.price % 1 == 0 ? parseInt(cost.price) : cost.price.toFixed(2)}</span>
                    </div>
                </div>
                `;
            container.append(card);

            // Display the Grand Total Cost
            $('#grand-total-cost').text('Grand Total Cost - ' + grandTotalCost);
        });
    }

    function handleSuccess(response, form) {
        // alert(response.message); // simple for now

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

        $('#category-wrapper').show();

        isEdit = false;
        currentId = null;

        $('#costCreate button[type="submit"]').text('Add');
    }


    let table = $('#cost-table').DataTable({
        processing: true,
        serverSide: false,
        ajax: '/collections/{{ $collection->id }}/costs',

        paging: false,
        info: false,
        lengthChange: false,

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
                data: 'date'
            },
            {
                data: 'actions'
            }
        ],

        drawCallback: function(settings) {
            let table = this.api();
            let data = table.rows({
                page: 'current'
            }).data().toArray();

            renderCards(data, showCategoryColor);
        }
    });

    // form submit
    $('#costCreate form').on('submit', function(e) {
        e.preventDefault(); // ❗ stop normal form submit

        let form = $(this);

        // Example:
        // "2000 Breakfast"
        let combinedInput = $('#combined_input').val().trim();

        let price = 0;
        let name = combinedInput;

        // Match: starts with number + space + remaining text
        let match = combinedInput.match(/^(\d+)\s+(.+)$/);

        if (match) {
            price = match[1];
            name = match[2];
        }

        // Build data manually
        let formData = form.serializeArray();

        // Add separated values
        formData.push({
            name: 'price',
            value: price
        });
        formData.push({
            name: 'name',
            value: name
        });

        // Convert back to query string
        formData = $.param(formData);

        let url = form.attr('action');
        let method = 'POST';

        if (isEdit) {
            url = `/costs/${currentId}`;
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
        let category = btn.data('category');

        // fill form
        $('#cost_id').val(id);
        $('input[name="name"]').val(name);
        $('input[name="price"]').val(price);
        $('select[name="category_id"]').val(category === 'No Category' ? '' : category);

        $('#category-wrapper').hide();

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
            url: '/costs/' + id,
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

    $('#sort-price-asc').on('click', function() {
        showCategoryColor = false;
        table.order([1, 'asc']).draw();
    });

    $('#sort-price-desc').on('click', function() {
        showCategoryColor = false;
        table.order([1, 'desc']).draw();
    });

    $('#sort-category').on('click', function() {
        showCategoryColor = true;
        table.order([2, 'desc']).draw();
    })

    $('#sort-date').on('click', function() {
        showCategoryColor = true;
        table.order([3, 'desc']).draw();
    })
</script>

@stop