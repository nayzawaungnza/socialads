@extends('layouts/master', ['activePage' => 'clients.create', 'titlePage' => __('New Client')])


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
				Essentials,
				Paragraph,
				Bold,
				Italic,
				Font
			} from 'ckeditor5';
    ClassicEditor
        .create(document.querySelector('#editor'), {
          plugins: [ Essentials, Paragraph, Bold, Italic, Font ],
            toolbar: ['undo', 'redo', '|', 'bold', 'italic', '|', 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'],
        })
        
        .then(editor => {
          editor.ui.view.editable.element.style.height = '300px';
          
            window.editor = editor;
        })
        .catch(error => {
            console.error(error);
        });
</script>

    
@endsection

@section('content')
 
    <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Client/</span> Create
            </h4>
        
           <div class="card mb-4">
                @isset($url)
                    <form  class="card-body" method="POST" action="{{$url}}" enctype="multipart/form-data" >
                @else
                  <form  class="card-body" method="POST" action="{{url('/admin/clients/store')}}" enctype="multipart/form-data" >
                @endisset
                  @csrf
                
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                      <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter client Name" />
                      @error('name')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="email">Email </label>
                      <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" />
                      @error('email')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="url">Website URL </label>
                      <input type="text" id="url" name="url" value="{{ old('url') }}" class="form-control @error('url') is-invalid @enderror" placeholder="Enter web url" />
                      @error('url')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-md-6">
                      <label class="form-label" for="facebook">Facebook </label>
                      <input type="text" id="facebook" name="facebook" value="{{ old('facebook') }}" class="form-control @error('facebook') is-invalid @enderror" placeholder="Enter facebook url" />
                      @error('facebook')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>
                    
                    
                    <div class="col-md-6">
                      <label class="form-label" for="telegram">Telegram </label>
                      <input type="text" id="telegram" name="telegram" value="{{ old('telegram') }}" class="form-control @error('telegram') is-invalid @enderror" placeholder="Enter telegram url" />
                      @error('telegram')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-md-6">
                      <label class="form-label" for="youtube">Youtube </label>
                      <input type="text" id="youtube" name="youtube" value="{{ old('youtube') }}" class="form-control @error('youtube') is-invalid @enderror" placeholder="Enter youtube url" />
                      @error('youtube')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="linkedIn">LinkedIn </label>
                      <input type="text" id="linkedIn" name="linkedIn" value="{{ old('linkedIn') }}" class="form-control @error('linkedIn') is-invalid @enderror" placeholder="Enter linkedIn url" />
                      @error('linkedIn')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-md-6">
                      <label class="form-label" for="twitter">Twitter </label>
                      <input type="text" id="twitter" name="twitter" value="{{ old('twitter') }}" class="form-control @error('twitter') is-invalid @enderror" placeholder="Enter twitter url" />
                      @error('twitter')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-md-6">
                      <label class="form-label" for="tiktok">Tiktok </label>
                      <input type="text" id="tiktok" name="tiktok" value="{{ old('tiktok') }}" class="form-control @error('tiktok') is-invalid @enderror" placeholder="Enter tiktok url" />
                      @error('tiktok')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>

                    <div>
                      <label class="form-label" for="editor">Description</label>
                      <textarea id="editor" name="description" style="height: 300px; width: 100%;" class=" form-control" placeholder="Enter Description">{{ old('description') }}</textarea>
                    </div>
                    
                  </div>
                 
                  <hr class="my-4 mx-n4" />
                  <div class="row g-3">
                    
                    <div class="col-md-6">
                          <label class="form-label" for="basic-default-upload-file">Client pic</label>
                          <input type="file" name="default_image" class="form-control @error('default_image') is-invalid @enderror" id="basic-default-upload-file">
                          @error('default_image')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                        <div class="mt-3">
                            <img id="imagePreview" 
                                src="{{ asset('assets/img/backgrounds/5.jpg') }}" 
                                alt="Preview Image" 
                                style="max-width: 100%; height: auto; border-radius: 8px;">
                        </div>
                    </div>
                    
                    
                  </div>
                  
                  <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Create</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div>
                </form>
              </div>

    </div>

@endsection
