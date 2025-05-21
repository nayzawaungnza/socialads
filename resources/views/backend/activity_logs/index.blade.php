@extends('layouts/master', ['activePage' => 'activitylogs','titlePage' => 'Activity Logs'])


@section('vendor-style')
<!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ url('/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('vendor-script')
 <!-- Vendors JS -->
    <script src="{{ url('/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ url('/js/activitylogs.js') }}"></script>
<script src="{{ url('/assets/js/tables-datatables-advanced.js') }}"></script>
@endsection

@section('content')
 
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Admin /</span> Activity Logs
    </h4>
              <!-- Users List Table -->
              <!-- Ajax Sourced Server-side -->
              <div class="card">
                <h5 class="card-header">Activity Log</h5>
                <div id="table_url" data-table-url="{{route('activity_logs.index')}}"></div>
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="table table-bordered table-hover activity-log-data-table" width="100%">
                        <thead>
                            <tr>
                                <th width="20%">Time</th>
                                <th>Activity Causer Type</th>
                                <th>Activity Causer Name</th>
                                <th>Activity Subject Type</th>
                                <th width="40%">Description</th>
                            </tr>
                        </thead>
                    </table>
                </div>
              </div>
              <!--/ Ajax Sourced Server-side -->
              
            </div>
 

@endsection
