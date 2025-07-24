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
                             class="page-title d-flex align-items-center flex-wrap me-3 mb-3 mb-lg-0">
                            <!--begin::Title-->
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">User
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">User Edit Form</small>
                                <!--end::Description--></h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">

                            <!--begin::Button-->
                            <a href="{{ URL::to('user-list') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">User List</a>
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

<!--Table Alert Message-->
<div class="text-center">
    <div class="row">
        <div class="col-md-5 mx-auto">
           @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> {{ session('error') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif


        </div>
    </div>
</div>

<!--End Table Alert Message-->

                <div class="container-xxl">
                    <div class="row">
                        <div class="col-xxl-12">
                            <div class="card card-xxl-stretch mt-4">
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title m-0">
                                        <h3 class="fw-bolder m-0">Edit User</h3>
                                    </div>
                                    <!--end::Card title-->
                                </div>

                                <!-- Card Body-->
                                <div class="card-body">

                                    <!-- Start Form-->

                                    <form class="g-form w-100" action="{{ route('user.update') }}"  enctype="multipart/form-data" method="POST">
                                         @csrf
                                        <div class="row">
                                            <input type="hidden" name="id" value="{{ $user_data->id }}">

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">
                                                        First Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="first_name"  value="{{ $user_data->first_name }}" autocomplete="off"/>
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
                                                           type="text" name="last_name"  value="{{ $user_data->last_name }}" autocomplete="off"/>
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
                                                           type="text" name="username"  value="{{ $user_data->username }}" autocomplete="off"/>
                                                    <!--end::Input-->
                                                    @if ($errors->has('username'))
                                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Email</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="email" readonly name="email"  value="{{ $user_data->email }}" autocomplete="off"/>
                                                    @if ($errors->has('email'))
                                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Phone Number</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text"  value="{{ $user_data->phone_number }}" name="phone_number" autocomplete="off"/>
                                                    @if ($errors->has('phone_number'))
                                                        <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">

                                                    <label class="form-label fw-bolder text-dark">Password</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="password" name="password" autocomplete="off"/>
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
                                                            <option @if($user_data->gender=='Male') selected  @endif value="Male">Male</option>
                                                            <option @if($user_data->gender=='Female') selected  @endif value="Female">Female</option>
                                                            <option @if($user_data->gender=='Others') selected  @endif value="Others">Others</option>
                                                    </select>
                                                    @if ($errors->has('gender'))
                                                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                                                    @endif
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Set Role</label>
                                                    <select class="form-control form-control-sm form-control-solid" name="role_id" aria-label="Default select example">
                                                            <option value="">Select Role</option>
                                                            @foreach($role_list as $role)
                                                            <option @if($user_data->role_id==$role->id) selected  @endif value="{{$role->id}}">{{$role->name}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Status</label>
                                                    <select class=" form-control form-control-sm form-control-solid" name="status" aria-label="Default select example">
                                                        <option value="">Select status</option>
                                                        <option @if($user_data->status=='1') selected  @endif value="1">Active</option>
                                                        <option @if($user_data->status=='0') selected  @endif value="0">Inactive</option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Address</label>
                                                    <textarea class="form-control form-control-sm  form-control-solid" name="address" rows="3">{{ $user_data->address }}</textarea>
                                                </div>
                                            </div>


                                        </div>
                                        <!--End Row-->
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            {{--<a href="{{ route('create-user') }}" class="btn btn-light btn-active-light-primary me-2">Reset</a>--}}
                                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Submit</button>
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
