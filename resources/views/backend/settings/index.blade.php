@extends('layouts/master', ['activePage' => 'setting', 'titlePage' => __('Config Setting')])


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

 <!-- Page CSS -->
    <!-- Page -->
    {{-- <link rel="stylesheet" href="{{ url('/assets/vendor/css/pages/page-auth.css') }}" /> --}}
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
 
    <script src="{{ url('/assets/js/form-layouts.js') }}"></script>
   <script src="{{ url('/js/file-upload.js') }}"></script>
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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <a href="/admin/home" class="breadcrumb-item">Home </a>
                    <li class="breadcrumb-item active" aria-current="page"> Configuration Settings </li>
                </ol>
            </nav>
        
           <div class="card mb-4">
                @isset($url)
                    <form  class="card-body" method="POST" action="{{$url}}" enctype="multipart/form-data" >
                @else
                  <form  class="card-body" method="POST" action="{{url('/admin/config_settings/'.$setting->id)}}" enctype="multipart/form-data" >
                @endisset
                  @csrf
                  @method('patch')

                    <div class="row g-3">
                        <div class="col-md-6">
                                <div class=" align-items-start align-items-sm-center gap-4 mb-3">
                                    <img src="{{ $setting->site_logo ? Storage::url($setting->site_logo) : url('/images/logo_default.png') }}" alt="site_logo" class="d-block w-px-300 h-px-100 rounded-2" id="uploadedLogo" />
                                    <div class="button-wrapper mt-2">
                                        <label for="uploadlogo" class="btn btn-primary me-2 mb-3" tabindex="0">
                                        <span class="d-none d-sm-block">Upload site logo</span>
                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                        <input type="file" id="uploadlogo" name="site_logo" class="logo-file-input" hidden />
                                        </label>
                                        <button type="button" class="btn btn-label-secondary logo-image-reset mb-3">
                                        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                        </button>

                                        <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                        @error('site_logo')
                                            <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    </div>
                        </div>
                        <div class="col-md-6">
                                <div class=" align-items-start align-items-sm-center gap-4">
                                    <img src="{{ $setting->favicon ? Storage::url($setting->favicon) : url('/images/fav_default.png') }}" alt="favicon" class="d-block w-px-100 h-px-100 rounded-2" id="uploadedFav" />
                                    <div class="button-wrapper mt-2">
                                        <label for="uploadfav" class="btn btn-primary me-2 mb-3" tabindex="0">
                                        <span class="d-none d-sm-block">Upload fav logo</span>
                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                        <input type="file" id="uploadfav" name="favicon" class="fav-file-input" hidden />
                                        </label>
                                        <button type="button" class="btn btn-label-secondary fav-image-reset mb-3">
                                        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                        </button>

                                        <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                        @error('favicon')
                                            <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    </div>
                        </div>
                    </div>
                    

                    
                  
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label" for="site_name">Site Name</label>
                      <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $setting->site_name) }}" class="form-control @error('site_name') is-invalid @enderror" placeholder="Enter Site Name" />
                      @error('site_name')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="contact_email">Contact Email</label>
                      <div class="input-group input-group-merge">
                        <input
                          type="email"
                          id="contact_email"
                          class="form-control @error('contact_email') is-invalid @enderror"
                          name="contact_email"
                          value="{{ old('contact_email', $setting->contact_email) }}"
                          placeholder="john.doe@gmail.com"
                          aria-label="john.doe@gmail.com"
                          aria-describedby="contact_email" />
                        
                      </div>
                      @error('contact_email')
                        <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                      @enderror
                    </div>
                    
                  </div>
                  <hr class="my-4 mx-n4" />
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label" for="contact_phone">Phone No</label>
                      <input
                        type="text"
                        id="contact_phone"
                        name="contact_phone"
                        value="{{ old('contact_phone') }}"
                        class="form-control phone-mask @error('contact_phone', $setting->contact_phone) is-invalid @enderror"
                        placeholder="09 xxx xxx xxx"
                        aria-label="09 xxx xxx xxx" />
                        @error('contact_phone')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-address">Address</label>
                      <input type="text" id="multicol-address" value="{{ old('address', $setting->address) }}" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="address" />
                      @error('address')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    
                  </div>

                  <hr class="my-4 mx-n4" />
                  <h6 class="mb-3">Social Media</h6>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label" for="facebook_url">Facebook</label>
                      <input
                        type="text"
                        id="facebook_url"
                        name="facebook_url"
                        value="{{ old('facebook_url',$setting->facebook_url) }}"
                        class="form-control  @error('facebook_url' ) is-invalid @enderror"
                        placeholder="https://www.facebook.com/" />
                        @error('facebook_url')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="youtube_url">Youtube</label>
                      <input 
                        type="text" 
                        id="youtube_url" 
                        value="{{ old('youtube_url', $setting->youtube_url) }}" 
                        name="youtube_url" 
                        class="form-control @error('youtube_url') is-invalid @enderror" 
                        placeholder="https://www.youtube.com/"  />
                      @error('youtube_url')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                      <label class="form-label" for="twitter_url">Twitter</label>
                      <input
                        type="text"
                        id="twitter_url"
                        name="twitter_url"
                        value="{{ old('twitter_url',$setting->twitter_url) }}"
                        class="form-control  @error('twitter_url') is-invalid @enderror"
                        placeholder="https://www.twitter.com/" />
                        @error('twitter_url')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="instagram_url">Instagram</label>
                      <input 
                        type="text" 
                        id="instagram_url" 
                        value="{{ old('instagram_url', $setting->instagram_url) }}" 
                        name="instagram_url" 
                        class="form-control @error('instagram_url') is-invalid @enderror" 
                        placeholder="https://www.instagram.com/"  />
                      @error('instagram_url')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                      <label class="form-label" for="linkedin_url">Linkedin</label>
                      <input 
                        type="text" 
                        id="linkedin_url" 
                        value="{{ old('linkedin_url', $setting->linkedin_url) }}" 
                        name="linkedin_url" 
                        class="form-control @error('linkedin_url') is-invalid @enderror" 
                        placeholder="https://www.linkedin.com/"  />
                      @error('linkedin_url')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                      <label class="form-label" for="tiktok_url">Tiktok</label>
                      <input 
                        type="text" 
                        id="tiktok_url" 
                        value="{{ old('tiktok_url', $setting->tiktok_url) }}" 
                        name="tiktok_url" 
                        class="form-control @error('tiktok_url') is-invalid @enderror" 
                        placeholder="https://www.tiktok.com/"  />
                      @error('tiktok_url')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="whatsapp_url">Whatsapp</label>
                      <input 
                        type="text" 
                        id="whatsapp_url" 
                        value="{{ old('whatsapp_url', $setting->whatsapp_url) }}" 
                        name="whatsapp_url" 
                        class="form-control @error('whatsapp_url') is-invalid @enderror" 
                        placeholder="https://www.whatsapp.com/"  />
                      @error('whatsapp_url')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="viber">Viber</label>
                      <input 
                        type="text" 
                        id="viber" 
                        value="{{ old('viber', $setting->viber) }}" 
                        name="viber" 
                        class="form-control @error('viber') is-invalid @enderror" 
                        placeholder="viber number"  />
                      @error('viber')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>

                  </div>

                  <hr class="my-4 mx-n4" />
                  <h6 class="mb-3">Meta </h6>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label" for="meta_description">Meta Description</label>
                      <textarea
                        id="meta_description"
                        name="meta_description"
                        class="form-control @error('meta_description') is-invalid @enderror"
                        placeholder="meta description">{{ old('meta_description', $setting->meta_description) }}</textarea>
                     
                        @error('meta_description')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="meta_keywords">Keywords</label>
                      <input 
                        type="text" 
                        id="meta_keywords" 
                        value="{{ old('meta_keywords', $setting->meta_keywords) }}" 
                        name="meta_keywords" 
                        class="form-control @error('meta_keywords') is-invalid @enderror" 
                        placeholder="meta keywords"  />
                      @error('meta_keywords')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>

                  <hr class="my-4 mx-n4" />
                  <h6 class="mb-3">Google Map</h6>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label" for="latitude">Latitude</label>
                      <input
                        type="text"
                        id="latitude"
                        name="latitude"
                        value="{{ old('latitude',$setting->latitude) }}"
                        class="form-control  @error('latitude') is-invalid @enderror"
                        placeholder="123.456" />
                        @error('latitude')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="longitude">Longitude</label>
                      <input 
                        type="text" 
                        id="longitude" 
                        value="{{ old('longitude', $setting->longitude) }}" 
                        name="longitude" 
                        class="form-control @error('longitude') is-invalid @enderror" 
                        placeholder="123.456"  />
                      @error('longitude')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                      <label class="form-label" for="google_maps_api_key">Google Maps API Key</label>
                      <input
                        type="text"
                        id="google_maps_api_key"
                        name="google_maps_api_key"
                        value="{{ old('google_maps_api_key',$setting->google_maps_api_key) }}"
                        class="form-control  @error('google_maps_api_key') is-invalid @enderror"
                        placeholder="xxxx-xxxx-xxxx-xxxxx-xxxxx" />
                        @error('google_maps_api_key')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="google_maps_embed_url">Google Maps Embed URL</label>
                      <textarea
                        id="google_maps_embed_url"
                        name="google_maps_embed_url"
                        class="form-control @error('google_maps_embed_url') is-invalid @enderror"
                        placeholder="" >
                        {{ old('google_maps_embed_url', $setting->google_maps_embed_url) }}
                        </textarea>
                      
                      @error('google_maps_embed_url')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>
                  <hr class="my-4 mx-n4" />
                  <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="timezone">Timezone</label>
                        <select class="form-control @error('timezone') is-invalid @enderror select2" 
                                name="timezone" 
                                data-placeholder="Select Timezone" 
                                style="width: 100%;">
                            <option value="">Select Timezone</option>

                            @php
                                $timezones = collect(DateTimeZone::listIdentifiers())
                                    ->groupBy(function ($tz) {
                                        return explode('/', $tz)[0]; // Group by the first part (Continent/Region)
                                    });
                            @endphp

                            @foreach ($timezones as $region => $zones)
                                <optgroup label="{{ $region }}">
                                    @foreach ($zones as $timezone)
                                        <option value="{{ $timezone }}" {{ old('timezone', $setting->timezone) == $timezone ? 'selected' : '' }}>
                                            {{ str_replace('_', ' ', $timezone) }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                         @error('timezone')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                   <div class="col-md-6">
                        <label class="d-block form-label">Maintenance Mode</label>
                        <div class="form-check form-check-inline mt-3">
                            <input name="maintenance_mode" class="form-check-input" type="radio" value="1" id="maintenance_mode_on" {{ old('maintenance_mode', $setting->maintenance_mode) == true ? 'checked' : ''}}>
                            <label class="form-check-label text-warning" for="maintenance_mode_on"> On </label>
                        </div>
                        <div class="form-check form-check-inline mt-3">
                            <input name="maintenance_mode" class="form-check-input" type="radio" value="0" id="maintenance_mode_off" {{ old('maintenance_mode', $setting->maintenance_mode) == false ? 'checked' : ''}}>
                            <label class="form-check-label text-success" for="maintenance_mode_off"> Off </label>
                        </div>
                        @error('maintenance_mode')
                            <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="copyright_text">Copyright Text</label>
                        <textarea id="editor" name="copyright_text" 
                        style="height: 300px; width: 100%;" 
                        class="form-control" 
                        placeholder="Enter copyright text">{{ old('copyright_text', $setting->copyright_text) }}</textarea>
                        @error('copyright_text')
                          <span class="error invalid-feedback" style="margin-left:8px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                  </div>
                  <hr class="my-4 mx-n4" />
                  
                  <div class="pt-4">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Save Setting</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div>
                </form>
              </div>

    </div>

@endsection
