<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{url('/assets/')}}"
  data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        {{ $titlePage }} | {{ config('app.name') }} 
    </title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
   <link rel="icon" type="image/png" href="{{ url('/images/SA_Icon.png') }}" />
   
    @include('layouts/sections/styles')

    @include('layouts/sections/scriptsIncludes')
   
  </head>

  <body>

  <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        @include('layouts/sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

         @include('layouts/navbar')

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">

            @yield('content')
            

            @include('layouts/footer')

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
  
    @include('layouts/sections/scripts')

     <script>
        $(document).ready(function() {
               var status = "{{ session('status') }}";
               if(status){
                      toastr.success(status, "Success", {
                      "closeButton": true,
                      "progressBar": true,
                      "positionClass": "toast-top-right",
                      "timeOut": "8000" // duration in milliseconds
                      });
               }

               var error = "{{ session('error') }}";
               if(error){
                      toastr.error(status, "Error", {
                      "closeButton": true,
                      "progressBar": true,
                      "positionClass": "toast-top-right",
                      "timeOut": "8000" // duration in milliseconds
                      });
               }
        });
        $(document).ready(function() {
    $('#basic-default-upload-file').change(function(event) {
        let input = event.target;
        let imgElement = $('#imagePreview');
        let defaultImage = "{{ asset('images/default.png') }}"; // Always use this as the default image

        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                imgElement.attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            imgElement.attr('src', defaultImage); // Reset to default image if no file is selected
        }
    });
    
    $('#basic-banner-upload-file').change(function(event) {
        let input = event.target;
        let imgElement = $('#bannerimagePreview');
        let defaultImage = "{{ asset('images/default.png') }}"; // Always use this as the default image

        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                imgElement.attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            imgElement.attr('src', defaultImage); // Reset to default image if no file is selected
        }
    });
    $(document).ready(function() {
    $('.social-ads-upload-file').change(function(event) {
        let input = event.target;
        // Find the preview image in the same container
        let imgElement = $(this).closest('.social-ads-file-container').find('.social-ads-imagePreview');
        // Get the current default src in case we need to revert
        let defaultImage = imgElement.attr('src');

        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                imgElement.attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            // Reset to the original default image for this specific preview
            imgElement.attr('src', defaultImage);
        }
    });
});

// Dynamic page selection based on page type
    $('#page_type').change(function() {
        let pageType = $(this).val();
        let pageSelect = $('#pageSelect');
        
        // Hide all options first
        pageSelect.find('optgroup, option').hide();
        
        // Show the relevant options
        if (pageType) {
            if (pageType === 'page') {
                pageSelect.find('optgroup[label="Pages"]').show();
                pageSelect.find('optgroup[label="Pages"] option').show();
            } else if (pageType === 'post') {
                pageSelect.find('optgroup[label="Posts"]').show();
                pageSelect.find('optgroup[label="Posts"] option').show();
            } else if (pageType === 'postcategory') {
                pageSelect.find('optgroup[label="Post Categories"]').show();
                pageSelect.find('optgroup[label="Post Categories"] option').show();
            } else if (pageType === 'service') {
                pageSelect.find('optgroup[label="Services"]').show();
                pageSelect.find('optgroup[label="Services"] option').show();
            } else if (pageType === 'project') {
                pageSelect.find('optgroup[label="Projects"]').show();
                pageSelect.find('optgroup[label="Projects"] option').show();
            } else if (pageType === 'projectcategory') {
                pageSelect.find('optgroup[label="Project Categories"]').show();
                pageSelect.find('optgroup[label="Project Categories"] option').show();
            } else if (pageType === 'client') {
                pageSelect.find('optgroup[label="Clients"]').show();
                pageSelect.find('optgroup[label="Clients"] option').show();
            } else if (pageType === 'partner') {
                pageSelect.find('optgroup[label="Partners"]').show();
                pageSelect.find('optgroup[label="Partners"] option').show();
            } else if (pageType === 'faq') {
                pageSelect.find('optgroup[label="FAQs"]').show();
                pageSelect.find('optgroup[label="FAQs"] option').show();
            }
        } else {
            // Show all if no type selected
            pageSelect.find('optgroup, option').show();
        }
        
        // Reset the selected value
        pageSelect.val('');
    });

    // Set initial page type if editing
    @if(isset($seo) && $seo->page_type)
        $('#page_type').trigger('change');
        $('#pageSelect').val('{{ $seo->page_id }}');
    @endif
    
});
      </script>




  </body>
</html>
