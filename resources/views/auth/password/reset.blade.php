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
        <div class="login-logo">
            <a href="{{ url('/home') }}"><b>{{ config('app.name') }}</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
                @isset($url)
                <form method="POST" action="{{ $url }}">
                @else
                <form action="{{ route('password.update') }}" method="POST">
                @endisset
                    @csrf
                    @php
                        if (!isset($token)) {
                            $token = \Request::route('token');
                        }
                    @endphp
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                        @if ($errors->has('email'))
                        <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                        @if ($errors->has('password'))
                        <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                        @if ($errors->has('password_confirmation'))
                        <span class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @error('token')
                            <span class="error invalid-feedback" style="display:block;">{{ $message }}</span>
                            @enderror
                            <button type="submit" class="btn btn-success btn-block">Reset Password</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a class="btn btn-success btn-block" href="{{ route('login') }}">Login</a>
                </p>
            </div>
        </div>
    </div>
    @vite(['resources/js/app.js'])
</body>
</html>
