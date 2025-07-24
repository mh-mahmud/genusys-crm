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
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Meeting
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Meeting List</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->
            <div class="me-4">
                <!--begin::Menu-->

                <!--begin::Menu 1-->
                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_61484bf44d957">
                    <!--begin::Header-->
                    <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Menu separator-->
                    <div class="separator border-gray-200"></div>
                    <!--end::Menu separator-->
                    <!--begin::Form-->
                    <div class="px-7 py-5">
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-bold">Status:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <select class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_61484bf44d957" data-allow-clear="true">
                                    <option></option>
                                    <option value="1">Approved</option>
                                    <option value="2">Pending</option>
                                    <option value="2">In Process</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-bold">Member Type:</label>
                            <!--end::Label-->
                            <!--begin::Options-->
                            <div class="d-flex">
                                <!--begin::Options-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" />
                                    <span class="form-check-label">Author</span>
                                </label>
                                <!--end::Options-->
                                <!--begin::Options-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="2" checked="checked" />
                                    <span class="form-check-label">Customer</span>
                                </label>
                                <!--end::Options-->
                            </div>
                            <!--end::Options-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-bold">Notifications:</label>
                            <!--end::Label-->
                            <!--begin::Switch-->
                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
                                <label class="form-check-label">Enabled</label>
                            </div>
                            <!--end::Switch-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Menu 1-->
                <!--end::Menu-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Button-->
            <a href="{{ route('meeting-create') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Create</a>

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


    <div class="modal fade" id="add_feedback_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                {{--<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                
                    <div class="row">
                        <div class="col-md-12">
                            <div class="fv-row mb-3">
                                <label class="form-label fw-bolder text-dark">Feedback</label>
                                <textarea class="form-control form-control-sm form-control-solid" name="meeting_feedback" rows="2">{{ old('meeting_feedback', isset($meeting) ? $meeting->feedback : '') }}</textarea>
                @if ($errors->has('meeting_feedback'))
                <span class="text-danger">{{ $errors->first('meeting_feedback') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="fv-row mb-3">

                <form action=# name="star-rating-form">
                    <h6 id="title" class="call-to-action-text">Select a rating:</h6>
                    <div class="star-wrap">
                        <input class="star" checked type="radio" value=" " id="skip-star" name="rating" autocomplete="off" />
                        <label class="star-label hidden"></label>
                        <input class="star" type="radio" id="st-1" value="1" name="rating" autocomplete="off" />
                        <label class="star-label" for="st-1">
                            <div class="star-shape"></div>
                        </label>
                        <input class="star" type="radio" id="st-2" value="2" name="rating" autocomplete="off" />
                        <label class="star-label" for="st-2">
                            <div class="star-shape"></div>
                        </label>
                        <input class="star" type="radio" id="st-3" value="3" name="rating" autocomplete="off" />
                        <label class="star-label" for="st-3">
                            <div class="star-shape"></div>
                        </label>
                        <input class="star" type="radio" id="st-4" value="4" name="rating" autocomplete="off" />
                        <label class="star-label" for="st-4">
                            <div class="star-shape"></div>
                        </label>
                        <input class="star" type="radio" id="st-5" value="5" name="rating" autocomplete="off" />
                        <label class="star-label" for="st-5">
                            <div class="star-shape"></div>
                        </label>
                        <label class="skip-button" for="skip-star">
                            &times;
                        </label>
                    </div>
                </form>
                <p id="result">Not chosen</p>


            </div>
        </div>
    </div>


    <div class="card-footer d-flex justify-content-end py-0 px-0">
        <a href="{{ route('meeting-index') }}" class="btn btn-light me-2 btn-sm">Reset</a>
        <button type="button" class="btn btn-primary btn-sm" id="submit_button">Submit</button>
    </div>

</div>--}}


