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
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Permission Form</small>
                                <!--end::Description--></h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">

                            <!--begin::Button-->
                            <a href="{{ URL::to('permission-list') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Permission List</a>
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
                                        <h3 class="fw-bolder m-0">Create Permission</h3>
                                    </div>
                                    <!--end::Card title-->
                                </div>

                                <!-- Card Body-->
                                <div class="card-body">

                                    <!-- Start Form-->

                                    <form class="g-form w-100" action="{{ route('store-permission') }}"  enctype="multipart/form-data" method="POST">
                                         @csrf
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Parent ID</label>
                                                    <select class=" form-control form-control-sm form-control-solid" name="parent_id"
                                                            aria-label="Default select example">
                                                            <option value="">Select option</option>
                                                            @foreach($list as $key=>$val)
                                                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">
                                                        Permision Name</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" name="name" autocomplete="off" required />
                                                    @if ($errors->has('name'))
                                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Permision Slug</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" name="slug" autocomplete="off"/>
                                                    @if ($errors->has('slug'))
                                                        <span class="text-danger">{{ $errors->first('slug') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Show in Menu</label>
                                                    <select class=" form-control form-control-sm form-control-solid" name="show_in_menu" aria-label="Default select example" required>
                                                            <option value="">Select option</option>
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Details</label>
                                                    <textarea class="form-control form-control-sm  form-control-solid" name="address" rows="3"></textarea>
                                                </div>
                                            </div> -->


                                        </div>
                                        <!--End Row-->
                                      <div class="card-footer d-flex justify-content-end py-6 px-9">
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
