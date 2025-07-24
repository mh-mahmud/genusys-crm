@extends('layouts.master')
@php
    use Carbon\Carbon;
@endphp

@section('content')

    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                 data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                 class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Blogs 
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Blog List</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center py-1">

                <!--begin::Button-->
                <a href="{{ route('create-blog') }}" class="btn btn-sm btn-success" id="kt_toolbar_primary_button">Create Blog</a>
                &nbsp;&nbsp;


                <!--end::Button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--**********************************
                       Tables
         ***********************************-->
    <div class="container-fluid">

        <!--Table Alert Message-->
        <!-- Display Success and Error Messages using SweetAlert2 -->
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success')}}',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error')}}',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif

        <!--End Table Alert Message-->
        <div class="modal fade" id="add_lead_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog mw-400px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--begin::Modal header-->
                    <!--begin::Modal body-->
                    
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>

        <div class="row">
            <div class="col-xxl-12">
                <div class="collapse mt-3" id="g-lead-filter">
                    <div class="card card-body">
                        <form action="#">
                            <div class="row">
                                <div class="mb-5 col-md-3">
                                    <label for="exampleFormControlInput1" class="required form-label">Example</label>
                                    <input type="email" class="form-control form-control-sm  form-control-solid"
                                           placeholder="Example input"/>
                                </div>
                                <div class="mb-5 col-md-3">
                                    <label for="exampleFormControlInput1" class="required form-label">Example</label>
                                    <input type="email" class="form-control form-control-sm  form-control-solid"
                                           placeholder="Example input"/>
                                </div>
                                <div class="mb-5 col-md-3">
                                    <label for="exampleFormControlInput1" class="required form-label">Example</label>
                                    <input type="email" class="form-control form-control-sm  form-control-solid"
                                           placeholder="Example input"/>
                                </div>
                                <div class="mb-5 col-md-3">
                                    <label for="exampleFormControlInput1" class="required form-label">Example</label>
                                    <input type="email" class="form-control form-control-sm form-control-solid"
                                           placeholder="Example input"/>
                                </div>
                                <div class="mb-5 col-md-3">
                                    <label for="exampleFormControlInput1" class="required form-label">Example</label>
                                    <input type="email" class="form-control form-control-sm form-control-solid"
                                           placeholder="Example input"/>
                                </div>
                                <div class="mb-5 col-md-3">
                                    <label for="exampleFormControlInput1" class="required form-label">Example</label>
                                    <input type="email" class="form-control form-control-sm form-control-solid"
                                           placeholder="Example input"/>
                                </div>
                                <div class="mb-5 col-md-3">
                                    <label for="exampleFormControlInput1" class="required form-label">Example</label>
                                    <input type="email" class="form-control form-control-sm form-control-solid"
                                           placeholder="Example input"/>
                                </div>
                                <div class="mb-5 col-md-1 mt-8">
                                    <button class="btn btn-sm btn-warning w-100" data-bs-toggle="collapse"   data-bs-target="#g-lead-filter">Close</button>
                                </div>
                                <div class="mb-5 col-md-1 mt-8">
                                   <button type="reset" class="btn btn-sm btn-success w-100">Reset</button>
                                </div>
                                <div class="mb-5 col-md-1 mt-8">
                                   <button class="btn btn-sm btn-success w-100">Filter</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="card mt-3">
                    <!--begin::Header-->
                    <div class="d-flex justify-content-between align-items-start card-header px-2 border-0 pt-1">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Blog List</span>
                            <!-- <span class="text-muted mt-1 fw-bold fs-7">Leads Form data here</span> -->
                        </h3>

                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <form action="{{ route('blog-search') }}" method="POST" class="d-flex">
                                @csrf
                                <!--begin::Input group-->
                                <div class="d-flex align-items-center position-relative">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                              transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="black"></path>
                                    </svg>
                                </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" name="search"
                                           class="form-control form-control-sm form-control-solid w-250px ps-15"
                                           value="{{ request('search') }}" placeholder="Search by Form Name">
                                </div>
                                <!--end::Input group-->
                                <button type="submit" class="btn btn-primary btn-sm ms-2">Search</button>
                            </form>
                            <button class="btn btn-sm btn-primary px-3" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#g-lead-filter" aria-expanded="false"
                                    aria-controls="collapseExample">
                                <i class="bi bi-funnel-fill pe-0 fs-4"></i>
                            </button>


                        </div>


                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body px-2 pt-2">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            @if($blogs->isNotEmpty())
                                <!--begin::Table-->
                                <table
                                    class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr class="fw-bolder text-muted bg-light bd-cyan">
                                        <th class="ps-4 rounded-start min-w-20px">SL</th>
                                        <!-- <th class="min-w-150px">Form ID</th> -->
                                        <th class="min-w-150px">Blog Name</th>
                                        <th class="min-w-140px">Category Name</th>
                                        <!-- <th class="min-w-150px">Description</th> -->
                                        <th class="min-w-100px">Blog Image</th>
                                        <th class="min-w-120px">Status</th>
                                        <th class="min-w-100px text-end rounded-end text-end-new">Actions</th>
                                    </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                    @foreach ($blogs as $blog)
                                        <tr>

                                            <td class="ps-5 text-dark fs-6">{{($blogs->currentPage() - 1) * $blogs->perPage() + $loop->iteration}}</td>

                                            <td class="text-dark fs-6">{{$blog->blog_name }}</td>
                                            <td class="text-dark fs-6">{{ $blog->blog_category->category_name }}</td>
                                            <!-- <td class="text-dark fs-6 ">{{ $blog->blog_description }}</td> -->

                                            <td style="width: 20%;" class="text-dark fs-6" style="border:1px solid red">
                                                @if($blog->blog_image != '')
                                                    <img style="width: 35%;" src="{{ asset('uploads/blogs/' . $blog->blog_image) }}" alt="{{ $blog->blog_name }}">
                                                @endif
                                            </td>

                                            <td>
                                                @if ($blog->status == 1)
                                                    <span class="badge badge-light-success">Active</span>
                                                @elseif ($blog->status == 0)
                                                    <span class="badge badge-light-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">
                                                 
                                                    <a href="{{ route('blog-show', $blog->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">

                                                        <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                         viewBox="0 0 24 24">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path
                                                                d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                                                fill="black" fill-rule="nonzero" opacity="0.7"/>
                                                            <path
                                                                d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                                                fill="black" opacity="0.7"/>
                                                        </g>
                                                    </svg>
                                                </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <a href="{{ route('blog-edit', $blog->id) }}"
                                                       class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3"
                                                              d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                              fill="black"/>
                                                        <path
                                                            d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                            fill="black"/>
                                                    </svg>
                                                </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <form action="{{ route('blog-delete', $blog->id) }}"
                                                          method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                                onclick="return confirmDelete()">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none">
                                                            <path
                                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                fill="black"/>
                                                            <path opacity="0.5"
                                                                  d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                  fill="black"/>
                                                            <path opacity="0.5"
                                                                  d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                  fill="black"/>
                                                        </svg>
                                                    </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            @else
                                <p>No results found.</p>
                            @endif
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--begin::Body-->

                </div>

                <!--Table Pagination-->
                <!-- <ul class="pagination">
                        <li class="page-item previous disabled"><span class="page-link">Previous</span></span>
                        </li>
                        <li class="page-item "><a href="#" class="page-link">1</a></li>
                        <li class="page-item active"><a href="#" class="page-link">2</a></li>
                        <li class="page-item "><a href="#" class="page-link">3</a></li>
                        <li class="page-item "><a href="#" class="page-link">4</a></li>
                        <li class="page-item "><a href="#" class="page-link">5</a></li>
                        <li class="page-item "><a href="#" class="page-link">6</a></li>
                        <li class="page-item next"><a class="page-link" href="#">Next</span></a></li>
                    </ul> -->

                @include('components.pagination', ['paginator' => $blogs])

                {{-- <ul class="pagination mt-2">
                        <!-- Previous Page Link -->
                        @if ($blogs->onFirstPage())
                            <li class="page-item previous disabled"><span class="page-link"><i class="previous"></i></span></li>
                        @else
                            <li class="page-item previous"><a href="{{ $blogs->previousPageUrl() }}" class="page-link"><i class="previous"></i></a></li>
                @endif

                <!-- Pagination Elements -->
                @for ($page = 1; $page <= $blogs->lastPage(); $page++)
                    @if ($page == $blogs->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                    <li class="page-item"><a href="{{ $blogs->url($page) }}" class="page-link">{{ $page }}</a></li>
                    @endif
                    @endfor

                    <!-- Next Page Link -->
                    @if ($blogs->hasMorePages())
                    <li class="page-item next"><a href="{{ $blogs->nextPageUrl() }}" class="page-link"><i class="next"></i></a></li>
                    @else
                    <li class="page-item next disabled"><span class="page-link"><i class="next"></i></span></li>
                    @endif
                    </ul> --}}

                <!--End Table Pagination-->

            </div>
        </div>
    </div>

    <script>
        document.getElementById('submit_button').addEventListener('click', function () {
            var formId = document.getElementById('id').value;
            if (formId) {
                var baseUrl = '{{ url('/') }}';
                //window.location.href = 'http://localhost/gplexCRM/public/lead/create?id=' + formId;
                window.location.href = baseUrl + '/lead/create?id=' + formId;
            } else {
                alert('Please select a form.');
            }
        });

        function confirmDelete() {
            if (confirm("Are you sure you want to delete Blogger Category?")) {
                document.getElementById('deleteForm').submit();
            }
            return false;
        }
    </script>

    <!-- End Tables-->

@endsection
