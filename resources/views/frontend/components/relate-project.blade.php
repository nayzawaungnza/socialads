@if(!empty($projects))
<div class="recent-post-section pt-30 pb-30">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="social-ads-flex mb-5">
                    <h3 style="color: #e600ff;" class="social-labs-normal-title text-align-left aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">SEE MORE OF OUR WORK</h3>
                    
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
                                        <img src="../assets/frontend/images/Arrow.svg" alt="Image" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
        <div class="" style="text-align: center;">
            <a href="{{route('website.portfolio')}}" target="_blank" class="social-ads-secondary-btn"><span>Explore our other case studies</span></a>
        </div>
            
        </div>
    </div>
</div>

@endif