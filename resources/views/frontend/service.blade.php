@extends('layouts/frontend/master', ['activePage' => 'services', 'page' => 'Service'])
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

<div class="" >
     <img src="{{Storage::disk('public')->url($page->default_image->image_url)}}" style="width:100%;" >
    <!--<div class="container">-->
    <!--    <div class="row">-->
    <!--        <div class="col-lg-12">-->
    <!--            <div class="banner-content">-->
    <!--                <h2>Services</h2>-->
    <!--                <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">-->
    <!--                    <ol class="breadcrumb">-->
    <!--                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>-->
    <!--                        <li class="breadcrumb-item active" aria-current="page">Services</li>-->
    <!--                    </ol>-->
    <!--                </nav>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
</div>

<div class="portfolio-louder">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-lg-8 col-12 col-md-auto col-lg-auto mx-auto">
                <h3 class="text-center">Simple solutions. <span class="theme">Real results.</span></h3>
                
            </div>
        </div>
    </div>
</div>

<div class="service-page-section">
    <div class="container">
        <div class="row">
            
            
            <div id="tabs">
              <ul>
                  @foreach($services as $service)
                  
                    <li class="col-md-4 col-lg-2 col-6">
                        <a href="#{{$service->slug}}">
                            <div class="icon">
                                <img src="{{Storage::disk('public')->url($service->default_image->image_url)}}" alt="{{$service->name}}" class="img-fluid icon-image">
                            </div>
                            <div class="service-title">
                                <p>{{$service->name}}</p>
                            </div>
                        </a>
                    </li>
                    @endforeach
                
              </ul>
                @foreach($services as $service)
                  
                    <div id="{{$service->slug}}" class="col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-md-7 col-lg-7 col-12">
                                <div class="position-relative p-0">
                                    <div class="service-feature-box">
                                        <img src="./assets/frontend/images/Glass_Tab_Service_Page.png" alt="Back Image" class="service-page-overlay-image">
                                        <div class="service-overlay-content">
                                            <div class="d-flex flex-nowrap w-full justify-content-between align-items-center mb-1 w-100">
                                                <div>
                                                    <a target="_blank" href="{{route('website.service-detail', $service->slug)}}">
                                                        <h4>{{$service->name}}</h4>
                                                    </a>
                                                </div>
                                            </div>
                                            {!! $service->description !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-5 col-lg-5 col-12 d-flex align-items-center justify-content-center">
                                <div class="position-relative w-100 custom-padding">
                                    <div class="service-feature-box-left">
                                        <img src="./assets/frontend/images/Glass_Tab_Service_Page_Finger.png" alt="Back Image" class="service-page-overlay-image-left">
                                        <div class="service-overlay-content-left">
                                            <p>FOCUS AREA</p>
                                            {!! $service->extra_focus !!}
                                            <a href="{{route('website.service-detail', $service->slug)}}" class="social-ads-service-detail-btn" target="_blank">
                                                Learn More <i class="bx bx-right-arrow-alt"></i></a>
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
</div>
<div class="social-ads-process">
    <img src="./assets/frontend/images/Social_Ads_Services_Page_Our_Process.png" alt="Social Ads Process" class="w-100">
</div>
<div class="social-ads-question">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h3 class="question-title text-center">Let’s Build Something Amazing Together</h3>
                <p class="text-center">At Social Ads, we’re more than just a digital agency. We’re your growth partner.We’re here to listen, understand, and create solutions that fit your brand’s unique needs.</p>
                
                <div class="social-flex">
                    <a class="contact-us-button" href="" target="_blank">Start a Project</a>
                    <a class="free-consult-button" href="" target="_blank">ClaimYour FreeConsultation</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div class="identity-post-section">-->
<!--<div class="container">-->
<!--    <div class="row">-->
<!--        <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-12 aos-init aos-animate" data-aos="fade-up">-->
<!--                <div class="blog-card">-->
<!--                    <div class="blog-img">-->
                        
<!--                            <img src="https://www.socialadsdigital.com/assets/frontend/images/Glass_Tab_All.png" alt="Mobile Devices Care Service">-->
                        
<!--                        <div class="blog-metainfo">-->
                            
<!--                            <p>Every business has its unique digital fingerprint.</p>-->
<!--                            <p>Let's discover yours and unlock your true potential in the digital landscape.</p>-->
<!--                            <br>-->
<!--                            <p>Where is Your Business Today?</p>-->
<!--                            <ul class="business-types">-->
<!--                                <li>a) New Business</li>-->
<!--                                <li>b) Growing Business</li>-->
<!--                                <li>c) Transforming Business</li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--    </div>-->
<!--</div>-->
<!--</div>-->
@endsection