@extends('layouts/frontend/master', ['activePage' => 'notfound', 'page' => 'Page Not Found'])

@section('content')

<div class="error-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="error-content">
                            <h2>4<span>0</span>4</h2>
                            <h4>Page is not Found!!</h4>
                            <a class="default-btn" href="{{url('/')}}"><span>Go Home</span> <i class="bx bx-home"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection