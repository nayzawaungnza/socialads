@extends('layouts/frontend/master', ['activePage' => 'portfolio', 'page' => 'Portfolio'])
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

<div class="" style="">
    <img src="{{Storage::disk('public')->url($page->default_image->image_url)}}" style="width:100%;" >
    <!--<div class="container">-->
    <!--    <div class="row">-->
    <!--        <div class="col-lg-12">-->
    <!--            <div class="banner-content">-->
    <!--                <h2>Portfolio</h2>-->
    <!--                <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">-->
    <!--                    <ol class="breadcrumb">-->
    <!--                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>-->
    <!--                        <li class="breadcrumb-item active" aria-current="page">Portfolio</li>-->
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
                <h3><span class="theme">Over 10 Million Impressions</span> Generated for Our Clients</h3>
                <h3>through <span class="theme1">Data-Driven Marketing & Creative Innovation</span></h3>
                <p>in just 200 days</p>
            </div>
        </div>
    </div>
</div>
 @if($projects->count())
    <div class="recent-post-section pt-50 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <button class="social-ads-project-category-btn active" data-filter="*"><span>All</span></button>
                    @if($categories->count())
                        @foreach($categories as $category)
                            <button class="social-ads-project-category-btn" data-filter=".{{$category->slug}}">
                                <span>{{$category->name}}</span>
                            </button>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="row project-list">
                @foreach($projects as $project)
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 project-item @foreach($project->categories as $category){{$category->slug}} @endforeach">
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
                                                <img src="./assets/frontend/images/Arrow.svg" alt="Arrow" />
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

<div class="social-ads-quotation">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-12 d-flex align-middle">
                <div class="">
                    <h3 class="quote-sub-title">Loved What You Saw?</h3>
                    <p></p>
                    <p></p>
                    <h1 class="quote-title">Let’s Build Something Great Together.</h1>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-12">
                @include('frontend.components.social-ads-form')
                
            </div>
        </div>
    </div>
</div>


<div class="social-ads-faq">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12 ">
                <h3 class="faq-title">Got Questions? We’ve Got Answers.</h3>
                <p class="text-center mb-2">Here’s everything you need to know before working with us. If you still have questions, feel free to reach out!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12 border faq-list faq-border">
                <h6>How long does a typical project take?</h6>
                <p>Every project is unique. Branding projects take 3-6 weeks, web development takes 6-12 weeks, and marketing campaigns vary based on goals. We provide a tailored timeline for each client.</p>
            </div>
            <div class="col-lg-6 col-md-6 col-12 border faq-list faq-border">
                <h6>What’s the process to start working with you?</h6>
                <ol>
                    <li>Contact us through our form.</li>
                    <li>Discovery call to discuss your goals.</li>
                    <li>Proposal & strategy plan tailored for you.</li>
                    <li>Execution & launch of your project.</li>
                </ol>
            </div>
            <div class="col-lg-6 col-md-6 col-12 border faq-list faq-border">
                <h6>Do you offer custom pricing?</h6>
                <p>Yes! We create custom packages based on your goals and budget. Let’s discuss your needs, and we’ll recommend the best solution for you.</p>
            </div>
            <div class="col-lg-6 col-md-6 col-12 border faq-list faq-border">
                <h6>Do you provide ongoing support after project completion?</h6>
                <p>Yes! We offer maintenance, optimization, and growth support for branding, web, and marketing projects.</p>
            </div>
            <div class="col-lg-6 col-md-6 col-12 border faq-list faq-border">
                <h6>What industries do you specialize in?</h6>
                <p>We work with e-commerce, startups, corporate brands, tech companies, and service-based businesses. No matter your industry, we craft a strategy that works.</p>
            </div>
            <div class="col-lg-6 col-md-6 col-12 border faq-list faq-border">
                <h6>Can I request a consultation before committing?</h6>
                <p>Absolutely! We offer a free 30-minute consultation to understand your needs and explore how we can help.</p>
            </div>
        </div>
    </div>
</div>
<div class="social-ads-question">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h3 class="question-title text-center">Still have questions? Let’s talk!</h3>
                <p class="text-center">At Social Ads, we’re more than just a digital agency. We’re your growth partner. We’re here to listen, understand, and create solutions that fit your brand’s unique needs.</p>
                
                <div class="social-flex">
                    <a class="contact-us-button" href="{{url('contact-us')}}" target="_blank">Contact Us</a>
                    <a class="free-consult-button" href="#" target="_blank">Schedulea Free Consultation</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection