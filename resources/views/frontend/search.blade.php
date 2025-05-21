@extends('layouts/frontend/master', ['activePage' => 'search', 'page' => "Search Results for '{$query}'"])

@section('content')

<div class="section-banner sbg-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class=" search-content">
                    <h4>Search Results for "{{ $query }}"</h4>
                    <a class="default-btn" href="{{url('/')}}"><span>Go Home</span> <i class="bx bx-home"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    @if ($projects->isEmpty() && $posts->isEmpty() && $services->isEmpty())
            <div class="alert alert-warning text-center">No results found.</div>
        @else
            <div class="row">
                @foreach (['project' => $projects, 'post' => $posts, 'service' => $services] as $type => $items)
                    @if(!$items->isEmpty())
                        <div class="col-lg-12">
                            <h3 class="mb-3 text-white">{{ ucfirst($type) }}</h3>
                        </div>
                        @foreach ($items as $item)
                            <div class="col-md-4 col-lg-3 col-12 mb-4">
                                <div class="card shadow-sm">
                                    <img src="{{ Storage::disk('public')->url($item->default_image->image_url) }}" class="card-img-top" alt="{{ $item->name ?? $item->name }}">
                                    <div class="card-body">
                                        <a class="search-detail" href="{{ route("website.{$type}-detail", ['slug' => $item->slug]) }}">
                                            <h5 class="card-title">{{ $item->name ?? $item->name }}</h5>
                                        </a>
                                        <p class="card-text">{{ Str::limit($item->description ?? $item->description, 100) }}</p>
                                        <a href="{{ route("website.{$type}-detail", ['slug' => $item->slug]) }}" class="social-ads-btn-1">Read More</a>
                                    </div>
                                </div>
                            </div>
                            
                        @endforeach
                    @endif
                @endforeach
            </div>
        @endif
</div>

@endsection
