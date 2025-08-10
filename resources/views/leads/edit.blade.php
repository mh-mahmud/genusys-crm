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
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success')}}',
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
            text: '{{ session('error ')}}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    @endif
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
									
									@if(isset($lead->form_id) && $lead->form_id)
										<!-- Form dropdown with 'disabled' attribute if form_id is set -->
										<select class="form-control form-control-sm form-control-solid" name="form_id" aria-label="Default select example" disabled>
											<option value="">Select Form Name</option>
											@foreach($formName as $id => $name)
												<option value="{{ $id }}" {{ $lead->form_id == $id ? 'selected' : '' }}>{{ $name }}</option>
											@endforeach
										</select>
										@if ($errors->has('form_id'))
										<span class="text-danger">{{ $errors->first('form_id') }}</span>
									    @endif
										<!-- hidden input when form is submitted -->
										<input type="hidden" name="form_id" value="{{ $lead->form_id }}">
									@else
										<!-- without 'disabled' attribute if form_id is not set -->
										<select class="form-control form-control-sm form-control-solid" name="form_id" aria-label="Default select example">
											<option value="">Select Form Name</option>
											@foreach($formName as $id => $name)
												<option value="{{ $id }}" {{ $lead->form_id == $id ? 'selected' : '' }}>{{ $name }}</option>
											@endforeach
										</select>
									@endif

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

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Time at Residence</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="time_at_residence" value="{{ old('time_at_residence', $lead->time_at_residence) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('time_at_residence'))
                                    <span class="text-danger">{{ $errors->first('time_at_residence') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Prior Address</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="prior_address" value="{{ old('prior_address', $lead->prior_address) }}" autocomplete="off" />
                                    @if ($errors->has('prior_address'))
                                    <span class="text-danger">{{ $errors->first('prior_address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Cell Phone</label>
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
                                    <label class="form-label fw-bolder text-dark">Home Phone</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="home_phone" value="{{ old('home_phone', $lead->home_phone) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('home_phone'))
                                    <span class="text-danger">{{ $errors->first('home_phone') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Work Phone</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="work_phone" value="{{ old('work_phone', $lead->work_phone) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('work_phone'))
                                    <span class="text-danger">{{ $errors->first('work_phone') }}</span>
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

                            <!-- Lead Status -->
                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Lead Status</label>
                                    <select class="form-control form-control-sm form-control-solid" name="lead_status">
                                        <option value="">-- Select Status --</option>
                                        <option value="New" {{$lead->lead_status == 'New' ? 'selected' : '' }}>New</option>
                                        <option value="Qualified" {{$lead->lead_status== 'Qualified' ? 'selected' : '' }}>Qualified</option>
                                        <option value="Proposition" {{$lead->lead_status== 'Proposition' ? 'selected' : '' }}>Proposition</option>
                                        <option value="Ongoing" {{$lead->lead_status== 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                        <option value="Won" {{$lead->lead_status== 'Won' ? 'selected' : '' }}>Won</option>
                                        <option value="Lost" {{$lead->lead_status== 'Lost' ? 'selected' : '' }}>Lost</option>
                                    </select>
                                    @if ($errors->has('lead_status'))
                                    <span class="text-danger">{{ $errors->first('lead_status') }}</span>
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




                            {{--
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
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Contact Person Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="contact_person_name" value="{{ old('contact_person_name', $lead->contact_person_name) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('contact_person_name'))
                                    <span class="text-danger">{{ $errors->first('contact_person_name') }}</span>
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



                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Lead Start Date</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid flatpickr" type="text" id="common_dob" name="lead_start_date" value="{{ old('lead_start_date', $lead->lead_start_date) }}" />
                                    <!--end::Input-->
                                    @if ($errors->has('lead_start_date'))
                                    <span class="text-danger">{{ $errors->first('lead_start_date') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fv-row mb-3">
                                    <label class="form-label  fw-bolder text-dark">Profile Image</label>
                                    <input class="form-control form-control-sm form-control-solid" type="file" name="profile_image" autocomplete="off"/>
                                    @if ($lead->profile_image)
                                    <div class="mt-3" id="profile-image-container">
                                        <img src="{{ asset('uploads/leads/' . $lead->profile_image) }}" alt="Profile Image" width="100px">
                                        <button type="button" class="btn btn-danger btn-sm p-2" id="delete-profile-image">
                                            <i class="fas fa-trash-alt pe-0"></i>
                                        </button>
                                    </div>

                                    @else
                                        <img alt="Logo" src="{{ asset('uploads/noimage.jpg') }}" width="100px"/>
                                    @endif
                                    
                                </div>
                            </div>--}}


                        </div>

                        @foreach ($tableData as $tableName => $data)
                        @if ($data->isNotEmpty())
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5><u>{{ ucwords(str_replace('_', ' ', $tableName)) }}</u></h5>

                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                    <thead>
                                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                                            <th class="ps-4 min-w-50px">SL</th>
                                            @foreach ($data->first() as $key => $value)
                                            @if (!in_array($key, ['id', 'lead_id', 'form_id','created_by','created_at', 'updated_at']))
                                            <th class="ps-4 min-w-150px">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                            @endif
                                            @endforeach
                                            <th class="ps-4 min-w-150px">Created By</th>
                                            <th class="min-w-50px text-end pe-4">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $index => $row)
                                        <tr>
                                            <td class="ps-4 text-dark fs-6">{{ $index + 1 }}</td>
                                            @foreach ($row as $key => $value)
                                            @if (!in_array($key, ['id', 'lead_id', 'form_id','created_by','created_at', 'updated_at']))
                                            <td class="ps-5 text-dark fs-6">{{ $value }}</td>
                                            @endif
                                            @endforeach
                                            <td class="ps-5 text-dark fs-6">{{ $row->created_by }}</td>
                                            <td class="text-end pe-4">

                                                <a href="{{ route('lead-edit-tabledata', ['tableName' => $tableName, 'leadId' => $row->id]) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </a>

                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        @endif
                        @endforeach


                        <!--End Row-->

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            {{--<a href="{{ route('lead-edit', $lead->id) }}" class="btn btn-light me-2">Reset</a>--}}
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#delete-profile-image').click(function() {
            if (confirm('Are you sure you want to delete your Lead profile image?')) {
                $.ajax({
                    url: '{{ route('update-lead-profile-image', $lead->id) }}', // Using the correct route
                    type: 'PUT', // Correct HTTP method
                    data: {
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#profile-image-container').remove();
                           // alert('Profile image deleted successfully');
                        } else {
                            alert('Error deleting profile image');
                        }
                    },
                    error: function() {
                        alert('Error deleting profile image');
                    }
                });
            }
        });
    });
    </script>
<!-- End Forms-->


<!-- </div> -->
<!--end::Content-->

@endsection
