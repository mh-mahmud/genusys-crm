@extends('layouts.master')

@section('content')

    @php
        $routes = config('constants.route_options');
        $selectedRoute = old('route');
    @endphp
	<div class="toolbar" id="kt_toolbar">
                    <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Product
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Product</small>
                    <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center py-1">

                <a href="{{ route('feature-list') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Help List</a>
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
                            <h3 class="fw-bolder m-0">Help Create</h3>
                        </div>
                        <!--end::Card title-->
                    </div>

                    <!-- Card Body-->
                    <div class="card-body">

                        <!-- Start Form-->

                        <form class="g-form w-100" action="{{ route('feature-create-pro') }}"  method="POST" enctype="multipart/form-data">
                                @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-3">
                                        <!--begin::Label-->
                                        <label class="form-label fw-bolder text-dark">Title<span class="text-danger">*</span></label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-sm form-control-solid"
                                                type="text" name="title" autocomplete="off" value="{{ old('title') }}" />
                                        <!--end::Input-->
                                        @if ($errors->has('title'))
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="fv-row mb-3">
                                        <!--begin::Label-->
                                        <label class="form-label fw-bolder text-dark">Route<span class="text-danger">*</span></label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class=" form-control form-control-sm form-control-solid" name="route">
                                            <option value=''>Select</option>
                                            @foreach($routes as $value => $label)
                                                <option value="{{ $value }}" {{ $selectedRoute == $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('route'))
                                            <span class="text-danger">{{ $errors->first('route') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label fw-bolder text-dark"
                                                for="textarea">Content<span
                                                    class="text-danger">*</span></label>
                                            <textarea
                                                class="form-control form-control-sm  form-control-solid editor"
                                                id="description" name="description"
                                                rows="3">{{ old('description') }}</textarea>
                                            @if ($errors->has('description'))
                                                <span
                                                    class="text-danger">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Status</label>
                                        <select class=" form-control form-control-sm form-control-solid" name="status"
                                                aria-label="Default select example">

                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>

                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-5">
                                <input type="reset" id="resetButton" value="Reset" class="btn btn-light">
                                <button type="submit" class="btn btn-primary"
                                        id="kt_account_profile_details_submit">Send
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
