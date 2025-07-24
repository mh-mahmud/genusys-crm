@extends('layouts.master')


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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dashboard
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Hi {{ Auth::user()->first_name }}</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>

    </div>
    <!--end::Container-->
</div>

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
            timer: 2000
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
            timer: 2000
        });
    </script>
    @endif

    <!--End Table Alert Message-->
    <!--end::Toolbar-->

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">


            <!--begin::Row-->
            <div class="p-5"></div>
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-sm-4">
                    <div class="card card-flush h-md-20 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <!-- <span class="fs-4 fw-semibold text-gray-500 me-1 align-self-start">$</span> -->
                                    <!--end::Currency-->

                                    <!--begin::Amount-->
                                    <span
                                        class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{$count_lead}}</span>
                                    <!--end::Amount-->

                                    <!--begin::Badge-->
                                    <!-- <span class="badge badge-light-success fs-base">
                                            <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1"><span class="path1"></span><span class="path2"></span></i>
                                            2.2%
                                        </span>   -->
                                    <!--end::Badge-->
                                </div>
                                <!--end::Info-->

                                <!--begin::Subtitle-->
                                <a href="{{ route('lead-index') }}">
                                    <span class="text-gray-500 pt-1 fw-semibold fs-6">Total Leads</span>
                                </a>

                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card card-flush h-md-20 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <!-- <span class="fs-4 fw-semibold text-gray-500 me-1 align-self-start">$</span> -->
                                    <!--end::Currency-->

                                    <!--begin::Amount-->
                                    <span
                                        class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{$active_agents}}</span>
                                    <!--end::Amount-->

                                    <!--begin::Badge-->
                                    <!-- <span class="badge badge-light-success fs-base">
                                            <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1"><span class="path1"></span><span class="path2"></span></i>
                                            2.2%
                                        </span>  -->
                                    <!--end::Badge-->
                                </div>
                                <!--end::Info-->

                                <!--begin::Subtitle-->
                                <a href="{{ route('agents-index') }}">
                                    <span class="text-gray-500 pt-1 fw-semibold fs-6">Active Agents</span>
                                </a>

                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card card-flush h-md-20 mb-5 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Currency-->
                                    <!-- <span class="fs-4 fw-semibold text-gray-500 me-1 align-self-start">$</span> -->
                                    <!--end::Currency-->

                                    <!--begin::Amount-->
                                    <span
                                        class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{$active_products}}</span>
                                    <!--end::Amount-->

                                    <!--begin::Badge-->
                                    <!-- <span class="badge badge-light-success fs-base">
                                            <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1"><span class="path1"></span><span class="path2"></span></i>
                                            2.2%
                                        </span>  -->
                                    <!--end::Badge-->
                                </div>
                                <!--end::Info-->

                                <!--begin::Subtitle-->
                                <span class="text-gray-500 pt-1 fw-semibold fs-6">Total Products</span>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                    </div>
                </div>
                <!--end::Col-->

            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xl-4">
                    <!--begin::List Widget 3-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title fw-bolder text-dark">Todo List</h3>
                            <div class="card-toolbar">
                                <!--begin::Menu-->
                                <button type="button"
                                    class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                            viewBox="0 0 24 24">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
                                                <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000"
                                                    opacity="0.3" />
                                                <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000"
                                                    opacity="0.3" />
                                                <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000"
                                                    opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </button>

                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-2">

                            @php
                            $i=1;
                            @endphp
                            @foreach($todo_list as $key=>$val)

                            @php
                            switch($i) {
                            case($i==1):
                            $bg_color = 'bg-success';
                            break;

                            case($i==2):
                            $bg_color = 'bg-danger';
                            break;

                            case($i==3):
                            $bg_color = 'bg-warning';
                            break;

                            case($i==4):
                            $bg_color = 'bg-primary';
                            break;
                            default:
                            $bg_color = 'bg-default';
                            }
                            @endphp
                            <div class="d-flex align-items-center mb-8">
                                <!--begin::Bullet-->
                                <span class="bullet bullet-vertical h-40px {{$bg_color}}"></span>
                                <!--end::Bullet-->
                                <!--begin::Checkbox-->
                                <div class="form-check form-check-custom form-check-solid mx-5">
                                    <input class="form-check-input" type="checkbox" value="" />
                                </div>
                                <!--end::Checkbox-->
                                <!--begin::Description-->
                                <div class="flex-grow-1">
                                    <a href="#"
                                        class="text-gray-800 text-hover-primary fw-bolder fs-6">{{$val->task_name}}</a>
                                    <span class="text-muted d-block"
                                        style="color: red !important;font-size:10px;">Due Date: {{substr($val->due_date, 0, 10)}}</span>
                                </div>
                                <!--end::Description-->
                                <span
                                    class="badge badge-light-successconst_task fs-8 fw-bolder">{{$const_task[$val->status]}}</span>
                            </div>
                            @php
                            $i++;
                            @endphp
                            @endforeach

                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end:List Widget 3-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xl-8">
                    <!--begin::Tables Widget 9-->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">New Leads</span>
                            </h3>
                            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-trigger="hover" title="Click to add a user">
                                <a href="{{ route('lead-create') }}"
                                    class="btn btn-sm btn-light btn-active-primary">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                                transform="rotate(-90 11.364 20.364)" fill="black" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->Create Lead</a>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body p-1">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th class="w-25px">
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        data-kt-check="true" data-kt-check-target=".widget-9-check" />
                                                </div>
                                            </th>
                                            <th class="min-w-150px">Name</th>
                                            <th class="min-w-140px">Email</th>
                                            <th class="min-w-120px">Phone</th>
                                            <th class="min-w-120px">Gender</th>
                                            <th class="min-w-120px">Age</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        @foreach($lead_list as $key=>$val)
                                        <tr>
                                            <td>
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input widget-9-check" type="checkbox"
                                                        value="1" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!-- <div class="symbol symbol-45px me-5">
                                                            <img src="assets/media/avatars/150-3.jpg" alt="" />
                                                        </div> -->
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <a href="#"
                                                            class="text-dark fw-bolder text-hover-primary fs-6">{{ $val->first_name }}</a>
                                                        <span class="text-muted fw-bold text-muted d-block fs-7">Lead Source: {{$val->lead_source}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#"
                                                    class="text-dark fw-bolder text-hover-primary d-block fs-6">{{$val->email}}</a>
                                                <span class="text-muted fw-bold text-muted d-block fs-7">Houses &amp; Hotels</span>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex flex-column w-100 me-2">
                                                    <div class="d-flex flex-stack mb-2">
                                                        <span
                                                            class="text-muted me-2 fs-7 fw-bold">{{$val->phone}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex flex-column w-100 me-2">
                                                    <div class="d-flex flex-stack mb-2">
                                                        <span
                                                            class="text-muted me-2 fs-7 fw-bold">{{$val->gender}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex flex-column w-100 me-2">
                                                    <div class="d-flex flex-stack mb-2">
                                                        <span
                                                            class="text-muted me-2 fs-7 fw-bold">{{$val->age}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--begin::Body-->
                    </div>
                    <!--end::Tables Widget 9-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xl-4">
                    <!--begin::List Widget 2-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title fw-bolder text-dark">Agents</h3>
                            <div class="card-toolbar">
                                <!--begin::Menu-->
                                <button type="button"
                                    class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                            viewBox="0 0 24 24">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
                                                <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000"
                                                    opacity="0.3" />
                                                <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000"
                                                    opacity="0.3" />
                                                <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000"
                                                    opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </button>

                                <!--end::Menu-->
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-2">

                            @foreach($agent_list as $key=> $val)
                            <div class="d-flex align-items-center mb-7">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <img src="assets/media/avatars/150-1.jpg" class="" alt="" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Text-->
                                <div class="flex-grow-1">
                                    <a href="#"
                                        class="text-dark fw-bolder text-hover-primary fs-6">{{$val->first_name}} {{$val->last_name}}</a>
                                    <span class="text-muted d-block fw-bold">Agent Id: {{$val->agent_id}}</span>
                                </div>
                                <!--end::Text-->
                            </div>
                            @endforeach

                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::List Widget 2-->
                </div>

                <div class="col-xl-8">
                    <!--begin::Tables Widget 9-->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Campaign</span>
                            </h3>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body p-1">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th class="w-25px">
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        data-kt-check="true" data-kt-check-target=".widget-9-check" />
                                                </div>
                                            </th>
                                            <th class="min-w-150px">Campaign Title</th>
                                            <th class="min-w-140px">Start date</th>
                                            <th class="min-w-120px">End Start</th>
                                            <th class="min-w-120px">Type</th>
                                            <th class="min-w-120px">Limit</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        @foreach($camp_list as $key=>$val)
                                        <tr>
                                            <td>
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input widget-9-check" type="checkbox"
                                                        value="1" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <a href="#"
                                                            class="text-dark fw-bolder text-hover-primary fs-6">{{ $val->campaign_title }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="#"
                                                    class="text-dark fw-bolder text-hover-primary d-block fs-6">{{$val->start_date}}</a>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex flex-column w-100 me-2">
                                                    <div class="d-flex flex-stack mb-2">
                                                        <span
                                                            class="text-muted me-2 fs-7 fw-bold">{{$val->end_date}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex flex-column w-100 me-2">
                                                    <div class="d-flex flex-stack mb-2">
                                                        <span
                                                            class="text-muted me-2 fs-7 fw-bold">{{$val->campaign_type}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="d-flex flex-column w-100 me-2">
                                                    <div class="d-flex flex-stack mb-2">
                                                        <span
                                                            class="text-muted me-2 fs-7 fw-bold">{{$val->campaign_limit}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--begin::Body-->
                    </div>
                    <!--end::Tables Widget 9-->
                </div>

            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <!-- calender design is here -->
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->

    @endsection
