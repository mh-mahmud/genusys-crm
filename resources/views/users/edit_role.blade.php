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
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">User
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Role Form</small>
                                <!--end::Description--></h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">
                            <!--begin::Button-->
                            <a href="{{ URL::to('role-list') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Role List</a>
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
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title m-0">
                                        <h3 class="fw-bolder m-0">Create Role</h3>
                                    </div>
                                    <!--end::Card title-->
                                </div>

                                <!-- Card Body-->
                                <div class="card-body">

                                    <!-- Start Form-->

                                    <form class="g-form w-100" action="{{ route('role-update') }}"  enctype="multipart/form-data" method="POST">
                                         @csrf
                                        <div class="row">
                                            <input type="hidden" name="id" value="{{ $role_data->id }}">

                                            <div class="col-md-12">
                                                <div class="fv-row mb-3">

                                                    <label class="form-label fw-bolder text-dark">Role Name</label>
                                                    <input class="form-control form-control-sm form-control-solid" value="{{ $role_data->name }}" type="text" name="role_name" autocomplete="off"/>
                                                    @if ($errors->has('role_name'))
                                                        <span class="text-danger">{{ $errors->first('role_name') }}</span>
                                                    @endif

                                                </div>
                                            </div>

                                            @foreach($menus as $key=>$value)
                                                <div class="col-md-6">
                                                    <div class="fv-row mb-3">
                                                        <label class="form-label fw-bolder text-dark">{{ str_replace("_", " ", $key) }}</label>

                                                        @foreach($value as $k=>$v)
                                                        <div class="form-check mt-3" style="margin-left: 20px;">
                                                            <input @php if(in_array($v->id, $ids)) echo "checked" @endphp class="form-check-input" type="checkbox" name="{{$key}}[]" value="{{ $v->id }}">
                                                            <label class="form-check-label">{{$v->name}}</label>
                                                        </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            @endforeach


                                        </div>
                                        <!--End Row-->
                                      <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Submit
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
