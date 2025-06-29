@extends('layouts/master', ['activePage' => 'inbox.show', 'titlePage' => __('View Inbox')])


@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{ url('/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-user-view.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
 <script src="{{ url('/assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{ url('/assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">View /</span> Inbox
</h4>
<div class="row">
  
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="mb-3 col-md-3 border-bottom pb-3">
        <div class="mb-0 text-wrap fw-semibold">Name</div>
      </div>
      <div class="mb-3 col-md-9 border-bottom pb-3">
        <div class="mb-0 text-muted">{{ $contactform->name }}</div>
      </div>
      <div class="mb-3 col-md-3 border-bottom pb-3">
        <div class="mb-0 text-wrap fw-semibold">Email</div>
      </div>
      <div class="mb-3 col-md-9 border-bottom pb-3">
        <div class="mb-0 text-muted">{{ $contactform->email }}</div>
      </div>
      <div class="mb-3 col-md-3 border-bottom pb-3">
        <div class="mb-0 text-wrap fw-semibold">Subject</div>
      </div>
      <div class="mb-3 col-md-9 border-bottom pb-3">
          <div class="mb-0 text-muted">{{ $contactform->subject }}</div>
      </div>
      
      <div class="mb-3 col-md-3 border-bottom pb-3">
        <div class="mb-0 text-wrap fw-semibold">Company</div>
      </div>
      <div class="mb-3 col-md-9 border-bottom pb-3">
          <div class="mb-0 text-muted">{{ $contactform->company_name }}</div>
      </div>
      <div class="mb-3 col-md-3 border-bottom pb-3">
        <div class="mb-0 text-wrap fw-semibold">Service</div>
      </div>
      <div class="mb-3 col-md-9 border-bottom pb-3">
          <div class="mb-0 text-muted">{{ $contactform->service?->name }}</div>
      </div>
      <div class="mb-3 col-md-3 border-bottom pb-3">
        <div class="mb-0 text-wrap fw-semibold">Message</div>
      </div>
      <div class="mb-3 col-md-9 border-bottom pb-3">
          <div class="mb-0 text-muted">{{ $contactform->message }}</div>
      </div>
      <div class="mb-3 col-md-3 border-bottom pb-3">
        <div class="mb-0 text-wrap fw-semibold">Created At</div>
      </div>
      <div class="mb-3 col-md-9 border-bottom pb-3">
        <div class="mb-0 text-muted">{{ $contactform->created_at }}</div>
      </div>
      
      <div class="mb-3 col-md-3 border-bottom pb-3">
        <div class="mb-0 text-wrap fw-semibold">Updated At</div>
      </div>
      <div class="mb-3 col-md-9 border-bottom pb-3">
        <div class="mb-0 text-muted">{{ $contactform->updated_at }}</div>
      </div>
      <div class="mb-3 col-md-3 border-bottom pb-3">
        <div class="mb-0 text-wrap fw-semibold">Updated By</div>
      </div>
      <div class="mb-3 col-md-9 border-bottom pb-3">
        <div class="mb-0 text-muted">{{ $contactform->updatedBy?->name }}</div>
      </div>
    </div>
    <div class="row">
      
      
    </div>
    <div class="justify-content-end">
      <div class="col-sm-10">
          <a href="/admin/contacts" class="btn btn-outline-secondary">Back</a>
      </div>
    </div>
  </div>
</div>

 
</div>
</div>
<!-- Modal -->
<!-- /Modal -->
@endsection
