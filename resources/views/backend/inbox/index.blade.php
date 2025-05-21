@extends('layouts.master', ['activePage' => 'inbox', 'titlePage' => __('Inbox')])

@section('vendor-style')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-email.css') }}" />
@endsection

@section('vendor-script')
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/app-email.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.mark-as-read-btn').click(function() {
            var contactId = $(this).data('id');
            $.ajax({
                url: '/admin/contacts/' + contactId + '/mark-as-read', // Adjust as necessary
                type: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('.mark-as-read-btn[data-id="' + contactId + '"]').replaceWith('<span class="badge badge-success">Read</span>');
                        $('tr[data-id="' + contactId + '"]').addClass('table-light');
                        alert(response.message);
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
            <div class="col app-emails-list">
                <div class="shadow-none border-0">
                    <div class="emails-list-header p-3 py-lg-3 py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center w-100">
                                <div class="mb-0 mb-lg-2 w-100">
                                    <div class="input-group input-group-merge shadow-none">
                                        <span class="input-group-text border-0 ps-0" id="email-search">
                                            <i class="ti ti-search"></i>
                                        </span>
                                        <input type="text" class="form-control email-search-input border-0" placeholder="Search mail">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="container-m-nx m-0">
                    <div class="email-list pt-0">
                        <ul class="list-unstyled m-0">
                            @forelse($contacts as $contact)
                                <li class="email-list-item {{ $contact->mark_as_read ? 'email-marked-read' : '' }}" data-sent="true">
                                    <a href="{{url('admin/contacts/' . $contact->id . '/')}}">
                                    <div class="d-flex align-items-center">
                                        <i class="email-list-item-bookmark ti ti-star ti-sm d-sm-inline-block d-none cursor-pointer ms-2 me-3"></i>
                                        <div class="avatar avatar-sm me-sm-3 me-2">
                                            <span class="avatar-initial rounded-circle bg-label-info">SK</span>
                                        </div>
                                        <div class="email-list-item-content ms-2 ms-sm-0 me-2">
                                            <span class="h6 email-list-item-username me-2">{{ $contact->name }}</span>
                                            <span class="email-list-item-subject d-xl-inline-block d-block">{{ $contact->subject }}</span>
                                        </div>
                                        @if($contact->status === 'new')
                                            <div>
                                                <span class="badge bg-primary rounded-pill ms-auto">{{ $contact->status }}</span>
                                            </div>
                                        @endif
                                        <div class="email-list-item-meta ms-auto d-flex align-items-center">
                                            <small class="email-list-item-time text-muted">{{ $contact->formatted_created_at }}</small>
                                            <ul class="list-inline email-list-item-actions text-nowrap">
                                                @if(!$contact->mark_as_read)
                                                 <li class="list-inline-item email-unread mark-as-read-btn" data-id="{{ $contact->id }}">
                                                    <i class="ti ti-mail ti-sm"></i>
                                                </li>
                                                @endif
                                               
                                                <li class="list-inline-item email-delete" data-id="{{ $contact->id }}">
                                                    <i class="ti ti-trash ti-sm"></i>
                                                </li>
                                                <li class="list-inline-item email-archive" data-id="{{ $contact->id }}">
                                                    <i class="ti ti-archive ti-sm"></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    </a>
                                </li>
                            @empty
                                <li class="email-list-empty text-center">No items found.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="app-overlay"></div>
            </div>
        </div>
    </div>
</div>
@endsection
