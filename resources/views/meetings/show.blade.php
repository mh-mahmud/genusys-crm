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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Meeting Details
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Meeting Details</small>
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
                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                    id="kt_menu_61484bf44d957">
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
                                <select class="form-select form-select-solid" data-kt-select2="true"
                                    data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_61484bf44d957"
                                    data-allow-clear="true">
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
                                <label
                                    class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" />
                                    <span class="form-check-label">Author</span>
                                </label>
                                <!--end::Options-->
                                <!--begin::Options-->
                                <label
                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="2"
                                        checked="checked" />
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
                            <div
                                class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value=""
                                    name="notifications" checked="checked" />
                                <label class="form-check-label">Enabled</label>
                            </div>
                            <!--end::Switch-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button type="reset"
                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true">Reset
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary"
                                data-kt-menu-dismiss="true">Apply
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
            <a href="{{ route('meeting-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Meeting
                List</a>
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
            <!-- <div class="card mb-5"> -->
            <div class="card mt-4">
                <div class="card-header bg-light bd-cyan">
                    <div class="card-title">
                        <h2>Meeting Details</h2>
                    </div>
                </div>
                <!--begin::Body-->
                <div class="card-body p-1">

                    <!-- Show Lead Information if lead_id exists -->
                    @if($lead)
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Lead</span>
                        <span>{{ $lead->first_name . ' ' . $lead->last_name . ' <' . $lead->email . '>' }}</span>
                    </div>
                    @endif

                    <!-- Show Recipients Information if recipients exist -->
                    @if($users && count($users) > 0)
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Recipients</span>
                        <span>
                            @foreach($users as $user)
                            {{ $user->username . ' <' . $user->email . '>' }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </span>
                    </div>
                    @endif

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Meeting Subject</span>
                        <span>{{ $meeting->meeting_subject }}</span>
                    </div>

                    @php
                    date_default_timezone_set('Asia/Dhaka');
                    //assuming the $meeting->meeting_date is a datetime string
                    $meetingDate = Carbon::parse($meeting->meeting_date); // Parse date with Carbon
                    // Format pieces of the date and time
                    $dayOfWeek = $meetingDate->format('l'); // full day name (example., Thursday)
                    $day = $meetingDate->format('d'); // numeric day (example., 12)
                    $monthYear = $meetingDate->format('F Y'); // full month and year (example., September 2024)
                    $time = $meetingDate->format('g:i A'); // time with AM/PM (example., 2:00 PM)
                    $timezone = $meetingDate->timezoneName; // timezone (example., Asia/Dhaka)
                    @endphp

                    <div class="position-relative d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <!-- <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Meeting Date</span> -->
                        <span>
                            <div class="calendar-block position-relative">
                                <div class="calendar-left">
                                    <!-- Display the day of the week -->
                                    <div class="calendar-header">{{ $dayOfWeek }}</div>
                                    <!-- Display the numeric day -->
                                    <div class="calendar-date">{{ $day }}</div>
                                    <!-- Display the month and year -->
                                    <div class="calendar-footer">
                                        <div class="calendar-month-year">{{ $monthYear }}</div>
                                        <div class="calendar-time-block">
                                            <!-- Display the time -->
                                            <div class="calendar-time">{{ $time }}</div>
                                            <!-- Display the timezone dynamically -->
                                            <div class="calendar-timezone">({{ $timezone }})</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </span>

                        <!-- Event details placed behind the calendar using z-index -->
                        <span class="event-details-block">
                            <div class="event-details">
                                <h3>Details of the event</h3>
                                <ul>
                                    <li><strong>Description:</strong>{{ $meeting->meeting_description }}</li>
                                    <li>
                                        Please attend the meeting on time.<br><strong>How to Join:</strong> <a href="{{ $meeting->meeting_link }}">{{ $meeting->meeting_link }}</a></li>
                                    <li><strong>Duration:</strong> {{ $meeting->duration }}</li>
                                </ul>
                            </div>
                        </span>
                    </div>


                    @if($meeting->attachments)
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Attachments</span>
                        <span> <a href="{{ asset('uploads/meetings/' . $meeting->attachments) }}" target="_blank">
                                <i class="fas fa-paperclip me-1"></i>Attachment
                            </a></span>
                    </div>
                    @endif

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Status</span>
                        @if ($meeting->status === 1)
                        <span>Active</span>
                        @elseif ($meeting->status === 0)
                        <span>Inactive</span>
                        @endif
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Created By</span>
                        <span>{{ $meeting->user->username ?? 'N/A' }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Rating</span>
                        <span>
                            @for ($i = 1; $i <= 5; $i++)
                                @if($i <=$meeting->rating)
                                <i class="fa fa-star text-warning"></i> <!-- yellow star ratings -->
                                @else
                                <i class="fa fa-star text-muted"></i> <!-- grey star remaining -->
                                @endif
                                @endfor
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Meeting Feedback</span>
                        <span>{{ $meeting->meeting_feedback }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Send Email</span>
                        @if ($meeting->send_email === 1)
                        <span>Yes</span>
                        @elseif ($meeting->send_email === 0 || $meeting->send_email === null)
                        <span>No</span>
                        @endif
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Send SMS</span>
                        @if ($meeting->send_sms === 1)
                            <span>Yes</span>
                        @elseif ($meeting->send_sms === 0 || $meeting->send_sms === null)
                            <span>No</span>
                        @endif
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