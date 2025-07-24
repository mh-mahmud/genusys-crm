@extends('layouts.master')
@php
use Carbon\Carbon;
@endphp

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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Product Specification Details
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Product Specification Details</small>
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
                             Tables View
               ***********************************-->
<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-8 mx-auto">
            <!-- <div class="card mb-5"> -->
            <div class="card mt-4">
                <div class="card-header bg-light bd-cyan">
                    <div class="card-title">
                        <h2>Product Specification Details</h2>
                    </div>
                </div>
                <!--begin::Body-->
                <div class="card-body p-4">

                <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Customer:</span>
                        <span>{{$productSpecification->first_name?? '' }} {{$productSpecification->last_name?? '' }}</span>
                </div>

                <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Product Name:</span>
                        <span>{{ $productSpecification->product_names ?? '' }}</span>
                </div>

                <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Work Order Number:</span>
                        <span>{{ $productSpecification->work_order_number }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Work Order Value:</span>
                        <span>{{ number_format($productSpecification->work_order_value, 2) }}</span>
                    </div>

                    @if($productSpecification->work_order_file)
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Work Order File:</span>
                        <a href="{{ asset('uploads/product_specification/' . $productSpecification->work_order_file) }}" target="_blank">Download</a>
                    </div>
                    @endif

                    <!-- new data -->
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Advance Amount:</span>
                        <span>{{ number_format($productSpecification->advance_amount) }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Total Installment:</span>
                        <span>{{ $productSpecification->total_installment }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Per Month Installment:</span>
                        <span>{{ number_format($productSpecification->per_month_installment) }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Payment Date Cycle:</span>
                        <span>{{ $productSpecification->payment_date_cycle }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Remaining Month:</span>
                        <span>{{ $productSpecification->remaining_month }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Due Balance:</span>
                        <span>{{ number_format($productSpecification->due_balance) }}</span>
                    </div>
                    <!-- end new data -->

                    
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Purchase Order Value:</span>
                        <span>{{ number_format($productSpecification->purchase_order_value, 2) }}</span>
                    </div>

                    @if($productSpecification->purchase_order_file)
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Purchase Order File:</span>
                        <a href="{{ asset('uploads/product_specification/' . $productSpecification->purchase_order_file) }}" target="_blank">Download</a>
                    </div>
                    @endif

                   
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">AMC Start Date:</span>
                        <span>{{ $productSpecification->amc_start_date ? \Carbon\Carbon::parse($productSpecification->amc_start_date)->format('d-m-Y') : '' }}
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">AMC Renewal Date:</span>
                        <span>{{ $productSpecification->amc_renewal_date ? \Carbon\Carbon::parse($productSpecification->amc_renewal_date)->format('d-m-Y') : '' }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">AMC Rate (%):</span>
                        <span>{{ !empty($productSpecification->amc_rate) ? $productSpecification->amc_rate . '%' : '' }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Rental Amount:</span>
                        <span>{{ number_format($productSpecification->rental_amount, 2) }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">AMC Effective Amount:</span>
                        <span>{{ number_format($productSpecification->amc_effective_amount, 2) }}</span>
                    </div>

                    @if($productSpecification->amc_agreement_documents)
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">AMC Agreement Documents:</span>
                        <a href="{{ asset('uploads/product_specification/' . $productSpecification->amc_agreement_documents) }}" target="_blank">Download</a>
                    </div>
                    @endif


                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Service Type:</span>
                        <span>{{ $productSpecification->service_type }}</span>
                    </div>

                   
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px flex-shrink-0">Software Value:</span>
                        <span>{{ $productSpecification->software_value }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px flex-shrink-0">Hardware Value:</span>
                        <span>{{ $productSpecification->hardware_value }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px flex-shrink-0">Implementation Cost:</span>
                        <span>{{ $productSpecification->implementation_value }}</span>
                    </div>

                    @if($productSpecification->invoice_mushak_file)
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Invoice Mushak File:</span>
                        <a href="{{ asset('uploads/product_specification/' . $productSpecification->invoice_mushak_file) }}" target="_blank">Download</a>
                    </div>
                    @endif

                    @if($productSpecification->tax_exemption_certificate)
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                        <span class="fw-bold w-lg-150px">Tax Exemption Certificate:</span>
                        <a href="{{ asset('uploads/product_specification/' . $productSpecification->tax_exemption_certificate) }}" target="_blank">Download</a>
                    </div>
                    @endif

                   
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fw-bold w-lg-150px flex-shrink-0">Notes:</span>
                        <span>{{ $productSpecification->note }}</span>
                    </div>

                    @if(!empty($data_set))
                    <div class="row">
                        <div class="col-md-6">
                            <p style="margin-top:20px;font-size:17px;"><b>Product Details:</b></p>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row">

                        @foreach($data_set as $data)
                        <div class="col-md-6">
                            <fieldset style="border:1px solid #ddd;padding: 20px;margin:20px">
                                <legend style="font-size:13px;"><b>{{ $data[0]->product->name }}</b></legend><hr>


                                @php $i=1;  @endphp
                                @foreach($data as $key => $value)
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-4">
                                        @if($i==1)<label class="form-label">Feature Name</label>@endif
                                        <input class="form-control form-control-sm form-control-solid" readonly type="text" value="{{ $value->product_feature_name }}" />
                                        @if ($errors->has('feature_name'))
                                        <div class="text-danger">{{ $errors->first('feature_name') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        @if($i==1)<label class="form-label">Unit Price</label>@endif
                                        <input class="form-control form-control-sm form-control-solid" readonly type="text" value="{{ $value->unit_price }}" />
                                        @if ($errors->has('unit_price'))
                                        <div class="text-danger">{{ $errors->first('unit_price') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        @if($i==1)<label class="form-label">Quantity</label>@endif
                                        <input class="form-control form-control-sm form-control-solid" readonly type="text" value="{{ $value->quantity }}" placeholder="" />
                                        @if ($errors->has('quantity'))
                                        <div class="text-danger">{{ $errors->first('quantity') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        @if($i==1)<label class="form-label">Total</label>@endif
                                        <input class="form-control form-control-sm form-control-solid" readonly type="text" value="{{ $value->quantity * $value->unit_price }}" placeholder="" />
                                        @if ($errors->has('quantity'))
                                        <div class="text-danger">{{ $errors->first('quantity') }}</div>
                                        @endif
                                    </div>
                                </div>
                                @php $i++;  @endphp
                                @endforeach


                            </fieldset>
                        </div>
                        @endforeach
                    </div>

                </div>


            </div>

        </div>
    </div>
</div>


<!-- End Tables View-->


<!-- </div> -->
<!--end::Content-->

@endsection