@extends('auth/layouts/master')

@section('content')
 <h4 class="mb-1 pt-2">Welcome to Admin Panel! 👋</h4>
              <p class="mb-4">Please sign-in to your account and start the erp</p>

               @isset($url)
                <form id="formAuthentication" class="mb-3" method="POST" action="{{ $url }}">
                @else
                <form id="formAuthentication" class="mb-3" method="post" action="{{ url('/login') }}">
                @endisset
                    @csrf
                <div class="mb-3">
                  <label for="email" class="form-label">Email or Username</label>
                  <input
                    type="text"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email" value="{{ old('email') }}"
                    placeholder="Enter your email or username"
                    autofocus />
                    @error('email')
                    <span class="invalid-feedback">
                        <div>{{ $message }}</div>
                    </span>
                    @enderror
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                    <a href="auth-forgot-password-basic.html">
                      <small>Forgot Password?</small>
                    </a>
                  </div>
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
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" name="remember" type="checkbox" id="remember" />
                    <label class="form-check-label" for="remember"> Remember Me </label>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>
              </form>

              <p class="text-center">
                <span>New on our platform?</span>
                <a href="{{ route('admin.register-view') }}">
                  <span>Create an account</span>
                </a>
              </p>

              @if(session()->has('status'))
                <div class="alert alert-success alert-dismissible" role="alert">
                  {{ session()->get('status') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            
              @endif
              @if(session()->has('email') && session()->has('password'))
                  <div class="alert alert-success alert-dismissible" role="alert">
                    <h5>Email : {{ session()->get('email') }} <br> Password : {{ session()->get('password') }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  
              @endif

              
@endsection