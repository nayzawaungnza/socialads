<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    @vite(['resources/css/app.css'])
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo m-0">
            <a href="{{ url('/') }}">
                <img src="{{ Storage::disk('public')->url('images/mas-logo.png') }}" alt="AdminLTE Logo" class="w-50">
            </a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                @isset($url)
                <form method="POST" action="{{ $url }}">
                @else
                <form method="post" action="{{ url('/login') }}">
                @endisset
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="form-control @error('email') is-invalid @enderror">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                        @error('email')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-success btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
                {{-- <p class="mb-1">
                    @isset($url)
                    <a class="text-success" href="{{ route('hub_vendor.forgot-password-view') }}">I forgot my password</a>
                    @else
                    <a class="text-success"href="{{ route('password.request') }}">I forgot my password</a>
                    @endisset
                </p> --}}
            </div>
        </div>
        @if(session()->has('status'))
            <div class="mt-5 alert alert-success alert-dismissible">
            <h5><i class="icon fas fa-check"></i> Created!</h5>
            {{ session()->get('status') }}
            </div>
        @endif
        @if(session()->has('email') && session()->has('password'))
             <div class="mt-5 alert alert-info alert-dismissible">
                <h5>Email : {{ session()->get('email') }} <br> Password : {{ session()->get('password') }}</h5>
             </div>
        @endif
    </div>
    @vite(['resources/js/app.js'])
</body>
</html>
