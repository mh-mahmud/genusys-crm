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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Agent Edit Forms
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Agent Edit form</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
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
                        <h3 class="fw-bolder m-0">Agent Edit</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form w-100" action="{{ route('agents-update', $agent->agent_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Email</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid"
                                        type="email" name="email" value="{{ old('email', $user->email) }}" autocomplete="off" />
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
                                        type="text" name="first_name" value="{{ $agent->first_name }}" autocomplete="off" />
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
                                        type="text" name="last_name" value="{{ $agent->last_name }}" autocomplete="off" />
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
                                        type="text" name="username" value="{{$user->username }}" autocomplete="off" />
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
                                        type="text" name="phone_number" value="{{ $agent->phone_number }}" autocomplete="off" />
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
                                        type="password" name="password" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Gender</label>
                                    <select class="form-control form-control-sm form-control-solid" name="gender" aria-label="Default select example">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ $agent->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ $agent->gender === 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ $agent->gender === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Set Role</label>
                                    <select class="form-control form-control-sm form-control-solid" name="role_id" aria-label="Default select example">
                                            <option value="">Select Role</option>
                                            @foreach($role_list as $role)
                                            <option @if($agent->role_id==$role->id) selected  @endif value="{{$role->id}}">{{$role->name}}</option>
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
                                            placeholder="Date Of Birth" name="birth_day" value="{{ $agent->birth_day }}">
                                    </div>
                                    <!-- <input class="form-control form-control-lg form-control-solid"
                                                           type="date" name="birth_day" value="{{ $agent->birth_day }}" autocomplete="off"/> -->
                                    <!--end::Input-->
                                </div>
                            </div>



                            {{--<div class="col-md-6">
                                <div class="fv-row mb-3">

                                    <label class="form-label  fw-bolder text-dark">Image
                                        Upload</label>

                                    <input class="form-control form-control-sm form-control-solid"
                                        type="file" name="profile_image" autocomplete="off" />

                                </div>
                            </div>--}}

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label  fw-bolder text-dark">Image Upload</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="file" name="profile_image" autocomplete="off" />

                                    @if ($user->profile_image)
                                    <div class="mt-3" id="profile-image-container">
                                        <img src="{{ asset('uploads/agents/' . $user->profile_image) }}" alt="Profile Image" width="100px">
                                        <button type="button" class="btn btn-danger btn-sm p-2" id="delete-profile-image">
                                            <i class="fas fa-trash-alt pe-0"></i>
                                        </button>
                                    </div>

                                    @else
                                        <img alt="Logo" src="{{ asset('uploads/noimage.jpg') }}" width="100px"/>
                                    @endif

                                    <!--end::Input-->
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Status</label>
                                    <select class="form-control form-control-sm form-control-solid" name="status" aria-label="Default select example">
                                        <option value="1" {{ $agent->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $agent->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Address</label>
                                    <textarea class="form-control form-control-sm  form-control-solid" name="address" rows="3">{{ $agent->address }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Note</label>
                                    <textarea class="form-control form-control-sm  form-control-solid" name="description" rows="3">{{ $agent->description }}</textarea>
                                </div>
                            </div>


                        </div>
                        <!--End Row-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update Changes</button>
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
        $('#delete-profile-image').click(function() {
            if (confirm('Are you sure you want to delete your profile image?')) {
                $.ajax({
                    url: '{{ route('update-profile-image', $user->id) }}', // Using the correct route
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

@endsection
