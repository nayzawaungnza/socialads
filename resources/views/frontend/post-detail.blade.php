@extends('layouts/frontend/master', ['activePage' => 'insights', 'page' => 'Insights'])
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

<div class="blog-section-banner">
            <div class="container">
                <div class="blog-title-shape">
                    <h2>{{$post->name}}</h2>
                    <ul>
                        <li>{{ $post->created_at->format('M d, Y') }}</li>
                        
                        <li>{{ $post->createdBy?->name}}</li>
                    </ul>
                </div>
            </div>
        </div>
        
<div class="blog-standard-section ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-12">
                        <div class="blog-details-dec">
                            {!! $post->description !!}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="widget-area">
                           
                           @include('frontend.search-widget')
                           
                            @include('frontend.components.category-widget')
                            

                            

                            
                            
                        </div>
                    </div>
                </div>
            </div>
            @include('frontend.components.related-articles')
</div>
@endsection