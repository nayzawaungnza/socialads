@extends('layouts/frontend/master', ['activePage' => 'services', 'page' => 'Service Detail'])
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
    <img src="{{Storage::disk('public')->url($service->default_banner?->image_url)}}" style="width:100%;" >
    <!--<div class="container">-->
    <!--    <div class="row">-->
    <!--        <div class="col-lg-12">-->
    <!--            <div class="banner-content service-sub-title">-->
    <!--                {!! $service->sub_title !!}-->
                    
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
</div>
<section class="services-details-area ">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-lg-9 mx-auto col-12">
                        <div class="services-sub-description pbt-20 text-center aos-init aos-animate" data-aos="fade-up" data-aos-offset="100">
                            {!! $service->sub_description !!}
                            <a href="#" class="service-button"><span>Get a Proposal</span><i class="bx bx-right-arrow-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container pbt-20">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-12">
                        <div class="services-brand-content pbt-20 aos-init aos-animate" data-aos="fade-up" data-aos-offset="100">
                            <h4>{{$service->brand_title}}</h4>
                            {!! $service->brand_description !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="container pbt-20">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-12 services-business-title">
                        <h4>{{$service->business_title}}</h4>
                    </div>
                    <div class="col-md-6 col-lg-6 col-12 d-flex align-items-center justify-content-center mx-auto">
                                <div class="position-relative w-100 custom-padding">
                                    <div class="service-feature-box-left">
                                        <img src="../assets/frontend/images/Glass_Tab_Service_Page_Finger.png" alt="Back Image" class="service-page-overlay-image-left">
                                        <div class="service-overlay-content-left">
                                            
                                            {!! $service->extra_focus !!}
                                            <a href="{{route('website.service-detail', $service->slug)}}" class="social-ads-service-detail-btn" target="_blank">
                                                Get In Touch <i class="bx bx-right-arrow-alt"></i></a>
                                        </div>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
            
            <div class="container pbt-20">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-12 services-personalization-title">
                        <h4>{{$service->personalization_title}}</h4>
                    </div>
                    <div class="col-md-6 col-lg-6 col-12 d-flex align-items-center justify-content-center">
                        <img src="../assets/frontend/images/Personalization-Image-min.png" class="personal-img">
                    </div>
                    <div class="col-md-6 col-lg-6 col-12 ">
                                <div class="personalizaiton-content">
                                    {!! $service->personalization_description !!}
                                 </div>
                    </div>
                </div>
            </div>
</section>

@include('frontend.components.client-success-stories')
@include('frontend.components.faqs')
@include('frontend.components.build-scale')
        
@endsection