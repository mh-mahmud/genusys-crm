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
<div class="container-xxl container">
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2500
        });
    </script>
    @endif

    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: '{{ implode('', $errors->all()) }}',
            showConfirmButton: false,
            timer: 2500
        });
    </script>
    @endif
    <div class="row">
        <div class="col-xxl-12 col-md-10 mx-md-auto">
            <div class="card card-xxl-stretch mt-4">
                <div class="card-header bg-light bd-cyan">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Lead Create</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body pt-3">

                    <!-- Start Form-->

                    <form class="g-form w-100" action="{{ route('lead-store') }}" enctype="multipart/form-data" method="POST">
                        @csrf

                        <div class="row">

                            <!-- Left Side Inputs -->
                            <div class="col-md-6">
                                <div class="row">
                                    <h5 class="mb-2" style="border:1px solid #DDD;padding:7px;background-color:#54B4D3;color:#f7f7f7">Client Contact Information</h5>

                                    <div class="col-md-4">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">First Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="first_name" value="{{ old('first_name') }}" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('first_name'))
                                            <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Middle Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="middlename" value="{{ old('middlename') }}" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('middlename'))
                                            <span class="text-danger">{{ $errors->first('middlename') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Last Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="last_name" value="{{ old('last_name') }}" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('last_name'))
                                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Address</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            {{--<input class="form-control form-control-sm form-control-solid" type="text" name="address" value="{{ old('address') }}" autocomplete="off" />--}}
                                            <textarea class="form-control form-control-sm form-control-solid" name="address">{{ old('address') }}</textarea>
                                            <!--end::Input-->
                                            @if ($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Zip</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="zip" value="{{ old('zip') }}" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('zip'))
                                            <span class="text-danger">{{ $errors->first('zip') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Country</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="country" value="{{ old('country') }}" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('country'))
                                            <span class="text-danger">{{ $errors->first('country') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">City</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="city" value="{{ old('city') }}" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('city'))
                                            <span class="text-danger">{{ $errors->first('city') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">State</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="state" value="{{ old('state') }}" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('state'))
                                            <span class="text-danger">{{ $errors->first('state') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Time at Residence</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="time_at_residence" value="{{ old('time_at_residence') }}" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('time_at_residence'))
                                            <span class="text-danger">{{ $errors->first('time_at_residence') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Prior Address</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            {{--<input class="form-control form-control-sm form-control-solid" type="text" name="prior_address" value="{{ old('prior_address') }}" autocomplete="off" />--}}
                                            <textarea class="form-control form-control-sm form-control-solid" name="prior_address">{{ old('prior_address') }}</textarea>
                                            <!--end::Input-->
                                            @if ($errors->has('prior_address'))
                                            <span class="text-danger">{{ $errors->first('prior_address') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Cell Phone</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" value="{{ old('phone') }}" name="phone" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Home Phone</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" value="{{ old('home_phone') }}" name="home_phone" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('home_phone'))
                                            <span class="text-danger">{{ $errors->first('home_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Work Phone</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" value="{{ old('work_phone') }}" name="work_phone" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('work_phone'))
                                            <span class="text-danger">{{ $errors->first('work_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Email</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="email" name="email" value="{{ old('email') }}" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{--
                                    <div class="col-md-3">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Alternative Number</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="alternative_number" value="{{ old('alternative_number') }}" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('alternative_number'))
                                            <span class="text-danger">{{ $errors->first('alternative_number') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Contact Person Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="contact_person_name" value="{{ old('contact_person_name') }}" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('contact_person_name'))
                                            <span class="text-danger">{{ $errors->first('contact_person_name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Company</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="company" value="{{ old('company') }}" autocomplete="off" />
                                            <!--end::Input-->
                                            @if ($errors->has('company'))
                                            <span class="text-danger">{{ $errors->first('company') }}</span>
                                            @endif
                                        </div>
                                    </div>--}}

                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <label class="form-label fw-bolder text-dark">Lead Status</label>
                                            <select class="form-control form-control-sm form-control-solid" name="lead_status">
                                                <option value="">-- Select Status --</option>
                                                <option value="New">New</option>
                                                <option value="Qualified">Qualified</option>
                                                <option value="Proposition">Proposition</option>
                                                <option value="Ongoing">Ongoing</option>
                                                <option value="Won">Won</option>
                                                <option value="Lost">Lost</option>
                                            </select>
                                            @if ($errors->has('lead_status'))
                                            <span class="text-danger">{{ $errors->first('lead_status') }}</span>
                                            @endif
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <label class="form-label fw-bolder text-dark">Lead Source</label>
                                            <select class="form-control form-control-sm form-control-solid" name="lead_source">
                                                <option value="" disabled {{ old('lead_source') == '' ? 'selected' : '' }}>Select Lead Source</option>
                                                @foreach(config('constants.lead_source') as $source)
                                                <option value="{{ $source }}" {{ old('lead_source') == $source ? 'selected' : '' }}>
                                                    {{ $source }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('lead_source'))
                                            <span class="text-danger">{{ $errors->first('lead_source') }}</span>
                                            @endif
                                        </div>
                                    </div>




                                    <div class="col-md-6">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Lead Notes</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea class="form-control form-control-sm form-control-solid" name="lead_notes" rows="3">{{ old('lead_notes') }}</textarea>
                                            <!--end::Input-->
                                            @if ($errors->has('lead_notes'))
                                            <span class="text-danger">{{ $errors->first('lead_notes') }}</span>
                                            @endif
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <!-- <div class="col-md-1">
                                <div class="row">&nbsp;</div>
                            </div> -->

                            <!-- Right Side Placeholder -->
                            <div class="col-md-6">
                                <div class="row" style="margin-left:10px !important;">
                                    <h5 class="mb-2" style="border:1px solid #DDD;padding:7px;background-color:#54B4D3;color:#f7f7f7">Note Section</h5>

                                    <div class="col-md-12">
                                        <div class="fv-row mb-1">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Write a Note</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea class="form-control form-control-sm form-control-solid" name="lead_notes" rows="3">{{ old('lead_notes') }}</textarea>
                                            <!--end::Input-->
                                            @if ($errors->has('lead_notes'))
                                            <span class="text-danger">{{ $errors->first('lead_notes') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="fv-row mb-1">
                                            <label class="form-label fw-bolder text-dark">Result Code</label>
                                            <select class="form-control form-control-sm form-control-solid" name="result_codes_id">
                                                <option value="" disabled {{ old('result_codes_id') == '' ? 'selected' : '' }}>Select Code</option>
                                                @foreach($lead_result_codes as $result_code)
                                                <option value="{{ $result_code->id }}" {{ old('result_codes_id') == $result_code->id ? 'selected' : '' }}>
                                                    {{ $result_code->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('result_codes_id'))
                                            <span class="text-danger">{{ $errors->first('result_codes_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <div class="row" style="margin-left:10px !important;">
                                    <h5 class="mb-3" style="border:1px solid #DDD;padding:7px;background-color:#54B4D3;color:#f7f7f7">Action Information</h5>
                                      <span class="mb-2">Quote Number</span>          
                                    <div class="mb-5">
                                        <h5 class="custom-bottom-border">Dates</h4>
                                        <table class="custom-table">
                                                <tr>
                                                    <td>Created</td>
                                                    <td>{{ date("Y-m-d") }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Last modified</td>
                                                    <td>Not yet quoted</td>
                                                </tr>
                                                <tr>
                                                    <td>Bridged</td>
                                                    <td>Not yet exported</td>
                                                </tr>
                                        </table>
                                    </div>

                                     <div class="mb-5">
                                        <h5 class="custom-bottom-border">Producer Info</h5>
                                        <table class="custom-table">
                                                <tr>
                                                    <td>Assigned To</td>
                                                    <td>
                                                        <select class="form-control form-control-sm form-control-solid" name="assigned_to">
                                                            <option value="" {{ old('assigned_to') == '' ? 'selected' : '' }}>-- Select Lead --</option>
                                                            @foreach($users as $value)
                                                            <option value="{{ $value->id }}" {{ old('assigned_to') == $value->id ? 'selected' : '' }}>
                                                                {{ $value->first_name . " " . $value->last_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('assigned_to'))
                                                        <span class="text-danger">{{ $errors->first('assigned_to') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Created by</td>
                                                    <td>{{ Auth::user()->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Last modified</td>
                                                    <td>Not yet quoted</td>
                                                </tr>
                                                <tr>
                                                    <td>Submitted</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Bound</td>
                                                    <td></td>
                                                </tr>
                                                    <td>Region</td>
                                                    <td>None</td>
                                                </tr>
                                        </table>
                                    </div>
                                    <div class="mb-5">
                                        <h5 class="custom-bottom-border">Location</h5>
                                        <table class="custom-table">
                                            </tr>
                                                <td>Location</td>
                                                <td>US</td>
                                            </tr>
                                        </table>
                                    </div>

                                    {{--
                                    <div class="mb-5">
                                        <h5 class="custom-bottom-border">Last Carrier Saved</h5>
                                        <table class="custom-table">
                                            <tr>
                                                <td>Carrier</td>
                                                <td>Not yet quoted</td>
                                            </tr>
                                            <tr>
                                                <td>Total Premium</td>
                                                <td>Not yet quoted</td>
                                            </tr>
                                            <tr>
                                                <td>Down Payment</td>
                                                <td>Not yet quoted</td>
                                            </tr>
                                            <tr>
                                                <td>Payment</td>
                                                <td>Not yet quoted</td>
                                            </tr>
                                             <tr>
                                                <td>Payment Plan</td>
                                                <td>Not yet quoted</td>
                                            </tr>
                                        </table>
                                    </div>
                                    --}}

                                </div>
                            </div>

                        </div>


                        <div id="dynamic-fields" class="row">
                            <input type="hidden" name="form_id" value="{{ request()->input('form_id') }}">

                            @php
                            $cardCollection = collect($fieldsByTable);
                            @endphp

                            @foreach($cardCollection->chunk(2) as $rows)
                            <div class="row">
                                @foreach($rows as $tableName => $fields)
                                <div class="col-md-6" style="">
                                <h5 class="mb-0" style="border:1px solid #DDD;padding:7px;margin-bottom:10px;margin-top:30px;background-color:#54B4D3;color:#f7f7f7">{{ ucwords(str_replace('_', ' ', $tableName)) }}</h5>
                                
                                <div class="row" style="margin-top:20px">
                                    @foreach($fields as $field)
                                        <div class="col-md-6">
                                            <div class="fv-row mb-1">
                                                <label for="{{ $field->field_name }}" class="form-label fw-bolder text-dark">{{ ucwords(str_replace('_', ' ', $field->field_name)) }}</label>
                                                @if(in_array($field->field_value, ['varchar', 'char']))
                                                <input type="text" class="form-control form-control-sm form-control-solid" id="{{ $field->field_name }}" name="{{ $field->field_name }}" value="{{ old($field->field_name) }}">
                                                @elseif($field->field_value == 'int')
                                                <input type="number" class="form-control form-control-sm form-control-solid" id="{{ $field->field_name }}" name="{{ $field->field_name }}" value="{{ old($field->field_name) }}">
                                                @elseif($field->field_value == 'date')
                                                <input type="date" class="form-control form-control-sm form-control-solid" id="common_dob" name="{{ $field->field_name }}" value="{{ old($field->field_name) }}">
                                                @elseif($field->field_value == 'text')
                                                <textarea class="form-control form-control-sm form-control-solid" name="{{ $field->field_name }}" rows="1">{{ old($field->field_name) }}</textarea>
                                                @elseif($field->field_value == 'file')
                                                <input type="file" class="form-control form-control-sm form-control-solid" name="{{ $field->field_name }}">
                                                @elseif($field->field_value == 'dropdown')
                                                @php
                                                // Split the character_length string into an array of options
                                                $dropdownOptions = explode(',', $field->character_length);
                                                @endphp

                                                <select class="form-control form-control-sm form-control-solid" name="{{ $field->field_name }}" id="{{ $field->field_name }}">
                                                    {{--<option value="" selected>Select {{ ucwords(str_replace('_', ' ', $field->field_name)) }}</option>--}}
                                                    <option value="" selected>-- Select --</option>
                                                    @foreach($dropdownOptions as $option)
                                                    <option value="{{ $option }}" {{ old($field->field_name) == $option ? 'selected' : '' }}>
                                                        {{ ucfirst($option) }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                </div>

                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        
                           
                        </div>
                        <!--End Row-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Submit</button>
                        </div>

                    </form>
                    <!-- End Form-->

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