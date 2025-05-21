@extends('layouts/frontend/master', ['activePage' => 'insights', 'page' => 'Insights'])
@section('seometa')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
   
@endsection
@section('content')

<div class="section-banner sbg-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="banner-content">
                    <h2>Insights</h2>
                    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Insights</li>
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
                    <div class="col-xl-8 col-lg-12">
                        <div class="blog-stand-card">
                            <div class="row">
                                
                                @foreach($posts as $post)
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                        <div class="blog-card standard">
                                            <div class="blog-img">
                                                <a href="{{ route('website.post-detail', $post->slug) }}">
                                                    <img src="{{ Storage::disk('public')->url($post->default_image->image_url) }}" alt="{{ $post->title }}">
                                                </a>
                                                <ul class="blog-metainfo">
                                                    <li>
                                                        <i class="bx bx-calendar"></i>
                                                        <a href="#">{{ $post->created_at->format('M d, Y') }}</a>
                                                    </li>
                                                    <li>
                                                        <i class="bx bx-time"></i>
                                                         {{$post->read_time}}
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="blog-info">
                                                <h3>
                                                    <a href="{{ route('website.post-detail', $post->slug) }}">{{ $post->name }}</a>
                                                </h3>
                                                <p>
                                                    @if($post->excerpt)
                                                        {!! Str::limit($post->excerpt, 150) !!}
                                                    @else
                                                        {!! Str::limit($post->description, 150) !!}
                                                    @endif
                                                </p>
                                                <a href="{{ route('website.post-detail', $post->slug) }}" class="btn-link">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                
                                
                                <div class="blog-pagi">
                                    {{ $posts->links() }}
            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="widget-area">
                            
                            @include('frontend.search-widget')
                            
                            <div class="widget widget-categories">
                                <h3 class="widget-title">Categories</h3>
                                <div class="post-categories">
                                    <ul>
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="{{ route('website.category-post', $category->slug) }}">
                                                    <i class="bx bxs-square"></i> {{ $category->name }}
                                                </a>
                                                <span>({{ $category->posts_count }})</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="widget widget-post">
                                <h3 class="widget-title">Recent Posts</h3>
                                @foreach($recent_posts as $post)
                                    <article class="item">
                                        <a href="{{ route('website.post-detail', $post->slug) }}" class="thumb">
                                            
                                            <span class="fullimage" role="img" style="background-image: url('{{ Storage::disk('public')->url($post->default_image->image_url) }}');"></span>
                                            
                                        </a>
                                        <div class="info">
                                            <h4 class="title usmall">
                                                <a href="{{ route('website.post-detail', $post->slug) }}">
                                                    {{ $post->name }}
                                                </a>
                                            </h4>
                                            <ul class="meta">
                                                <li>
                                                    <i class="bx bx-calendar"></i>
                                                    {{ $post->created_at->format('M d, Y') }}
                                                </li>
                                                
                                            </ul>
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection