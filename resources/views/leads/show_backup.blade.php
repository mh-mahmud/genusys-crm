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
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Lead Details
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Lead Details</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">

            <a href="{{ route('lead-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Lead List</a>
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
                        <h2>Lead Details</h2>
                    </div>
                </div>
                <!--begin::Body-->
                <div class="card-body p-1">
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Form Name</span>
                        <span>{{ $lead->leadsForm?->form_name ?? '' }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">First Name</span>
                        <span>{{ $lead->first_name }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Last Name</span>
                        <span>{{ $lead->last_name }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Email</span>
                        <span>{{ $lead->email }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Phone</span>
                        <span>{{ $lead->phone }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Lead Title</span>
                        <span>{{ $lead->title }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Alternative Number</span>
                        <span>{{ $lead->alternative_number }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Gender</span>
                        @if ($lead->gender === 'Male')
                        <span>Male</span>
                        @elseif ($lead->gender === 'Female')
                        <span>Female</span>
                        @else
                        <span>Other</span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Date of Birth</span>
                        <span>
                            @if($lead->dob)
                            {{ \Carbon\Carbon::parse($lead->dob)->format('d-m-Y') }}
                            @endif
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Age</span>
                        <span>{{ $lead->age }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Marital Status</span>
                        <span>
                            @if(in_array($lead->marital_status, config('constants.marital_status')))
                            {{ $lead->marital_status }}
                            @else

                            @endif
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Address</span>
                        <span>{{ $lead->address }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Age</span>
                        <span>{{ $lead->age }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Company</span>
                        <span>{{ $lead->company }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Status</span>
                        @if ($lead->lead_status === 1)
                        <span>Active</span>
                        @elseif ($lead->lead_status === 0)
                        <span>Inactive</span>
                        @endif
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Lead Rating</span>
                        <span>{{ $lead->lead_rating }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Website</span>
                        <span>{{ $lead->website }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Lead Owner</span>
                        <span>{{ $lead->lead_owner }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Industry</span>
                        <span>{{ $lead->industry }}</span>
                    </div>


                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Lead Source</span>
                        <span>
                            @if(in_array($lead->lead_source, config('constants.lead_source')))
                            {{ $lead->lead_source }}
                            @else

                            @endif
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Street</span>
                        <span>{{ $lead->street }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">City</span>
                        <span>{{ $lead->city }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Zip</span>
                        <span>{{ $lead->zip }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">State</span>
                        <span>{{ $lead->state }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Country</span>
                        <span>{{ $lead->country }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Lead Notes</span>
                        <span>{{ $lead->lead_notes }}</span>
                    </div>

                    @foreach ($tableData as $tableName => $data)
                    @if (!empty($data))
                    <div class="mt-4">
                        <h5><u>{{ ucwords(str_replace('_', ' ', $tableName)) }}</u></h5>
                        <ul class="list-group">
                            @foreach ($data as $key => $value)
                            @if (!in_array($key, ['id', 'lead_id', 'form_id']))
                            <li class="list-group-item" style="background-color:#F5F8FA;"><span class="fs-6 fw-bolder mb-1 text-gray-900 w-lg-100px w-xxl-150px">{{ ucwords(str_replace('_', ' ', $key)) }}</span>: {{ $value }}</li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Tables View-->


<!-- </div> -->
<!--end::Content-->

@endsection
