@extends('layouts/master', ['activePage' => 'post_categories', 'titlePage' => __('Edit Category')])


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
     <script src="{{ url('/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/tagify/tagify.js') }}"></script>
    

@endsection

@section('page-script')
<!-- Page JS -->
    <script src="{{ url('/assets/js/form-layouts.js') }}"></script>
   <script src="{{ url('/js/delete-record.js') }}"></script>
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
          editor.ui.view.editable.element.style.height = '150px';
          
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
                <span class="text-muted fw-light">category/</span> Edit
            </h4>
          
            
          <div class="row">
              <div class="col-md-12">
                  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                  <div class="card mb-4">
                      @isset($url)
                          <form  class="card-body" method="POST" action="{{$url}}" enctype="multipart/form-data">
                      @else
                        <form  class="card-body" method="POST" action="{{url('/admin/post_categories/'.$postCategory->id)}}" enctype="multipart/form-data">
                      @endisset
                        @csrf
                        @method('put')
                        
                      
                        <div class="row g-3">
                          <div class="col-md-6">
                            <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $postCategory->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Category Name" />
                            @error('name')
                              <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                            @enderror

                            
                              <label class="form-label" for="parent_category">Parent Category</label>
                              <select id="parent_category" name="parent_category" class="form-select @error('parent_category') is-invalid @enderror">
                                  <option value="" selected>Please Select Parent Category</option>

                                  @if (!empty($categories))
                                      @foreach ($categories as $category)
                                          <option value="{{ $category->id }}" {{ old('parent_category', $postCategory->parent_id) == $category->id ? 'selected' : '' }}>
                                              {{ $category->name }}
                                          </option>

                                          @if ($category->children->isNotEmpty())
                                              @foreach ($category->children as $child)
                                                  <option value="{{ $child->id }}" {{ old('parent_category', $postCategory->parent_id) == $child->id ? 'selected' : '' }}>
                                                      &nbsp;&nbsp;— {{ $child->name }}
                                                  </option>

                                                  @if ($child->children->isNotEmpty())
                                                      @foreach ($child->children as $subChild)
                                                          <option value="{{ $subChild->id }}" {{ old('parent_category', $postCategory->parent_id) == $subChild->id ? 'selected' : '' }}>
                                                              &nbsp;&nbsp;&nbsp;&nbsp;— {{ $subChild->name }}
                                                          </option>
                                                      @endforeach
                                                  @endif
                                              @endforeach
                                          @endif
                                      @endforeach
                                  @else
                                      <option value="">No Category Available</option>
                                  @endif
                              </select>

                              @error('parent_category')
                                  <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                              @enderror
                            

                          </div>
                          <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Topics?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="topics" id="topicsYes" value="1" 
                                            {{ old('topics', $postCategory->topics) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="topicsYes">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="topics" id="topicsNo" value="0"
                                            {{ old('topics', $postCategory->topics) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="topicsNo">No</label>
                                    </div>
                                    @error('topics')
                                        <span class="error text-danger invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                    
                          <div class="col-md-6">
                            <label class="form-label " for="editor">Description</label>
                            <textarea id="editor" name="description" style="height: 150px; width: 100%;" class=" form-control" placeholder="Enter Description">{{ old('description', $postCategory->description) }}</textarea>

                          </div>
                          
                          <div class="col-md-6">
                                  <label class="form-label" for="basic-default-upload-file">Image</label>
                                  <input type="file" name="default_image" class="form-control @error('default_image') is-invalid @enderror" id="basic-default-upload-file">
                                  @error('default_image')
                                  <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                @enderror
                                
                                 <div class="mt-3">
                                    <img id="imagePreview" 
                                        src="{{ isset($postCategory) && $postCategory->default_image ? asset('storage/' . $postCategory->default_image->image_url)  : asset('assets/img/backgrounds/5.jpg') }}" 
                                        alt="Preview Image" 
                                        style="max-width: 100%; height: auto; border-radius: 8px;">
                                </div>
                            </div>
                          
                        </div>
                        
                        <hr class="my-4 mx-n4" />
                        
                        <div class="pt-4">
                          <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                          <button type="reset" class="btn btn-label-secondary">Cancel</button>
                        </div>
                      </form>
                  </div>
              </div>
              
          </div>
    </div>

@endsection
