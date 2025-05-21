<div class="widget widget-post">
        <h3 class="widget-title">Recent Posts</h3>
        @foreach($posts as $post)
        <article class="item">
                                    <a href="{{ route('website.post-detail', $post->slug) }}" class="thumb">
                                        <span class="fullimage" style="background-image:url({{Storage::disk('public')->url($post->default_image->image_url)}});" role="img"></span>
                                    </a>
                                    <div class="info">
                                        <h4 class="title usmall"><a href="{{ route('website.post-detail', $post->slug) }}">{{ $post->name }}</a></h4>
                                        <ul class="meta">
                                            <li><i class="bx bx-calendar"></i> {{ $post->created_at->format('M d, Y') }}</li>
                                            
                                        </ul>
                                    </div>
        </article>
        @endforeach
</div>