<!-- Modal Body -->
<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
    <form action="{{ url('/meeting-update-feedback/') }}" method="POST" name="star-rating-form">
        @csrf <!-- Token for form security -->

        <!-- Feedback Textarea -->
        <div class="row">
            <div class="col-md-12">
                <div class="fv-row mb-3">
                    <label class="form-label fw-bolder text-dark">Feedback</label>
                    <textarea class="form-control form-control-sm form-control-solid" name="meeting_feedback" rows="2"></textarea>
                    @if ($errors->has('meeting_feedback'))
                    <span class="text-danger">{{ $errors->first('meeting_feedback') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Star Rating -->
        <div class="row">
            <div class="col-md-12">
                <div class="fv-row mb-3">
                    <h6 id="title" class="call-to-action-text">Select a rating:</h6>
                    <div class="star-wrap">
                        <!-- Skip Rating -->
                        <input class="star" checked type="radio" value="" id="skip-star" name="rating" />
                        <label class="star-label hidden"></label>

                        <!-- Star Ratings -->
                        <input class="star" type="radio" id="st-1" value="1" name="rating" />
                        <label class="star-label" for="st-1">
                            <div class="star-shape"></div>
                        </label>

                        <input class="star" type="radio" id="st-2" value="2" name="rating" />
                        <label class="star-label" for="st-2">
                            <div class="star-shape"></div>
                        </label>

                        <input class="star" type="radio" id="st-3" value="3" name="rating" />
                        <label class="star-label" for="st-3">
                            <div class="star-shape"></div>
                        </label>

                        <input class="star" type="radio" id="st-4" value="4" name="rating" />
                        <label class="star-label" for="st-4">
                            <div class="star-shape"></div>
                        </label>

                        <input class="star" type="radio" id="st-5" value="5" name="rating" />
                        <label class="star-label" for="st-5">
                            <div class="star-shape"></div>
                        </label>

                        <!-- Skip Button for Removing Rating -->
                        <!-- <label class="skip-button" for="skip-star">&times;</label> -->
                    </div>
                    <p id="result">Not chosen</p>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="card-footer d-flex justify-content-end py-0 px-0">
            <a href="{{ route('meeting-index') }}" class="btn btn-light me-2 btn-sm">Back</a>
            <button type="submit" class="btn btn-primary btn-sm" id="submit_button">Submit</button>
        </div>
    </form>
</div>


<!--end::Modal body-->
</div>
<!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>

<!--End Table Alert Message-->


<div class="row">
    <div class="col-xxl-12">
        <div class="card mt-4">
            <!--begin::Header-->
            <div class="d-flex justify-content-between align-items-start card-header border-0 p-1">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Meeting List</span>
                    <!-- <span class="text-muted mt-1 fw-bold fs-7">Leads Form data here</span> -->
                </h3>

                <div class="d-flex flex-wrap gap-2">
                    <form action="{{ route('meeting-search') }}" method="POST" class="d-flex">
                        @csrf
                        <!--begin::Input group-->
                        <div class="d-flex align-items-center position-relative">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" name="search" class="form-control form-control-sm form-control-solid w-250px ps-15" value="{{ request('search') }}" placeholder="Search by Meeting Name">
                        </div>
                        <!--end::Input group-->
                        <button type="submit" class="btn btn-primary btn-sm ms-2">Search</button>
                    </form>
                </div>


            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body p-1">
                <!--begin::Table container-->
                <div class="table-responsive">
                    @if($meetings->isNotEmpty())
                    <!--begin::Table-->
                    <table class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fw-bolder text-muted bg-light bd-cyan">
                                <th class="ps-4">SL</th>
                                <!-- <th class="min-w-150px">Form ID</th> -->
                                <th class="min-w-150px">Meeting Subject</th>
                                <!-- <th class="min-w-150px">Promotion</th> -->
                                <th class="min-w-140px">Meeting Date</th>
                                <th class="min-w-140px">Duration</th>
                                <th class="min-w-140px">Created By</th>
                                <th class="min-w-120px">Status</th>
                                <th class="min-w-120px">Rating</th>
                                <th class="min-w-100px text-center text-end-new">Actions</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            @foreach ($meetings as $meeting)
                            <tr>
                                <td class="ps-5 text-dark fs-6">{{($meetings->currentPage() - 1) * $meetings->perPage() + $loop->iteration}}</td>
                                <td class="text-dark fs-6 w-250px">{{$meeting->meeting_subject }}</td>
                                <td class="text-dark fs-6">{{ \Carbon\Carbon::parse($meeting->meeting_date)->format('Y-m-d h:i A') }}</td>
                                <td class="text-dark fs-6">{{$meeting->duration }}</td>
                                <td class="text-dark fs-6">{{$meeting->user->username ?? 'N/A'}}</td>

                                <td>
                                    @if ($meeting->status == 1)
                                    <span class="badge badge-light-success">Active</span>
                                    @elseif ($meeting->status == 0)
                                    <span class="badge badge-light-danger">Inactive</span>
                                    @endif
                                </td>

                                <td class="text-dark fs-6">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if($i <=$meeting->rating)
                                        <i class="fa fa-star text-warning"></i> <!-- Yellow star for ratings -->
                                        @else
                                        <i class="fa fa-star text-muted"></i> <!-- Grey star for remaining -->
                                        @endif
                                        @endfor
                                </td>



                                <td>
                                    <div class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">
                                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#add_feedback_modal"
                                            data-id="{{ $meeting->id }}"> <!-- Pass meeting ID here -->
                                            <!-- Svg Icon -->
                                            <span class="svg-icon svg-icon-3">
                                                <svg fill="#000000" width="800px" height="800px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M84 0v1423.143h437.875V1920l621.235-496.857h692.39V0H84Zm109.469 109.464H1726.03V1313.57h-621.235l-473.452 378.746V1313.57H193.469V109.464Z" fill-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </a>

                                        <a href="{{ route('meeting-show', $meeting->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="black" fill-rule="nonzero" opacity="0.7" />
                                                        <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="black" opacity="0.7" />
                                                    </g>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <a href="{{ route('meeting-edit', $meeting->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <form action="{{ route('meeting-destroy', $meeting->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="return confirmDelete()">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
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

        @include('components.pagination', ['paginator' => $meetings])

        {{-- <ul class="pagination mt-2">
                    <!-- Previous Page Link -->
                    @if ($meetings->onFirstPage())
                        <li class="page-item previous disabled"><span class="page-link"><i class="previous"></i></span></li>
                    @else
                        <li class="page-item previous"><a href="{{ $meetings->previousPageUrl() }}" class="page-link"><i class="previous"></i></a></li>
        @endif

        <!-- Pagination Elements -->
        @for ($page = 1; $page <= $meetings->lastPage(); $page++)
            @if ($page == $meetings->currentPage())
            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
            <li class="page-item"><a href="{{ $meetings->url($page) }}" class="page-link">{{ $page }}</a></li>
            @endif
            @endfor

            <!-- Next Page Link -->
            @if ($meetings->hasMorePages())
            <li class="page-item next"><a href="{{ $meetings->nextPageUrl() }}" class="page-link"><i class="next"></i></a></li>
            @else
            <li class="page-item next disabled"><span class="page-link"><i class="next"></i></span></li>
            @endif
            </ul> --}}

            <!--End Table Pagination-->

    </div>
</div>
</div>

<script>
    function displayValue() {
        starVal = document.forms["star-rating-form"]["rating"].value;
        if (starVal == '') {
            document.getElementById("result").innerText = "Not Chosen";
        } else {
            document.getElementById("result").innerText =
                "You chose: " + starVal +
                " out of 5.";
        }
    }
    document.addEventListener("DOMContentLoaded", () => {
        displayValue();
        document.forms["star-rating-form"]["rating"].forEach((star) => {
            star.addEventListener("change", () => {
                displayValue();
            });
        });
    });
</script>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <script src="{{url('/')}}/assets/js/jquery-3.6.0.min.js"></script> -->
<script>
    $(document).ready(function() {
        //Trigger modal and load data
        $('a[data-bs-target="#add_feedback_modal"]').on('click', function() {
            var meetingId = $(this).data('id');
            //Set the form action dynamically with meeting ID using route
            var formAction = "{{ route('meeting-update-feedback', ':id') }}"; // ':id' is a placeholder
            formAction = formAction.replace(':id', meetingId); // Replace ':id' with actual meetingId
            $('form[name="star-rating-form"]').attr('action', formAction);
            //Make an AJAX call to fetch the meeting data
            var fetchUrl = "{{ route('meeting-feedback', ':id') }}"; // Define the route for fetching data
            fetchUrl = fetchUrl.replace(':id', meetingId); // Replace ':id' with actual meetingId
            $.ajax({
                url: fetchUrl,
                type: 'GET',
                success: function(data) {
                    //Populate the modal fields with AJAX response
                    $('textarea[name="meeting_feedback"]').val(data.meeting_feedback);
                    //Update the rating value in the modal
                    $('input[name="rating"]').prop('checked', false); // Uncheck all ratings first
                    if (data.rating) {
                        $('input[name="rating"][value="' + data.rating + '"]').prop('checked', true);
                    } else {
                        $('#skip-star').prop('checked', true); // Select skip if no rating
                    }
                }
            });
        });
    });
</script>




<script>
    function toggleIcon(element, type) {
        const parent = element.parentElement;
        const playIconLink = parent.querySelector('.play-icon');
        const stopIconLink = parent.querySelector('.stop-icon');

        if (type === 'play') {
            playIconLink.classList.add('d-none');
            stopIconLink.classList.remove('d-none');
        } else {
            playIconLink.classList.remove('d-none');
            stopIconLink.classList.add('d-none');
        }
    }


    function confirmDelete() {
        if (confirm("Are you sure you want to delete Meeting?")) {
            document.getElementById('deleteForm').submit();
        }
        return false;
    }
</script>
<style>
    .d-none {
        display: none !important;
    }
</style>

<!-- End Tables-->

@endsection