@extends('layouts.master')
@php
    use Carbon\Carbon;
@endphp

@section('content')



<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Logs
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Log List</small>
            </h1>
        </div>

        <div class="d-flex align-items-center py-1">
            {{--<a href="{{ route('meeting-create') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Create</a>--}}
        </div>
    </div>
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
                    text: '{{ session('success') }}',
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
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif

        <!--End Table Alert Message-->


        <div class="row">
            <div class="col-xxl-12">
                <div class="card mt-4 p-3">
                    <!--begin::Header-->
                    <div class="d-flex justify-content-between align-items-start card-header border-0 p-1">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Activity Logs</span>
                            <!-- <span class="text-muted mt-1 fw-bold fs-7">Leads Form data here</span> -->
                        </h3>
                        <form action="{{ route('log-list') }}" method="GET" class="d-flex">
                            <!--begin::Input group for Start and End Dates-->
                            <div class="d-flex flex-wrap gap-2 align-items-center justify-content-center position-relative">
                                <input type="date" name="start_date" class="form-control form-control-sm form-control-solid w-250px" value="{{ request('start_date') }}" placeholder="Start Date">
                                <input type="date" name="end_date" class="form-control form-control-sm form-control-solid w-250px" value="{{ request('end_date') }}" placeholder="End Date">

                                <!--begin::Input group for Search-->
                                <div class="d-flex align-items-center position-relative">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                                    </svg>
                                </span>
                                    <!--end::Svg Icon-->
                                    <input type="text" name="search" class="form-control form-control-sm form-control-solid w-250px ps-15" value="{{ request('search') }}" placeholder="Search">
                                </div>
                                <!--end::Input group-->

                                <!--begin::Search Button-->
                                <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                <!--end::Search Button-->
                            </div>
                            <!--end::Input group for Start and End Dates-->

                        </form>

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-1">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            @if (isset($logs) && $logs->isNotEmpty())
                                <!--begin::Table-->
                                <table class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr class="fw-bolder text-muted bg-light bd-cyan">
                                        <th class="ps-4 rounded-start min-w-40px">SL</th>
                                        <th class="min-w-150px">Module</th>
                                        <th class="min-w-140px">Sub Module</th>
                                        <th class="min-w-140px">Log Message</th>
                                        <th class="min-w-140px">Lead</th>
                                        <th class="min-w-140px">Created By</th>
                                        <th class="min-w-120px">Created At</th>
                                    </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                    @foreach ($logs as $log)
                                    <tr>
                                        <td class="ps-5 text-dark fs-6">{{($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration}}</td>
                                        <td class="text-dark fs-6">{{ $log->module }}</td>
                                        <td class="text-dark fs-6">{{ $log->sub_module }}</td>
                                        <td class="text-dark fs-6">{{ $log->log_message }}</td>
                                        <td class="text-dark fs-6">
                                            @isset($log)
                                                {{ $log->lead_first_name }} {{ $log->lead_last_name }}
                                            @endisset
                                        </td>
                                        <td class="text-dark fs-6">{{ $log->first_name }} {{ $log->last_name }}</td>
                                        <td>
                                            {{ Carbon::parse($log->created_at)->format('d-m-Y h:i:s A') }}
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
                                            <!--end::Tab Logs-->

                </div>

                <!--Table Pagination-->
                @if (isset($logs) && $logs->isNotEmpty())
                @include('components.pagination', ['paginator' => $logs])
                @endif
                <!--End Table Pagination-->

            </div>
        </div>
    </div>


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
    <script>
        function confirmDelete() {
            if (confirm("Are you sure you want to delete Email Template?")) {
                document.getElementById('deleteForm').submit();
            }
            return false;
        }
    </script>

    <!-- End Tables-->

@endsection
