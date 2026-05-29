@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<!-- <h1>Dashboard</h1> -->
@stop

@section('plugins.Chartjs', true)

@section('content')

<div class="row">

    {{-- Recent Costs Table --}}
    <div class="col-lg-6 col-md-12">
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold">
                    Recent Costs
                </h3>
            </div>

            <div class="card-body p-0">

                <table class="table table-hover mb-0">

                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Cost</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach( $recentCollections as $collection )
                        <tr>
                            <td>No</td>
                            <td>{{ $collection->name }}</td>
                            <td>{{ $collection->costs[0]->total_cost }} MMK</td>
                            <td>{{ $collection->created_at?->format('Y M d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

        </div>
    </div>


    {{-- Widgets --}}
    <div class="col-lg-3 col-md-6">
        <div class="row">

            {{-- Category --}}
            <div class="col-lg-6 col-12">
                <div class="card shadow-sm border-0" style="min-height: 113px">
                    <div class="card-body py-3 px-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <p class="text-muted mb-1 small font-weight-bold">
                                    Category
                                </p>
                                <h3 class="mb-0 font-weight-bold text-success">
                                    {{ $categoryCount }}
                                </h3>
                            </div>
                            <div>
                                <i class="fas fa-layer-group fa-2x text-success opacity-50"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Collection --}}
            <div class="col-md-6 col-12">
                <div class="card shadow-sm border-0" style="min-height: 113px">
                    <div class="card-body py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <p class="text-muted mb-1 small font-weight-bold">
                                    Category
                                </p>
                                <h3 class="mb-0 font-weight-bold text-success">
                                    {{ $categoryCount }}
                                </h3>
                            </div>
                            <div>
                                <i class="fas fa-layer-group fa-2x text-success opacity-50"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            {{-- Category --}}
            <div class="col-md-6 col-12">
                <div class="card shadow-sm border-0" style="min-height: 113px">
                    <div class="card-body py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <p class="text-muted mb-1 small font-weight-bold">
                                    Collection
                                </p>
                                <h3 class="mb-0 font-weight-bold text-success">
                                    {{ $collectionCount }}
                                </h3>
                            </div>
                            <div>
                                <i class="fas fa-wallet fa-2x text-success opacity-50"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Collection --}}
            <div class="col-md-6 col-12">
                <div class="card shadow-sm border-0" style="min-height: 113px">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <p id="year-month" class="text-muted mb-1 small font-weight-bold"></p>

                                <h3 id="today-date" class="mb-0 font-weight-bold text-primary"></h3>
                            </div>

                            <div>
                                <i class="fas fa-calendar-alt fa-2x text-primary opacity-50"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- PROFILE --}}
    <div class="col-lg-3 d-flex">
        <div class="card shadow-sm border-0 w-100">
            <div class="card-body py-3 px-3 d-flex flex-column justify-content-center align-items-center text-center">

                @if(auth()->user()->avatar_url)
                <img
                    src="{{ route('avatar.show') }}"
                    alt="Avatar"
                    class="rounded-circle mb-2"
                    style="
                    width: 100px;
                    height: 100px;
                    object-fit: cover;
                ">
                @endif

                <h5 class="font-weight-bold mb-1">
                    {{ auth()->user()->name }}
                </h5>

                <p class="text-muted small mb-0">
                    Welcome back
                </p>

            </div>
        </div>
    </div>

</div>


<!-- Line & Bar  Report -->
<div class="row">

    <!-- Latest Collection Date Report -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Latest Spending Chart Analysis By Date</h3>
            </div>

            <div class="card-body">
                <canvas id="latestCollectionDateReport"></canvas>
            </div>
        </div>
    </div>

    <!-- Previous Collection Report By Date -->
    <div class="col-lg-6">
        <div class=" card">
            <div class="card-header">
                <h3 class="card-title">Previous Spending Chart Analysis By Date</h3>
            </div>

            <div class="card-body">
                <canvas id="previousCollectionDateReport"></canvas>
            </div>
        </div>
    </div>

</div>


<!-- Doughnut Report -->
<div class="row">

    <!-- Latest Collection Category Report -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Latest Spending Chart Analysis By Category</h3>
            </div>

            <div class="card-body">
                <canvas id="latestCollectionCategoryReport"></canvas>
            </div>
        </div>
    </div>

    <!-- Previous Collection Report By Category -->
    <div class="col-lg-6">
        <div class=" card">
            <div class="card-header">
                <h3 class="card-title">Previous Spending Chart Analysis By Category</h3>
            </div>

            <div class="card-body">
                <canvas id="previousCollectionCategoryReport"></canvas>
            </div>
        </div>
    </div>


</div>

@stop

@section('js')
<script>
    // Display current year, month, and today's date
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');

    $('#year-month').text(`${year} ${now.toLocaleString('default', { month: 'long' })}`);
    $('#today-date').text(day);



    // Latest Collection Report By Date
    const latestCollectionDateReport = document.getElementById('latestCollectionDateReport').getContext('2d');

    new Chart(latestCollectionDateReport, {
        type: 'line',
        data: {
            labels: @json($latestCollectionDateReport['labels']),

            datasets: [{
                label: '',
                data: @json($latestCollectionDateReport['data']),
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });


    // Latest Collection Report By Category
    const latestCollectionCategoryReport = document.getElementById('latestCollectionCategoryReport').getContext('2d');

    new Chart(latestCollectionCategoryReport, {
        type: 'doughnut',
        data: {
            labels: @json($latestCollectionCategoryReport['labels']),
            datasets: [{
                label: 'Expenses',
                data: @json($latestCollectionCategoryReport['data']),
                backgroundColor: @json($latestCollectionCategoryReport['colors']),
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                },
                title: {
                    display: false,
                    text: 'Monthly Expense Breakdown'
                }
            }
        }
    });


    // Previous Collection Report By Date
    const previousCollectionDateReport = document.getElementById('previousCollectionDateReport').getContext('2d');

    new Chart(previousCollectionDateReport, {
        type: 'bar',
        data: {
            labels: @json($previousCollectionDateReport['labels']),
            datasets: [{
                label: 'Previous Spending Graph',
                data: @json($previousCollectionDateReport['data']),
                backgroundColor: ['#007bff'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });


    // Previous Collection Report By Category
    const previousCollectionCategoryReport = document.getElementById('previousCollectionCategoryReport').getContext('2d');

    new Chart(previousCollectionCategoryReport, {
        type: 'doughnut',
        data: {
            labels: @json($previousCollectionCategoryReport['labels']),
            datasets: [{
                label: 'Expenses',
                data: @json($previousCollectionCategoryReport['data']),
                backgroundColor: @json($previousCollectionCategoryReport['colors']),
                borderWidth: 2
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                },
                title: {
                    display: false,
                    text: 'Monthly Expense Breakdown'
                }

            }

        }
    });
</script>
@stop