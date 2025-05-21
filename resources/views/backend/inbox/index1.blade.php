@extends('layouts/master', ['activePage' => 'inbox', 'titlePage' => __('Inbox')])


@section('vendor-style')
<!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ url('/assets/vendor/libs/select2/select2.css') }}" />
    
    
@endsection
@section('page-style')
<link rel="stylesheet" href="{{ url('/assets/vendor/css/pages/app-email.css') }}" />
@endsection
@section('vendor-script')
 <!-- Vendors JS -->
   
    
    <script src="{{ url('/assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ url('/assets/vendor/libs/block-ui/block-ui.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ url('/assets/js/app-email.js') }}"></script>

<script>
	$(document).ready(function() {
    $('.mark-as-read-btn').click(function() {
        var contactId = $(this).data('id');

        $.ajax({
            url: '/admin/contacts/' + contactId + '/mark-as-read', // Adjust the URL as necessary
            type: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Update the UI to reflect the "read" status
                    $('button[data-id="' + contactId + '"]').replaceWith('<span class="badge badge-success">Read</span>');
                    $('tr[data-id="' + contactId + '"]').addClass('table-light'); // Mark row as read visually
                    alert(response.message); // Show success message
                } else {
                    alert('Something went wrong!');
                }
            },
            error: function(xhr) {
                console.log(xhr);
                alert('An error occurred!');
            }
        });
    });
});
		
</script>

@endsection

