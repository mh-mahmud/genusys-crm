@extends('layouts.master')

@section('content')

	  <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                     data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                     class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <!--begin::Title-->
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Create Proposal
                        <!--begin::Separator-->
                        <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                        <!--end::Separator-->
                        <!--begin::Description-->
                        <small class="text-muted fs-7 fw-bold my-1 ms-1">Add New</small>
                        <!--end::Description--></h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center py-1">

                    <!--begin::Button-->
                    <a href="{{ route('proposal-list') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Proposal List</a>
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
                                <h3 class="fw-bolder m-0">New Proposal</h3>
                            </div>
                            <!--end::Card title-->
                        </div>

                        <!-- Card Body-->
                        <div class="card-body pb-2">

                            <!-- Start Form-->

                            <form class="g-form g-proposal w-100" action="{{ route('store-proposal') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="row">
                                    <!--Left Part-->
                                    <div class="col-xl-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Subject<span class="text-danger">*</span></label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" name="subject"  value="{{ old('subject') }}" />
                                                    @if ($errors->has('subject'))
                                                        <span class="text-danger">{{ $errors->first('subject') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Lead ID<span class="text-danger">*</span>
                                                    </label>
                                                    <select name="lead_id" class=" form-control form-control-sm form-control-solid" aria-label="Default select example">
                                                        <option value="">Select Lead</option>
                                                        @foreach($leads as $lead)
                                                            <option value="{{ $lead->id }}">{{ $lead->first_name . " " . $lead->last_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('lead_id'))
                                                        <span class="text-danger">{{ $errors->first('lead_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Company Name</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" name="company_name" />
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Date<span class="text-danger">*</span></label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-sm form-control-solid flatpickr date" placeholder="Date" name="start_date" value="{{ old('start_date') }}">
                                                        @if ($errors->has('start_date'))
                                                        <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">

                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Open Till<span class="text-danger">*</span></label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-sm form-control-solid flatpickr date" placeholder="Open Till" name="end_date" value="{{ old('end_date') }}">
                                                        @if ($errors->has('end_date'))
                                                        <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-12">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Currency<span class="text-danger">*</span></label>
                                                    <select class=" form-control form-control-sm form-control-solid" id="currency" name="currency"
                                                            aria-label="Default select example">
                                                        <option value=''>Select</option>
                                                        @foreach($currencies as $currency)
                                                        <option value="{{$currency->name}}" {{ old("currency") == $currency->name ? "selected" : "" }}>
                                                            {{ $currency->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('currency'))
                                                        <span class="text-danger">{{ $errors->first('currency') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label  fw-bolder text-dark">Upload PDF, xcel or Word</label>
                                                    <input class="form-control form-control-sm form-control-solid" accept=".csv,.xls,.xlsx,.docx,.pdf" type="file" name="upload_file" />
                                                    @if ($errors->has('upload_file'))
                                                        <span class="text-danger">{{ $errors->first('upload_file') }}</span>
                                                    @endif
                                                </div>
                                            </div>


                                            {{-- <div class="col-md-6">
                                                <div class="form-check form-switch form-check-light">
                                                    <label class="form-label fw-bolder text-dark g-proposal-c-label" for="status">Allow Comments</label>
                                                    <div><input class="form-check-input" type="checkbox" value="" id="status" name="status" checked="checked"/></div>
                                                </div>
                                            </div> --}}

                                        </div>
                                    </div>

                                    <!--Right Part-->
                                    <div class="col-xl-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Status<span class="text-danger">*</span></label>
                                                    <select class=" form-control form-control-sm form-control-solid" id="status" name="status" aria-label="Default select example">
                                                        <option value=''>Select</option>
                                                        @foreach(config('constants.proposal_status') as $key => $status)
                                                        <option value="{{$status}}" {{ old('status') == $key ? 'selected' : '' }}>{{ $status }} </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('status'))
                                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Full Name</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" name="first_name" />
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Email To<span class="text-danger">*</span></label>
                                                    <input class="form-control form-control-sm form-control-solid" type="email" id="send_to" name="send_to"  value="{{ old('send_to') }}"/>
                                                    @if ($errors->has('send_to'))
                                                        <span class="text-danger">{{ $errors->first('send_to') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Address</label>
                                                    <textarea class="form-control form-control-sm  form-control-solid" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">City</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" id="city" name="city"  value="{{ old('city') }}"/>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">State</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" id="state" name="state"  value="{{ old('state') }}"/>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label  fw-bolder text-dark">Country</label>
                                                    <select class=" form-control form-control-sm form-control-solid" name="country_name" aria-label="Default select example">
                                                        <option value=''>Select</option>
                                                        @foreach($countries as $country)
                                                        <option value="{{$country->name}}" {{ old('country_name') == $country->name ? 'selected' : '' }}>{{ $country->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Zip Code</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" id="zip_code" name="zip_code"  value="{{ old('zip_code') }}"/>
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Email</label>
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="email" id="send_to_email" name="send_to_email"  value="{{ old('send_to_email') }}"/>
                                                </div>
                                            </div> -->

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark">Phone</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" id="phone" name="phone"  value="{{ old('phone') }}"/>
                                                </div>
                                            </div>


                                    </div>
                                        </div>


                                </div>
                                <!--End Row-->

                                <div class="mt-2 overflow-hidden">

                                    <div class="card">
                                        <div class="card-header">
                                            <div class="g-proposal-add-item d-flex flex-wrap justify-content-between align-items-center w-100 gap-3">
                                                <!-- <div>
                                                    <div class="input-group input-group-sm min-w-300px w-100 w-md-500px">
                                                        <div class="flex-grow-1">
                                                            <select class="form-select form-select-sm rounded-end-0 border-end" data-control="select2" data-placeholder="Add an item">
                                                                <option></option>
                                                                <option value="1">Option 1</option>
                                                                <option value="2">Option 2</option>
                                                                <option value="3">Option 3</option>
                                                                <option value="4">Option 4</option>
                                                                <option value="5">Option 5</option>
                                                            </select>
                                                        </div>
                                                        <span class="input-group-sm input-group-text"><i class="bi bi-plus fs-4"></i></span>
                                                    </div>
                                                </div> -->


                                                <!-- <div class="g-right-proposal-table-header d-flex align-items-center gap-3">

                                                    <div class="min-w-sm-100px">
                                                        <strong>Show quantity as: </strong>
                                                    </div>

                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio" value="" id="g-qty" name="quantity"/>
                                                        <label class="form-check-label" for="g-qty">
                                                            qty
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio" value="" id="g-hours" name="quantity"/>
                                                        <label class="form-check-label" for="g-hours">
                                                            hours
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio" value="" id="g-qty-hours" name="quantity"/>
                                                        <label class="form-check-label" for="g-qty-hours">
                                                            qty/hours
                                                        </label>
                                                    </div>

                                                </div> -->

                                            </div>
                                        </div>



                                            <div class="table-responsive">
                                                <!--Proposal Table Preview-->
                                                <table class="table table-rounded table-sm table-striped border align-middle gs-2">
                                                    <thead>
                                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                                        <th>Item details</th>
                                                        <th>Description</th>
                                                        <th>Price</th>
                                                        <th>Offer Price</th>
                                                        <!-- <th>Tax Amount</th> -->
                                                        <th>Amount</th>
                                                        <!-- <th><i class="bi bi-gear-fill"></i></th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <textarea class="form-control form-control-sm min-w-250px" name="item_name" cols="30" rows="2"placeholder=""></textarea>
                                                            @if ($errors->has('item_name'))
                                                                <span class="text-danger">{{ $errors->first('item_name') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control form-select-sm min-w-250px" name="item_description" cols="30" rows="2"placeholder="Long Description"></textarea>
                                                            @if ($errors->has('item_description'))
                                                                <span class="text-danger">{{ $errors->first('item_description') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <input id="price" class="form-control form-control-sm" type="number" name="price">
                                                            @if ($errors->has('price'))
                                                                <span class="text-danger">{{ $errors->first('price') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <input id="offer_price" class="form-control form-control-sm" type="number" name="offer_price">
                                                            @if ($errors->has('offer_price'))
                                                                <span class="text-danger">{{ $errors->first('offer_price') }}</span>
                                                            @endif
                                                        </td>
                                                        <!-- <td>
                                                            <input class="form-control form-control-sm" type="number" name="tax">
                                                            <select class="form-select form-select-sm" data-control="" data-placeholder="No Tax">
                                                                <option value="fixed">Fixed</option>
                                                                <option value="percent">%</option>
                                                            </select>
                                                        </td> -->
                                                        <td><b><span id="total_amount">0</span></b></td>
                                                        <!-- <td>
                                                            <button type="button" class="btn btn-sm btn-primary py-2 px-2">
                                                                <i class="bi bi-check"></i>
                                                            </button>
                                                        </td> -->
                                                    </tr>

                                                    </tbody>
                                                </table>

                                                <!--End Proposal Table Preview-->
                                            </div>


                                            <div class="row mb-4">
                                                <div class="col-md-4 ms-auto ">
                                                    <!-- Proposal Calculations-->
                                                    <div class="table-responsive bg-light-warning rounded-2 p-3">
                                                        <table class="table table-sm table-row-bordered align-middle">
                                                            <tr>
                                                                <th class="text-end"><strong>Sub Total:</strong></th>
                                                                <td class="text-end"><b><span class="cur-data">BDT</span></b> <span id="sub_total">0</span></td>
                                                            </tr>
                                                            <!-- <tr>
                                                                <th><strong>Discount :</strong>
                                                                    <div class="input-group">
                                                                        <div class="flex-grow-1">
                                                                            <input
                                                                                class="form-control form-control-sm rounded-end-0 border-end"
                                                                                type="text" name="discount">
                                                                        </div>
                                                                        <select class="form-select form-select-sm form-control-sm"
                                                                                name="discount_type" id="">
                                                                            <option value="fixed">Fixed Amount</option>
                                                                            <option value="percentage">%</option>
                                                                        </select>
                                                                    </div>
                                                                </th>
                                                                <td class="text-end"> <strong>BDT</strong> -0.00</td>
                                                            </tr> -->
                                                            <tr>
                                                                <th><strong>Tax :</strong>
                                                                    <div class="input-group flex-nowrap">
                                                                        <div class="flex-grow-1">
                                                                            <input id="tax_amount" class="form-control form-control-sm rounded-end-0 border-end" type="text" name="tax_percent">
                                                                        </div>
                                                                        <select class="form-select form-select-sm form-control-sm" name="tax_type" id="tax_type" style="width:40%">
                                                                            <!-- <option value="fixed">Fixed Amount</option> -->
                                                                            <option value="percentage">%</option>
                                                                        </select>
                                                                    </div>
                                                                </th>
                                                                <td class="text-end"> <b><span class="cur-data">BDT</span></b> <span id="tax_field">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <th><strong>Discount :</strong>
                                                                    <input id="discount" disabled class="form-control form-control-sm" type="text" name="discount">
                                                                </th>
                                                                <td class="text-end"><b><span class="cur-data">BDT</span></b>  <span id="discount_right">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-end"><strong>Total with Tax: </strong></th>
                                                                <td class="text-end">
                                                                    <b><span class="cur-data">BDT</span></b> <span id="total_amount_final">0</span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <!--End Proposal Calculations-->
                                                </div>
                                            </div>




                                        <!--begin::Actions-->
                                        <div class="card-footer d-flex justify-content-end py-4 pe-0">
                                            <button type="submit" class="btn btn-primary"
                                                    id="kt_account_profile_details_submit">Submit
                                            </button>
                                        </div>
                                        <!--end::Actions-->
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


@section('endScript')

<script type="text/javascript">
    /*var offer_price = 0;
    var price = 0;
    var discount = 0;*/
    $("#offer_price").on("focusout", function() {
        var offer_price = parseFloat($("#offer_price").val()) || 0;
        var price = parseFloat($("#price").val()) || 0;
        var discount = price - offer_price;
        $("#total_amount").text(offer_price);
        $("#sub_total").text(offer_price);
        $("#discount").val(discount);
        $("#discount_right").text(discount);
    });

    // $("#offer_price").on("focusout", function() {
    //     var offer_price = parseFloat($("#offer_price").val()) || 0;
    //     $("#total_amount").text(offer_price);
    // });

    $("#tax_amount").on("focusout", function() {
        var tax = parseFloat($("#tax_amount").val()) || 0;
        offer_price = parseFloat($("#offer_price").val()) || 0;

        if(offer_price > 0 && tax >= 0 && tax <= 50) {
            var tax_value = offer_price*tax/100;
            var final = tax_value + offer_price;

            tax_value = parseFloat(tax_value).toFixed(2);
            $("#tax_field").text(tax_value);
            // final = parseFloat(final).toFixed(2);
            $("#total_amount_final").text(final);
        }
    });

    $("#currency").on("change", function() {
        var cur_val = $(this).val();
        $(".cur-data").text(cur_val);
    });
</script>

@endsection

@endsection
