@extends('layouts/master', ['activePage' => 'seo', 'titlePage' => __('SEO')])

@section('vendor-style')
<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ url('/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ url('/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ url('/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ url('/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ url('/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
<!-- Vendors JS -->
<script src="{{ url('/assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ url('/assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ url('/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ url('/assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
<script src="{{ url('/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
<script src="{{ url('/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ url('/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')
<script>
    $(document).ready(function() {
        // Initialize DataTable with advanced features
        $('#seoTable').DataTable({
            responsive: true,
            dom: '<"row"<"col-md-6"B><"col-md-6"f>>rt<"row"<"col-md-6"l><"col-md-6"p>>',
            buttons: [
                {
                    extend: 'csv',
                    text: '<i class="ti ti-download"></i> CSV',
                    className: 'btn btn-secondary btn-md mx-2'
                },
                {
                    extend: 'excel',
                    text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                    className: 'btn btn-secondary btn-md mx-2'
                },
                {
                    extend: 'print',
                    text: '<i class="ti ti-printer"></i> Print',
                    className: 'btn btn-secondary btn-md mx-2'
                }
            ],
            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search...",
            }
        });

        // SweetAlert for delete confirmation
        $('.delete-btn').click(function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">SEO /</span> List
        </h4>
        <a href="{{ route('seo.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Create New
        </a>
    </div>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table id="seoTable" class="table border-top" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>Page Type</th>
                        <th>Page ID</th>
                        <th>Title</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seoMetas as $seo)
                    <tr>
                        <td>
                            <span class="badge bg-label-primary">{{ ucfirst($seo->page_type) }}</span>
                        </td>
                        <td>{{ $seo->page_name }}</td>
                        <td>
                            <strong>{{ $seo->title }}</strong>
                            @if($seo->description)
                            <p class="mb-0 text-muted small">{{ Str::limit($seo->description, 50) }}</p>
                            @endif
                        </td>
                        <td>{{ $seo->created_at->format('d M Y') }}</td>
                        <td>{{ $seo->updated_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-inline-block">
                                <button 
                                    class="btn btn-sm btn-icon dropdown-toggle hide-arrow" 
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                    <li>
                                        <a href="{{ route('seo.show', $seo->id) }}" class="dropdown-item">
                                            <i class="bx bx-show me-1"></i> View
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('seo.edit', $seo->id) }}" class="dropdown-item">
                                            <i class="bx bx-edit me-1"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('seo.destroy', $seo->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item delete-btn">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection