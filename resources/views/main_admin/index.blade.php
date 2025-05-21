@extends('layouts/master', ['activePage' => 'accounts', 'titlePage' => __('Accounts')])


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
<script src="{{ url('/assets/js/tables-datatables-advanced.js') }}"></script>
@endsection

@section('content')
 
<div class="container-xxl flex-grow-1 container-p-y">
              <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                          <span>Session</span>
                          <div class="d-flex align-items-center my-2">
                            <h3 class="mb-0 me-2">21,459</h3>
                            <p class="text-success mb-0">(+29%)</p>
                          </div>
                          <p class="mb-0">Total Users</p>
                        </div>
                        <div class="avatar">
                          <span class="avatar-initial rounded bg-label-primary">
                            <i class="ti ti-user ti-sm"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                          <span>Paid Users</span>
                          <div class="d-flex align-items-center my-2">
                            <h3 class="mb-0 me-2">4,567</h3>
                            <p class="text-success mb-0">(+18%)</p>
                          </div>
                          <p class="mb-0">Last week analytics</p>
                        </div>
                        <div class="avatar">
                          <span class="avatar-initial rounded bg-label-danger">
                            <i class="ti ti-user-plus ti-sm"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                          <span>Active Users</span>
                          <div class="d-flex align-items-center my-2">
                            <h3 class="mb-0 me-2">19,860</h3>
                            <p class="text-danger mb-0">(-14%)</p>
                          </div>
                          <p class="mb-0">Last week analytics</p>
                        </div>
                        <div class="avatar">
                          <span class="avatar-initial rounded bg-label-success">
                            <i class="ti ti-user-check ti-sm"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                          <span>Pending Users</span>
                          <div class="d-flex align-items-center my-2">
                            <h3 class="mb-0 me-2">237</h3>
                            <p class="text-success mb-0">(+42%)</p>
                          </div>
                          <p class="mb-0">Last week analytics</p>
                        </div>
                        <div class="avatar">
                          <span class="avatar-initial rounded bg-label-warning">
                            <i class="ti ti-user-exclamation ti-sm"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Users List Table -->
              <!-- Ajax Sourced Server-side -->
              <div class="card">
              
                <h5 class="card-header">
                Teachers List
                    <div class="demo-inline-spacing">
                        <a href="{{route('accounts.create')}}" class="btn btn-secondary add-new btn-primary">
                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                        <span class="d-none d-sm-inline-block">Add New User</span></a>
                    </div>
                </h5>
                
                <div id="table_url" data-table-url="{{url('admin/accounts')}}"></div>
                <div class="card-datatable table-responsive text-nowrap">
                  <table class="user-datatables-ajax table">
                    <thead>
                      <tr>
                         <th>Full name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Mobile</th>
                        <th>Profile Pic</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <!--/ Ajax Sourced Server-side -->
              
            </div>
 

@endsection
