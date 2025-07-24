@extends('layouts.master')

@section('content')

<!-- <div class="content d-flex flex-column flex-column-fluid" id="kt_content"> -->

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
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Campaign</small>
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
            <a href="{{ route('campaign-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Campaign List</a>
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
                        <h3 class="fw-bolder m-0">Campaign Create</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form w-100" action="{{ route('campaign-store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Campaign Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="campaign_title" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('campaign_title'))
                                    <span class="text-danger">{{ $errors->first('campaign_title') }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Promotion Name</label>
                                    <select class=" form-control form-control-sm form-control-solid" data-control="select2" name="promotion_id" aria-label="Default select example">
                                        <option value="">Select Promotion Name</option>
                                        @foreach($promotions as $id => $name)
                                        <option value="{{ $id }}">{{$name}}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('promotion_id'))
                                    <span class="text-danger">{{ $errors->first('promotion_id') }}</span>
                                    @endif
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Form Name</label>
                                    <select class="form-control form-control-sm form-control-solid" name="form_id" aria-label="Default select example">
                                        <option value="">Select Form Name</option>
                                        @foreach($formName as $id => $name)
                                        <option value="{{ $id }}" {{ old('form_id') == $id ? 'selected' : '' }}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('form_id'))
                                    <span class="text-danger">{{ $errors->first('form_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">
                                        Start Date</label>

                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-sm form-control-solid flatpickr" placeholder="Start Date" name="start_date">
                                        @if ($errors->has('start_date'))
                                        <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                        @endif
                                    </div>
                                    <!-- <input class="form-control form-control-sm form-control-solid"
                                                           type="date" name="birth_day" autocomplete="off"/> -->
                                    <!--end::Input-->
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">
                                        End Date</label>

                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-sm form-control-solid flatpickr" placeholder="End Date" name="end_date">
                                        @if ($errors->has('end_date'))
                                        <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                        @endif
                                    </div>
                                    <!-- <input class="form-control form-control-sm form-control-solid"
                                                           type="date" name="birth_day" autocomplete="off"/> -->
                                    <!--end::Input-->
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Campaign Type</label>
                                    <select class="form-control form-control-sm form-control-solid" name="campaign_type">
                                        <option value="" disabled selected>Select Campaign Type</option>
                                        @foreach(config('constants.campaign_type') as $campaign_type)
                                        <option value="{{ $campaign_type }}">{{ $campaign_type }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('campaign_type'))
                                    <span class="text-danger">{{ $errors->first('campaign_type') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Campaign Limit</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="number" name="campaign_limit" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('campaign_limit'))
                                    <span class="text-danger">{{ $errors->first('campaign_limit') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Campaign Service</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="campaign_service" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('campaign_service'))
                                    <span class="text-danger">{{ $errors->first('campaign_service') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Template</label>
                                    <select class=" form-control form-control-sm form-control-solid" name="template_type"  id="templateType" aria-label="Default select example">

                                        <option value="Email" selected>Email</option>
                                        <option value="SMS">SMS</option>

                                    </select>
                                </div>
                            </div>

                             <div class="col-md-6"  id="emailFields">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Email Template</label>
                                    <select class=" form-control form-control-sm form-control-solid" name="email_template_id" aria-label="Default select example">
                                        <option value="">Select Email Template</option>
                                        @foreach($email as $id => $name)
                                        <option value="{{ $id }}">{{$name}}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('email_template_id'))
                                    <span class="text-danger">{{ $errors->first('email_template_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 d-none" id="smsFields">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">SMS Template</label>
                                    <select class=" form-control form-control-sm form-control-solid" name="sms_template_id" aria-label="Default select example">
                                        <option value="">Select SMS Template</option>
                                        @foreach($sms as $id => $name)
                                        <option value="{{ $id }}">{{$name}}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('sms_template_id'))
                                    <span class="text-danger">{{ $errors->first('sms_template_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Status</label>
                                    <select class=" form-control form-control-sm form-control-solid" name="status" aria-label="Default select example">

                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>

                                    </select>
                                </div>
                            </div>




                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Description</label>
                                    <textarea class="form-control form-control-sm  form-control-solid" name="description" rows="2"></textarea>
                                </div>
                            </div>



                        </div>
                        <!--End Row-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('campaign-create') }}" class="btn btn-light me-2">Reset</a>
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes
                            </button>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        $('[name="start_date"]').flatpickr({
            enableTime: true,  // enables time picker
            dateFormat: "Y-m-d H:i", // custom date format
            time_24hr: true,  // 24-hour time format
            onOpen: function(selectedDates, dateStr, instance) {
                if (!dateStr) { // only set current date if no date is already selected
                    instance.setDate(new Date());  // set current date and time when opened
                }
            }
        });

       
        $('[name="end_date"]').flatpickr({
            enableTime: true,  // enables time picker
            dateFormat: "Y-m-d H:i", // custom date format
            time_24hr: true,  // 24-hour time format
            onOpen: function(selectedDates, dateStr, instance) {
                if (!dateStr) { // only set current date if no date is already selected
                    instance.setDate(new Date());  // set current date and time when opened
                }
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const templateTypeSelect = document.getElementById('templateType');
        const emailFields = document.getElementById('emailFields');
        const smsFields = document.getElementById('smsFields');

        function toggleFields() {
            const selectedType = templateTypeSelect.value;
            if (selectedType === 'Email') {
                emailFields.classList.remove('d-none');
                smsFields.classList.add('d-none');
            } else if (selectedType === 'SMS') {
                emailFields.classList.add('d-none');
                smsFields.classList.remove('d-none');
            }
        }

        templateTypeSelect.addEventListener('change', toggleFields);

        // Initialize the fields based on the default selection
        toggleFields();
    });
</script>


@endsection
