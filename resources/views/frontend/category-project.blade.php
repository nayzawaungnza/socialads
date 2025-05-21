@extends('layouts/frontend/master', ['activePage' => 'Project Category', 'page' => 'Portfolio'])
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
                    <h2>Services</h2>
                    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/portfolio')}}">Portfolio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
 @if($category->projects->count())
    <div class="recent-post-section pt-50 pb-30">
        <div class="container">
            <div class="row">
                @foreach($category->projects as $project)
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 aos-init aos-animate" data-aos="fade-up">
                        <div class="blog-card">
                            <div class="blog-img">
                                <a href="{{ route('website.project-detail', $project->slug) }}">
                                    <img src="{{ Storage::disk('public')->url($project->default_image->image_url) }}"
                                         alt="{{ $project->name }}" />
                                </a>
                                <div class="blog-metainfo">
                                    <h3>
                                        <a href="{{ route('website.project-detail', $project->slug) }}">
                                            {{ $project->name }}
                                        </a>
                                    </h3>
                                    <div class="d-flex flex-nowrap w-full justify-content-between align-items-center">
                                        @if($project->categories->count() > 0)
                                            <ul>
                                                @foreach($project->categories as $category)
                                                    <li>
                                                        <a href="{{ route('website.category-project', $category->slug) }}">
                                                            {{ $category->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        <div>
                                            <a href="{{ route('website.project-detail', $project->slug) }}" class="btn-link">
                                                <img src="../../assets/frontend/images/Arrow.svg" alt="Arrow" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
        </div>
    </div>
@endif

@endsection