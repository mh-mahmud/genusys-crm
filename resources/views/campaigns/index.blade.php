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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Campaign
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Campaign List</small>
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
            <a href="{{ route('campaign-create') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Create</a>

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


    <div class="row">
        <div class="col-xxl-12">
            <div class="card mt-4">
                <!--begin::Header-->
                <div class="d-flex justify-content-between align-items-start card-header border-0 p-1">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Campaign List</span>
                        <!-- <span class="text-muted mt-1 fw-bold fs-7">Leads Form data here</span> -->
                    </h3>

                    <div class="d-flex flex-wrap gap-2">
                        <form action="{{ route('campaign-search') }}" method="POST" class="d-flex">
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
                                <input type="text" name="search" class="form-control form-control-sm form-control-solid w-250px ps-15" value="{{ request('search') }}" placeholder="Search by Campaign Name">
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
                        @if($campaigns->isNotEmpty())
                        <!--begin::Table-->
                        <table class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder text-muted bg-light bd-cyan">
                                    <th class="min-w-150px ps-4">SL</th>
                                    <!-- <th class="min-w-150px">Form ID</th> -->
                                    <th class="min-w-150px">Campaign Name</th>
                                    <!-- <th class="min-w-150px">Promotion</th> -->
                                    <th class="min-w-140px">Start Date</th>
                                    <th class="min-w-140px">End Date</th>
                                    <th class="min-w-140px">Template</th>
                                    <th class="min-w-140px">Type</th>
                                    <th class="min-w-140px">Limit</th>
                                    <th class="min-w-120px">Status</th>
                                    <th class="min-w-120px text-center text-center-new">Data</th>
                                    <th class="min-w-120px text-center text-center-new">Start/Stop</th>
                                    <th class="min-w-100px text-center text-center-new">Actions</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach ($campaigns as $campaign)
                                <tr>
                                    <td class="ps-5 text-dark fs-6">{{($campaigns->currentPage() - 1) * $campaigns->perPage() + $loop->iteration}}</td>
                                    <td class="text-dark fs-6">{{$campaign->campaign_title }}</td>
                                    <!-- <td class="text-dark fs-6">{{$campaign->promotion_title }}</td> -->
                                    <td class="text-dark fs-6">
                                        @if($campaign->start_date)
                                        {{ \Carbon\Carbon::parse($campaign->start_date)->format('Y-m-d h:i A') }}
                                        @endif
                                    </td>
                                    <td class="text-dark fs-6">
                                        @if($campaign->end_date)
                                        {{ \Carbon\Carbon::parse($campaign->end_date)->format('Y-m-d h:i A') }}
                                        @endif
                                    </td>
                                    <td class="text-dark fs-6">
                                        {{ $campaign->email_template_id ? 'Email' : ($campaign->sms_template_id ? 'SMS' : '') }}
                                    </td>
                                    <td class="text-dark fs-6">{{$campaign->campaign_type }}</td>
                                    <td class="text-dark fs-6">{{$campaign->campaign_limit }}</td>

                                    <td>
                                        @if ($campaign->status == 1)
                                        <span class="badge badge-light-success">Active</span>
                                        @elseif ($campaign->status == 0)
                                        <span class="badge badge-light-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-inline-flex justify-content-center gap-1 w-100 border-bottom-0">
                                            <!-- Play Icon Link -->
                                            <a href="{{ route('campaign-data', $campaign->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M8 6.00067L21 6.00139M8 12.0007L21 12.0015M8 18.0007L21 18.0015M3.5 6H3.51M3.5 12H3.51M3.5 18H3.51M4 6C4 6.27614 3.77614 6.5 3.5 6.5C3.22386 6.5 3 6.27614 3 6C3 5.72386 3.22386 5.5 3.5 5.5C3.77614 5.5 4 5.72386 4 6ZM4 12C4 12.2761 3.77614 12.5 3.5 12.5C3.22386 12.5 3 12.2761 3 12C3 11.7239 3.22386 11.5 3.5 11.5C3.77614 11.5 4 11.7239 4 12ZM4 18C4 18.2761 3.77614 18.5 3.5 18.5C3.22386 18.5 3 18.2761 3 18C3 17.7239 3.22386 17.5 3.5 17.5C3.77614 17.5 4 17.7239 4 18Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>


                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-inline-flex justify-content-center gap-1 w-100 border-bottom-0">
                                            @php
                                            $hasPending = \App\Models\CampaignData::where('status', config('constants.campaign_status.Pending'))
                                            ->where('campaign_id', $campaign->id)
                                            ->exists();
                                            @endphp
                                            <!-- Play Icon Link -->
                                            @if($hasPending)
                                            <a href="{{ route('campaign-start', ['id' =>$campaign->id]) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 play-icon" onclick="toggleIcon(this, 'play')">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="800px" height="800px" viewBox="-3 0 28 28" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                        <title>play</title>
                                                        <desc>Created with Sketch Beta.</desc>
                                                        <defs></defs>
                                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                            <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-417.000000, -569.000000)" fill="#000000">
                                                                <path d="M418.983,594.247 L418.983,571.722 L436.831,582.984 L418.983,594.247 L418.983,594.247 Z M438.204,581.536 L419.394,569.279 C418.278,568.672 417,568.943 417,570.917 L417,595.052 C417,597.012 418.371,597.361 419.394,596.689 L438.204,584.433 C439.288,583.665 439.258,582.242 438.204,581.536 L438.204,581.536 Z" id="play" sketch:type="MSShapeGroup"></path>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>

                                            <!-- Stop Icon Link -->
                                            @else
                                            <a href="{{ route('campaign-stop', ['id' =>$campaign->id]) }}" style="background-color: #FF3131;" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 stop-icon" onclick="toggleIcon(this, 'stop')">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12 21C10.22 21 8.47991 20.4722 6.99987 19.4832C5.51983 18.4943 4.36628 17.0887 3.68509 15.4442C3.0039 13.7996 2.82567 11.99 3.17294 10.2442C3.5202 8.49836 4.37737 6.89472 5.63604 5.63604C6.89472 4.37737 8.49836 3.5202 10.2442 3.17294C11.99 2.82567 13.7996 3.0039 15.4442 3.68509C17.0887 4.36628 18.4943 5.51983 19.4832 6.99987C20.4722 8.47991 21 10.22 21 12C21 14.387 20.0518 16.6761 18.364 18.364C16.6761 20.0518 14.387 21 12 21ZM12 4.5C10.5166 4.5 9.0666 4.93987 7.83323 5.76398C6.59986 6.58809 5.63856 7.75943 5.07091 9.12988C4.50325 10.5003 4.35473 12.0083 4.64411 13.4632C4.9335 14.918 5.64781 16.2544 6.6967 17.3033C7.7456 18.3522 9.08197 19.0665 10.5368 19.3559C11.9917 19.6453 13.4997 19.4968 14.8701 18.9291C16.2406 18.3614 17.4119 17.4001 18.236 16.1668C19.0601 14.9334 19.5 13.4834 19.5 12C19.5 10.0109 18.7098 8.10323 17.3033 6.6967C15.8968 5.29018 13.9891 4.5 12 4.5Z" fill="#000000" />
                                                        <path d="M14.5 8H9.5C8.67157 8 8 8.67157 8 9.5V14.5C8 15.3284 8.67157 16 9.5 16H14.5C15.3284 16 16 15.3284 16 14.5V9.5C16 8.67157 15.3284 8 14.5 8Z" fill="#000000" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">
                                            <a href="{{ route('campaign-lead-upload', $campaign->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11 8C11 7.44772 11.4477 7 12 7C12.5523 7 13 7.44771 13 8V11H16C16.5523 11 17 11.4477 17 12C17 12.5523 16.5523 13 16 13H13V16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16V13H8C7.44772 13 7 12.5523 7 12C7 11.4477 7.44771 11 8 11H11V8Z" fill="#0F0F0F" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M23 4C23 2.34315 21.6569 1 20 1H4C2.34315 1 1 2.34315 1 4V20C1 21.6569 2.34315 23 4 23H20C21.6569 23 23 21.6569 23 20V4ZM21 4C21 3.44772 20.5523 3 20 3H4C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21H20C20.5523 21 21 20.5523 21 20V4Z" fill="#0F0F0F" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            <a href="{{ route('campaign-show', $campaign->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
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
                                            <a href="{{ route('campaign-edit', $campaign->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            <form action="{{ route('campaign-destroy', $campaign->id) }}" method="POST" style="display: inline;">
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

            @include('components.pagination', ['paginator' => $campaigns])

            {{-- <ul class="pagination mt-2">
                    <!-- Previous Page Link -->
                    @if ($campaigns->onFirstPage())
                        <li class="page-item previous disabled"><span class="page-link"><i class="previous"></i></span></li>
                    @else
                        <li class="page-item previous"><a href="{{ $campaigns->previousPageUrl() }}" class="page-link"><i class="previous"></i></a></li>
            @endif

            <!-- Pagination Elements -->
            @for ($page = 1; $page <= $campaigns->lastPage(); $page++)
                @if ($page == $campaigns->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                <li class="page-item"><a href="{{ $campaigns->url($page) }}" class="page-link">{{ $page }}</a></li>
                @endif
                @endfor

                <!-- Next Page Link -->
                @if ($campaigns->hasMorePages())
                <li class="page-item next"><a href="{{ $campaigns->nextPageUrl() }}" class="page-link"><i class="next"></i></a></li>
                @else
                <li class="page-item next disabled"><span class="page-link"><i class="next"></i></span></li>
                @endif
                </ul> --}}

                <!--End Table Pagination-->

        </div>
    </div>
</div>

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
        if (confirm("Are you sure you want to delete Campaign?")) {
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