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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Lead
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Lead</small>
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
                                Forms
                  ***********************************-->
<div class="container-xxl">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card card-xxl-stretch mt-4">
                <div class="card-header bg-light bd-cyan">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Lead Edit</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form w-100" action="{{ route('lead-update', $lead->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Form Name</label>
                                    <select class="form-control form-control-sm form-control-solid" name="form_id" aria-label="Default select example" disabled>
                                        <option value="">Select Form Name</option>
                                        @foreach($formName as $id => $name)
                                        <option value="{{ $id }}" {{ $lead->form_id == $id ? 'selected' : '' }}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('form_id'))
                                    <span class="text-danger">{{ $errors->first('form_id') }}</span>
                                    @endif
                                </div>
                            </div>



                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">First Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="first_name" value="{{ old('first_name', $lead->first_name) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Last Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="last_name" value="{{ old('last_name', $lead->last_name) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('last_name'))
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Email</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="email" name="email" value="{{ old('email', $lead->email) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Phone</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="phone" value="{{ old('phone', $lead->phone) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Alternative Number</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="alternative_number" value="{{ old('alternative_number', $lead->alternative_number) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('alternative_number'))
                                    <span class="text-danger">{{ $errors->first('alternative_number') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Gender</label>
                                    <select class="form-control form-control-sm form-control-solid" name="gender" aria-label="Default select example">
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="Male" {{ $lead->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ $lead->gender === 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ $lead->gender === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>




                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Date of Birth</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-sm form-control-solid flatpickr" placeholder="Date Of Birth" name="dob" value="{{ old('dob', $lead->dob) }}">
                                    </div>
                                    <!--end::Input-->
                                    @if ($errors->has('dob'))
                                    <span class="text-danger">{{ $errors->first('dob') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Age</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="position-relative">
                                        <input type="number" class="form-control form-control-sm form-control-solid flatpickr" placeholder="Age" name="age" value="{{ old('age', $lead->age) }}">
                                    </div>
                                    <!--end::Input-->
                                    @if ($errors->has('age'))
                                    <span class="text-danger">{{ $errors->first('age') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Marital Status</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-control form-control-sm form-control-solid" name="marital_status">
                                        <option value="" disabled selected>Select Marital Status</option>
                                        @foreach(config('constants.marital_status') as $status)
                                        <option value="{{ $status }}" {{$lead->marital_status== $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                    @if ($errors->has('marital_status'))
                                    <span class="text-danger">{{ $errors->first('marital_status') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Address</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="address" value="{{ old('address', $lead->address) }}" autocomplete="off" />
                                    @if ($errors->has('address'))
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Company -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Company</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="company" value="{{ old('company', $lead->company) }}" autocomplete="off" />
                                    @if ($errors->has('company'))
                                    <span class="text-danger">{{ $errors->first('company') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Lead Status -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Lead Status</label>
                                    <select class="form-control form-control-sm form-control-solid" name="lead_status">
                                        <option value="1" {{$lead->lead_status == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{$lead->lead_status== '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @if ($errors->has('lead_status'))
                                    <span class="text-danger">{{ $errors->first('lead_status') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Title</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="title" value="{{ old('title', $lead->title) }}" autocomplete="off" />
                                    @if ($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Lead Rating -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Lead Rating</label>
                                    <input class="form-control form-control-sm form-control-solid" type="number" name="lead_rating" value="{{ old('lead_rating', $lead->lead_rating) }}" autocomplete="off" />
                                    @if ($errors->has('lead_rating'))
                                    <span class="text-danger">{{ $errors->first('lead_rating') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Website</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="website" value="{{ old('website', $lead->website) }}" autocomplete="off" />
                                    @if ($errors->has('website'))
                                    <span class="text-danger">{{ $errors->first('website') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Lead Owner -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Lead Owner</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="lead_owner" value="{{ old('lead_owner', $lead->lead_owner) }}" autocomplete="off" />
                                    @if ($errors->has('lead_owner'))
                                    <span class="text-danger">{{ $errors->first('lead_owner') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Industry -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Industry</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="industry" value="{{ old('industry', $lead->industry) }}" autocomplete="off" />
                                    @if ($errors->has('industry'))
                                    <span class="text-danger">{{ $errors->first('industry') }}</span>
                                    @endif
                                </div>
                            </div>


                            <!-- Lead Source -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Lead Source</label>
                                    <select class="form-control form-control-sm form-control-solid" name="lead_source">
                                        <option value="" disabled>Select Lead Source</option>
                                        @foreach(config('constants.lead_source') as $source)
                                        <option value="{{ $source }}" {{ $lead->lead_source == $source ? 'selected' : '' }}>{{ $source }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('lead_source'))
                                    <span class="text-danger">{{ $errors->first('lead_source') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Street -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Street</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="street" value="{{ old('street', $lead->street) }}" autocomplete="off" />
                                    @if ($errors->has('street'))
                                    <span class="text-danger">{{ $errors->first('street') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">City</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="city" value="{{ old('city', $lead->city) }}" autocomplete="off" />
                                    @if ($errors->has('city'))
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Zip -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Zip</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="zip" value="{{ old('zip', $lead->zip) }}" autocomplete="off" />
                                    @if ($errors->has('zip'))
                                    <span class="text-danger">{{ $errors->first('zip') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- State -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">State</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="state" value="{{ old('state', $lead->state) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('state'))
                                    <span class="text-danger">{{ $errors->first('state') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Country -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Country</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="country" value="{{ old('country', $lead->country) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('country'))
                                    <span class="text-danger">{{ $errors->first('country') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Lead Notes -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Lead Notes</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea class="form-control form-control-sm form-control-solid" name="lead_notes" rows="3">{{ old('lead_notes', $lead->lead_notes) }}</textarea>
                                    <!--end::Input-->
                                    @if ($errors->has('lead_notes'))
                                    <span class="text-danger">{{ $errors->first('lead_notes') }}</span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div id="dynamic-fields" class="row">
                            <input type="hidden" name="form_id" value="{{ $lead->form_id }}">
                            @foreach($fieldsByTable as $tableName => $fields)
                            <div class="col-md-12">
                                <h5><u>{{ ucwords(str_replace('_', ' ', $tableName)) }}</u></h5>
                            </div>
                            @foreach($fields as $field)
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label for="{{ $field->field_name }}" class="form-label fw-bolder text-dark">{{ ucwords(str_replace('_', ' ', $field->field_name)) }}</label>
                                    @php
                                    $value = isset($tableData[$tableName]) ? $tableData[$tableName]->{$field->field_name} : null;
                                    @endphp
                                    @if(in_array($field->field_value, ['varchar', 'char']))
                                    <input type="text" class="form-control form-control-sm form-control-solid" id="{{ $field->field_name }}" name="{{ $field->field_name }}" value="{{ old($field->field_name, $value) }}">
                                    @elseif($field->field_value == 'int')
                                    <input type="number" class="form-control form-control-sm form-control-solid" id="{{ $field->field_name }}" name="{{ $field->field_name }}" value="{{ old($field->field_name, $value) }}">
                                    @elseif($field->field_value == 'date')
                                    <input type="date" class="form-control form-control-sm form-control-solid" id="common_dob" name="{{ $field->field_name }}" value="{{ old($field->field_name, $value) }}">
                                    @elseif($field->field_value == 'text')
                                    <textarea class="form-control form-control-sm form-control-solid" name="{{ $field->field_name }}" rows="1">{{ old($field->field_name, $value) }}</textarea>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @endforeach
                        </div>


                        <!--End Row-->

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('lead-edit', $lead->id) }}" class="btn btn-light me-2">Reset</a>
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update Changes
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

@endsection
