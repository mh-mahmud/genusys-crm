@extends('layouts.master')

@section('content')

<!-- <div class="content d-flex flex-column flex-column-fluid" id="kt_content"> -->

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">

    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Invoice Forms
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Invoice form</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->

            <!--end::Wrapper-->
            <!--begin::Button-->
            <a href="{{ route('invoice-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Invoice List</a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--begin::Container-->

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
                        <h3 class="fw-bolder m-0">Edit New Invoice</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form g-proposal w-100" action="{{ route('invoice-update', $invoice->id) }}" enctype="multipart/form-data" method="POST">
                        <input type="hidden" name="sub_total" id="subtotal-hidden" value="{{ old('sub_total', $invoice->sub_total) }}">
                        <input type="hidden" name="total_amount" id="total-hidden" value="{{ old('total_amount', $invoice->total_amount) }}">
                        <input type="hidden" name="total_tax" id="totaltax-hidden" value="{{ old('total_tax', $invoice->total_tax) }}">
                        <input type="hidden" name="total_discount" id="totaldiscount-hidden" value="0.00">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!--Left Part-->
                            <div class="col-xl-6">
                                <div class="row">


                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Customer<span class="text-danger">*</span>

                                            </label>
                                            <select class="form-control form-control-sm form-control-solid"  id="customerSelect" name="customer_id" data-allow-clear="true"
                                            data-kt-select2="select2">
                                                <option value="" {{ old('customer_id', $invoice->customer_id) == '' ? 'selected' : '' }}>Select Customer</option>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}"  data-address="{{ $customer->address }}"  {{ old('customer_id', $invoice->customer_id) == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->first_name }} {{ $customer->last_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('customer_id'))
                                            <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark" for="address">Bill To</label>
                                            <textarea class="form-control form-control-sm form-control-solid" id="address" name="address" rows="3">{{ old('address', $invoice->address) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">
                                                Invoice Number

                                                <span class="text-danger">*</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">INV-</span>
                                                <input class="form-control form-control-sm"
                                                    type="text" name="invoice_number" id="invoice_number"
                                                    value="{{ old('invoice_number', str_replace('INV-', '', $invoice->invoice_number)) }}" />

                                                @if ($errors->has('invoice_number'))
                                                <span class="text-danger">{{ $errors->first('invoice_number') }}</span>
                                                @endif
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                    <div class="col-xl-6">

                                        <div class="fv-row mb-5">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">
                                                Invoice Date<span class="text-danger">*</span></label>

                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="position-relative">
                                                <input type="text" class="form-control form-control-sm form-control-solid flatpickr date" placeholder="Date" name="invoice_date" value="{{ old('invoice_date', $invoice->invoice_date) }}">
                                                @if ($errors->has('invoice_date'))
                                                <span class="text-danger">{{ $errors->first('invoice_date') }}</span>
                                                @endif
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-xl-6">

                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">
                                                Due Date</label>

                                            <div class="position-relative">
                                                <input type="text" class="form-control form-control-sm form-control-solid flatpickr date" placeholder="Due Date" name="due_date" value="{{ old('due_date', $invoice->due_date) }}">
                                                @if ($errors->has('due_date'))
                                                <span class="text-danger">{{ $errors->first('due_date') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-xl-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Custom Invoice</label>
                                            <select
                                                id="custom-invoice-select"
                                                class="form-control form-control-sm form-control-solid"
                                                name="custom_invoice_id"
                                                aria-label="Default select example">
                                                <option value="" {{ old('custom_invoice_id', $invoiceCustomFormId) === null ? 'selected' : '' }}>Nothing Selected</option>
                                                @foreach($custom_invoice as $custom_invoices)
                                                <option
                                                    value="{{ $custom_invoices->id }}"
                                                    data-fields="{{ json_encode($custom_invoices->field_details) }}"
                                                    data-footer="{{ json_encode($custom_invoices->footer_details) }}"
                                                    {{ old('custom_invoice_id', $invoiceCustomFormId) == $custom_invoices->id ? 'selected' : '' }}>
                                                    {{ $custom_invoices->invoice_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('custom_invoice_id'))
                                            <span class="text-danger">{{ $errors->first('custom_invoice_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="fv-row mb-5">
                                        <label class="form-label fw-bolder text-dark">Work Order Number</label>

                                            </label>
                                            <select class="form-control form-control-sm form-control-solid" name="ps_id" id="work-order-select">
                                                <option value="" {{ old('ps_id', $invoice->ps_id) == '' ? 'selected' : '' }}>Select Work Order Number</option>
                                                @foreach($wordOrderNumbers as $wordOrderNumber)
                                                <option value="{{ $wordOrderNumber->id }}" {{ old('ps_id', $invoice->ps_id) == $wordOrderNumber->id ? 'selected' : '' }}>
                                                    {{ $wordOrderNumber->work_order_number }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('ps_id'))
                                            <span class="text-danger">{{ $errors->first('ps_id') }}</span>
                                            @endif

                                        </div>
                                    </div>



                                    {{-- <div class="col-md-6">
                                                <div class="form-check form-switch form-check-light">
                                                    <label class="form-label fw-bolder text-dark g-proposal-c-label"
                                                           for="status">Allow Comments</label>
                                                    <div>
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="status"
                                                               name="status" checked="checked"/>
                                                    </div>
                                                </div>
                                            </div> --}}

                                </div>
                            </div>

                            <!--Right Part-->
                            <div class="col-xl-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Allowed payment modes for this invoice

                                            </label>
                                            <select class="form-control form-control-sm form-control-solid" name="payment_mode">
                                                <option value="" {{ old('payment_mode', $invoice->payment_mode) == '' ? 'selected' : '' }}>Nothing Selected</option>
                                                <option value="Bank" {{ old('payment_mode', $invoice->payment_mode) == 'Bank' ? 'selected' : '' }}>Bank</option>
                                                <option value="Stripe Checkout" {{ old('payment_mode', $invoice->payment_mode) == 'Stripe Checkout' ? 'selected' : '' }}>Stripe Checkout</option>
                                            </select>

                                            @if ($errors->has('payment_mode'))
                                            <span class="text-danger">{{ $errors->first('payment_mode') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Currency</label>
                                            <select class="form-control form-control-sm form-control-solid" id="currency" name="currency">
                                                <option value="">Select</option>
                                                @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}" {{ old('currency', $invoice->currency) == $currency->id ? 'selected' : '' }}>{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('currency'))
                                            <span class="text-danger">{{ $errors->first('currency') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Status

                                            </label>
                                            <select class="form-control form-control-sm form-control-solid" name="invoice_status">
                                                @foreach(config('constants.invoice_status') as $key => $status)
                                                <option value="{{ $key }}" {{ old('invoice_status', $invoice->invoice_status) == $key ? 'selected' : '' }}>{{ $status }}</option>
                                                @endforeach
                                            </select>


                                            @if ($errors->has('invoice_status'))
                                            <span class="text-danger">{{ $errors->first('invoice_status') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        @php
                                        $isAdmin = Auth::user()->user_type === 'admin';
                                        @endphp
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Sale Agent</label>

                                            <select class="form-control form-control-sm form-control-solid"
                                                name="sale_agent_id"
                                                aria-label="Default select example"
                                                {{ !$isAdmin ? 'disabled' : '' }}>
                                                <option value="" {{ old('sale_agent_id', $invoice->sale_agent_id) === null ? 'selected' : '' }}>Nothing Selected</option>
                                                @foreach($agents as $agent)
                                                @if($isAdmin)
                                                <option value="{{ $agent->agent_id }}"
                                                    {{ old('sale_agent_id', $invoice->sale_agent_id) == $agent->agent_id ? 'selected' : '' }}>
                                                    {{ $agent->first_name }} {{ $agent->last_name }}
                                                </option>
                                                @elseif($agent->user_id == Auth::user()->id)
                                                <option value="{{ $agent->agent_id }}"
                                                    {{ old('sale_agent_id', $invoice->sale_agent_id) == $agent->agent_id ? 'selected' : '' }}>
                                                    {{ $agent->first_name }} {{ $agent->last_name }}
                                                </option>
                                                <input type="hidden" name="sale_agent_id" value="{{ $invoice->sale_agent_id }}">
                                                @endif
                                                @endforeach
                                            </select>

                                            @if ($errors->has('sale_agent_id'))
                                            <span class="text-danger">{{ $errors->first('sale_agent_id') }}</span>
                                            @endif
                                        </div>
                                    </div>




                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Discount Type</label>
                                            <select class="form-control form-control-sm form-control-solid" name="discount_type_name">
                                                <option value="" {{ old('discount_type_name', $invoice->discount_type) === null ? 'selected' : '' }}>Nothing Selected</option>
                                                @foreach($discountTypes as $type)
                                                <option value="{{ $type }}" {{ old('discount_type_name', $invoice->discount_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('discount_type'))
                                            <span class="text-danger">{{ $errors->first('discount_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">
                                                Reference Number

                                               
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="input-group">
                                                
                                                <input class="form-control form-control-sm"
                                                    type="text" name="ref_no"
                                                    value="{{ old('ref_no', $invoice->ref_no) }}" />
                                                @if($errors->has('ref_no'))
                                                <span class="text-danger">{{ $errors->first('ref_no') }}</span>
                                                @endif
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark" for="textarea">Admin Note</label>
                                            <textarea class="form-control form-control-sm form-control-solid" id="admin_note" name="admin_note" rows="3">{{ old('admin_note', $invoice->admin_note) }}</textarea>
                                            @if ($errors->has('admin_note'))
                                            <span class="text-danger">{{ $errors->first('admin_note') }}</span>
                                            @endif
                                        </div>
                                    </div>






                                </div>
                            </div>


                        </div>
                        <!--End Row-->

                        <div class="my-3 overflow-hidden">

                            <div class="card">
                                <div id="default-invoice" style="display: block;">
                                    <div class="card-header p-0">
                                        <div
                                            class="g-proposal-add-item d-flex flex-wrap justify-content-between align-items-center w-100 gap-3">
                                            <div>
                                                <!--begin::Both add-ons-->
                                                <!-- @if(is_null($invoiceCustomFormId))
                                                <div class="input-group input-group-sm min-w-300px w-100 w-md-500px">
                                                    <div class="flex-grow-1">
                                                        <select class="form-select form-select-sm rounded-end-0 border-end" data-control="select2" name="product_id" id="product-select">
                                                            <option value="" {{ old('product_id') == '' ? 'selected' : '' }}>Nothing Selected</option>
                                                            @foreach($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                data-name="{{ $product->name }}"
                                                                data-description="{{ $product->description }}"
                                                                data-rate="{{ $product->product_value }}"
                                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('product_id'))
                                                        <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                                        @endif
                                                    </div>
                                                    <span class="input-group-sm input-group-text"><i class="bi bi-plus fs-4"></i></span>
                                                </div>
                                                @endif -->
                                                <!--end::Both add-ons-->
                                            </div>


                                            <!-- <div class="g-right-proposal-table-header d-flex align-items-center gap-3">

                                            <div class="min-w-sm-100px">
                                                <strong>Show quantity as: </strong>
                                            </div>

                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="" id="g-qty" name="quantity" />
                                                <label class="form-check-label" for="g-qty">
                                                    qty
                                                </label>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="" id="g-hours" name="quantity" />
                                                <label class="form-check-label" for="g-hours">
                                                    hours
                                                </label>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="" id="g-qty-hours" name="quantity" />
                                                <label class="form-check-label" for="g-qty-hours">
                                                    qty/hours
                                                </label>
                                            </div>

                                        </div> -->

                                        </div>
                                    </div>

                                    @if(is_null($invoiceCustomFormId))
                                    <div class="table-responsive">
                                        <!--Invoice Table Preview-->
                                        <table class="table table-rounded table-sm table-striped border align-middle gs-2" id="proposal-table">
                                            <thead>
                                                <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                                    <th>Itemsssssssss</th>
                                                    <th>Description</th>
                                                    <th>Qty</th>
                                                    <th>Rate</th>
                                                    <th>Tax</th>
                                                    <th>Amount</th>
                                                    <th><i class="bi bi-gear-fill"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body-work-order"></tbody>


                                            <tbody id="table-body">
                                                @foreach($invoiceItems as $item)

                                                <tr>
                                                    <td>
                                                        <textarea class="form-control form-control-sm min-w-250px" name="items[item_name][]" cols="30" rows="2"
                                                            id="item-name" placeholder="Item Name" readonly>{{ $item['Item'] }}</textarea>
                                                        @error('items.*.item_name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control form-select-sm min-w-250px" name="items[descriptions][]" cols="30" rows="2"
                                                            id="item-description" placeholder="Description">{{ $item['Description'] }}</textarea>
                                                    </td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="number" name="items[quantity][]" id="item-quantity"
                                                            placeholder="Quantity" value="{{$item['Qty'] }}">
                                                    </td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="number" name="items[rate][]" id="item-rate"
                                                            placeholder="Rate" value="{{ $item['Rate']}}">
                                                    </td>
                                                    <td>
                                                        <select class="form-select form-select-sm" data-control="select2" data-placeholder="No Tax" id="item-tax"
                                                            name="items[tax][]">
                                                            <option value="" {{ $item['Tax'] == '' ? 'selected' : '' }}>No Tax (0.00%)</option>
                                                            <option value="5.00" {{ $item['Tax'] == '5.00' ? 'selected' : '' }}>5.00%</option>
                                                            <option value="10.00" {{ $item['Tax'] == '10.00' ? 'selected' : '' }}>10.00%</option>
                                                            <option value="15.00" {{ $item['Tax'] == '15.00' ? 'selected' : '' }}>15.00%</option>
                                                        </select>
                                                    </td>
                                                    <td class="item-amount">{{ $item['Amount'] }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger py-2 px-2 remove-row">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <!-- <tr>
                                                    <td>
                                                        <textarea class="form-control form-control-sm min-w-250px" name="items[item_name][]" cols="30" rows="2"
                                                            id="item-name" placeholder="Item Name" readonly></textarea>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control form-select-sm min-w-250px" name="items[descriptions][]" cols="30" rows="2"
                                                            id="item-description" placeholder="Description"></textarea>
                                                    </td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="number" name="items[quantity][]" id="item-quantity"
                                                            placeholder="Quantity">
                                                    </td>
                                                    <td>
                                                        <input class="form-control form-control-sm" type="number" name="items[rate][]" id="item-rate"
                                                            placeholder="Rate">
                                                    </td>
                                                    <td>
                                                        <select class="form-select form-select-sm" data-control="select2" data-placeholder="No Tax" id="item-tax"
                                                            name="items[tax][]">
                                                            <option value="0.00">No Tax (0.00%)</option>
                                                            <option value="5.00">5.00%</option>
                                                            <option value="10.00">10.00%</option>
                                                            <option value="15.00">15.00%</option>
                                                        </select>
                                                    </td>
                                                    <td class="item-amount">0.00</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-primary py-2 px-2 add-row">
                                                            <i class="bi bi-check"></i>
                                                        </button>
                                                    </td>
                                                </tr> -->

                                                <!-- <tr>

                                                <td>
                                                    <textarea class="form-control form-control-sm min-w-250px" name="items[item_name][]" cols="30" rows="2" id="item-name" placeholder="Item Name">{{ old('items.item_name.0') }}</textarea>
                                                    @error('items.item_name.0')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>


                                                <td>
                                                    <textarea class="form-control form-control-sm min-w-250px" name="items[descriptions][]" cols="30" rows="2" id="item-description" placeholder="Description">{{ old('items.description.0') }}</textarea>
                                                    @error('items.description.0')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>


                                                <td>
                                                    <input class="form-control form-control-sm" type="number" name="items[quantity][]" id="item-quantity" placeholder="Quantity" value="{{ old('items.quantity.0') }}">
                                                    @error('items.quantity.0')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>


                                                <td>
                                                    <input class="form-control form-control-sm" type="number" name="items[rate][]" id="item-rate" placeholder="Rate" value="{{ old('items.rate.0') }}">
                                                    @error('items.rate.0')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>


                                                <td>
                                                    <select class="form-select form-select-sm" name="items[tax][]">
                                                        <option value="0.00" {{ old('items.tax.0') == '0.00' ? 'selected' : '' }}>No Tax (0.00%)</option>
                                                        <option value="5.00" {{ old('items.tax.0') == '5.00' ? 'selected' : '' }}>5.00%</option>
                                                        <option value="10.00" {{ old('items.tax.0') == '10.00' ? 'selected' : '' }}>10.00%</option>
                                                        <option value="15.00" {{ old('items.tax.0') == '15.00' ? 'selected' : '' }}>15.00%</option>
                                                    </select>
                                                    @error('items.tax.0')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>


                                                <td class="item-amount">0.00</td>


                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary py-2 px-2 add-row">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </td>
                                            </tr> -->
                                            </tbody>

                                        </table>
                                        <!--End Proposal Table Preview-->
                                    </div>



                                    <div class="row">
                                        <div class="col-md-4 ms-auto ">
                                            <!-- Proposal Calculations-->
                                            <div class="table-responsive bg-light-warning rounded-2 p-3">
                                                <table class="table table-sm table-row-bordered align-middle">
                                                    <tr>
                                                        <th class="text-end"><strong>Sub Total:</strong></th>
                                                        <td class="text-end"><strong>BDT</strong> <span id="subtotal-amount1">{{ old('sub_total', $invoice->sub_total) }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><strong>Discount :</strong>
                                                            <div class="input-group flex-nowrap">
                                                                <div class="flex-grow-1">
                                                                    <input class="form-control form-control-sm rounded-end-0 border-end" type="number" name="discount" placeholder="Discount">
                                                                </div>
                                                                <select class="form-select form-select-sm form-control-sm" name="discount_type">
                                                                    <option value="fixed">Fixed Amount</option>
                                                                    <option value="percentage">%</option>
                                                                </select>
                                                            </div>
                                                        </th>
                                                        <td class="text-end"><strong>BDT</strong> <span id="discount-amount">-{{ old('discount', $invoice->discount) }}</span></td>
                                                    </tr>
                                                    <!-- New Tax Row -->
                                                    <tr>
                                                        <th class="text-end"><strong>Total Tax:</strong></th>
                                                        <td class="text-end"><strong>BDT</strong> <span id="total-tax-amount">{{ old('total_tax', $invoice->total_tax) }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><strong>Adjustment :</strong>
                                                            <input class="form-control form-control-sm" type="number" name="adjustment" placeholder="Adjustment">
                                                        </th>
                                                        <td class="text-end"><strong>BDT</strong> <span id="custom_adjustment">{{ old('adjustment', $invoice->adjustment) }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-end"><strong>Total</strong></th>
                                                        <td class="text-end">
                                                            <strong>BDT</strong> <span id="total-amount">{{ old('total_amount', $invoice->total_amount) }}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <!--End Proposal Calculations-->
                                        </div>
                                    </div>
                                    @endif

                                </div>

                                @if(!is_null($invoiceCustomFormId))

                                <div id="custom-invoice" style="display: block;">
                                    <table id="custom-invoice-table" class="table table-rounded table-sm table-striped border align-middle gs-2" style="display: none;">
                                        <thead>
                                            <tr id="custom-invoice-header" class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200"></tr>
                                        </thead>
                                        <tbody id="custom-invoice-body">
                                            <tr>
                                                <!-- Placeholder for dynamic input fields, populated by JS below -->
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table id="custom-invoice-footer-table" class="table table-rounded table-sm table-striped border align-middle gs-2" style="display: none;">
                                        <thead>
                                            <tr id="custom-invoice-footer-header" class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200"></tr>
                                        </thead>
                                        <tbody id="custom-invoice-footer-body">
                                            <tr>
                                                <!-- Placeholder for dynamic footer fields, populated by JS below -->
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-4 ms-auto ">
                                            <!-- Proposal Calculations-->
                                            <div class="table-responsive bg-light-warning rounded-2 p-3">
                                                <table class="table table-sm table-row-bordered align-middle">
                                                    <tr>
                                                        <th class="text-end"><strong>Sub Total:</strong></th>
                                                        <td class="text-end"><strong>BDT</strong> <span id="custom-subtotal-amount">{{ old('sub_total', $invoice->sub_total) }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><strong>VAT :</strong>
                                                            <div class="input-group flex-nowrap">
                                                                <div class="flex-grow-1">
                                                                    <input class="form-control form-control-sm rounded-end-0 border-end" id="custom_vat" type="number" name="vat" placeholder="VAT">
                                                                </div>
                                                                %
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <!-- New Tax Row -->
                                                    <tr>
                                                        <th class="text-end"><strong>Total VAT:</strong></th>
                                                        <td class="text-end"><strong>BDT</strong> <span id="custom-total-vat">{{ old('total_tax', $invoice->total_tax) }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><strong>Adjustment :</strong>
                                                            <input id="custom_adjustment" class="form-control form-control-sm" type="number" name="custom_adjustment" placeholder="Adjustment" />
                                                        </th>
                                                        <td class="text-end"><strong>BDT</strong> <span id="custom_adjustment">{{ old('adjustment', $invoice->adjustment) }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-end"><strong>Total</strong></th>
                                                        <td class="text-end">
                                                            <strong>BDT</strong> <span id="custom-total-amount">{{ old('total_amount', $invoice->total_amount) }}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <!--End Proposal Calculations-->
                                        </div>
                                    </div>
                                </div>

                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark" for="textarea">Client Note</label>
                                            <textarea class="form-control form-control-sm  form-control-solid" id="client_note" name="client_note" rows="3">{{ old('client_note', $invoice->client_note) }}</textarea>
                                            @if ($errors->has('client_note'))
                                            <span class="text-danger">{{ $errors->first('client_note') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark" for="textarea">Terms & Conditions</label>
                                            <textarea class="form-control form-control-sm  form-control-solid" id="address" name="terms_conditions" rows="3">{{ old('terms_conditions', $invoice->terms_conditions) }}</textarea>
                                            @if ($errors->has('terms_condition'))
                                            <span class="text-danger">{{ $errors->first('terms_condition') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>




                                <!--begin::Actions-->
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <!-- <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard
                                    </button> -->
                                    <button type="submit" class="btn btn-primary"
                                        id="kt_account_profile_details_submit">Save Changes
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

<script>
$(document).ready(function () {
    $('#customerSelect').on('change', function () {
        var customerId = $(this).val();
        var workOrderSelect = $('#work-order-select');

        // clear existing options
        workOrderSelect.empty();
        workOrderSelect.append('<option value="">Select Work Order Number</option>');
        let baseUrl = "{{ url('/') }}"; // base url get

        if (customerId) {
            $.ajax({
               url: baseUrl + '/invoice/get-work-orders/' + customerId,
                type: 'GET',
                success: function (data) {
                    if (data.length > 0) {
                        $.each(data, function (index, workOrder) {
                            workOrderSelect.append('<option value="' + workOrder.id + '">' + workOrder.work_order_number + '</option>');
                        });
                    } else {
                        workOrderSelect.append('<option value="">No work orders found</option>');
                    }
                },
                error: function () {
                    alert('Failed to load work orders.');
                }
            });
        }
    });
});
</script>


<script>
    function recalculateTotals() {
        let subtotal = 0;
        let totalTax = 0;

        const rows = document.querySelectorAll('#table-body-work-order tr');

        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('input[name="items[quantity][]"]')?.value) || 0;
            const rate = parseFloat(row.querySelector('input[name="items[rate][]"]')?.value) || 0;
            const tax = parseFloat(row.querySelector('select[name="items[tax][]"]')?.value) || 0;

            const amount = qty * rate;
            const taxAmount = (amount * tax) / 100;

            subtotal += amount;
            totalTax += taxAmount;

            const amountCell = row.querySelector('.item-amount');
            if (amountCell) {
                amountCell.textContent = (amount + taxAmount).toFixed(2);
            }
        });

        const discountInput = parseFloat(document.querySelector('input[name="discount"]')?.value) || 0;
        const discountType = document.querySelector('select[name="discount_type"]')?.value;
        let discountAmount = 0;

        if (discountType === 'percentage') {
            discountAmount = (subtotal * discountInput) / 100;
        } else {
            discountAmount = discountInput;
        }

        const adjustment = parseFloat(document.querySelector('input[name="adjustment"]')?.value) || 0;
        const total = subtotal - discountAmount + totalTax + adjustment;

        document.getElementById('subtotal-amount').textContent = subtotal.toFixed(2);
        document.getElementById('discount-amount').textContent = `-${discountAmount.toFixed(2)}`;
        document.getElementById('total-tax-amount').textContent = totalTax.toFixed(2);
        document.getElementById('adjustment-amount').textContent = adjustment.toFixed(2);
        document.getElementById('total-amount').textContent = total.toFixed(2);

        // Optional hidden inputs update
        const setHidden = (id, value) => {
            const el = document.getElementById(id);
            if (el) el.value = value;
        };

        setHidden('subtotal-hidden', subtotal.toFixed(2));
        setHidden('totaltax-hidden', totalTax.toFixed(2));
        setHidden('totaldiscount-hidden', discountAmount.toFixed(2));
        setHidden('total-hidden', total.toFixed(2));
    }

    // Recalculate on key inputs
    document.addEventListener('input', function (e) {
        const name = e.target.name;
        if (
            name === 'discount' ||
            name === 'adjustment' ||
            name === 'items[quantity][]' ||
            name === 'items[rate][]'
        ) {
            recalculateTotals();
        }
    });

    // Use event delegation for change events
    document.addEventListener('change', function (e) {
        const name = e.target.name;
        if (
            name === 'discount_type' ||
            name === 'items[tax][]'
        ) {
            recalculateTotals();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        recalculateTotals();
    });

    // Work Order selector dynamic load
    document.getElementById('work-order-select').addEventListener('change', function () {
        const workOrderId = this.value;
        if (!workOrderId) return;
        let baseUrl = "{{ url('/') }}";

        fetch(`${baseUrl}/product-specification/get-spec-details/${workOrderId}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('table-body-work-order');
                tableBody.innerHTML = '';

                data.forEach((item, index) => {
                    tableBody.innerHTML += `
                        <tr>
                            <td><textarea class="form-control form-control-sm min-w-250px" name="items[item_name][]" rows="2" readonly>${item.product_feature_name}</textarea></td>
                            <td><textarea class="form-control form-control-sm min-w-250px" name="items[descriptions][]" rows="2" placeholder="Description">${item.product_description ?? ''}</textarea></td>
                            <td><input class="form-control form-control-sm" type="number" name="items[quantity][]" value="${item.quantity}"></td>
                            <td><input class="form-control form-control-sm" type="number" name="items[rate][]" value="${item.unit_price}"></td>
                            <td>
                                <select class="form-select form-select-sm" name="items[tax][]">
                                    <option value="0.00">No Tax (0.00%)</option>
                                    <option value="5.00">5.00%</option>
                                    <option value="10.00">10.00%</option>
                                    <option value="15.00">15.00%</option>
                                </select>
                            </td>
                            <td class="item-amount">0.00</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>`;
                });

                recalculateTotals();
            });
    });
</script>

<script>
    $(document).ready(function() {

        //function to calculate row amount including tax
        function calculateRowAmount_Backup(row) {
            var quantity = parseFloat(row.find('input[name="items[quantity][]"]').val()) || 0;
            var rate = parseFloat(row.find('input[name="items[rate][]"]').val()) || 0;
            var taxRate = parseFloat(row.find('select[name="items[tax][]"]').val()) || 0;

            var amount = quantity * rate;
            var taxAmount = amount * (taxRate / 100);
            var totalAmount = amount + taxAmount;

            row.find('.item-amount').text(totalAmount.toFixed(2));
            return totalAmount;
        }

        //function to calculate the subtotal
        function calculateSubtotal_backup() {
            var subtotal = 0;
            $('#table-body tr').each(function() {
                var row = $(this);
                var rowAmount = calculateRowAmount(row);
                subtotal += rowAmount;
            });
            return subtotal;
        }

        //function to calculate and update the total
        function updateTotal_backup() {
            var subtotal = calculateSubtotal();
            var discountValue = parseFloat($('input[name="discount"]').val()) || 0;
            var discountType = $('select[name="discount_type"]').val();
            var adjustmentValue = parseFloat($('input[name="adjustment"]').val()) || 0;

            //count discount
            if (discountType === 'percentage') {
                discountValue = (subtotal * discountValue) / 100;
            }

            var discountedSubtotal = subtotal - discountValue;
            var total = discountedSubtotal + adjustmentValue;

            //update values on the view
            $('#subtotal-amount').text(subtotal.toFixed(2));
            $('#discount-amount').text('-' + discountValue.toFixed(2));
            $('#adjustment-amount').text(adjustmentValue.toFixed(2));
            $('#total-amount').text(total.toFixed(2));

            //update hidden input values
            $('#subtotal-hidden').val(subtotal.toFixed(2));
            $('#total-hidden').val(total.toFixed(2));
        }

        //function to calculate row amount including tax
        function calculateRowAmount(row) {
            var quantity = parseFloat(row.find('input[name="items[quantity][]"]').val()) || 0;
            var rate = parseFloat(row.find('input[name="items[rate][]"]').val()) || 0;
            var taxRate = parseFloat(row.find('select[name="items[tax][]"]').val()) || 0;

            var amount = quantity * rate;
            var taxAmount = amount * (taxRate / 100);
            var totalAmount = amount + taxAmount;

            row.find('.item-amount').text(totalAmount.toFixed(2));
            return {
                totalAmount: totalAmount,
                taxAmount: taxAmount
            };
        }

        //function to calculate the subtotal and total tax
        function calculateSubtotalAndTax() {
            var subtotal = 0;
            var totalTax = 0;
            $('#table-body tr').each(function() {
                var row = $(this);
                var rowData = calculateRowAmount(row);
                subtotal += rowData.totalAmount - rowData.taxAmount; //subtotal excluding tax
                totalTax += rowData.taxAmount; //total tax
            });
            return {
                subtotal: subtotal,
                totalTax: totalTax
            };
        }

        //function to calculate and update the total
        function updateTotal() {
            var values = calculateSubtotalAndTax();
            var subtotal = values.subtotal;
            var totalTax = values.totalTax;
            var discountValue = parseFloat($('input[name="discount"]').val()) || 0;
            var discountType = $('select[name="discount_type"]').val();
            var adjustmentValue = parseFloat($('input[name="adjustment"]').val()) || 0;

            //count discount
            if (discountType === 'percentage') {
                discountValue = (subtotal * discountValue) / 100;
            }

            var discountedSubtotal = subtotal - discountValue;
            var total = discountedSubtotal + adjustmentValue + totalTax; // total includes tax

            //update values on the view
            $('#subtotal-amount').text(subtotal.toFixed(2));
            $('#discount-amount').text('-' + discountValue.toFixed(2));
            $('#adjustment-amount').text(adjustmentValue.toFixed(2));
            $('#total-tax-amount').text(totalTax.toFixed(2)); // update total tax
            $('#total-amount').text(total.toFixed(2));

            //update hidden input values
            $('#subtotal-hidden').val(subtotal.toFixed(2));
            $('#total-hidden').val(total.toFixed(2));
            $('#totaltax-hidden').val(totalTax.toFixed(2));
            $('#totaldiscount-hidden').val(discountValue.toFixed(2));
        }

        //add new row logic
        $(document).on('click', '.add-row', function() {
            var lastRow = $('#table-body tr:last'); //reference to the last row

            //ensure necessary fields in the last row are filled before adding a new row
            var itemName = lastRow.find('textarea[name="items[item_name][]"]').val();
            var description = lastRow.find('textarea[name="items[descriptions][]"]').val();
            var quantity = lastRow.find('input[name="items[quantity][]"]').val();
            var rate = lastRow.find('input[name="items[rate][]"]').val();

            if (itemName !== "" && quantity !== "" && rate !== "") {
                //all fields are filled, add a new row
                var newRow = `<tr>
                   <td>
                       <textarea class="form-control form-control-sm min-w-250px" name="items[item_name][]" cols="30" rows="2"
                           placeholder="Item Name" readonly></textarea>
                   </td>
                   <td>
                       <textarea class="form-control form-select-sm min-w-250px" name="items[descriptions][]" cols="30" rows="2"
                           placeholder="Description"></textarea>
                   </td>
                   <td>
                       <input class="form-control form-control-sm" type="number" name="items[quantity][]"
                           placeholder="Quantity">
                   </td>
                   <td>
                       <input class="form-control form-control-sm" type="number" name="items[rate][]"
                           placeholder="Rate">
                   </td>
                   <td>
                       <select class="form-select form-select-sm" name="items[tax][]">
                           <option value="0.00">No Tax (0.00%)</option>
                           <option value="5.00">5.00%</option>
                           <option value="10.00">10.00%</option>
                           <option value="15.00">15.00%</option>
                       </select>
                   </td>
                   <td class="item-amount">0.00</td>
                   <td>
                       <button type="button" class="btn btn-sm btn-danger py-2 px-2 remove-row">
                           <i class="bi bi-trash"></i>
                       </button>
                   </td>
               </tr>`;

                //append the new row to the table body
                $('#table-body').append(newRow);

                //clear the product selection
                $('#product-select').val('').trigger('change');
                //when add more row click this input hide
                $('input[name="discount"]').val('');
                $('input[name="adjustment"]').val('');
            } else {
                //alert user if any field in the last row is not filled
                alert('Please fill all fields in the last row before adding a new one.');
            }
        });

        //remove row logic
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            updateTotal(); //recalculate total after row removal
        });

        //handle product selection and populate only the last row
        $('#product-select').on('change', function() {
            var selectedOption = $(this).find('option:selected');

            //get selected product details
            var productName = selectedOption.data('name');
            var productDescription = selectedOption.data('description');
            var productRate = selectedOption.data('rate');
            //get the last row in the table
            var lastRow = $('#table-body tr:last');
            //set values in the last row
            lastRow.find('textarea[name="items[item_name][]"]').val(productName);
            lastRow.find('textarea[name="items[descriptions][]"]').val(productDescription);
            lastRow.find('input[name="items[rate][]"]').val(productRate);

            //optionally calculate the amount ex(quantity * rate)
            var quantity = lastRow.find('input[name="items[quantity][]"]').val();
            if (quantity && productRate) {
                lastRow.find('.item-amount').text((quantity * productRate).toFixed(2));
            }
        });

        //changes in the quantity, rate, or tax fields to update the row amount
        $(document).on('input change', 'input[name="items[quantity][]"], input[name="items[rate][]"], select[name="items[tax][]"]', function() {
            var row = $(this).closest('tr');
            calculateRowAmount(row);
            updateTotal();
        });

        //changes in the discount or adjustment inputs
        $('input[name="discount"], select[name="discount_type"], input[name="adjustment"]').on('input change', function() {
            updateTotal();
        });
    });
</script>




<script>
    function getTotalAmount(value) {
        let total = 0;

        const amountInputs = document.querySelectorAll('.custom-amount-input');

        amountInputs.forEach(input => {
            let value = parseFloat(input.value.replace(/,/g, '')) || 0;
            total += value;
        });

        const formattedTotal = total.toFixed(2);

        document.getElementById('custom-subtotal-amount').innerHTML = formattedTotal;
        document.getElementById('subtotal-hidden').value = formattedTotal;
        document.getElementById('total-hidden').value = formattedTotal;
        document.getElementById('custom-total-amount').innerHTML = formattedTotal;
        let vatInput = document.querySelector('[id="custom_vat"]');
        if (vatInput && vatInput.value) {
            calculateVat(vatInput.value);
        }
        let adjustmentInput = document.querySelector('[id="custom_adjustment"]');
        if (adjustmentInput && adjustmentInput.value) {
            calculateCustomAdjustment(adjustmentInput.value);
        }
    }

    function calculateVat(value) {
        value = parseFloat(value);
        if (isNaN(value)) {
            value = 0;
        }
        let subTotalAmount = document.getElementById('subtotal-hidden').value;
        let totalVat = (subTotalAmount * value) / 100;
        document.getElementById('totaltax-hidden').value = totalVat;
        let totalAmount = 0;
        totalAmount = parseFloat(subTotalAmount) + parseFloat(totalVat) + parseFloat(totalAmount);
        document.getElementById('custom-total-vat').innerHTML = totalVat.toFixed(2);
        document.getElementById('total-hidden').value = totalAmount.toFixed(2);
        document.getElementById('custom-total-amount').innerHTML = totalAmount.toFixed(2);
    }

    function calculateCustomAdjustment(value) {
        // Validate the input value
        value = value === '' || isNaN(parseFloat(value)) ? 0 : parseFloat(value);

        // Fetch values and validate them
        let subTotalAmount = getValidNumber(document.getElementById('subtotal-hidden')?.value);
        let totalVat = getValidNumber(document.getElementById('totaltax-hidden')?.value);
        console.log('totalVat', totalVat)
        // Calculate the total amount
        let totalAmount = subTotalAmount + totalVat + value;


        // Safely update DOM elements if they exist
        let totalHidden = document.getElementById('total-hidden');
        let totalAmountDisplay = document.getElementById('custom-total-amount');
        let adjustmentDisplay = document.getElementById('custom-adjustment-amount');

        if (totalHidden)
            totalHidden.value = totalAmount.toFixed(2);
        if (totalAmountDisplay)
            totalAmountDisplay.innerHTML = totalAmount.toFixed(2);
        if (adjustmentDisplay)
            adjustmentDisplay.innerHTML = totalAmount.toFixed(2);
    }

    function getValidNumber(value) {
        return value === '' || isNaN(parseFloat(value)) ? 0 : parseFloat(value);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const customInvoiceSelect = document.getElementById('custom-invoice-select');
        const defaultInvoice = document.getElementById('default-invoice');
        const proposalTable = document.getElementById('custom-invoice-table'); // custom table id
        const customInvoiceHeader = document.getElementById('custom-invoice-header');
        const customInvoiceBody = document.getElementById('custom-invoice-body');

        const footerTable = document.getElementById('custom-invoice-footer-table');
        const customInvoiceFooterHeader = document.getElementById('custom-invoice-footer-header');
        const customInvoiceFooterBody = document.getElementById('custom-invoice-footer-body');
        const customInvoiceDiv = document.getElementById('custom-invoice');

        const customVat = document.getElementById('custom_vat');
        const customAdjustment = document.getElementById('custom_adjustment');


        window.sanitizeInput = function(inputElement) {
            inputElement.value = inputElement.value.replace(/,/g, '');
            getTotalAmount(inputElement.value);
        };

        customVat.addEventListener('input', function() {
            calculateVat(this.value);
        });

        customAdjustment.addEventListener('input', function() {
            calculateCustomAdjustment(this.value);
        });

        customInvoiceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const fieldDetails = selectedOption.dataset.fields ? JSON.parse(selectedOption.dataset.fields) : null;
            // const footerDetails = selectedOption.dataset.fields ? JSON.parse(selectedOption.dataset.footer) : null;
            if (fieldDetails && fieldDetails.length > 0) {

                defaultInvoice.style.display = 'none';
                proposalTable.style.display = 'table';
                customInvoiceDiv.style.display = 'block';

                const fields = fieldDetails.map(detail => ({
                    field_name: detail.field_name,
                    field_value: detail.field_value
                }));


                const rawData = JSON.parse(invoiceDescription.replace(/&quot;/g, '"'));
                const existingData = rawData.map(entry => {
                    const result = {};
                    entry.forEach(field => {
                        const key = Object.keys(field)[0];
                        result[key] = field[key];
                    });
                    return result;
                });

                console.log(invoiceDescription);

                // Populate the invoice fields with existing data
                populateCustomInvoiceFields(fields, existingData);
            } else {
                customInvoiceDiv.style.display = 'none';
                defaultInvoice.style.display = 'block';
                proposalTable.style.display = 'none';
            }

            // if (footerDetails && footerDetails.length > 0) {
            //     footerTable.style.display = 'table';
            //     populateCustomInvoiceFooters(footerDetails);

            // }else {
            //     footerTable.style.display = 'none';

            // }

        });


        function populateCustomInvoiceFields(fields, existingData = []) {
            // Headers in the custom invoice table
            customInvoiceHeader.innerHTML = fields.map(field => `<th>${field.field_name}</th>`).join('') + '<th>Amount</th><th>Action</th>';

            // Initialize the custom invoice table body
            customInvoiceBody.innerHTML = '';

            // If existing data is available, populate the first row
            if (existingData.length > 0) {
                existingData.forEach((data, index) => {
                    const initialRow = `
                        <tr>
                            ${fields.map(field => `
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="items[${field.field_value}][]" 
                                        placeholder="${field.field_name}" 
                                        value="${data[field.field_value] || ''}" />
                                </td>`).join('')}
                            <td>
                                <input 
                                    type="text" 
                                    class="form-control custom-amount-input" 
                                    name="items[amount][]" 
                                    placeholder="Amount" 
                                    value="${data['amount'] || ''}" 
                                    oninput="sanitizeInput(this)" />
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger py-2 px-3 remove-row">
                                    <i class="bi bi-trash pe-0"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    // Add the initial row for each existing data entry
                    customInvoiceBody.insertAdjacentHTML('beforeend', initialRow);
                });
            }

            // After populating existing data, add an empty row with "Add More" functionality
            customInvoiceBody.insertAdjacentHTML('beforeend', `
                <tr>
                    ${fields.map(field => `
                        <td>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="items[${field.field_value}][]" 
                                placeholder="${field.field_name}" />
                        </td>`).join('')}
                    <td>
                        <input 
                            type="text" 
                            class="form-control custom-amount-input" 
                            name="items[amount][]" 
                            placeholder="Amount" 
                            oninput="sanitizeInput(this)" />
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary py-2 px-3" id="add-row">
                            <i class="bi bi-plus-lg pe-0"></i>
                        </button>
                    </td>
                </tr>
            `);

            // Add functionality for the "Remove" buttons
            addRemoveFunctionality();

            // Add event listener for the "Add More" button
            document.getElementById('add-row').addEventListener('click', function() {
                // Insert a new, empty row
                customInvoiceBody.insertAdjacentHTML('beforeend', `
                    <tr>
                        ${fields.map(field => `
                            <td>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="items[${field.field_value}][]" 
                                    placeholder="${field.field_name}" />
                            </td>`).join('')}
                        <td>
                            <input 
                                type="text" 
                                class="form-control custom-amount-input" 
                                name="items[amount][]" 
                                placeholder="Amount" 
                                oninput="sanitizeInput(this)" />
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger py-2 px-3 remove-row">
                                <i class="bi bi-trash pe-0"></i>
                            </button>
                        </td>
                    </tr>
                `);

                // Reapply functionality for new rows
                addRemoveFunctionality();
            });
        }

function populateCustomInvoiceFields_backup_27022025(fields, existingData = []) {
    //console.log
    // headers in the custom invoice table
    customInvoiceHeader.innerHTML = fields.map(field => `<th>${field.field_name}</th>`).join('') + '<th>Amount</th><th>Action</th>';

    // initialize the custom invoice table body
    customInvoiceBody.innerHTML = '';

    // if existing data is available, populate the first row
    if (existingData.length >0) {
        //alert('sdsdsds');
        existingData.forEach((data) => {
            const initialRow = `
                <tr>
                    ${fields.map(field => `
                        <td>
                            ${
                                field.field_name.toLowerCase() === 'description'
                                ? `<textarea class="form-control form-select-sm min-w-250px" cols="30" rows="2" name="items[${field.field_value}][]" placeholder="${field.field_name}">${data[field.field_value] || ''}</textarea>`
                                : `<input type="text" class="form-control" name="items[${field.field_value}][]" placeholder="${field.field_name}" value="${data[field.field_value] || ''}" />`
                            }
                        </td>`).join('')}
                    <td>
                        <input 
                            type="text" 
                            class="form-control custom-amount-input" 
                            name="items[amount][]" 
                            placeholder="Amount" 
                            value="${data['amount'] || ''}" 
                            oninput="sanitizeInput(this)" />
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger py-2 px-3 remove-row">
                            <i class="bi bi-trash pe-0"></i>
                        </button>
                    </td>
                </tr>
            `;
            // add the initial row for each existing data entry
            customInvoiceBody.insertAdjacentHTML('beforeend', initialRow);
        });
    }

    // add an empty row with add more functionality
    customInvoiceBody.insertAdjacentHTML('beforeend', `
        <tr>
            ${fields.map(field => `
                <td>
                    ${
                        field.field_name.toLowerCase() === 'description'
                        ? `<textarea class="form-control form-select-sm min-w-250px" cols="30" rows="2" name="items[${field.field_value}][]" placeholder="${field.field_name}"></textarea>`
                        : `<input type="text" class="form-control" name="items[${field.field_value}][]" placeholder="${field.field_name}" />`
                    }
                </td>`).join('')}
            <td>
                <input 
                    type="text" 
                    class="form-control custom-amount-input" 
                    name="items[amount][]" 
                    placeholder="Amount" 
                    oninput="sanitizeInput(this)" />
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-primary py-2 px-3" id="add-row">
                    <i class="bi bi-plus-lg pe-0"></i>
                </button>
            </td>
        </tr>
    `);

    // Add functionality for the "Remove" buttons
    addRemoveFunctionality();

    // Add event listener for the "Add More" button
    document.getElementById('add-row').addEventListener('click', function() {
        // Insert a new, empty row
        customInvoiceBody.insertAdjacentHTML('beforeend', `
            <tr>
                ${fields.map(field => `
                    <td>
                        ${
                            field.field_name.toLowerCase() === 'description'
                            ? `<textarea class="form-control" name="items[${field.field_value}][]" placeholder="${field.field_name}"></textarea>`
                            : `<input type="text" class="form-control" name="items[${field.field_value}][]" placeholder="${field.field_name}" />`
                        }
                    </td>`).join('')}
                <td>
                    <input 
                        type="text" 
                        class="form-control custom-amount-input" 
                        name="items[amount][]" 
                        placeholder="Amount" 
                        oninput="sanitizeInput(this)" />
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger py-2 px-3 remove-row">
                        <i class="bi bi-trash pe-0"></i>
                    </button>
                </td>
            </tr>
        `);

        // Reapply functionality for new rows
        addRemoveFunctionality();
    });
}

        const invoiceDescription = `{{ $invoice->item_description }}`;



        // function populateCustomInvoiceFooters(fields) {
        //     // headers in custom invoice table
        //     customInvoiceFooterHeader.innerHTML = fields.map(field => `<th>${field.field_name}</th>`).join('');


        //     customInvoiceFooterBody.innerHTML = `
        //     <tr>
        //         ${fields.map(field => `<td><input type="text" class="form-control" name="footer[${field.field_value}]" placeholder="${field.field_name}" /></td>`).join('')}
        //     </tr>
        // `;

        // }

        //remove row button
        function addRemoveFunctionality() {
            document.querySelectorAll('.remove-row').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('tr').remove();
                    getTotalAmount();
                });
            });
        }

        // Trigger the change event on page load
        customInvoiceSelect.dispatchEvent(new Event('change'));
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let customerSelect = document.getElementById("customerSelect");
        let addressField = document.getElementById("address");

        function updateAddressField() {
            let selectedOption = customerSelect.options[customerSelect.selectedIndex];
            let address = selectedOption ? selectedOption.getAttribute("data-address") || "" : "";
            addressField.value = address;
        }
        $('#customerSelect').select2({
            placeholder: "Select Customer",
            allowClear: true
        }).on("change", function () {
            updateAddressField();//update the address field selected
        });

        //set the address field on page load customer selected
        updateAddressField();
    });
</script>



<!-- End Forms-->


<!-- </div> -->
<!--end::Content-->


@endsection