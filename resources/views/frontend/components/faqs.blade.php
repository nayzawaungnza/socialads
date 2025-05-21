@if(!empty($service->faqs))
<div class="recent-post-section pt-30 pb-30">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="social-ads-flex text-center">
                    <h3 style="color: #e600ff;" class="social-labs-normal-title  aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">FREQUENTLY ASKED QUESTIONS (FAQS)</h3>
                    
                </div>
            </div>
        </div>
        <div class="row">
            
        @foreach($service->faqs as $faq)
            <div class="col-md-12">
                <div class="faq-wrap">
                    <h4>{{$faq->question}}</h4>
                    {!! $faq->answer !!}
                </div>
            </div>
        @endforeach
        
        <div class="" style="text-align: center;">
            <a href="{{route('website.portfolio')}}" target="_blank" class="social-ads-secondary-btn"><span>See more of our success stories</span></a>
        </div>
            
        </div>
    </div>
</div>

@endif