@extends('layouts/frontend/master', ['activePage' => 'privacy', 'page' => 'Privacy Policy'])
@section('seometa')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
     <meta property="og:image:width" content="380">
    <meta property="og:image:height" content="200">
    <meta property="og:image:alt" content="Social Ads Digital Marketing">
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
   
@endsection
@section('content')

<div class="section-banner sbg-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="banner-content">
                    <h2>About</h2>
                    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
        <div class="ptb-100 {{$page->slug}}">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-12">
                        <h1 class="page-title">{{$page->name}}</h1>
                        {!! $page->description !!}
                    </div>
                </div>
            </div>
        </div>
        
        
@endsection