@extends('layouts/master', ['activePage' => 'projects.create', 'titlePage' => __('New Project')])


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
                <span class="text-muted fw-light">project /</span> Create
            </h4>
        
           <div class="card mb-4">
                @isset($url)
                    <form  class="card-body" method="POST" action="{{$url}}" enctype="multipart/form-data" >
                @else
                  <form  class="card-body" method="POST" action="{{url('/admin/projects/store')}}" enctype="multipart/form-data" >
                @endisset
                  @csrf

                  
                
                  <div class="row g-3">
                    <div class="col-md-12">
                      <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                      <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Project Name" />
                      @error('name')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>
                    <div>
                      <label class="form-label" for="editor">Description</label>
                      <textarea id="editor" name="description" style="height: 300px; width: 100%;" class="editor form-control" placeholder="Enter Description">{{ old('description') }}</textarea>

                    </div>
                    
                  </div>
                  <hr class="my-4 mx-n4" />
                  <div class="row g-3">
                      <div class="col-md-12">
    <label class="form-label">Category <span class="text-danger">*</span></label>
    @if(!empty($categories))
        @foreach($categories as $category)
            <div class="form-check">
                <input class="form-check-input @error('project_category') is-invalid @enderror" type="checkbox" 
                       name="project_category[]" value="{{ $category->id }}"
                       {{ (is_array(old('project_category')) && in_array($category->id, old('project_category'))) ? 'checked' : '' }}>
                <label class="form-check-label" for="category_{{ $category->id }}">
                    {{ $category->name }}
                </label>
            </div>
            @if($category->children->isNotEmpty())
                @foreach($category->children as $child)
                    <div class="form-check ms-3">
                        <input class="form-check-input @error('project_category') is-invalid @enderror" type="checkbox" 
                               name="project_category[]" value="{{ $child->id }}"
                               {{ (is_array(old('project_category')) && in_array($child->id, old('project_category'))) ? 'checked' : '' }}>
                        <label class="form-check-label" for="category_{{ $child->id }}">
                            — {{ $child->name }}
                        </label>
                    </div>
                    @if($child->children->isNotEmpty())
                        @foreach($child->children as $subChild)
                            <div class="form-check ms-5">
                                <input class="form-check-input @error('project_category') is-invalid @enderror" type="checkbox" 
                                       name="post_category[]" value="{{ $subChild->id }}"
                                       {{ (is_array(old('project_category')) && in_array($subChild->id, old('project_category'))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="category_{{ $subChild->id }}">
                                    — {{ $subChild->name }}
                                </label>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
    @else
        <p>No Category Available</p>
    @endif

    @error('project_category')
        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
    @enderror
</div>

                  </div>
                  
                  <hr class="my-4 mx-n4" />
                  <div class="row g-3">
                      <div class="col-md-6">
                        <div class="">Stage</div>
                        <div class="form-check mt-3">
                          <input name="stage" class="form-check-input" type="radio" value="1" id="stageRadio" {{ old('stage') == '1' ? 'checked' : ''}}>
                          <label class="form-check-label text-warning" for="stageRadio"> Ongoing </label>
                        </div>
                        <div class="form-check mt-3">
                          <input name="stage" class="form-check-input" type="radio" value="2" id="stageRadio1" {{ old('stage') == '2' ? 'checked' : ''}}>
                          <label class="form-check-label text-success" for="stageRadio1"> Complete </label>
                        </div>
                      </div>
                      <div class="col-md-6">
                            <label class="form-label" for="project-date"> Date</label>
                            <input
                              type="text"
                              id="project-date"
                              name="date"
                              value="{{ old('date') }}"
                              class="form-control dob-picker flatpickr-input @error('date') is-invalid @enderror"
                              placeholder="YYYY-MM-DD" />
                              @error('date')
                                <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                              @enderror
                      </div>
                  </div>
                  <hr class="my-4 mx-n4" />
                  <div class="row g-3">
                      <div class="col-md-6">
                         <label class="form-label" for="duration">Duration <span class="text-warning">(with months)</span></label>
                          <input type="number" id="duration" name="duration" value="{{ old('duration') }}" class="form-control @error('duration') is-invalid @enderror" placeholder="Enter project duration" />
                          @error('duration')
                            <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="col-md-6">
                          <label for="client_id" class="form-label">Client </label>
                          <select class="form-control @error('client_id') is-invalid @enderror select2" name="client_id" data-placeholder="Select Subject" style="width: 100%;">
                              <option value="">Select Client</option>
                              @if(!empty($clients))
                                  @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : ''}}>{{$client->name}}</option>
                                  @endforeach
                              @else
                                  <option value="">no has client</option>
                              @endif
                             
                          </select>
                          
                          @error('client_id')
                              <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="col-md-6">
                      <label class="form-label" for="industry">Industry</label>
                      <input type="text" id="industry" name="industry" value="{{ old('industry') }}" class="form-control @error('industry') is-invalid @enderror" placeholder="Enter industry" />
                      @error('industry')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <hr class="my-4 mx-n4" />
                  <div class="row g-3">
                    
                    <div class="col-md-6">
                          <label class="form-label" for="basic-default-upload-file">Project pic</label>
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
                    
                    <div class="col-md-6">
                      <label class="form-label" for="excerpt">Excerpt</label>
                      <textarea id="excerpt" name="excerpt" class="editor form-control @error('excerpt') is-invalid @enderror" placeholder="enter excerpt">{{ old('excerpt') }}</textarea>
                      @error('excerpt')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="goal">Goal</label>
                      <textarea id="goal" name="goal" class="editor form-control @error('goal') is-invalid @enderror" placeholder="enter goal">{{ old('goal') }}</textarea>
                      @error('goal')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="strategy">Strategy</label>
                      <textarea id="strategy" name="strategy" class="editor form-control @error('strategy') is-invalid @enderror" placeholder="enter strategy">{{ old('strategy') }}</textarea>
                      @error('strategy')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="result">Result</label>
                      <textarea id="result" name="result" class="editor form-control @error('result') is-invalid @enderror" placeholder="enter result">{{ old('result') }}</textarea>
                      @error('result')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
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
