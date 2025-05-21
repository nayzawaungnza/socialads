@extends('layouts/master', ['activePage' => 'services.edit', 'titlePage' => __('Edit Service')])


@section('vendor-style')
<!-- Vendors CSS -->
   <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

   
@endsection
@section('page-style')

 
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css">
    @endsection

@section('vendor-script')
<!-- Vendors JS -->
    <script src="{{ url('/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/tagify/tagify.js') }}"></script>
    

@endsection

@section('page-script')
<!-- Page JS -->
    <script src="{{ url('/assets/js/form-layouts.js') }}"></script>
<script type="importmap">
			{
				"imports": {
					"ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.js",
					"ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.2.0/"
				}
			}
</script>
<script type="module">
import {
    ClassicEditor,
    Heading,
    Essentials,
    Paragraph,
    Bold,
    Italic,
    Font,
    List,
    Alignment,
    Underline,
    Strikethrough,
    Link,
    BlockQuote
} from 'ckeditor5';
document.querySelectorAll('.editor').forEach(element => {
ClassicEditor
    .create(element, {
        plugins: [
            Heading, Essentials, Paragraph, Bold, Italic, Font, List, Alignment,
            Underline, Strikethrough, Link, BlockQuote
        ],
        toolbar: [
            'heading', '|',
            'undo', 'redo', '|', 
            'bold', 'italic', 'underline', 'strikethrough', '|',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
            'alignment', '|', 
            'numberedList', 'bulletedList', '|',
            'link', 'blockQuote'
        ]
    })
    .then(editor => {
        editor.ui.view.editable.element.style.height = '300px';
        window.editor = editor;
    })
    .catch(error => {
        console.error(error);
    });
});
    
</script>
    
@endsection

@section('content')
 
    <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Service /</span> Update
            </h4>
        
           <div class="card mb-4">
                @isset($url)
                    <form  class="card-body" method="POST" action="{{$url}}" enctype="multipart/form-data" >
                @else
                  <form  class="card-body" method="POST" action="{{url('/admin/services/'.$service->id.'')}}" enctype="multipart/form-data" >
                @endisset
                  @csrf
                  @method('PUT')
                  
                
                  <div class="row g-3">
                    <div class="col-md-12">
                      <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                      <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Post Name" />
                      @error('name')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>
                    <div>
                      <label class="form-label" for="editor">Description</label>
                      <textarea id="editor" name="description" style="height: 300px; width: 100%;" class="editor form-control" placeholder="Enter Description">{{ old('description', $service->description) }}</textarea>

                    </div>
                    
                  </div>
                  
                  <hr class="my-4 mx-n4" />
                  <div class="row g-3">
                      
                      <div class="col-md-6">
                          <label class="form-label" for="basic-banner-upload-file">Service Banner</label>
                          <input type="file" name="banner_image" class="form-control @error('banner_image') is-invalid @enderror" id="basic-banner-upload-file">
                          @error('banner_image')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                        <div class="mt-3">
                            <img id="bannerimagePreview" 
                                src="{{ isset($service) && $service->default_banner ? asset('storage/' . $service->default_banner->image_url)  : asset('assets/img/backgrounds/5.jpg') }}" 
                                alt="Preview Image" 
                                style="max-width: 100%; height: auto; border-radius: 8px;">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                          <label class="form-label" for="basic-default-upload-file">Service pic</label>
                          <input type="file" name="default_image" class="form-control @error('default_image') is-invalid @enderror" id="basic-default-upload-file">
                          @error('default_image')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                        <div class="mt-3">
                            <img id="imagePreview" 
                                src="{{ isset($service) && $service->default_image ? asset('storage/' . $service->default_image->image_url)  : asset('assets/img/backgrounds/5.jpg') }}" 
                                alt="Preview Image" 
                                style="max-width: 100%; height: auto; border-radius: 8px;">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="excerpt">Excerpt</label>
                      <textarea id="excerpt" name="excerpt" class="editor form-control @error('excerpt') is-invalid @enderror" placeholder="enter excerpt">{{ old('excerpt', $service->excerpt) }}</textarea>
                      @error('excerpt')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="extra_focus">Focus Areas</label>
                      <textarea id="extra_focus"  name="extra_focus" class="editor form-control @error('extra_focus') is-invalid @enderror" placeholder="enter focus areas">{{ old('extra_focus', $service->extra_focus) }}</textarea>
                      @error('extra_focus')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                  </div>
                  
                  <hr class="my-4 mx-n4" />
                    <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label" for="editor_1">Sub Title</label>
                          <textarea id="editor_1" name="sub_title" style="height: 300px; width: 100%;" class="editor form-control" placeholder="Enter sub title">{{ old('sub_title', $service->sub_title) }}</textarea>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="editor_2">Sub Description</label>
                          <textarea id="editor_2" name="sub_description" style="height: 300px; width: 100%;" class="editor form-control" placeholder="Enter sub Description">{{ old('sub_description', $service->sub_description) }}</textarea>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label" for="brand_title">Brand Title</label>
                          <input type="text" id="brand_title" name="brand_title" value="{{ old('brand_title', $service->brand_title) }}" class="form-control @error('brand_title') is-invalid @enderror" placeholder="Enter brand title" />
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="editor_3">Brand Description</label>
                          <textarea id="editor_3" name="brand_description" style="height: 300px; width: 100%;" class="editor form-control" placeholder="Enter brand Description">{{ old('brand_description', $service->brand_description) }}</textarea>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label" for="business_title">Business Title</label>
                          <input type="text" id="businessn_title" name="business_title" value="{{ old('business_title', $service->business_title) }}" class="form-control @error('business_title') is-invalid @enderror" placeholder="Enter business title" />
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label" for="personalization_title">Personalization Title</label>
                          <input type="text" id="personalization_title" name="personalization_title" value="{{ old('personalization_title', $service->personalization_title) }}" class="form-control @error('personalization_title') is-invalid @enderror" placeholder="Enter personalization title" />
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="editor_4">Personalization Description</label>
                          <textarea id="editor_4" name="personalization_description" style="height: 300px; width: 100%;" class="editor form-control" placeholder="Enter personalization Description">{{ old('personalization_description', $service->personalization_description) }}</textarea>
                        </div>
                    </div>
                  
                  <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div>
                </form>
              </div>

    </div>

@endsection