@section('content')
 

 
 <div class="container-xxl flex-grow-1 container-p-y">
     
    
    
    <div class="app-email card">
                <div class="row g-0">
                  <!-- Email Sidebar -->
                  
                  <!--/ Email Sidebar -->

                  <!-- Emails List -->
                  <div class="col app-emails-list">
                    <div class="shadow-none border-0">
                      <div class="emails-list-header p-3 py-lg-3 py-2">
                        <!-- Email List: Search -->
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="d-flex align-items-center w-100">
                            <i class="ti ti-menu-2 ti-sm cursor-pointer d-block d-lg-none me-3" data-bs-toggle="sidebar" data-target="#app-email-sidebar" data-overlay=""></i>
                            <div class="mb-0 mb-lg-2 w-100">
                              <div class="input-group input-group-merge shadow-none">
                                <span class="input-group-text border-0 ps-0" id="email-search">
                                  <i class="ti ti-search"></i>
                                </span>
                                <input type="text" class="form-control email-search-input border-0" placeholder="Search mail" aria-label="Search mail" aria-describedby="email-search">
                              </div>
                            </div>
                          </div>
                          <div class="d-flex align-items-center mb-0 mb-md-2">
                            <i class="ti ti-rotate-clockwise ti-sm rotate-180 scaleX-n1-rtl cursor-pointer email-refresh me-2"></i>
                            <div class="dropdown d-flex align-self-center">
                              <button class="btn p-0" type="button" id="emailsActions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="emailsActions">
                                <a class="dropdown-item" href="javascript:void(0)">Mark as read</a>
                                <a class="dropdown-item" href="javascript:void(0)">Mark as unread</a>
                                <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                <a class="dropdown-item" href="javascript:void(0)">Archive</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <!-- Email List: Actions -->
                        
                      </div>
                      <hr class="container-m-nx m-0">
                      <!-- Email List: Items -->
                      <div class="email-list pt-0 ps ps--active-y">
                        <ul class="list-unstyled m-0">
                          <li class="email-list-item " data-starred="true" data-bs-toggle="sidebar" data-target="#app-email-view">
                            <div class="d-flex align-items-center">
                              
                              <i class="email-list-item-bookmark ti ti-star ti-sm d-sm-inline-block d-none cursor-pointer ms-2 me-3"></i>
                              <img src="../../assets/img/avatars/1.png" alt="user-avatar" class="d-block flex-shrink-0 rounded-circle me-sm-3 me-2" height="32" width="32">
                              <div class="email-list-item-content ms-2 ms-sm-0 me-2">
                                <span class="h6 email-list-item-username me-2">Chandler Bing</span>
                                <span class="email-list-item-subject d-xl-inline-block d-block">
                                  Focused impactful open issues from the project of GitHub</span>
                              </div>
                              <div class="email-list-item-meta ms-auto d-flex align-items-center">
                                <span class="email-list-item-label badge badge-dot bg-danger d-none d-md-inline-block me-2" data-label="private"></span>
                                <small class="email-list-item-time text-muted">08:40 AM</small>
                                <ul class="list-inline email-list-item-actions text-nowrap">
                                  <li class="list-inline-item email-read"><i class="ti ti-mail-opened ti-sm"></i></li>
                                  <li class="list-inline-item email-delete"><i class="ti ti-trash ti-sm"></i></li>
                                  <li class="list-inline-item"><i class="ti ti-archive ti-sm"></i></li>
                                </ul>
                              </div>
                            </div>
                          </li>
                          @foreach($contacts as $contact)
                          <li class="email-list-item {{ $contact->mark_as_read ? '' : 'email-marked-read' }} " data-sent="true" data-bs-toggle="sidebar" data-target="#app-email-view">
                            <div class="d-flex align-items-center">
                              
                              <i class="email-list-item-bookmark ti ti-star ti-sm d-sm-inline-block d-none cursor-pointer ms-2 me-3"></i>
                              <div class="avatar avatar-sm d-block flex-shrink-0 me-sm-3 me-2">
                                <span class="avatar-initial rounded-circle bg-label-info">Sk</span>
                              </div>
                              <div class="email-list-item-content ms-2 ms-sm-0 me-2">
                                <span class="h6 email-list-item-username me-2">{{$contact->name}}</span>
                                <span class="email-list-item-subject d-xl-inline-block d-block">{{$contact->subject}}</span>
                              </div>
                              <div class="email-list-item-meta ms-auto d-flex align-items-center">
                                <span class="email-list-item-label badge badge-dot bg-info d-none d-md-inline-block me-2" data-label="important"></span>
                                <small class="email-list-item-time text-muted">{{$contact->formatted_created_at}}</small>
                                <ul class="list-inline email-list-item-actions text-nowrap">
                                  <li class="list-inline-item email-unread mark-as-read-btn" data-id="{{ $contact->id }}"><i class="ti ti-mail ti-sm"></i></li>
                                  <li class="list-inline-item email-delete"><i class="ti ti-trash ti-sm"></i></li>
                                  <li class="list-inline-item"><i class="ti ti-archive ti-sm"></i></li>
                                </ul>
                              </div>
                            </div>
                          </li>
                          @endforeach
                        </ul>
                        <ul class="list-unstyled m-0">
                          <li class="email-list-empty text-center d-none">No items found.</li>
                        </ul>
                      <div class="ps__rail-x" style="left: 0px; bottom: -671px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 671px; height: 254px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 184px; height: 69px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: -671px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 671px; height: 254px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 184px; height: 69px;"></div></div></div>
                    </div>
                    <div class="app-overlay"></div>
                  </div>
                  <!-- /Emails List -->

                  <!-- Email View -->
                  <div class="col app-email-view flex-grow-0 bg-body" id="app-email-view">
                    <div class="card shadow-none border-0 rounded-0 app-email-view-header p-3 py-md-3 py-2">
                      <!-- Email View : Title  bar-->
                      <div class="d-flex justify-content-between align-items-center py-2">
                        <div class="d-flex align-items-center overflow-hidden">
                          <i class="ti ti-chevron-left ti-sm cursor-pointer me-2" data-bs-toggle="sidebar" data-target="#app-email-view"></i>
                          <h6 class="text-truncate mb-0 me-2">Focused impactful open issues</h6>
                          <span class="badge bg-label-danger rounded-pill">Private</span>
                        </div>
                        <!-- Email View : Action  bar-->
                        <div class="d-flex align-items-center">
                          <i class="ti ti-printer ti-sm mt-1 cursor-pointer d-sm-block d-none"></i>
                          <div class="dropdown ms-3">
                            <button class="btn p-0" type="button" id="dropdownMoreOptions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="ti ti-dots-vertical ti-sm"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMoreOptions">
                              <a class="dropdown-item" href="javascript:void(0)">
                                <i class="ti ti-mail ti-xs me-1"></i>
                                <span class="align-middle">Mark as unread</span>
                              </a>
                              <a class="dropdown-item" href="javascript:void(0)">
                                <i class="ti ti-mail-opened ti-xs me-1"></i>
                                <span class="align-middle">Mark as unread</span>
                              </a>
                              <a class="dropdown-item" href="javascript:void(0)">
                                <i class="ti ti-star ti-sm me-1"></i>
                                <span class="align-middle">Add star</span>
                              </a>
                              <a class="dropdown-item" href="javascript:void(0)">
                                <i class="ti ti-calendar ti-xs me-1"></i>
                                <span class="align-middle">Create Event</span>
                              </a>
                              <a class="dropdown-item" href="javascript:void(0)">
                                <i class="ti ti-volume-off ti-xs me-1"></i>
                                <span class="align-middle">Mute</span>
                              </a>
                              <a class="dropdown-item d-sm-none d-block" href="javascript:void(0)">
                                <i class="ti ti-printer ti-xs me-1"></i>
                                <span class="align-middle">Print</span>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr class="app-email-view-hr mx-n3 mb-2">
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                          <i class="ti ti-trash ti-sm cursor-pointer me-3" data-bs-toggle="sidebar" data-target="#app-email-view"></i>
                          <i class="ti ti-mail-opened ti-sm cursor-pointer me-3"></i>
                          <div class="dropdown me-3">
                            <button class="btn p-0" type="button" id="dropdownMenuFolderTwo" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="ti ti-folder ti-sm"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuFolderTwo">
                              <a class="dropdown-item" href="javascript:void(0)">
                                <i class="ti ti-info-circle ti-xs me-1"></i>
                                <span class="align-middle">Spam</span>
                              </a>
                              <a class="dropdown-item" href="javascript:void(0)">
                                <i class="ti ti-pencil ti-xs me-1"></i>
                                <span class="align-middle">Draft</span>
                              </a>
                              <a class="dropdown-item" href="javascript:void(0)">
                                <i class="ti ti-trash ti-xs me-1"></i>
                                <span class="align-middle">Trash</span>
                              </a>
                            </div>
                          </div>
                          <div class="dropdown me-3">
                            <button class="btn p-0" type="button" id="dropdownLabelTwo" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="ti ti-tag ti-sm"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLabelTwo">
                              <a class="dropdown-item" href="javascript:void(0)">
                                <i class="badge badge-dot bg-success me-1"></i>
                                <span class="align-middle">Workshop</span>
                              </a>
                              <a class="dropdown-item" href="javascript:void(0)">
                                <i class="badge badge-dot bg-primary me-1"></i>
                                <span class="align-middle">Company</span>
                              </a>
                              <a class="dropdown-item" href="javascript:void(0)">
                                <i class="badge badge-dot bg-info me-1"></i>
                                <span class="align-middle">Important</span>
                              </a>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap justify-content-end">
                          <span class="d-sm-block d-none mx-3 text-muted">1-10 of 653</span>
                          <i class="ti ti-chevron-left ti-sm scaleX-n1-rtl cursor-pointer text-muted me-2"></i>
                          <i class="ti ti-chevron-right ti-sm scaleX-n1-rtl cursor-pointer"></i>
                        </div>
                      </div>
                    </div>
                    <hr class="m-0">
                    <!-- Email View : Content-->
                  </div>
                  <!-- Email View -->
                </div>

                <!-- Compose Email -->
                <!-- /Compose Email -->
              </div>
              
              
              
              
</div>



@endsection
