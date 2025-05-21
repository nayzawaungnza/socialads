@extends('layouts/frontend/master', ['activePage' => 'insights', 'page' => 'Insights'])
@section('seometa')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
   
@endsection
@section('content')

<div class="">
    <img src="{{Storage::disk('public')->url($page->default_image->image_url)}}" style="width:100%;" >
    <!--<div class="container">-->
    <!--    <div class="row">-->
    <!--        <div class="col-lg-12">-->
    <!--            <div class="banner-content">-->
    <!--                <h2>Insights</h2>-->
    <!--                <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">-->
    <!--                    <ol class="breadcrumb">-->
    <!--                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>-->
    <!--                        <li class="breadcrumb-item active" aria-current="page">Insights</li>-->
    <!--                    </ol>-->
    <!--                </nav>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
</div>

<div class="blog-banner text-primary py-4 py-xl-5">
    <div class="container-fluid px-4 px-md-5 px-lg-5 px-xl-5 max-width-container mx-auto">
        <div class="row justify-content-center align-items-stretch gx-4 gy-4">
            <!-- Main Blog Post -->
            @if($recent_posts->isNotEmpty())
                @php $post = $recent_posts->first(); @endphp
                <div class="col-12 col-lg-7">
                    <div class="card social-ads-feature  border-0 bg-light-green overflow-hidden">
                        <a href="{{ route('website.post-detail', $post->slug) }}" class="text-decoration-none">
                            <img src="{{ Storage::disk('public')->url(Str::replaceLast('.', '_medium.', $post->default_image->image_url)) }}" 
                                 alt="{{ $post->title }}" 
                                 class="card-img-top img-fluid"
                                 style="aspect-ratio: 16/9; object-fit: cover;">
                        </a>
                        <div class="card-body p-4 social-ads-feature ">
                            <a href="{{ route('website.post-detail', $post->slug) }}" class="text-decoration-none">
                                <h2 class="card-title fs-3 text-dark mt-3 mb-3 hover-underline">
                                    {{ $post->name }}
                                </h2>
                                <div class="card-text fs-sm text-dark line-clamp-3 mb-3 social-ads-black">
                                    @if($post->excerpt)
                                        {!! Str::limit($post->excerpt, 150) !!}
                                    @else
                                        {!! Str::limit($post->description, 150) !!}
                                    @endif
                                </div>
                                <p class="fs-sm text-muted">{{ $post->created_at->format('d/m/Y') }}</p>
                            </a>
                        </div>
                    </div>
                </div>
            @endif


            <!-- Featured Posts -->
            <div class="col-12 col-lg-5">
                <h3 class="fs-4 fw-semibold text-white">Featured Posts</h3>
                <hr class="bg-teal my-2" style="height: 4px; width: 100%;">
                
                <div class="featured-posts">
                     @if($features->isNotEmpty())
                        @foreach($posts as $post)
                            <div class="border-bottom py-3">
                                <a href="{{ route('website.post-detail', $post->slug) }}" 
                                   class="text-white fw-semibold line-clamp-2 mb-2 d-block hover-underline">
                                    {{ $post->name }}
                                </a>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span 
                                       class="tag text-white fs-sm px-2 py-1 hover-bg-gray">
                                        {{$post->createdBy?->name}}
                                    </span>
                                    <span class="fs-sm text-gray">{{ $post->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                     @endif
                     
                    


                </div>
            </div>
        </div>
    </div>
</div>

<div id="blog_three_column_01" class="container blog-three-column py-4">
    <div class="d-flex align-items-end mb-4 pb-3 border-bottom border-2 border-teal">
        <h2 class="fs-4 fw-semibold text-white m-0">Latest</h2>
        <a href="#" 
           class="ms-auto d-flex align-items-center text-white fw-semibold hover-underline text-decoration-none">
            <span>View More</span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="ms-1">
                <path d="M13.172 12L8.222 7.04999L9.636 5.63599L16 12L9.636 18.364L8.222 16.949L13.172 11.999L13.172 12Z" fill="#ffffff"/>
            </svg>
        </a>
    </div>

    <div class="row g-4">
        @foreach($posts->take(3) as $post)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 overflow-hidden">
                    <a href="{{ route('website.post-detail', $post->slug) }}" class="text-decoration-none">
                        <img src="{{ Storage::disk('public')->url($post->default_image->image_url) }}" 
                             alt="{{ $post->title }}" 
                             class="card-img-top img-fluid rounded"
                             style="aspect-ratio: 16/9; object-fit: cover;">
                    </a>
                    <div class="card-body py-2 px-2">
                        <a href="{{ route('website.post-detail', $post->slug) }}" class="text-decoration-none">
                            <h3 class="fs-5 text-dark fw-semibold line-clamp-2 my-3 hover-underline">
                                {{ $post->name }}
                            </h3>
                            <div class="fs-sm social-ads-black line-clamp-3 mb-3">
                                @if($post->excerpt)
                                    {!! Str::limit($post->excerpt, 150) !!}
                                @else
                                    {!! Str::limit($post->description, 150) !!}
                                @endif
                            </div>
                            <p class="fs-sm text-muted mb-0">{{ $post->created_at->format('d/m/Y') }}</p>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        

        
    </div>
</div>

<div class="topic container py-4 overflow-hidden">
    <div class="text-center mb-4 px-4">
        <h2 class="fs-3 fw-semibold social-ads-white mb-2">Explore More Topics</h2>
        <p class="blog-learning-paths-description">Ready to brush up on something new? We've got more to read right this way.</p>
    </div>

    <div class="row justify-content-center g-3 g-md-4">
        @foreach($topics as $postCategory)
            <div class="col-12 col-md-4">
                <a href="{{ route('website.category-post', $postCategory->slug) }}" 
                   class="card h-100 text-secondary text-decoration-none bg-light shadow-md hover-shadow-lg">
                    <div class="overflow-hidden rounded-top">
                        <img src="{{ Storage::disk('public')->url($postCategory->default_image->image_url) }}" alt="{{ $postCategory->title }}" class="img-fluid w-100 topic-image">
                        
                    </div>
                    <div class="card-body py-1 py-md-1 text-center d-flex align-items-center justify-content-center">
                        <div class="d-flex align-items-center">
                            <p class="social-ads-black fs-5 fw-semibold mb-0 capitalize hover-underline">{{ $postCategory->name }}</p>
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" 
                                 class="ms-2 text-xl" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 17.707L16.414 12 10.707 6.293 9.293 7.707 13.586 12 9.293 16.293z"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
        <!-- Topic 1 -->
        

        

        
    </div>
</div>

<style>
    
</style>


@endsection