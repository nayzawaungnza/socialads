@extends('layouts/frontend/master')

@section('content')


<section class="breadcrumb py-120 bg-main-25 position-relative z-1 overflow-hidden mb-0">
    <img src="assets/images/shapes/shape1.png" alt="" class="shape one animation-rotation d-md-block d-none">
    <img src="assets/images/shapes/shape2.png" alt="" class="shape two animation-scalation d-md-block d-none">
    <img src="assets/images/shapes/shape3.png" alt="" class="shape eight animation-walking d-md-block d-none">
    <img src="assets/images/shapes/shape5.png" alt="" class="shape six animation-walking d-md-block d-none">
    <img src="assets/images/shapes/shape4.png" alt="" class="shape four animation-scalation">
    <img src="assets/images/shapes/shape4.png" alt="" class="shape nine animation-scalation">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb__wrapper">
                    <h1 class="breadcrumb__title display-4 fw-semibold text-center"> Sign In</h1>
                    <ul class="breadcrumb__list d-flex align-items-center justify-content-center gap-4">
                        <li class="breadcrumb__item">
                            <a href="index.html" class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium"> 
                                <i class="text-lg d-inline-flex ph-bold ph-house"></i> Home</a>
                         </li>
                        <li class="breadcrumb__item">
                            <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                        </li>
                        <li class="breadcrumb__item">
                            <a href="course.html" class="breadcrumb__link text-neutral-500 hover-text-main-600 fw-medium"> </a> 
                        </li>
                        <li class="breadcrumb__item d-none">
                            <i class="text-neutral-500 d-flex ph-bold ph-caret-right"></i>
                        </li>
                        <li class="breadcrumb__item"> 
                            <span class="text-main-two-600"> Sign In </span> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="account py-120 position-relative">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-lg-6">
                    <div class="bg-main-25 border border-neutral-30 rounded-8 p-32">
                        <div class="mb-40">
                            <h3 class="mb-16 text-neutral-500">Welcome Back!</h3>
                            <p class="text-neutral-500">Sign in to your account and join us</p>
                        </div>
                        <form action="{{ $url ?? route('frontend.postlogin')}}">
                            @csrf
                            <div class="mb-24">
                                <label for="email" class="fw-medium text-lg text-neutral-500 mb-16">Enter Your Email ID</label>
                                <input type="email" class="common-input rounded-pill" id="email" placeholder="Enter Your Email...">
                            </div>
                            <div class="mb-16">
                                <label for="password" class="fw-medium text-lg text-neutral-500 mb-16">Enter Your Password</label>
                                <div class="position-relative">
                                    <input type="password" class="common-input rounded-pill" id="password" placeholder="Enter Your Password...">
                                    <span class="toggle-password position-absolute top-50 inset-inline-end-0 me-16 translate-middle-y ph-bold ph-eye-closed" id="#password"></span>
                                </div>
                            </div>
                            <div class="mb-16 text-end">
                                <a href="javascript:void(0)" class="text-warning-600 hover-text-decoration-underline">Forget password</a>
                            </div>
                            <div class="mb-16">
                                <p class="text-neutral-500">Don't have an account? 
                                    <a href="{{route('frontend.register')}}" class="fw-semibold text-main-600 hover-text-decoration-underline">Sign Up</a> 
                                </p>
                            </div>
                            <div class="mt-40">
                                <button type="submit" class="btn btn-main rounded-pill flex-center gap-8 mt-40">
                                    Sign In
                                    <i class="ph-bold ph-arrow-up-right d-flex text-lg"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-block d-none">
                    <div class="account-img">
                        <img src="assets/images/thumbs/account-img.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
   
  
@endsection