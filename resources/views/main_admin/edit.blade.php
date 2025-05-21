@extends('layouts/master', ['activePage' => 'accounts.edit', 'titlePage' => __('Edit Admin Account')])


@section('vendor-style')
  <link rel="stylesheet" href="{{ url('/assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/tagify/tagify.css') }}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
 <script src="{{ url('/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/tagify/tagify.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ url('/js/nrc.js') }}"></script>
<script src="{{asset('/js/file-upload.js')}}"></script>
<script src="{{ url('/assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="py-3 mb-4">
 <span class="text-muted fw-light">User / Edit /</span> Account
</h4>

<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-md-row mb-4">
      <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="ti-xs ti ti-users me-1"></i> Account</a></li>
      <li class="nav-item"><a class="nav-link" href="{{url('pages/account-settings-security')}}"><i class="ti-xs ti ti-lock me-1"></i> Security</a></li>
      <li class="nav-item"><a class="nav-link" href="{{url('pages/account-settings-billing')}}"><i class="ti-xs ti ti-file-description me-1"></i> Billing & Plans</a></li>
      <li class="nav-item"><a class="nav-link" href="{{url('pages/account-settings-notifications')}}"><i class="ti-xs ti ti-bell me-1"></i> Notifications</a></li>
      <li class="nav-item"><a class="nav-link" href="{{url('pages/account-settings-connections')}}"><i class="ti-xs ti ti-link me-1"></i> Connections</a></li>
    </ul>
    <div class="card mb-4">
      <h5 class="card-header">Teacher Profile Update</h5>
      <!-- Account -->
      @isset($url)
      <form method="POST" class="url" action="{{$url}}" enctype="multipart/form-data">
      @else
      <form method="POST" action="{{url('/admin/accounts/'.$account->id)}}" enctype="multipart/form-data">
      @endisset
      @csrf
      @method('PUT')
      
      
        <div class="card-body">
          <div class="d-flex align-items-start align-items-sm-center gap-4">
            <img src="{{ $account->default_image ? $account->default_image?->user_default_image_url : url('storage/images/profile-picture.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
            <div class="button-wrapper">
              <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                <span class="d-none d-sm-block">Upload new photo</span>
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
        <hr class="my-0">
        <div class="card-body">
          <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $account->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="john.doe" />
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
                            value="{{ old('email', $account->email) }}"
                            placeholder="john.doe@gmail.com"
                            aria-label="john.doe@gmail.com"
                            aria-describedby="email" />
                          
                        </div>
                        @error('email')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
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
                          value="{{ old('mobile', $account->mobile) }}"
                          class="form-control phone-mask @error('mobile') is-invalid @enderror"
                          placeholder="09 xxx xxx xxx"
                          aria-label="09 xxx xxx xxx" />
                          @error('mobile')
                            <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                          @enderror
                      </div>
                      
                      <div class="col-md-6">
                        <label class="form-label" for="multicol-address">Address</label>
                        <input type="text" id="multicol-address" value="{{ old('address', $account->address) }}" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="address" />
                        @error('address')
                            <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                          @enderror
                      </div>
                      
                     
                      
                      <div class="col-md-6">
                           <label for="roles" class="form-label">Select Role <span class="text-danger">*</span></label>
                                    <div class="select2-purple">
                                        <select class="select2 form-control @error('roles') is-invalid @enderror" name="roles" data-placeholder="Select a Role" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                            @foreach ($roles as $role)
                                            <option {!! in_array($role, $userRole ?: []) ? "selected" : "" !!} value="{{ $role }}">{{$role}}</option>
                                            @endforeach
                                            {{in_array($role, $userRole ?: []) ? "selected": ""}}
                                        </select>
                                        @error('roles')
                                        <span id="exampleInputEmail1-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                </div>
                      </div>
                      
                              
                      
                    </div>
                    <hr class="my-4 mx-n4" />
                   
                  <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div>
                    
        </div>
      </form>
      <!-- /Account -->
    </div>
    
  </div>
</div>

@endsection
