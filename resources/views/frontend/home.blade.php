@extends('layouts/frontend/master', ['activePage' => 'home', 'page' => 'Home'])

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
   @if(!empty($sliders))
    <div class="swiper mySwiper">
        <!-- Swiper Wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <img src="{{ Storage::disk('public')->url($slider->default_image->image_url) }}" alt="image">
                </div>
            @endforeach
        </div>
        <!-- Custom Navigation Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        
    </div>
@endif
<section class="social-ads-home-bg">
<div class="identity-title-section">
    <div class="container">
    <div class="row">
        <div class="col-md-12 col-12">
            <h3 class="text-center social-labs-title aos-init aos-animate social-finger" data-aos="fade-down" data-aos-offset="100">Identify Your Digital Fingerprint</h3>
        </div>
    </div>
    </div>
</div>
<div class="digital-identify-section">
    
  <div class="container">
    
    <div class="row">
        <div class="col-lg-11 col-md-11 col-12 mx-auto">
            <div class="row">
       
                <div class="col-lg-7 col-md-7 col-12">
                
                    <div class="identity-container aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                        <!-- Overlay image -->
                        <img src="./assets/frontend/images/Glass_Tab_All.png" alt="Back Image" class="overlay-image">
            
                        <!-- Content -->
                        <div class="content">
                            <p>Every business has its unique digital fingerprint.</p>
                            <p>Let's discover yours and unlock your true potential in the digital landscape.</p>
                            <br>
                            <p>Where is Your Business Today?</p>
                            <ul class="business-types">
                                <li>a) New Business</li>
                                <li>b) Growing Business</li>
                                <li>c) Transforming Business</li>
                            </ul>
                        </div>
            
                    </div>
        
                </div>
                <div class="col-lg-5 col-md-5 col-12 d-flex justify-content-center align-items-center">
                    <div class="fingerprint aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                        <img src="./assets/frontend/images/fingerprint.png" alt="Finger Print" class="fingerprint-image">
                    </div>
                </div>
            </div>
            
        </div>
    </div>
  </div>
</div>


   
@if(!empty($services))
    <div class="features-section-social-ads pb-30 service-post-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="social-labs-title text-align-left mb-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">Services</h3>
                    </div>
                    @foreach($services as $service)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12 col-sm-12 aos-init aos-animate" data-aos="fade-up">
                <div class="blog-card">
                    <div class="blog-img">
                        <a target="_blank" href="{{route('website.service-detail', $service->slug)}}">
                            <img src="https://www.socialadsdigital.com/assets/frontend/images/Glass_Tab_Service_1.svg" alt="{{$service->name}}">
                        </a>
                        <div class="blog-metainfo">
                            
                            <div class="d-flex flex-nowrap w-full justify-content-between align-items-center">
                                    <h3>
                                        <a target="_blank" href="{{route('website.service-detail', $service->slug)}}">{{$service->name}}</a>
                                    </h3>
                                                                
                                <div>
                                   <img src="{{Storage::disk('public')->url($service->default_image->image_url)}}" alt="{{$service->name}}" class="img-fluid icon-image">
                                </div>
                            </div>
                            {!! $service->excerpt !!}
                        </div>
                    </div>
                </div>
            </div>
            
                    
                    @endforeach
                    

                    
                    
                    
                </div>
            </div>
        </div>
@endif
@if(!empty($projects))
<div class="recent-post-section pt-30 pb-30">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="social-ads-flex mb-5">
                    <h3 class="social-labs-title text-align-left aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">Our Recent Journey</h3>
                    <div class="">
                        <a href="{{route('website.portfolio')}}" target="_blank" class="social-ads-blog-btn"><span>See all projects</span> <i class="bx bx-right-arrow-alt"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        @foreach($projects as $project)
            <div class="col-xl-4 col-lg-4 col-md-6 col-12 col-sm-12 aos-init aos-animate" data-aos="fade-up">
                <div class="blog-card">
                    <div class="blog-img">
                        <a href="{{route('website.project-detail', $project->slug)}}">
                            <img
                                src="{{Storage::disk('public')->url($project->default_image->image_url)}}"
                                alt="{{$project->name}}"
                            />
                        </a>
                        <div class="blog-metainfo">
                            <h3>
                                <a href="{{route('website.project-detail', $project->slug)}}">{{$project->name}}</a>
                            </h3>
                            <div class="d-flex flex-nowrap w-full justify-content-between align-items-center">
                                @if($project->categories->count() > 0)
                                    <ul>
                                        @foreach($project->categories as $category)
                                            <li><a href="{{route('website.category-project', $category->slug)}}">{{$category->name}}</a></li>
                                        @endforeach
                                        
                                    </ul>
                                @endif
                                
                                <div>
                                    <a href="{{route('website.project-detail', $project->slug)}}" class="btn-link">
                                        <img src="./assets/frontend/images/Arrow.svg" alt="Image" />
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


@if(!empty($clients) && $clients->count() > 0)
<div class="clients-social-ads pt-50 pb-70">
    <div class="container">
        <div class="row">
             <div class="col-md-12">
                <h3 class="text-center social-labs-title mb-5">Our <span>Clients</span></h3>
            </div>
            <div class="col-12">
                <div class="swiper client-slider">
                    <div class="swiper-wrapper">
                        @foreach($clients as $client)
                            <div class="swiper-slide">
                                <div class="client-image">
                                    <a href="{{$client->url ?? '#'}}" target="_blank">
                                    @if(isset($client->default_image->image_url))
                                        <img src="{{ Storage::disk('public')->url($client->default_image->image_url) }}" 
                                             alt="{{ $client->name }}">
                                    @else
                                        <img src="{{ asset('default-client.png') }}" alt="Default Image">
                                    @endif
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif


  
<div class="social-ads-banner pt-50 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex flex-nowrap w-full justify-content-between align-items-center mb-1">
                    <div class="position-relative w-100 p-0">
                        <h3 class="social-labs-title position-relative text-align-left z-3">Partner with Social Ads to Make Your</h3>
                        <h3 class="social-labs-title position-relative text-align-left z-3">Brand Digital <span>Fingerprint</span> Stand Out</h3>
                        <img class="star_1 z-1" src="./assets/frontend/images/Star_1.png" alt="Image">
                    </div>
                    <div class="">
                        <img class="diamond_1" src="./assets/frontend/images/Diamond_1.png" alt="Image">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="social-ads-flex mb-1">
                    <h5 class="social-labs-speak text-align-left position-relative z-4">Let us Touch and Transform Your Digital Success Story</h5>
                    <div class="">
                        <a href="#" class="social-ads-blog-btn z-3"><span>Claim your free consultation</span> <i class="bx bx-right-arrow-alt" ></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

</section>