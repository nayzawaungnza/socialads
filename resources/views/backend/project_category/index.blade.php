@extends('layouts/master', ['activePage' => 'project_categories', 'titlePage' => __('New Category')])


@section('vendor-style')
<!-- Vendors CSS -->
   <!-- Vendors CSS -->
   <link rel="stylesheet" href="{{ url('/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ url('/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
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
<script src="{{ url('/assets/js/tables-datatables-advanced.js') }}"></script>
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
                <span class="text-muted fw-light">category/</span> Create
            </h4>
          
            
          <div class="row">
              <div class="col-md-12">
                  <div class="card mb-4">
                      @isset($url)
                          <form  class="card-body" method="POST" action="{{$url}}" >
                      @else
                        <form  class="card-body" method="POST" action="{{url('/admin/project_categories/store')}}" >
                      @endisset
                        @csrf

                        
                      
                        <div class="row g-3">
                          <div class="col-md-6">
                            <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Category Name" />
                            @error('name')
                              <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                            @enderror

                            
                              <label class="form-label" for="parent_category">Parent Category</label>
                              <select id="parent_category" name="parent_category" class="form-select @error('parent_category') is-invalid @enderror">
                                  <option value="" disabled selected>Please Select Parent Category</option>

                                  @if (!empty($categories))
                                      @foreach ($categories as $category)
                                          <option value="{{ $category->id }}" {{ old('parent_category') == $category->id ? 'selected' : '' }}>
                                              {{ $category->name }}
                                          </option>

                                          @if ($category->children->isNotEmpty())
                                              @foreach ($category->children as $child)
                                                  <option value="{{ $child->id }}" {{ old('parent_category') == $child->id ? 'selected' : '' }}>
                                                      &nbsp;&nbsp;— {{ $child->name }}
                                                  </option>

                                                  @if ($child->children->isNotEmpty())
                                                      @foreach ($child->children as $subChild)
                                                          <option value="{{ $subChild->id }}" {{ old('parent_category') == $subChild->id ? 'selected' : '' }}>
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
                            <label class="form-label " for="editor">Description</label>
                            <textarea id="editor" name="description" style="height: 150px; width: 100%;" class=" form-control" placeholder="Enter Description">{{ old('description') }}</textarea>

                          </div>
                          
                        </div>
                        
                        <hr class="my-4 mx-n4" />
                        
                        <div class="pt-4">
                          <button type="submit" class="btn btn-primary me-sm-3 me-1">Create</button>
                          <button type="reset" class="btn btn-label-secondary">Cancel</button>
                        </div>
                      </form>
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="card mb-4">

                    <div id="table_url" data-table-url="{{route('project_categories.index')}}"></div>
                    <div class="card-datatable table-responsive text-nowrap">
                        <table class="table table-bordered table-hover post-category-data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th >Name</th>
                                            {{-- <th>Slug</th> --}}
                                            <th>Status</th>
                                            <th >Created At</th>
                                            <th>Created By</th>
                                            <th >Action</th>
                                        </tr>
                                    </thead>
                        </table>
                    </div>
                  </div>
              </div>
          </div>
    </div>

@endsection
