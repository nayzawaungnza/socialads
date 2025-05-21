<section class="related-articles">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="blog-suggested-content-header text-center text-white">Related Articles</h2>
            </div>
        </div>
        
        @if($relatedPosts && $relatedPosts->count() > 0)
            <div class="row">
                @foreach($relatedPosts as $post)
                <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                    <div class="blog-card standard">
                        <div class="blog-img">
                            <a href="{{ route('website.post-detail', $post->slug) }}">
                                <img src="{{ Storage::disk('public')->url($post->default_image->image_url) }}" alt="{{ $post->title }}">
                            </a>
                        </div>
                        <div class="blog-info">
                            <h3>
                                <a href="{{ route('website.post-detail', $post->slug) }}">{{ $post->name }}</a>
                            </h3>
                            <ul class="blog-metainfo">
                                <li>
                                    <i class="bx bx-calendar"></i>
                                    <a href="#">{{ $post->created_at->format('M d, Y') }}</a>
                                </li>
                                <li>
                                    <i class="bx bx-time"></i>
                                    {{ $post->reading_time }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="text-white mb-5">
                        No related articles found. Check out our latest posts instead!
                    </div>
                    <!-- Optional: You could add a link to your blog index here -->
                    <a href="{{ url('insights') }}" class="social-ads-project-category-btn">View All Articles</a>
                </div>
            </div>
        @endif
    </div>
</section>