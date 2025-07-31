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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Notification
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Notification</small>
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
                                Forms
                  ***********************************-->
<div class="container-xxl">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card card-xxl-stretch mt-4">
                <div class="card-header bg-light bd-cyan">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Notification Edit</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form w-100" action="{{ route('notification-update', $notification->id) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Select Lead/Customer <span style="color:red">(optional)</span></label>
                                    <select class="form-select form-select-sm rounded-end-0 border-end" data-control="select2" name="lead_id">
                                        <option value="" {{ old('lead_id', $notification->lead_id) == '' ? 'selected' : '' }}>Nothing Selected</option>
                                        @foreach($leads as $lead)
                                        <option value="{{ $lead->id }}" {{ old('lead_id', $notification->lead_id) == $lead->id ? 'selected' : '' }}>
                                            {{ $lead->first_name . ' ' . $lead->last_name . ' <' . $lead->email . '>' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('lead_id'))
                                    <span class="text-danger">{{ $errors->first('lead_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Notify Date</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-sm form-control-solid flatpickr" name="notify_datetime" value="{{ old('notify_datetime', \Carbon\Carbon::parse($notification->notify_datetime)->format('Y-m-d H:i')) }}" />
                                        @if ($errors->has('notify_datetime'))
                                        <span class="text-danger">{{ $errors->first('notify_datetime') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Notify To:</label>
                                    <select class="form-select form-select-sm rounded-end-0 border-end" data-control="select2" name="notify_by">
                                        <option value="" {{ old('notify_by', $notification->notify_by) == '' ? 'selected' : '' }}>Nothing Selected</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('notify_by', $notification->notify_by) == $user->id ? 'selected' : '' }}>
                                            {{ $user->username . ' <' . $user->email . '>' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('notify_by'))
                                    <span class="text-danger">{{ $errors->first('notify_by') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{--
                            <div class="col-md-6">
                                <div class="form-check form-check-custom form-check-sm mt-10">
                                    <input type="hidden" name="send_sms" value="0">
                                    <input class="form-check-input" type="checkbox" name="send_sms" id="sendSMS" value="1" {{ old('send_sms', $notification->send_sms) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bolder text-dark" for="sendSMS">
                                        Send SMS
                                    </label>
                                </div>
                            </div>
                            --}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Notify Message</label>
                                    <textarea class="form-control form-control-sm form-control-solid" name="notify_msg" rows="3">{{ old('notify_msg', $notification->notify_msg) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('[name="notify_datetime"]').flatpickr({
            enableTime: true, // enables time picker
            dateFormat: "Y-m-d H:i", //custom date format
            time_24hr: true, // 24-hour time format
            onOpen: function(selectedDates, dateStr, instance) {
                if (!dateStr) { // Only set current date if no date is already selected
                    instance.setDate(new Date()); // Set current date and time when opened
                }
            }
        });
    });
</script>


<!-- </div> -->
<!--end::Content-->

@endsection