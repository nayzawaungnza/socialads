@extends('layouts/frontend/master', ['activePage' => 'Post Category', 'page' => 'Categories'])
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
                    <h2>{{$category->name}}</h2>
                    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/blogs')}}">Blogs</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="blog-standard-section ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="blog-stand-card">
                            <div class="row">
                                
                                @foreach($category->posts as $post)
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                        <div class="blog-card standard">
                                            <div class="blog-img">
                                                <a href="{{ route('website.post-detail', $post->slug) }}">
                                                    <img src="{{ Storage::disk('public')->url($post->default_image->image_url) }}" alt="{{ $post->title }}">
                                                </a>
                                                
                                            </div>
                                            <div class="blog-info">
                                                <h3>
                                                    <a href="{{ route('website.post-detail', $post->slug) }}">{{ $post->name }}</a>
                                                </h3>
                                                <ul class="blog-metainfo">
                                                    <li>
                                                        <i class="bx bx-calendar"></i>
                                                        <a href="#">{{ $post->created_at->format('M d, Y') }}</a>
                                                    </li>
                                                    <li>
                                                        <i class="bx bx-time"></i>
                                                          {{ $post->reading_time }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                
                                
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            
</div>
@endsection