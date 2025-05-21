@extends('auth/layouts/master')

@section('content')
     <h4 class="mb-1 pt-2">Adventure starts here 🚀</h4>
              <p class="mb-4">Make your learning management easy and fun!</p>

                @isset($url)
                <form id="formAuthentication" class="mb-3" method="POST" action="{{ $url }}">
                @else
                <form id="formAuthentication" class="mb-3" method="post" action="{{ route('admin.register') }}">
                @endisset
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter your name"
                    autofocus />
                    @error('name')
                    <span class="invalid-feedback">
                        <div>{{ $message }}</div>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" />
                    @error('email')
                    <span class="invalid-feedback">
                        <div>{{ $message }}</div>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-phone">Phone No</label>
                    <input type="text" name="mobile" id="basic-default-phone" class="form-control phone-mask @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" placeholder="09 xxx xxx xxx">
                    @error('mobile')
                    <span class="invalid-feedback">
                        <div>{{ $message }}</div>
                    </span>
                    @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control @error('password') is-invalid @enderror"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                  </div>
                    @error('password')
                    <span class="invalid-feedback">
                        <div>{{ $message }}</div>
                    </span>
                    @enderror
                </div>

                <div class="form-password-toggle">
                        <label class="form-label" for="multicol-confirm-password">Confirm Password</label>
                        <div class="input-group input-group-merge">
                          <input type="password" id="multicol-confirm-password" name="password_confirmation" class="form-control" placeholder="············" aria-describedby="multicol-confirm-password2">
                          <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"><i class="ti ti-eye-off"></i></span>
                        </div>
                </div>

                {{-- <div class="mb-3">
                    <label class="form-label" for="birth-date">DOB</label>
                          <input
                            type="text"
                            class="form-control flatpickr-validation"
                            name="birth-date"
                            id="birth-date"
                            placeholder="YYYY-MM-DD"
                            required />
                </div> --}}

                <div class="mb-3">
                    <label class="form-label" for="address">Address</label>
                          <input
                            type="text"
                            class="form-control "
                            name="address" value="{{ old('address') }}"
                            id="address"
                            placeholder="Enter your Address" />
                </div>

                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" value="agree" />
                    <label class="form-check-label" for="terms-conditions">
                      I agree to
                      <a href="javascript:void(0);">privacy policy & terms</a>
                    </label>
                  </div>
                </div>
                <button class="btn btn-primary d-grid w-100">Sign up</button>
              </form>

              <p class="text-center">
                <span>Already have an account?</span>
                <a href="{{route('admin.login-view')}}">
                  <span>Sign in instead</span>
                </a>
              </p>

              
@endsection
