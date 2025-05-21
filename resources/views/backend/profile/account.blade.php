@extends('layouts/master')

@section('title', 'Account settings - Account')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
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
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Account Settings /</span> Account
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
      <h5 class="card-header">Profile Details</h5>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
          <img src="{{ asset('assets/img/avatars/14.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
          <div class="button-wrapper">
            <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
              <span class="d-none d-sm-block">Upload new photo</span>
              <i class="ti ti-upload d-block d-sm-none"></i>
              <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
            </label>
            <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
              <i class="ti ti-refresh-dot d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Reset</span>
            </button>

            <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
          </div>
        </div>
      </div>
      <hr class="my-0">
      <div class="card-body">
        <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label" for="name">Name</label>
                      <input type="text" id="name" name="name" value="{{ old('name', $teacher->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="john.doe" />
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
                          value="{{ old('email', $teacher->email) }}"
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
                        value="{{ old('mobile', $teacher->mobile) }}"
                        class="form-control phone-mask @error('mobile') is-invalid @enderror"
                        placeholder="09 xxx xxx xxx"
                        aria-label="09 xxx xxx xxx" />
                        @error('mobile')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label for="nrc_state" class="form-label">NRC <span class="text-danger">*</span> </label>
                            <div class="row">
                                <div class="col-md-3 select2-purple">
                                    <select class="nrc_state form-control @error('nrc_number') is-invalid @enderror select2" name="nrc_state" data-placeholder="xx" data-dropdown-css-class="" style="width: 100%;" data-attr-url="{{url('admin/nrc/getNrcTownshipByStateId')}}">
                                        <option value="">xx</option>
                                        @foreach ($nrcStates as $state)
                                        <option value="{{ $state->id }}" {{ ($teacher->nrc && $state->code==explode("-",$teacher->nrc)[0])?"selected":"" }}>{{$state->code}}</option>
                                        @endforeach
                                    </select>
                                    @error('nrc_state')
                                      <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 select2-purple">
                                    <select class="nrc_township form-control @error('nrc_number') is-invalid @enderror select2" name="nrc_township" data-placeholder="xxx">
                                        <option value="">xxx</option>
                                        @foreach ($nrcTownships as $township)
                                        <option value="{{ $township->id }}" {{ ($teacher->nrc && $township->code==explode("-",$teacher->nrc)[1])?"selected":"" }}>{{$township->code}}</option>
                                        @endforeach
                                    </select>
                                    @error('nrc_township')
                                      <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2 select2-purple">
                                    <select class="nrc_type form-control @error('nrc_number') is-invalid @enderror select2" name="nrc_type" data-placeholder="x">
                                        <option value="">x</option>
                                        @foreach ($nrcTypes as $type)
                                        <option value="{{ $type->id }}" {{ ($teacher->nrc && $type->code==explode("-",$teacher->nrc)[2])?"selected":"" }}>{{$type->code}}</option>
                                        @endforeach
                                    </select>
                                    @error('nrc_type')
                                      <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 select2-purple">
                                    <input type="text" name="nrc_number" class="form-control @error('nrc_number') is-invalid @enderror" id="nrc_number" placeholder="000000" value="{{ old('nrc_number', $teacher->nrc ? explode("-",$teacher->nrc)[3] : '') }}">
                                    
                                </div>
                                @error('nrc_number')
                                <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                @enderror
                            </div>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-slogan">Slogan</label>
                      <input type="text" id="multicol-slogan" value="{{ old('slogan', $teacher->slogan) }}" name="slogan" class="form-control @error('slogan') is-invalid @enderror" placeholder="Slogan" />
                      @error('slogan')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                          <label class="form-label" for="basic-default-upload-file">Profile pic</label>
                          <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" id="basic-default-upload-file">
                          @error('avatar')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-birthdate">Birth Date</label>
                      <input
                        type="text"
                        id="multicol-birthdate"
                        name="bod"
                        value="{{ old('bod',  $teacher->bod) }}"
                        class="form-control dob-picker flatpickr-input @error('bod') is-invalid @enderror"
                        placeholder="YYYY-MM-DD" />
                        @error('bod')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-join-date">Join Date</label>
                      <input
                        type="text"
                        name="join_date"
                        value="{{ old('join_date', $teacher->join_date) }}"
                        id="multicol-join-date"
                        class="form-control dob-picker flatpickr-input @error('join_date') is-invalid @enderror"
                        placeholder="YYYY-MM-DD" />
                        @error('join_date')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-address">Address</label>
                      <input type="text" id="multicol-address" value="{{ old('address' , $teacher->address) }}" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Address" />
                      @error('address')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                            
                    
                  </div>
                  <hr class="my-4 mx-n4" />
                  <h6>3. Socials</h6>
                  <div class="row g-3">
                    <div class="col-md-6">
                          <label class="form-label" for="multicol-show-socials">Show Socials</label>
                          <select class="form-select @error('show_socials') is-invalid @enderror" id="multicol-show-socials"  name="show_socials">
                            <option value="0" {{ old('show_socials', $teacher->show_socials ?? '1') == '0' ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('show_socials', $teacher->show_socials ?? '1') == '1' ? 'selected' : '' }}>Yes</option>
                          </select>
                          @error('show_socials')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                          @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="formtabs-facebook">Facebook</label>
                        <input type="text" id="formtabs-facebook" value="{{ old('facebook', $teacher->socials['facebook'] ?? '') }}" name="facebook" class="form-control @error('facebook') is-invalid @enderror" placeholder="https://facebook.com/abc">
                        @error('facebook')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="formtabs-twitter">Twitter</label>
                      <input type="text" id="formtabs-twitter" value="{{ old('twitter', $teacher->socials['twitter'] ?? '') }}" name="twitter" class="form-control @error('twitter') is-invalid @enderror" placeholder="https://twitter.com/abc">
                        @error('twitter')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="formtabs-linkedin">Linkedin</label>
                      <input type="text" id="formtabs-linkedin" value="{{ old('linkedin', $teacher->socials['linkedin'] ?? '') }}" name="linkedin" class="form-control @error('linkedin') is-invalid @enderror" placeholder="https://linkedin.com/abc">
                        @error('linkedin')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="formtabs-instagram">Instagram</label>
                      <input type="text" id="formtabs-instagram" value="{{ old('instagram', $teacher->socials['instagram'] ?? '') }}" name="instagram" class="form-control @error('instagram') is-invalid @enderror" placeholder="https://instagram.com/abc">
                      @error('instagram')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>
      </div>
      <!-- /Account -->
    </div>
    <div class="card">
      <h5 class="card-header">Delete Account</h5>
      <div class="card-body">
        <div class="mb-3 col-12 mb-0">
          <div class="alert alert-warning">
            <h5 class="alert-heading mb-1">Are you sure you want to delete your account?</h5>
            <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
          </div>
        </div>
        <form id="formAccountDeactivation" onsubmit="return false">
          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" />
            <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
          </div>
          <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="container-xxl flex-grow-1 container-p-y">
@endsection
