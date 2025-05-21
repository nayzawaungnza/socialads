<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <!--<title> {{ $settings->site_name ?? config('app.name') }}</title>-->
    <!--SEO META-->
    @yield('seometa')
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{Storage::url($settings->favicon)}}">

    @include('layouts/frontend/sections/styles')
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-8CYYLX1MVE"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8CYYLX1MVE');
</script>
</head> 
<body class="dark-theme">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="slider-container">
                    <div class="slider-text">
                      <span>Heads up! Our website is still in the works. If you come across anything odd or unfinished, we’re really sorry about that. We’re working hard to launch soon. Thanks for bearing with us!</span>
                      <span>Heads up! Our website is still in the works. If you come across anything odd or unfinished, we’re really sorry about that. We’re working hard to launch soon. Thanks for bearing with us!</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- ==================== Mobile Menu Start Here ==================== -->
{{-- @include('layouts/frontend/mobilemenu') --}}
<!-- ==================== Mobile Menu End Here ==================== -->


    <!-- ==================== Header Start Here ==================== -->
    @include('layouts/frontend/menu')
    <!-- ==================== Header End Here ==================== -->

   @yield('content')  
    
<!-- ==================== Footer Start Here ==================== -->
@include('layouts/frontend/footer')
<!-- ==================== Footer End Here ==================== -->
  

        
@include('layouts/frontend/sections/scripts')
   
    </body>
</html>