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

                    <form class="g-form w-100" action="{{ route('product-specification-store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="fv-row mb-5">
                                    <label class="form-label fw-bolder text-dark">Customer<span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm form-control-solid" name="customer_id" aria-label="Default select example">
                                        @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->first_name }} {{ $customer->last_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('customer_id'))
                                    <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                                    @endif

                                </div>
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Work Order Number</label>
                                <input class="form-control form-control-sm form-control-solid" type="text" name="work_order_number" value="{{ old('work_order_number') }}" />
                                @if ($errors->has('work_order_number'))
                                <div class="text-danger">{{ $errors->first('work_order_number') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Work Order File</label>
                                <input class="form-control form-control-sm form-control-solid" type="file" name="work_order_file" />
                                @if ($errors->has('work_order_file'))
                                <div class="text-danger">{{ $errors->first('work_order_file') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Work Order Value</label>
                                <input class="form-control form-control-sm form-control-solid" type="number" name="work_order_value" value="{{ old('work_order_value') }}" />
                                @if ($errors->has('work_order_value'))
                                <div class="text-danger">{{ $errors->first('work_order_value') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Advance Amount</label>
                                <input class="form-control form-control-sm form-control-solid" type="text" name="advance_amount" value="{{ old('advance_amount') }}" />
                                @if ($errors->has('advance_amount'))
                                <div class="text-danger">{{ $errors->first('advance_amount') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Total Installment</label>
                                <input class="form-control form-control-sm form-control-solid" type="text" name="total_installment" value="{{ old('total_installment') }}" />
                                @if ($errors->has('total_installment'))
                                <div class="text-danger">{{ $errors->first('total_installment') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Per Month Installment</label>
                                <input class="form-control form-control-sm form-control-solid" type="text" name="per_month_installment" value="{{ old('per_month_installment') }}" />
                                @if ($errors->has('per_month_installment'))
                                <div class="text-danger">{{ $errors->first('per_month_installment') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Payment Date Cycle</label>
                                <input class="form-control form-control-sm form-control-solid flatpickr" type="text" id="common_dob" name="payment_date_cycle" value="{{ old('payment_date_cycle') }}" />
                                @if ($errors->has('payment_date_cycle'))
                                <div class="text-danger">{{ $errors->first('payment_date_cycle') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Remaining Month</label>
                                <input class="form-control form-control-sm form-control-solid" type="text" name="remaining_month" value="{{ old('remaining_month') }}" />
                                @if ($errors->has('remaining_month'))
                                <div class="text-danger">{{ $errors->first('remaining_month') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Due Balance</label>
                                <input class="form-control form-control-sm form-control-solid" type="number" name="due_balance" value="{{ old('due_balance') }}" />
                                @if ($errors->has('due_balance'))
                                <div class="text-danger">{{ $errors->first('due_balance') }}</div>
                                @endif
                            </div>




                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Purchase Order Value</label>
                                <input class="form-control form-control-sm form-control-solid" type="number" name="purchase_order_value" value="{{ old('purchase_order_value') }}" />
                                @if ($errors->has('purchase_order_value'))
                                <div class="text-danger">{{ $errors->first('purchase_order_value') }}</div>
                                @endif
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Purchase Order File</label>
                                <input class="form-control form-control-sm form-control-solid" type="file" name="purchase_order_file" />
                                @if ($errors->has('purchase_order_file'))
                                <div class="text-danger">{{ $errors->first('purchase_order_file') }}</div>
                                @endif
                            </div>

                            <!-- add feature list -->
                            @foreach($sub_data as $data)
                            <div class="col-md-6">
                                <fieldset style="border:1px solid #ddd;padding: 20px;margin:20px">
                                    <legend style="font-size:13px;"><b>{{ $data->name }}</b></legend><hr>
                                    <input type="hidden" name="product_id[]" value="{{ $data->id }}">


                                    @php $i=1;  @endphp
                                    @foreach($data->features as $value)
                                    <div class="row" style="margin-top:10px;">
                                        <div class="col-md-4">
                                            @if($i==1)<label class="form-label">Feature Name</label>@endif
                                            <input class="form-control form-control-sm form-control-solid" readonly type="text" name="feature_name[{{ $data->id }}][]" value="{{ $value->p_feature_name }}" />
                                            @if ($errors->has('feature_name'))
                                            <div class="text-danger">{{ $errors->first('feature_name') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            @if($i==1)<label class="form-label">Unit Price</label>@endif
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="unit_price[{{ $data->id }}][]" value="{{ $value->unit_price }}" />
                                            @if ($errors->has('unit_price'))
                                            <div class="text-danger">{{ $errors->first('unit_price') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            @if($i==1)<label class="form-label">Quantity</label>@endif
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="quantity[{{ $data->id }}][]" value="" placeholder="" />
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

                            {{--
                            <div class="col-md-6">
                                <fieldset style="border:1px solid #ddd;padding: 20px;margin:20px">
                                    <legend style="font-size:13px;">Wallboard:-</legend>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bolder text-dark">Feature Name</label>
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="work_order_number" value="{{ old('work_order_number') }}" placeholder="" />
                                            @if ($errors->has('work_order_number'))
                                            <div class="text-danger">{{ $errors->first('work_order_number') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bolder text-dark">Unit Price</label>
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="work_order_number" value="{{ old('work_order_number') }}" placeholder="" />
                                            @if ($errors->has('work_order_number'))
                                            <div class="text-danger">{{ $errors->first('work_order_number') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bolder text-dark">Quantity</label>
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="work_order_number" value="{{ old('work_order_number') }}" placeholder="" />
                                            @if ($errors->has('work_order_number'))
                                            <div class="text-danger">{{ $errors->first('work_order_number') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:10px;">
                                        <div class="col-md-4">
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="work_order_number" value="{{ old('work_order_number') }}" placeholder="" />
                                            @if ($errors->has('work_order_number'))
                                            <div class="text-danger">{{ $errors->first('work_order_number') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="work_order_number" value="{{ old('work_order_number') }}" placeholder="" />
                                            @if ($errors->has('work_order_number'))
                                            <div class="text-danger">{{ $errors->first('work_order_number') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="work_order_number" value="{{ old('work_order_number') }}" placeholder="" />
                                            @if ($errors->has('work_order_number'))
                                            <div class="text-danger">{{ $errors->first('work_order_number') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:10px;">
                                        <div class="col-md-4">
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="work_order_number" value="{{ old('work_order_number') }}" placeholder="" />
                                            @if ($errors->has('work_order_number'))
                                            <div class="text-danger">{{ $errors->first('work_order_number') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="work_order_number" value="{{ old('work_order_number') }}" placeholder="" />
                                            @if ($errors->has('work_order_number'))
                                            <div class="text-danger">{{ $errors->first('work_order_number') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control form-control-sm form-control-solid" type="text" name="work_order_number" value="{{ old('work_order_number') }}" placeholder="" />
                                            @if ($errors->has('work_order_number'))
                                            <div class="text-danger">{{ $errors->first('work_order_number') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            --}}
                            <div class="row"></div>
                            <!-- end feature list -->



                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">AMC Start Date</label>
                                <input class="form-control form-control-sm form-control-solid flatpickr" type="text" id="common_dob" name="amc_start_date" value="{{ old('amc_start_date') }}" />
                                @if ($errors->has('amc_start_date'))
                                <div class="text-danger">{{ $errors->first('amc_start_date') }}</div>
                                @endif
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">AMC Renewal Date</label>
                                <input class="form-control form-control-sm form-control-solid flatpickr" type="text" id="common_dob" name="amc_renewal_date" value="{{ old('amc_renewal_date') }}" />
                                @if ($errors->has('amc_renewal_date'))
                                <div class="text-danger">{{ $errors->first('amc_renewal_date') }}</div>
                                @endif
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">AMC Rate (%)</label>
                                <input class="form-control form-control-sm form-control-solid" type="number" name="amc_rate" value="{{ old('amc_rate') }}" step="0.01" />
                                @if ($errors->has('amc_rate'))
                                <div class="text-danger">{{ $errors->first('amc_rate') }}</div>
                                @endif
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Rental Amount</label>
                                <input class="form-control form-control-sm form-control-solid" type="number" name="rental_amount" value="{{ old('rental_amount') }}" />
                                @if ($errors->has('rental_amount'))
                                <div class="text-danger">{{ $errors->first('rental_amount') }}</div>
                                @endif
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">AMC Effective Amount</label>
                                <input class="form-control form-control-sm form-control-solid" type="number" name="amc_effective_amount" value="{{ old('amc_effective_amount') }}" />
                                @if ($errors->has('amc_effective_amount'))
                                <div class="text-danger">{{ $errors->first('amc_effective_amount') }}</div>
                                @endif
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">AMC Agreement Documents</label>
                                <input class="form-control form-control-sm form-control-solid" type="file" name="amc_agreement_documents" />
                                @if ($errors->has('amc_agreement_documents'))
                                <div class="text-danger">{{ $errors->first('amc_agreement_documents') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Service Type</label>
                                    <select class=" form-control form-control-sm form-control-solid" name="service_type"
                                        aria-label="Default select example">
                                        <option value="">Select Service Type</option>
                                        <option value="Yearly" {{ old('service_type') == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                                        <option value="Half-Yearly" {{ old('service_type') == 'Half-Yearly ' ? 'selected' : '' }}>Half-Yearly</option>
                                        <option value="Quarterly" {{ old('service_type') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                        <option value="Monthly" {{ old('service_type') == 'Monthly ' ? 'selected' : '' }}>Monthly</option>

                                    </select>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Software Value</label>
                                <textarea class="form-control form-control-sm form-control-solid" name="software_value" rows="3">{{ old('software_value') }}</textarea>
                                @if ($errors->has('software_value'))
                                <div class="text-danger">{{ $errors->first('software_value') }}</div>
                                @endif
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Hardware Value</label>
                                <textarea class="form-control form-control-sm form-control-solid" name="hardware_value" rows="3">{{ old('hardware_value') }}</textarea>
                                @if ($errors->has('hardware_value'))
                                <div class="text-danger">{{ $errors->first('hardware_value') }}</div>
                                @endif
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Implementation Cost</label>
                                <textarea class="form-control form-control-sm form-control-solid" name="implementation_value" rows="3">{{ old('implementation_value') }}</textarea>
                                @if ($errors->has('implementation_value'))
                                <div class="text-danger">{{ $errors->first('implementation_value') }}</div>
                                @endif
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Invoice Mushak File</label>
                                <input class="form-control form-control-sm form-control-solid" type="file" name="invoice_mushak_file" />
                                @if ($errors->has('invoice_mushak_file'))
                                <div class="text-danger">{{ $errors->first('invoice_mushak_file') }}</div>
                                @endif
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Tax Exemption Certificate</label>
                                <input class="form-control form-control-sm form-control-solid" type="file" name="tax_exemption_certificate" />
                                @if ($errors->has('tax_exemption_certificate'))
                                <div class="text-danger">{{ $errors->first('tax_exemption_certificate') }}</div>
                                @endif
                            </div>


                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Note</label>
                                <textarea class="form-control form-control-sm form-control-solid" name="note" rows="3">{{ old('note') }}</textarea>
                                @if ($errors->has('note'))
                                <div class="text-danger">{{ $errors->first('note') }}</div>
                                @endif
                            </div>


                            <div class="card-footer d-flex justify-content-end py-6 px-9">

                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#product-values").on("click", function(e) {
            e.preventDefault();
            var values = $('#product-select').val();

            $.ajax({
                url: '{{ route("product.features.show") }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                    product_feature_values: values,
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message); // Success message
                    } else {
                        alert(response.message); // Error message
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Log the error
                    alert('Something went wrong!');
                }
            });

        });
    });
</script>


@endsection