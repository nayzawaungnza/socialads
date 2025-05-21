@extends('layouts/master', ['activePage' => 'seo.create', 'titlePage' => __('SEO')])


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
    Font,
    List,
    Alignment,
    Underline,
    Strikethrough,
    Link,
    BlockQuote
} from 'ckeditor5';

ClassicEditor
    .create(document.querySelector('#editor'), {
        plugins: [
            Essentials, Paragraph, Bold, Italic, Font, List, Alignment,
            Underline, Strikethrough, Link, BlockQuote
        ],
        toolbar: [
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

    ClassicEditor
    .create(document.querySelector('#excerpt'), {
        plugins: [
            Essentials, Paragraph, Bold, Italic, Font, List, Alignment,
            Underline, Strikethrough, Link, BlockQuote
        ],
        toolbar: [
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
</script>
    
@endsection

@section('content')
 
    <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">create/</span> SEO
            </h4>
        
            <div class="card mb-4">
                <form class="card-body" action="{{ route('seo.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="container mt-4">
                    <div class="row">
                        <!-- Page Type (Select Dropdown) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="page_type">Page Type</label>
                                <select name="page_type" id="page_type" class="form-control @error('page_type') is-invalid @enderror" required>
                                    <option value="">Select Page Type</option>
                                    <option value="page" {{ old('page_type') == 'page' ? 'selected' : '' }}>Page</option>
                                    <option value="service" {{ old('page_type') == 'service' ? 'selected' : '' }}>Service</option>
                                    <option value="project" {{ old('page_type') == 'project' ? 'selected' : '' }}>Project</option>
                                    <option value="projectcategory" {{ old('page_type') == 'projectcategory' ? 'selected' : '' }}>Project Category</option>
                                    <option value="post" {{ old('page_type') == 'post' ? 'selected' : '' }}>Post</option>
                                    <option value="postcategory" {{ old('page_type') == 'postcategory' ? 'selected' : '' }}>Post Category</option>
                                    <option value="client" {{ old('page_type') == 'client' ? 'selected' : '' }}>Client</option>
                                    <option value="partner" {{ old('page_type') == 'partner' ? 'selected' : '' }}>Partner</option>
                                    <option value="faq" {{ old('page_type') == 'faq' ? 'selected' : '' }}>FAQ</option>
                                    
                                </select>
                                @error('page_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
            
                        <!-- Page ID -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="page_id">Page ID</label>
                                <select name="page_id" class="form-control" id="pageSelect">
    <option value="">Select Page</option>

    <!-- Pages Group -->
    <optgroup label="Pages">
        @foreach($pages as $page)
            <option value="{{ $page->id }}">{{ $page->name }}</option>
        @endforeach
    </optgroup>

    <!-- Posts Group -->
    <optgroup label="Posts">
        @foreach($posts as $post)
            <option value="{{ $post->id }}">{{ $post->name }}</option>
        @endforeach
    </optgroup>
<!-- Post Categories Group -->
    <optgroup label="Post Categories">
        @foreach($postCategories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </optgroup>
    <!-- Services Group -->
    <optgroup label="Services">
        @foreach($services as $service)
            <option value="{{ $service->id }}">{{ $service->name }}</option>
        @endforeach
    </optgroup>

    <!-- Projects Group -->
    <optgroup label="Projects">
        @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
        @endforeach
    </optgroup>
    <!-- Project Categories Group -->
    <optgroup label="Project Categories">
        @foreach($projectCategories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </optgroup>
     <!-- Clients Group -->
    <optgroup label="Clients">
        @foreach($clients as $client)
            <option value="{{ $client->id }}">{{ $client->name }}</option>
        @endforeach
    </optgroup>
    <!-- Partners Group -->
    <optgroup label="Partners">
        @foreach($partners as $partner)
            <option value="{{ $partner->id }}">{{ $partner->name }}</option>
        @endforeach
    </optgroup>
    <optgroup label="FAQs">
        @foreach($faqs as $faq)
            <option value="{{ $faq->id }}">{{ $faq->question }}</option>
        @endforeach
    </optgroup>
    
</select>

@error('page_id')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror

                            </div>
                        </div>
            
                        <!-- Title -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
            
                        <!-- Description -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
            
                        <!-- Image -->
                        <div class="col-md-6">
                            <label class="form-label" for="basic-default-upload-file">Image</label>
                              <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="basic-default-upload-file">
                              @error('image')
                              <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                            @enderror
                            <div class="mt-3">
                                <img id="imagePreview" 
                                    src="{{ asset('assets/img/backgrounds/5.jpg') }}" 
                                    alt="Preview Image" 
                                    style="max-width: 100%; height: auto; border-radius: 8px;">
                            </div>
                        </div>
            
                        <!-- Robots (Select Dropdown) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="robots">Robots</label>
                                <select name="robots" id="robots" class="form-control @error('robots') is-invalid @enderror" required>
                                    <option value="index, follow" {{ old('robots') == 'index, follow' ? 'selected' : '' }}>Index, Follow</option>
                                    <option value="noindex, nofollow" {{ old('robots') == 'noindex, nofollow' ? 'selected' : '' }}>Noindex, Nofollow</option>
                                    <option value="noindex, follow" {{ old('robots') == 'noindex, follow' ? 'selected' : '' }}>Noindex, Follow</option>
                                    <option value="index, nofollow" {{ old('robots') == 'index, nofollow' ? 'selected' : '' }}>Index, Nofollow</option>
                                </select>
                                @error('robots')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
            
                        <!-- Open Graph Fields -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="og_title">Open Graph Title</label>
                                <input type="text" name="open_graph[title]" id="og_title" class="form-control @error('open_graph.title') is-invalid @enderror" value="{{ old('open_graph.title') }}">
                                @error('open_graph.title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="og_description">Open Graph Description</label>
                                <textarea name="open_graph[description]" id="og_description" class="form-control @error('open_graph.description') is-invalid @enderror">{{ old('open_graph.description') }}</textarea>
                                @error('open_graph.description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 social-ads-file-container">
                                <div class="form-group">
                                    <label class="form-label" for="basic-og-upload-file">Open Graph Image</label>
                                      <input type="file" name="open_graph[image]" class="social-ads-upload-file form-control @error('open_graph.image') is-invalid @enderror" id="basic-og-upload-file">
                                      @error('open_graph.image')
                                      <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-3">
                                        <img id="ogimagePreview" class="social-ads-imagePreview"  
                                            src="{{ asset('assets/img/backgrounds/5.jpg') }}" 
                                            alt="Preview Image" 
                                            style="max-width: 100%; height: auto; border-radius: 8px;">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="og_url">Open Graph URL</label>
                                <input type="text" name="open_graph[url]" id="og_url" class="form-control @error('open_graph.url') is-invalid @enderror" value="{{ old('open_graph.url') }}">
                                @error('open_graph.url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
            
                        <!-- Twitter Fields -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="twitter_title">Twitter Title</label>
                                <input type="text" name="twitter[title]" id="twitter_title" class="form-control @error('twitter.title') is-invalid @enderror" value="{{ old('twitter.title') }}">
                                @error('twitter.title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="twitter_description">Twitter Description</label>
                                <textarea name="twitter[description]" id="twitter_description" class="form-control @error('twitter.description') is-invalid @enderror">{{ old('twitter.description') }}</textarea>
                                @error('twitter.description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6  social-ads-file-container">
                                <div class="form-group">
                                    <label class="form-label" for="basic-twitter-upload-file">Twitter Image</label>
                                      <input type="file" name="twitter[image]" class="social-ads-upload-file form-control @error('twitter.image') is-invalid @enderror" id="basic-twitter-upload-file">
                                      @error('twitter.image')
                                      <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-3">
                                        <img id="twitterimagePreview" class="social-ads-imagePreview"  
                                            src="{{ asset('assets/img/backgrounds/5.jpg') }}" 
                                            alt="Preview Image" 
                                            style="max-width: 100%; height: auto; border-radius: 8px;">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="twitter_url">Twitter URL</label>
                                <input type="text" name="twitter[url]" id="twitter_url" class="form-control @error('twitter.url') is-invalid @enderror" value="{{ old('twitter.url') }}">
                                @error('twitter.url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
            
                        <!-- Structured Data Fields -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="structured_data_schema">Structured Data Schema</label>
                                <textarea name="structured_data[schema]" id="structured_data_schema" class="form-control @error('structured_data.schema') is-invalid @enderror">{{ old('structured_data.schema') }}</textarea>
                                @error('structured_data.schema')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6  social-ads-file-container">
                                <div class="form-group">
                                    <label class="form-label" for="basic-structured-data-upload-file">Structured Data Image</label>
                                      <input type="file" name="structured_data[image]" class="social-ads-upload-file form-control @error('structured_data.image') is-invalid @enderror" id="basic-structured-data-upload-file">
                                      @error('structured_data.image')
                                      <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-3">
                                        <img id="structureddataimagePreview" class="social-ads-imagePreview" 
                                            src="{{ asset('assets/img/backgrounds/5.jpg') }}" 
                                            alt="Preview Image" 
                                            style="max-width: 100%; height: auto; border-radius: 8px;">
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <!-- Alternate Links Fields -->
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="alt_link_url">Alternate Link URL</label>
                                <input type="text" name="alternate_links[url]" id="alt_link_url" class="form-control @error('alternate_links.url') is-invalid @enderror" value="{{ old('alternate_links.url') }}">
                                @error('alternate_links.url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alt_link_lang">Alternate Link Language</label>
                                <input type="text" name="alternate_links[lang]" id="alt_link_lang" class="form-control @error('alternate_links.lang') is-invalid @enderror" value="{{ old('alternate_links.lang') }}">
                                @error('alternate_links.lang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <!-- Submit Button -->
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Save SEO Meta</button>
                        </div>
                    </div>
                </div>
            </form>

            </div>

    </div>

@endsection
