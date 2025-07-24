@extends('layouts.master')
@php
use Carbon\Carbon;
@endphp

@section('content')

<!-- <div class="content d-flex flex-column flex-column-fluid" id="kt_content"> -->

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Notification Details
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Notification Details</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">

            <a href="{{ route('notification-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Notification List</a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->

<!--**********************************
                                Tables View
                  ***********************************-->
<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-8 mx-auto">
            <div class="card mt-4">
                <div class="card-header bg-light bd-cyan">
                    <div class="card-title">
                        <h2>Notification Details</h2>
                    </div>
                </div>
                <!--begin::Body-->
                <div class="card-body p-1">

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Notify Message</span>
                        <span>{{ $notification->notify_msg }}</span>
                    </div>


                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Notify Date</span>
                        <span>{{ \Carbon\Carbon::parse($notification->notify_datetime)->format('Y-m-d h:i A') }}</span>
                    </div>


                    @if($lead)
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Lead</span>
                        <span>{{ $lead->first_name . ' ' . $lead->last_name . ' <' . $lead->email . '>' }}</span>
                    </div>
                    @endif



                    @if($user && $user->first_name && $user->last_name)
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Notified By</span>
                        <span>{{ $user->first_name . ' ' . $user->last_name . ' <' . $user->email . '>' }}</span>
                    </div>
                    @else
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Notified By</span>
                        <span>System User</span>
                    </div>
                    @endif



                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Send SMS</span>
                        <span>{{ $notification->send_sms == 1 ? 'Yes' : ($notification->send_sms == 0 ? 'No' : '') }}</span>
                    </div>
                </div>



            </div>

        </div>
    </div>
</div>


<!-- End Tables View-->


<!-- </div> -->
<!--end::Content-->

@endsection