@extends('layouts/master', ['activePage' => 'roles', 'titlePage' => __('Role')])



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
<script src="{{ url('/js/delete-record.js') }}"></script>
<script src="{{ url('/js/roles.js') }}"></script>
<script src="{{ url('/assets/js/tables-datatables-advanced.js') }}"></script>
@endsection

@section('content')
 
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Admin /</span> Roles
    </h4>
              <!-- Users List Table -->
              <!-- Ajax Sourced Server-side -->
              <div class="card">
                <div class="card-header">
                        <div class="demo-inline-spacing">
                            <a href="{{route('roles.create')}}" class="btn btn-secondary add-new btn-primary"><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add New Role</span></a>
                        </div>
                </div>

                <div id="table_url" data-table-url="{{route('roles.index')}}"></div>
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="table table-bordered table-hover role-data-table" width="100%">
                                <thead>
                                    <tr>
                                        <th width="60%">Name</th>
                                        <th width="40%">Action</th>
                                    </tr>
                                </thead>
                    </table>
                </div>
              </div>
              <!--/ Ajax Sourced Server-side -->
              
            </div>
 

@endsection
