                        <div class="widget widget-categories">
                                <h3 class="widget-title">Categories</h3>
                                <div class="post-categories">
                                    <ul>
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="{{ route('website.category-post', $category->slug) }}">
                                                    <i class="bx bxs-square"></i> {{ $category->name }}
                                                </a>
                                                <span>({{ $category->posts_count }})</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>