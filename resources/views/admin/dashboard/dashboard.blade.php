@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<!-- Widgets -->
<div class="row pt-3">

    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1">Total Users</p>
                        <h3 class="font-weight-bold h3 text-center">{{ $userCount }}</h3>
                    </div>
                    <div class="icon">
                        <i class="far fa-users text-success opacity-50" style="font-size: 24px;"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1">Total Collections</p>
                        <h3 class="font-weight-bold h3 text-center">{{ $collectionCount }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fw fa-th text-success opacity-50" style="font-size: 24px;"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <p class="text-muted mb-1">Total Categories</p>
                        <h3 class="font-weight-bold h3 text-center">{{ $categoryCount }}</h3>
                    </div>
                    <div class="icon">
                        <i class="fas fa-layer-group text-success opacity-50" style="font-size: 24px;"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <p id="year-month" class="text-muted mb-1"></p>
                        <h3 id="today-date" class="font-weight-bold h3 text-center"></h3>
                    </div>
                    <div class="icon">
                        <i class="far fa-calendar-alt text-success opacity-50" style="font-size: 24px;"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <!-- Latest User Report -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Monthly User Report</h3>
            </div>
            <div class="card-body">
                <canvas id="monthly-user-report"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <!-- Most Collection User Report -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Monthly Most Collection User Report</h3>
            </div>
            <div class="card-body">
                <canvas id="monthly-most-collection-user-report2"></canvas>
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


    // Monthly User report
    const monthlyUserReport = document.getElementById('monthly-user-report').getContext('2d');

    new Chart(monthlyUserReport, {
        type: 'bar',
        data: {
            labels: @json($monthlyUserReport['labels']),

            datasets: [{
                labels: 'Monthly User Report',
                data: @json($monthlyUserReport['data']),
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
        },

    });



    // Monthly Most Collection User Report
    const monthlyMostCollectionUserReport2 = document.getElementById('monthly-most-collection-user-report2').getContext('2d');

    new Chart(monthlyMostCollectionUserReport2, {
        type: 'bar',
        data: {
            labels: @json($monthlyMostCollectionUserReport['labels']),

            datasets: [{
                labels: 'Monthly User Report',
                data: @json($monthlyMostCollectionUserReport['data']),
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
        },

    });
</script>
@stop