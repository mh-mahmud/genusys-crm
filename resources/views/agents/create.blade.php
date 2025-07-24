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
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Agent Forms
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Agent form</small>
                                <!--end::Description--></h1>
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
                                                    <input class="form-check-input" type="checkbox" value="1"/>
                                                    <span class="form-check-label">Author</span>
                                                </label>
                                                <!--end::Options-->
                                                <!--begin::Options-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="2"
                                                           checked="checked"/>
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
                                                       name="notifications" checked="checked"/>
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
                            <a href="{{ route('agents-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Agent List</a>
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
                                        <h3 class="fw-bolder m-0">Agent Create</h3>
                                    </div>
                                    <!--end::Card title-->
                                </div>

                                <!-- Card Body-->
                                <div class="card-body">

                                    <!-- Start Form-->

                                    <form class="g-form w-100" action="{{ route('agents-store') }}"  enctype="multipart/form-data" method="POST">
                                         @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Email</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="email" name="email" value="{{ old('email') }}" autocomplete="off"/>
                                                    <!--end::Input-->
                                                    @if ($errors->has('email'))
                                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">
                                                        First Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="first_name" value="{{ old('first_name') }}" autocomplete="off"/>
                                                    <!--end::Input-->
                                                    @if ($errors->has('first_name'))
                                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">
                                                    Last Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="last_name" value="{{ old('last_name') }}" autocomplete="off"/>
                                                    <!--end::Input-->
                                                    @if ($errors->has('last_name'))
                                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">
                                                    Username</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="username" value="{{ old('username') }}" autocomplete="off"/>
                                                    <!--end::Input-->
                                                    @if ($errors->has('username'))
                                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">
                                                    Phone Number</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="phone_number" value="{{ old('phone_number') }}" autocomplete="off"/>
                                                    <!--end::Input-->
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Password</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="password" name="password" autocomplete="off"/>
                                                    <!--end::Input-->
                                                    @if ($errors->has('password'))
                                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Gender</label>
                                                    <select class=" form-control form-control-sm form-control-solid" name="gender"
                                                            aria-label="Default select example">
                                                            <option value="">Select Gender</option>
                                                            {{--<option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                            <option value="Other">Other</option>--}}
															<option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Set Role</label>
                                                    <select class="form-control form-control-sm form-control-solid" name="role_id" aria-label="Default select example">
                                                            <option value="">Select Role</option>
                                                            @foreach($role_list as $role)
                                                            <option @if(old('role_id')==$role->id) selected  @endif value="{{$role->id}}">{{$role->name}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">
                                                    Date Of Birth</label>

                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-sm form-control-solid flatpickr"
                                                            placeholder="Date Of Birth" name="birth_day" value="{{ old('birth_day') }}">
                                                    </div>
                                                    <!-- <input class="form-control form-control-sm form-control-solid"
                                                           type="date" name="birth_day" autocomplete="off"/> -->
                                                    <!--end::Input-->
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label  fw-bolder text-dark">Image Upload</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="file" name="profile_image" autocomplete="off"/>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Status</label>
                                                    <select class=" form-control form-control-sm form-control-solid" name="status"
                                                            aria-label="Default select example">

                                                            {{--<option value="1" selected>Active</option>
                                                        <option value="0">Inactive</option>--}}
														<option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Address</label>
                                                    <textarea class="form-control form-control-sm  form-control-solid" name="address" rows="3">{{ old('address') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Note</label>
                                                    <textarea class="form-control form-control-sm  form-control-solid" name="description" rows="3">{{ old('description') }}</textarea>
                                                </div>
                                            </div>


                                        </div>
                                        <!--End Row-->
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


            <!-- </div> -->
            <!--end::Content-->


@endsection
