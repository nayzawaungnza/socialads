@extends('layouts/frontend/master', ['activePage' => 'about', 'page' => 'About Us'])
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
<div class="about-section ptb-40">
            <div class="container pb-40">
                <div class="row ">
                    <div class="col-md-12 about-breadcrumb">
                        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">About us</li>
                        </ol>
                        </nav>
                    </div>
                    
                    <div class="col-lg-6 col-md-6">
                        <div class="about-content aos-init aos-animate" data-aos="fade-up" data-aos-offset="100">
                            
                            <h2>About Us</h2>
                            {!! $page->description !!}

                           
                            <a class="about-default-btn" href="#"> Get In Touch</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="about-wrap aos-init aos-animate" data-aos="fade-zoom-in" data-aos-offset="100">
                            <div class="about-image-wrap">
                                <img src="{{url('assets/frontend/images/about_1.png')}}" style="width:100%;" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="container ptb-30">
                <div class="row ">
                    <div class="col-lg-6 col-md-6">
                        <div class="about-wrap aos-init aos-animate" data-aos="fade-zoom-in" data-aos-offset="100">
                            <div class="about-image-wrap">
                                <img src="{{url('assets/frontend/images/about_2.png')}}" style="width:100%;" >
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="about-content aos-init aos-animate" data-aos="fade-up" data-aos-offset="100">
                            <div class="mission-vision">
                                <h3>OUR MISSION</h3>
                                <p>“To become an agency that provides simple, accessible, and trustworthy digital solutions to create unique and successful businesses.”</p>
                            </div>
                            <div class="mission-vision">
                                <h3>OUR VISION</h3>
                                <p>“To empower every business touched by Social Ads to shine without boundaries through the radiant light of Social Ads’ digital expertise.”</p>
                            </div>
                            

                           
                            
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="container ptb-30">
                <div class="row ">
                    <div class="col-lg-6 col-md-6">
                        <div class="about-content-story aos-init aos-animate" data-aos="fade-up" data-aos-offset="100">
                                <h3>OUR Story</h3>
                                <p>Just as every fingerprint is unique, every brand has its own identity. At Social Ads Digital Agency, we embrace this uniqueness, crafting tailored digital strategies that amplify brand value. Our fingerprint-inspired approach reflects our commitment to strategic solutions, creativity, and measurable success—helping businesses grow, transform, and leave a lasting impact in the digital world.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="about-wrap aos-init aos-animate" data-aos="fade-zoom-in" data-aos-offset="100">
                            <div class="about-image-wrap">
                                <img src="{{url('assets/frontend/images/about_3.png')}}" style="width:100%;" >
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            
</div>
        
        <div class="process-wrap ptb-30">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-md-12">
                        <div class="process-content process-we-do aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                            <h3 class="text-center">What We Do</h3>
                            <p class="what0">We specialize in:</p>
                            
                            <div class="process-item-wrap">
                                <div class="process-item">
                                    <span>
                                        <img class="what-we-do-image" src="{{url('assets/frontend/images/Digital Marketing-min.png')}}">
                                    </span>
                                    <div class="process-info what-we-do-info">
                                        <p><b>Digital Marketing Services</b> – SEO, PPC, social media marketing, and content strategies to boost brand visibility and conversions.</p>
                                    </div>
                                </div>
                                <div class="process-item">
                                    <span>
                                        <img class="what-we-do-image" src="{{url('assets/frontend/images/Branding-min.png')}}">
                                    </span>
                                    <div class="process-info what-we-do-info">
                                        <p><b>Branding & Creative Design</b> – Crafting strong, strategic, and memorable brand identities.</p>
                                    </div>
                                </div>
                                <div class="process-item">
                                    <span>
                                        <img class="what-we-do-image" src="{{url('assets/frontend/images/Web&App Development-min.png')}}">
                                    </span>
                                    <div class="process-info what-we-do-info">
                                        <p><b>Web & App Development</b> – Creating high-performing, mobile-friendly, and user-centric digital experiences.</p>
                                    </div>
                                </div>
                                <div class="process-item ">
                                    <span>
                                        <img class="what-we-do-image" src="{{url('assets/frontend/images/ecommerce solution-min.png')}}">
                                    </span>
                                    <div class="process-info what-we-do-info">
                                        <p><b>E-Commerce Solutions</b> – Building optimized online stores and implementing growth strategies.</p>
                                    </div>
                                </div>
                                <div class="process-item">
                                    <span>
                                        <img class="what-we-do-image" src="{{url('assets/frontend/images/Integrated Marketing Campaign-min.png')}}" >
                                    </span>
                                    <div class="process-info what-we-do-info">
                                        <p><b>Integrated Marketing & Performance Tracking</b> – Data-backed strategies to drive measurable results and optimize performance.</p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-12">
                        <h2 class="why-title text-center">Why Us</h2>
                    </div>
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="process-content aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                            
                            <div class="process-item-wrap">
                                <div class="process-item">
                                    <span>
                                        <img class="why-us-image" src="{{url('assets/frontend/images/about_why_us_1.png')}}" >
                                    </span>
                                    <div class="process-info">
                                        <h4>SEO-Optimized Digital Strategies</h4>
                                        <p>We implement data-driven techniques to ensure your brand ranks high on search engines.</p>
                                    </div>
                                </div>
                                <div class="process-item">
                                    <span>
                                        <img class="why-us-image" src="{{url('assets/frontend/images/about_why_us_2.png')}}" >
                                    </span>
                                    <div class="process-info">
                                        <h4>Creative & Tech-Driven Approach</h4>
                                        <p>A perfect blend of creativity, strategy, and innovation.</p>
                                    </div>
                                </div>
                                <div class="process-item">
                                    <span>
                                        <img class="why-us-image" src="{{url('assets/frontend/images/about_why_us_3.png')}}" >
                                    </span>
                                    <div class="process-info">
                                        <h4>Client-Centric Collaboration</h4>
                                        <p>We work alongside you, treating your brand’s success as our priority.</p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="container ptb-40">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <h2 class="core-title">OUR CORE VALUES</h2>
                        <img class="core-image" src="{{url('assets/frontend/images/about_core_value.png')}}" >
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="process-content aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                            
                            <div class="process-item-wrap">
                                <div class="process-item">
                                    <div class="process-info">
                                        <h4>Results-Driven Approach</h4>
                                        <p>Focused on achieving measurable business growth.</p>
                                    </div>
                                </div>
                                <div class="process-item">
                                   
                                    <div class="process-info">
                                        <h4>Professional Excellence</h4>
                                        <p>Delivering high-quality, strategic solutions with precision expertise.</p>
                                    </div>
                                </div>
                                <div class="process-item">
                                   
                                    <div class="process-info">
                                        <h4>Empathy & Collaboration</h4>
                                        <p>We work as an extension of your team, ensuring brand success.</p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="container ptb-40">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-8 col-12 offset-lg-2 offset-md-2">
                        <p class="text-center whois">We’re always open to working with businesses, brands, and professionals who are looking for trusted digital partners.</p>
                        <div class="whois-group text-center">
                            <span class="whois-icon-left">
                                 <img class="icon-image" src="{{url('assets/frontend/images/Arrow_Right.png')}}" >
                            </span>
                            
                            <span class="whois-center">
                                <button class="whois-btn">
                                Let’s build success together!
                                </button>
                            </span>
                            <span class="whois-icon-right">
                                <img class="icon-image" src="{{url('assets/frontend/images/Arrow_Left.png')}}" >
                            </span>
                        
                        </div>
                        
                    </div>
                    
                    
                </div>
            </div>
            
        </div>
        @include('frontend.components.about-us-scale')
@endsection