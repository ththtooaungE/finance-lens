@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<!-- <h1>Dashboard</h1> -->
@stop

@section('plugins.Chartjs', true)

@section('content')

<div class="row">

    <class class="col-lg-6 row">
        
        {{-- Category --}}
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0">
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
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body py-3 px-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <p class="text-muted mb-1 small font-weight-bold">
                                Collection
                            </p>

                            <h3 class="mb-0 font-weight-bold text-primary">
                                {{ $collectionCount }}
                            </h3>
                        </div>

                        <div>
                            <i class="fas fa-wallet fa-2x text-primary opacity-50"></i>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </class>

    {{-- Table --}}
    <div class="col-lg-6 mb-3">
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
                            <td></td>
                            <td>{{ $collection->created_at?->format('Y-m-d h:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>


<!-- Latest Collection Report -->
<div class="row" style="gap: 0;">

    <!-- Latest Collection Date Report -->
    <div class="col-lg-6 p-3">
        <div class=" card">
            <div class="card-header">
                <h3 class="card-title">Latest Spending Chart Analysis By Date</h3>
            </div>

            <div class="card-body">
                <canvas id="latestCollectionDateReport"></canvas>
            </div>
        </div>
    </div>

    <!-- Latest Collection Category Report -->
    <div class="col-lg-6 p-3">
        <div class=" card">
            <div class="card-header">
                <h3 class="card-title">Latest Spending Chart Analysis By Category</h3>
            </div>

            <div class="card-body">
                <canvas id="latestCollectionCategoryReport"></canvas>
            </div>
        </div>
    </div>
</div>


<!-- Previous Collection Report -->
<div class="row">

    <!-- Previous Collection Report By Date -->
    <div class="col-lg-6 p-3">
        <div class=" card">
            <div class="card-header">
                <h3 class="card-title">Previous Spending Chart Analysis By Date</h3>
            </div>

            <div class="card-body">
                <canvas id="previousCollectionDateReport"></canvas>
            </div>
        </div>
    </div>

    <!-- Previous Collection Report By Category -->
    <div class="col-lg-6 p-3">
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


    // Latest Collection Report By Date
    const latestCollectionDateReport = document.getElementById('latestCollectionDateReport').getContext('2d');

    new Chart(latestCollectionDateReport, {
        type: 'line',
        data: {
            labels: @json($latestCollectionDateReport['labels']),

            datasets: [{
                label: 'Sales',
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
                    position: 'bottom'
                },
                title: {
                    display: true,
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
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Monthly Expense Breakdown'
                }

            }

        }
    });
</script>
@stop