@extends('layouts/frontend/master', ['activePage' => 'contact', 'page' => 'Contact Us'])
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
<div class="contact-section-title ptb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12 about-breadcrumb">
                        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact us</li>
                        </ol>
                        </nav>
                    </div>
                    
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="contact-content">
                            
                            <h2>Let’s Start Working Together.</h2>
                            <p>We’re here to help you grow with powerful marketing strategies, creative branding, and technology-driven solutions. Whether you have a question, need a consultation, or want to start a project, reach out to us!</p>
                        </div>
                        <div class="contact-info">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="contact-info-box">
                                        <i class="fi fi-tr-phone-call"></i>
                                        <h4><a href="tel:{{$settings->contact_phone}}">{{$settings->contact_phone}}</a></h4>
                                        <span>Phone</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="contact-info-box">
                                        <i class="fi fi-tr-envelope-dot"></i>
                                        <h4><a href="mailto:{{$settings->contact_email}}">{{$settings->contact_email}}</a></h4>
                                        <span>Email</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="content social-ads-social">
                                @if($settings->facebook_url || $settings->twitter_url || $settings->instagram_url || $settings->linkedin_url || $settings->youtube_url || $settings->whatsapp_url || $settings->tiktok_url || $settings->viber)
                                <ul>
                                    {{-- @if($settings->viber)
                                        <li><a href="{{$settings->viber}}" target="_blank"><i class='bx bxl-viber'></i></a></li>
                                    @endif --}}
                                    @if($settings->facebook_url)
                                        <li><a href="{{$settings->facebook_url}}" target="_blank"><i class='bx bxl-facebook'></i></a></li>
                                    @endif
                                    @if($settings->twitter_url)
                                        <li><a href="{{$settings->twitter_url}}" target="_blank">
                                            <!--<img class="social-icon" src="{{url('/assets/frontend/images/twitter-x.svg')}}">-->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
  <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
</svg>
                                            </a></li>
                                    @endif
                                    @if($settings->instagram_url)
                                        <li><a href="{{$settings->instagram_url}}" target="_blank"><i class='bx bxl-instagram'></i></a></li>
                                    @endif
                                    @if($settings->linkedin_url)
                                        <li><a href="{{$settings->linkedin_url}}" target="_blank"><i class='bx bxl-linkedin-square'></i></a></li>
                                    @endif
                                    @if($settings->youtube_url)
                                        <li><a href="{{$settings->youtube_url}}" target="_blank"><i class='bx bxl-youtube'></i></a></li>
                                    @endif
                                    @if($settings->whatsapp_url)
                                        <li><a href="{{$settings->whatsapp_url}}" target="_blank"><i class='bx bxl-whatsapp'></i></a></li>
                                    @endif
                                    {{-- @if($settings->tiktok_url)
                                        <li><a href="{{$settings->tiktok_url}}" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"></path></svg></a></li>
                                    @endif --}}

                                    
                                </ul>
                                @endif
                                
                            </div>
                            
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="widget-area">
                            @include('frontend.components.blog-widget')
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
 <div class="social-ads-response">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-8 col-md-8 col-12">
               <h3>What You Get When You Contact Us.</h3>
               <ul>
                   <li>Fast Response (Within 24 hours).</li>
                   <li>Tailored solutions for your brand’s growth.</li>
                   <li>Expert guidance from digital marketing specialists.</li>
                   <li>Personalized recommendations based on your business needs.</li>
               </ul>
                
            </div>
            <div class="col-lg-4 col-md-4 col-12 d-flex align-middle">
                
            </div>
            
        </div>
    </div>
</div>

<div class="social-ads-quotation">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-8 col-md-8 col-12">
                <h3 class="form-title">How can we help?</h3>
                @include('frontend.components.social-ads-form')
                
            </div>
            <div class="col-lg-4 col-md-4 col-12 d-flex align-middle">
                
            </div>
            
        </div>
    </div>
</div>

@endsection