@extends('layouts/master',['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('title', 'Academy Dashboard - Apps')

@section('vendor-style')
<!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />
@endsection

@section('vendor-script')
 <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/moment/moment.js"></script>
    <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>

@endsection

@section('page-script')
<!-- Page JS -->
    <!--<script src="../../assets/js/app-academy-dashboard.js"></script>-->
@endsection

@section('content')
 

 <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Hour chart  -->
              <div class="card bg-transparent shadow-none my-4 border-0">
                <div class="card-body row p-0 pb-3">
                  <div class="col-12 col-md-8 card-separator">
                    <h3>Welcome back, {{auth()->user()->name}} 👋🏻</h3>
                    <div class="col-12 col-lg-7">
                      <p>Your progress this week is Awesome. let's keep it up and get a lot of points reward !</p>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
                      <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
                        <span class="bg-label-primary p-2 rounded">
                          <i class="ti ti-device-laptop ti-xl"></i>
                        </span>
                        <div class="content-right">
                          <p class="mb-0">Hours Spent</p>
                          <h4 class="text-primary mb-0">34h</h4>
                        </div>
                      </div>
                      <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-info p-2 rounded">
                          <i class="ti ti-bulb ti-xl"></i>
                        </span>
                        <div class="content-right">
                          <p class="mb-0">Test Results</p>
                          <h4 class="text-info mb-0">82%</h4>
                        </div>
                      </div>
                      <div class="d-flex align-items-center gap-3">
                        <span class="bg-label-warning p-2 rounded">
                          <i class="ti ti-discount-check ti-xl"></i>
                        </span>
                        <div class="content-right">
                          <p class="mb-0">Course Completed</p>
                          <h4 class="text-warning mb-0">14</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-4 ps-md-3 ps-lg-4 pt-3 pt-md-0">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <div>
                          <h5 class="mb-2">Time Spendings</h5>
                          <p class="mb-5">Weekly report</p>
                        </div>
                        <div class="time-spending-chart">
                          <h3 class="mb-2">231<span class="text-muted">h</span> 14<span class="text-muted">m</span></h3>
                          <span class="badge bg-label-success">+18.4%</span>
                        </div>
                      </div>
                      <div id="leadsReportChart"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Hour chart End  -->

             

            </div>
            <!-- / Content -->

@endsection
