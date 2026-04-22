@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<p>Welcome {{ auth()->user()->name }}</p>

<table>
    <head>
        <tr>
            <th>Notification</th>
            <th>Date</th>
        </tr>
    </head>
    <tbody>
        <!-- Notifications will be populated here -->
    </tbody>
</table>
@stop