@extends('layouts/master', ['activePage' => 'subscribers.create', 'titlePage' => __('New Subscriber Account')])


@section('vendor-style')
<!-- Vendors CSS -->
   <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

   
@endsection
@section('page-style')

 <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ url('/assets/vendor/css/pages/page-auth.css') }}" />

    @endsection

@section('vendor-script')
<!-- Vendors JS -->
    <script src="{{ url('/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/tagify/tagify.js') }}"></script>
    

@endsection

@section('page-script')
 
    <script src="{{ url('/assets/js/form-layouts.js') }}"></script>
   <script src="{{ url('/js/file-upload.js') }}"></script>

    
@endsection

@section('content')
 
    <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">subscriber /</span> Create
            </h4>
        
           <div class="card mb-4">
                <h5 class="card-header">Create Subscriber</h5>
                @isset($url)
                    <form  class="card-body" method="POST" action="{{$url}}" enctype="multipart/form-data" >
                @else
                  <form  class="card-body" method="POST" action="{{url('/admin/subscribers/store')}}" enctype="multipart/form-data" >
                @endisset
                  @csrf

                  <h6>1. Account Details</h6>
                  <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                      <img src="{{ url('storage/images/profile-picture.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                      <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                          <span class="d-none d-sm-block">Upload profile photo</span>
                          <i class="ti ti-upload d-block d-sm-none"></i>
                          <input type="file" id="upload" name="avatar" class="account-file-input" hidden />
                        </label>
                        <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                          <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                          <span class="d-none d-sm-block">Reset</span>
                        </button>

                        <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                        @error('avatar')
                            <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label" for="name">Name</label>
                      <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="john.doe" />
                      @error('name')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="email">Email</label>
                      <div class="input-group input-group-merge">
                        <input
                          type="text"
                          id="email"
                          class="form-control @error('email') is-invalid @enderror"
                          name="email"
                          value="{{ old('email') }}"
                          placeholder="john.doe@gmail.com"
                          aria-label="john.doe@gmail.com"
                          aria-describedby="email" />
                        
                      </div>
                      @error('email')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <div class="form-password-toggle">
                        <label class="form-label" for="multicol-password">Password</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="password"
                            id="multicol-password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="multicol-password2" />
                          <span class="input-group-text cursor-pointer" id="multicol-password2"
                            ><i class="ti ti-eye-off"></i
                          ></span>
                        </div>
                        @error('password')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-password-toggle">
                        <label class="form-label" for="multicol-confirm-password">Confirm Password</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="password"
                            id="multicol-confirm-password"
                            name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="multicol-confirm-password2" />
                          <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"
                            ><i class="ti ti-eye-off"></i
                          ></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr class="my-4 mx-n4" />
                  <h6>2. Personal Info</h6>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-phone">Phone No</label>
                      <input
                        type="text"
                        id="multicol-phone"
                        name="mobile"
                        value="{{ old('mobile') }}"
                        class="form-control phone-mask @error('mobile') is-invalid @enderror"
                        placeholder="09 xxx xxx xxx"
                        aria-label="09 xxx xxx xxx" />
                        @error('mobile')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-address">Address</label>
                      <input type="text" id="multicol-address" value="{{ old('address') }}" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="address" />
                      @error('address')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    
                  </div>
                  <hr class="my-4 mx-n4" />
                  
                  <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div>
                </form>
              </div>

    </div>

@endsection
