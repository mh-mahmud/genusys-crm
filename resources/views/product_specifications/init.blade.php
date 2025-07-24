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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Product Specification Forms
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Product Specification form</small>
                <!--end::Description-->
            </h1>
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
                                    <input class="form-check-input" type="checkbox" value="1" />
                                    <span class="form-check-label">Author</span>
                                </label>
                                <!--end::Options-->
                                <!--begin::Options-->
                                <label
                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="2"
                                        checked="checked" />
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
                                    name="notifications" checked="checked" />
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
            <a href="{{ route('product-specification-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Product Specification List</a>
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
                        <h3 class="fw-bolder m-0">Product Specification Create</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form w-100" action="{{ route('product-specification-init-store') }}" enctype="multipart/form-data" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-5">
                                    <label class="form-label fw-bolder text-dark">Customer<span class="text-danger">*</span>

                                    </label>
                                    <!-- <select class="form-control form-control-sm form-control-solid" name="customer_id" aria-label="Default select example">
                                        <option value="" {{ old('customer_id') == '' ? 'selected' : '' }}>Select Customer</option>
                                        @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->first_name }} {{ $customer->last_name }}
                                        </option>
                                        @endforeach
                                    </select> -->
                                    <select  class="form-control form-control-sm form-control-solid" id="customerSelect" name="customer_id" data-allow-clear="true"
                                        data-kt-select2="select2">
                                            <option value="" {{ old('customer_id') == '' ? 'selected' : '' }}>Select Customer</option>
                                            @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" 
                                                {{ old('customer_id') == $customer->id || (isset($leadid) && $customer->lead_id == $leadid) ? 'selected' : '' }}>
                                                {{ $customer->first_name }} {{ $customer->last_name }}
                                            </option>
                                            @endforeach
                                    </select>
                                    @if ($errors->has('customer_id'))
                                    <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                                    @endif

                                </div>
                            </div>


                            <div class="col-md-6">
                                <label class="form-label fw-bolder text-dark">Product</label>
                                <select id="product-select" class="form-control form-control-sm form-control-solid"
                                    name="product_id[]"
                                    multiple="multiple"
                                    data-allow-clear="true"
                                    data-kt-select2="select2">
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ is_array(old('product_id')) && in_array($product->id, old('product_id')) ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                    @endforeach
                                </select>
                                
                                @if ($errors->has('product_id'))
                                <div class="text-danger">{{ $errors->first('product_id') }}</div>
                                @endif
                            </div>

                            <div class="col-md-2"><label class="form-label fw-bolder text-dark">[click to generate form]</label><button type="submit" class="btn btn-sm btn-success" id="product-values">Generate Form</button></div>

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

<script>




    document.addEventListener('DOMContentLoaded', function() {
        $('#product-select').select2({
            placeholder: "Select Products",
            allowClear: true,
        });

        $('#product-select').on("change", function() {
            var val = $(this).val();
        });


    });
</script>


@endsection