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
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Result Code
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Result Code</small>
                    <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center py-1">

                <a href="{{ route('result-code-list') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Result Code
                    List</a>
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
            <div class="col-xl-12">
                <div class="card card-xxl-stretch mt-4">
                    <div class="card-header bg-light bd-cyan">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Result Code Create</h3>
                        </div>
                        <!--end::Card title-->
                    </div>

                    <!-- Card Body-->
                    <div class="card-body pb-2">

                        <!-- Start Form-->

                        <form class="g-form w-100" action="{{ route('add-result-code-pro') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-3">
                                        <!--begin::Label-->
                                        <label class="form-label fw-bolder text-dark">Result Code<span
                                                class="text-danger">*</span></label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-sm form-control-solid"
                                               type="text" name="code" autocomplete="off" value="{{ old('code') }}"/>
                                        <!--end::Input-->
                                        @if ($errors->has('code'))
                                            <span class="text-danger">{{ $errors->first('code') }}</span>
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
                                               type="text" name="title" autocomplete="off" value="{{ old('title') }}"/>
                                        <!--end::Input-->
                                        @if ($errors->has('title'))
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Result Group</label>
                                        <select class=" form-control form-control-sm form-control-solid" id="result_group_id" name="result_group_id"
                                                aria-label="Default select example">
                                            <option value=''>Select</option>
                                            @foreach($group_code as $code)
                                                <option value="{{$code->id}}" {{ old('result_group_id') == $code->id ? 'selected' : '' }}>{{ $code->group_description }}</option>
                                            @endforeach
                                        </select>
                                        {{-- @if ($errors->has('result_group_id'))
                                            <span class="text-danger">{{ $errors->first('result_group_id') }}</span>
                                        @endif --}}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Result Action</label>
                                        <select class=" form-control form-control-sm form-control-solid" id="result_action_id" name="result_action_id"
                                                aria-label="Default select example">
                                            <option value=''>Select</option>
                                            @foreach($result_action as $action)
                                                <option value="{{$action->id}}" {{ old('result_action_id') == $action->id ? 'selected' : '' }}>{{ $action->rule_description }}</option>
                                            @endforeach
                                        </select>
                                        {{-- @if ($errors->has('result_action_id'))
                                            <span class="text-danger">{{ $errors->first('result_action_id') }}</span>
                                        @endif --}}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Lead Status</label>
                                        <select class=" form-control form-control-sm form-control-solid" id="lead_status_id" name="lead_status_id"
                                                aria-label="Default select example">
                                            <option value=''>Select</option>
                                            @foreach($lead_status as $status)
                                                <option value="{{$action->id}}" {{ old('lead_status_id') == $status->id ? 'selected' : '' }}>{{ $status->status_name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- @if ($errors->has('lead_status_id'))
                                            <span class="text-danger">{{ $errors->first('lead_status_id') }}</span>
                                        @endif --}}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Comment Required</label>
                                        <select class=" form-control form-control-sm form-control-solid" name="comment_required"
                                                aria-label="Default select example">
                                            <option value=''>Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Selectable</label>
                                        <select class=" form-control form-control-sm form-control-solid" name="selectable"
                                                aria-label="Default select example">
                                            <option value=''>Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Active</label>
                                        <select class=" form-control form-control-sm form-control-solid" name="status" aria-label="Default select example">
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer d-flex justify-content-end">
                                <input type="reset" value="Reset" class="btn btn-sm btn-light me-2">
                                <button type="submit" class="btn btn-sm btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
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
