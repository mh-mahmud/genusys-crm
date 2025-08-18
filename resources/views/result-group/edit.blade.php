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
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Result Group
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Result Group</small>
                                <!--end::Description--></h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">

                            <a href="{{ route('result-group-list') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Result group List</a>
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
                                        <h3 class="fw-bolder m-0">Result Group Edit</h3>
                                    </div>
                                    <!--end::Card title-->
                                </div>

                                <!-- Card Body-->
                                <div class="card-body">

                                    <!-- Start Form-->

                                    <form class="g-form w-100" action="{{ route('result-group-update-pro', $result_group->id) }}"  method="POST" enctype="multipart/form-data">
                                         @csrf
                                         @method('PUT')

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Result Group Code<span
                                                            class="text-danger">*</span></label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                        type="text" name="group_code" autocomplete="off" value="{{ old('group_code', $result_group->group_code) }}"/>
                                                    <!--end::Input-->
                                                    @if ($errors->has('group_code'))
                                                        <span class="text-danger">{{ $errors->first('group_code') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Result Description<span
                                                            class="text-danger">*</span></label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                        type="text" name="group_description" autocomplete="off" value="{{ old('group_description', $result_group->group_description) }}"/>
                                                    <!--end::Input-->
                                                    @if ($errors->has('group_description'))
                                                        <span class="text-danger">{{ $errors->first('group_description') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Active</label>
                                                    <select class=" form-control form-control-sm form-control-solid" name="status" aria-label="Default select example">
                                                        <option value="1" {{ old('status', $result_group->status) == 1 ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ old('status', $result_group->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                            
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <input type="reset" value="Reset" class="btn btn-light me-2">
                                            <button type="submit" class="btn btn-primary"
                                                    id="kt_account_profile_details_submit">Save Changes
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
