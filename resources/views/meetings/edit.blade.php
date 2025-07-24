@extends('layouts.master')

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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Meeting Edit Forms
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Meeting Edit form</small>
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
            <a href="{{ route('meeting-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Meeting List</a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->

<!--**********************************
                                Forms
                  ***********************************-->
<div class="container-xxl">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card card-xxl-stretch mt-4">
                <!-- <div class="card card-xxl-stretch"> -->
                <div class="card-header bg-light bd-cyan">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Meeting Edit</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form w-100"
                        action="{{ isset($meeting) ? route('meeting-update', $meeting->id) : route('meeting-store') }}"
                        enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        @if (isset($meeting))
                        @method('PUT') {{-- For updating the meeting --}}
                        @endif
                        <div class="row">
                            <!-- Recipient Type Dropdown (Lead/User) -->
                            <div class="col-md-6">
                            <div class="fv-row mb-3">
                                <label class="form-label fw-bolder text-dark">Recipient Type</label>
                                <select class="form-control form-control-sm form-control-solid" id="recipientType" name="recipient_type">
                                    <!-- If lead_id is not null, set Lead as selected. If recipients is not null, set User as selected. -->
                                    <option value="lead" 
                                        {{ old('recipient_type', isset($meeting->lead_id) && $meeting->lead_id !== null ? 'lead' : '') == 'lead' ? 'selected' : '' }}>
                                        Lead
                                    </option>
                                    {{--<option value="user" 
                                        {{ old('recipient_type', isset($meeting->recipients) && !empty($meeting->recipients) ? 'user' : '') == 'user' ? 'selected' : '' }}>
                                        User
                                    </option>--}}
                                </select>
                                @if ($errors->has('recipient_type'))
                                    <span class="text-danger">{{ $errors->first('recipient_type') }}</span>
                                @endif
                            </div>
                        </div>

                            <!-- Lead Dropdown (Shows when Lead is selected) -->
                            <div class="col-md-6" id="leadDropdown" style="display: {{ old('recipient_type', $meeting->recipient_type ?? '') == 'lead' ? 'block' : 'none' }}">
                            <div class="fv-row mb-3">
                                <label class="form-label fw-bolder text-dark">Select Lead</label>
                                <select id="g-lead-select" class="form-control form-control-sm form-control-solid" name="lead_id">
                                    <option value="">Select Lead</option>
                                    @foreach($leads as $lead)
                                        <option value="{{ $lead->id }}" {{ old('lead_id', $meeting->lead_id ?? '') == $lead->id ? 'selected' : '' }}>
                                        {{ $lead->first_name . ' ' . $lead->last_name . ' <' . $lead->email . '>' }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('lead_id'))
                                    <span class="text-danger">{{ $errors->first('lead_id') }}</span>
                                @endif
                            </div>
                        </div>

                            <!-- User Dropdown (Shows when User is selected) -->
                            <div class="col-md-6" id="userDropdown" style="display: {{ old('recipient_type', $meeting->recipient_type ?? '') == 'user' ? 'block' : 'none' }}">
                                <div class="fv-row mb-3 g-user-select">
                                    <label class="form-label fw-bolder text-dark">Select User</label>
                                    <select id="g-user-select" class="form-control form-control-sm form-control-solid" name="recipients[]" multiple="multiple" data-allow-clear="true" data-kt-select2="select2">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                    @if(is_array(old('recipients', $meeting->recipients ?? [])) && in_array($user->id, old('recipients', $meeting->recipients ?? [])))
                                                        selected
                                                    @endif>
                                                    {{ $user->username . ' <' . $user->email . '>' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('recipients'))
                                        <span class="text-danger">{{ $errors->first('recipients') }}</span>
                                    @endif
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Meeting Subject</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="meeting_subject" value="{{ old('meeting_subject', $meeting->meeting_subject ?? '') }}" autocomplete="off" />
                                    @if ($errors->has('meeting_subject'))
                                    <span class="text-danger">{{ $errors->first('meeting_subject') }}</span>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Meeting Date</label>
                                    <input type="text" class="form-control form-control-sm form-control-solid flatpickr" name="meeting_date" value="{{ old('meeting_date', $meeting->meeting_date ?? '') }}" />
                                    @if ($errors->has('meeting_date'))
                                    <span class="text-danger">{{ $errors->first('meeting_date') }}</span>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Meeting Description</label>
                                    <textarea class="form-control form-control-sm form-control-solid" name="meeting_description" rows="2">{{ old('meeting_description', $meeting->meeting_description ?? '') }}</textarea>
                                    @if ($errors->has('meeting_description'))
                                    <span class="text-danger">{{ $errors->first('meeting_description') }}</span>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Meeting Link</label>
                                    <input class="form-control form-control-sm form-control-solid" type="url" name="meeting_link" value="{{ old('meeting_link', $meeting->meeting_link ?? '') }}" autocomplete="off" />
                                    @if ($errors->has('meeting_link'))
                                    <span class="text-danger">{{ $errors->first('meeting_link') }}</span>
                                    @endif
                                </div>
                            </div>

                           
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Duration</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="duration" value="{{ old('duration', $meeting->duration ?? '') }}" autocomplete="off" />
                                    @if ($errors->has('duration'))
                                    <span class="text-danger">{{ $errors->first('duration') }}</span>
                                    @endif
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Attachments</label>
                                    <input type="file" class="form-control form-control-sm form-control-solid" name="attachments" />
                                    @if ($meeting->attachments)
                                <div class="mt-3" id="attachments-file-container">
                                    @php
                                       
                                        $fileExtension = pathinfo($meeting->attachments, PATHINFO_EXTENSION);
                                    @endphp

                                      <!-- Show a link for non-image attachments -->
                                        <a href="{{ asset('uploads/meetings/' . $meeting->attachments) }}" target="_blank">
                                            View {{ strtoupper($fileExtension) }} Attachment
                                        </a>
                                  

                                    <!-- Replace the trash icon with a new "remove" icon -->
                                    <button type="button" class="btn btn-danger btn-sm p-1" id="delete-attachments-file">
                                        <i class="fas fa-times-circle pe-0"></i>
                                    </button>
                                </div>
                            @endif
                                    @if ($errors->has('attachments'))
                                    <span class="text-danger">{{ $errors->first('attachments') }}</span>
                                    @endif
                                </div>
                            </div>

                        
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Status</label>
                                    <select class=" form-control form-control-sm form-control-solid" name="status" aria-label="Default select example">
                                        <option value="1" {{ old('status', $meeting->status ?? '1') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $meeting->status ?? '') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                           
                        <div class="col-md-2">
                            <div class="fv-row mt-10 form-check form-check-custom form-check-sm">
                                <input class="form-check-input form-check-sm" type="checkbox" name="send_email" id="sendEmail" value="1" {{ old('send_email', $meeting->send_email) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bolder text-dark" for="sendEmail">
                                    Send Email
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="fv-row mt-10 form-check form-check-custom form-check-sm">
                                <input class="form-check-input" type="checkbox" name="send_sms" id="sendSMS" value="1" {{ old('send_sms', $meeting->send_sms) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bolder text-dark" for="sendSMS">
                                    Send SMS
                                </label>
                            </div>
                        </div>

                        </div>
                        <!-- End Row -->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">{{ isset($meeting) ? 'Update Meeting' : 'Create Meeting' }}</button>
                        </div>
                    </form>

                    <!-- End Form-->

                </div>
                <!--End Card body-->

                <!--begin::Actions-->

                <!--end::Actions-->
            </div>
        </div>
    </div>
</div>
<!-- End Forms-->


<!-- </div> -->
<!--end::Content-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#delete-attachments-file').click(function() {
            if (confirm('Are you sure you want to delete your Attachments File?')) {
                $.ajax({
                    url: '{{ route('update-attachments-file', $meeting->id) }}', // Using the correct route
                    type: 'PUT', // Correct HTTP method
                    data: {
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#attachments-file-container').remove();
                            // alert('Profile image deleted successfully');
                        } else {
                            alert('Error deleting Attachments File');
                        }
                    },
                    error: function() {
                        alert('Error deleting Attachments File');
                    }
                });
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('[name="meeting_date"]').flatpickr({
            enableTime: true, // enables time picker
            dateFormat: "Y-m-d H:i", // here custom date format
            time_24hr: true, // 24-hour time format show
            onOpen: function(selectedDates, dateStr, instance) {
                if (!dateStr) { // only set current date if no date is already selected
                    instance.setDate(new Date()); // set current date time when opened
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        const recipientType = $('#recipientType');
        const leadDropdown = $('#leadDropdown');
        const userDropdown = $('#userDropdown');
        const leadSelect = $('#g-lead-select');
        const userSelect = $('#g-user-select');

        //function to toggle dropdowns based on the recipient type select
        recipientType.on('change', function() {
            if ($(this).val() === 'lead') {
                leadDropdown.show();
                userDropdown.hide();
                userSelect.val(null).trigger('change'); //clear user selection if lead is selected
            } else if ($(this).val() === 'user') {
                leadDropdown.hide();
                userDropdown.show();
                leadSelect.val(null).trigger('change'); //clear lead selection when user is selected
            }
        });

        // change event to show/hide appropriate dropdowns on page load
        recipientType.trigger('change');

        // select2 for user
        userSelect.select2({
            placeholder: "Select User",
            allowClear: true
        });

        //leadSelect.select2({
            //placeholder: "Select Lead",
           // allowClear: true
        //});

        // clear User selection when Lead is selected, and vice versa
        recipientType.on('change', function() {
            if ($(this).val() === 'lead') {
                userSelect.val(null).trigger('change'); // clear users selection if lead is selected
            } else if ($(this).val() === 'user') {
                leadSelect.val(null).trigger('change'); // Clear lead selection if user is selected
            }
        });
    });
</script>

@endsection