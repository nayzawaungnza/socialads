@extends('layouts/master', ['activePage' => 'seo.show', 'titlePage' => __('SEO Detail')])


@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{ url('/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-user-view.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
 <script src="{{ url('/assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{ url('/assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">SEO /</span> Details
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>SEO Metadata Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Page Type:</strong> {{ ucfirst($seo->page_type) }}</p>
                            <p><strong>Page ID:</strong> {{ $seo->page_name }}</p>
                            <p><strong>Title:</strong> {{ $seo->title }}</p>
                            <p><strong>Description:</strong> {{ $seo->description }}</p>
                        </div>
                        <div class="col-md-6">
                            @if($seo->image)
                            <p><strong>Image:</strong></p>
                            <img src="{{ asset('storage/'.$seo->image) }}" alt="SEO Image" style="max-width: 200px;">
                            @endif
                            <p><strong>Robots:</strong> {{ $seo->robots }}</p>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mt-4">Open Graph Data</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Title:</strong> {{ $seo->open_graph['title'] ?? 'N/A' }}</p>
                            <p><strong>Description:</strong> {{ $seo->open_graph['description'] ?? 'N/A' }}</p>
                            <p><strong>URL:</strong> {{ $seo->open_graph['url'] ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            @if(isset($seo->open_graph['image']))
                            <p><strong>Image:</strong></p>
                            <img src="{{ asset('storage/'.$seo->open_graph['image']) }}" alt="Open Graph Image" style="max-width: 200px;">
                            @endif
                        </div>
                    </div>

                    <hr>

                    <h5 class="mt-4">Twitter Data</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Title:</strong> {{ $seo->twitter['title'] ?? 'N/A' }}</p>
                            <p><strong>Description:</strong> {{ $seo->twitter['description'] ?? 'N/A' }}</p>
                            <p><strong>URL:</strong> {{ $seo->twitter['url'] ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            @if(isset($seo->twitter['image']))
                            <p><strong>Image:</strong></p>
                            <img src="{{ asset('storage/'.$seo->twitter['image']) }}" alt="Twitter Image" style="max-width: 200px;">
                            @endif
                        </div>
                    </div>

                    <hr>

                    <h5 class="mt-4">Structured Data</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Schema:</strong> {{ $seo->structured_data['schema'] ?? 'N/A' }}</p>
                            @if(isset($seo->structured_data['image']))
                            <p><strong>Image:</strong></p>
                            <img src="{{ asset('storage/'.$seo->structured_data['image']) }}" alt="Structured Data Image" style="max-width: 200px;">
                            @endif
                        </div>
                    </div>

                    <hr>

                    <h5 class="mt-4">Alternate Links</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>URL:</strong> {{ $seo->alternate_links['url'] ?? 'N/A' }}</p>
                            <p><strong>Language:</strong> {{ $seo->alternate_links['lang'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('seo.edit', $seo->id) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('seo.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
