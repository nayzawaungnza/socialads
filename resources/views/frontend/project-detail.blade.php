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

<div class="">
    <img src="../assets/frontend/images/Case Study Slider.png" style="width:100%;" >
    <!--<div class="container">-->
    <!--    <div class="row">-->
    <!--        <div class="col-lg-12">-->
    <!--            <div class="banner-content">-->
    <!--                <h2>{{$project->name}}</h2>-->
    <!--                <nav style="--bs-breadcrumb-divider: '|';" aria-label="breadcrumb">-->
    <!--                    <ol class="breadcrumb">-->
    <!--                        @foreach($project->categories as $category)-->
    <!--                            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('website.category-project', $category->slug)}}">{{$category->name}}</a></li>-->
    <!--                        @endforeach-->
                            
    <!--                    </ol>-->
    <!--                </nav>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
</div>
 
    <div class="recent-post-section pt-50 pb-30">
        <div class="container">
            <div class="row">
               <div class="col-md-8">
                   <h4 class="project-overview">PROJECT OVERVIEW</h4>
                   <h6 class="project-meta">Client : {{$project->client?->name}}</h6>
                   <h6 class="project-meta">Industry : {{$project->industry}}</h6>
                   <div class="project-content">
                       {!! $project->description!!}
                   </div>
               </div>
               <div class="col-md-4">
                   <img src="{{ Storage::disk('public')->url($project->default_image->image_url) }}"
                                         alt="{{ $project->name }}" />
               </div>
            </div>
            
        </div>
        <div class="container">
            <div class="row">
               <div class="col-md-8">
                   <h4 class="project-overview">THE GOAL</h4>
                   
                   <div class="project-content">
                       {!! $project->goal !!}
                   </div>
               </div>
               <div class="col-md-4">
                   
               </div>
            </div>
            
        </div>
        
        <div class="container">
            <div class="row">
               <div class="col-md-8">
                   <h4 class="project-overview">OUR STRATEGY & EXECUTION</h4>
                   
                   <div class="project-content">
                       {!! $project->strategy !!}
                   </div>
               </div>
               <div class="col-md-4">
                   
               </div>
            </div>
            
        </div>
        
        <div class="container">
            <div class="row">
               <div class="col-md-8">
                   <h4 class="project-overview">THE RESULTS</h4>
                   
                   <div class="project-content">
                       {!! $project->result !!}
                   </div>
               </div>
               <div class="col-md-4">
                   
               </div>
            </div>
            
        </div>
    </div>
@include('frontend.components.relate-project')
@include('frontend.components.grow-up-business')



@endsection