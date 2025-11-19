<div
    class="tab-pane fade {{ session('active_tab') === 'g_lead_products_tab' ? 'active show' : '' }}"
    id="g_lead_products" role="tabpanel" aria-labelledby="g_lead_products_tab">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-1">
                <strong class="fs-3">Product Details</strong>
                <a class="btn btn-success btn-sm" id="kt_activities_toggle_5"><i class="bi bi-plus-lg"></i>Add Product</a>

                {{--
                <a class="btn btn-success btn-sm" target="_blank"
                    href="{{ route('product-specification-create', $lead->id) }}">
                    <i class="bi bi-plus-lg"></i>
                    Add Specification
                </a>
                --}}
            </div>

            <div class="table-responsive">
                @if($productSpecifications->isNotEmpty())
                    <!--begin::Table-->
                    <table
                        class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered" id="tblPS">
                        <!--begin::Table head-->
                        <thead>
                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                            <th class="ps-4 min-w-50px">SL</th>
                            <th class="min-w-120px">Customer</th>
                            <th class="min-w-150px">Product Name</th>
                            <th class="min-w-140px">Work Order Number</th>
                            <th class="min-w-140px">Work Order Value</th>
                            <th class="min-w-140px">Work Order Rate</th>
                            <th class="min-w-140px">Purchase Order Value</th>
                            <th class="min-w-120px">AMC Start Date</th>
                            <th class="min-w-120px">AMC Rate</th>
                            <th class="min-w-100px">Service Type</th>
                            <th class="min-w-100px text-end-new">Actions</th>
                        </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                        @php
                            $i=1;
                        @endphp

                        @foreach($productSpecifications as $productSpecification)
                            <tr>
                                <td class="ps-5 text-dark fs-6" id="{{ $productSpecification->id }}">{{ $i }}</td>
                                <td class="text-dark fs-6 w-120px">{{$productSpecification->first_name}} {{$productSpecification->last_name}}</td>
                                <td class="text-dark fs-6 w-150px">{{ $productSpecification->product_names ?? '' }}</td>
                                <td class="text-dark fs-6 w-140px">{{ $productSpecification->work_order_number }}</td>
                                <td class="text-dark fs-6 w-140px">{{ number_format($productSpecification->work_order_value, 2) }}</td>
                                <td class="text-dark fs-6 w-140px">{{ !empty($productSpecification->work_order_rate) ? $productSpecification->work_order_rate . '%' : '' }}</td>
                                <td class="text-dark fs-6 w-140px">{{ number_format($productSpecification->purchase_order_value, 2) }}</td>
                                <td class="text-dark fs-6 w-120px">{{ $productSpecification->amc_start_date ? \Carbon\Carbon::parse($productSpecification->amc_start_date)->format('d-m-Y') : '' }}</td>
                                <td class="text-dark fs-6 w-120px">{{ !empty($productSpecification->amc_rate) ? $productSpecification->amc_rate . '%' : '' }}</td>
                                <td class="text-dark fs-6 w-120px">{{ $productSpecification->service_type }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex justify-content-end gap-1">
                                        <a href="#"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#add_invoice_modal_{{ $productSpecification->id }}">
                                        <span class="svg-icon svg-icon-3">
                                            <!-- Eye Icon -->
                                            <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M6.55281 1.60553C7.10941 1.32725 7.77344 1 9 1C10.2265 1 10.8906 1.32722 11.4472 1.6055L11.4631 1.61347C11.8987 1.83131 12.2359 1.99991 13 1.99993C14.2371 1.99998 14.9698 1.53871 15.2141 1.35512C15.5944 1.06932 16.0437 1.09342 16.3539 1.2369C16.6681 1.38223 17 1.72899 17 2.24148L17 13H20C21.6562 13 23 14.3415 23 15.999V19C23 19.925 22.7659 20.6852 22.3633 21.2891C21.9649 21.8867 21.4408 22.2726 20.9472 22.5194C20.4575 22.7643 19.9799 22.8817 19.6331 22.9395C19.4249 22.9742 19.2116 23.0004 19 23H5C4.07502 23 3.3148 22.7659 2.71092 22.3633C2.11331 21.9649 1.72739 21.4408 1.48057 20.9472C1.23572 20.4575 1.11827 19.9799 1.06048 19.6332C1.03119 19.4574 1.01616 19.3088 1.0084 19.2002C1.00194 19.1097 1.00003 19.0561 1 19V2.24146C1 1.72899 1.33184 1.38223 1.64606 1.2369C1.95628 1.09341 2.40561 1.06931 2.78589 1.35509C3.03019 1.53868 3.76289 1.99993 5 1.99993C5.76415 1.99993 6.10128 1.83134 6.53688 1.6135L6.55281 1.60553ZM3.00332 19L3 3.68371C3.54018 3.86577 4.20732 3.99993 5 3.99993C6.22656 3.99993 6.89059 3.67269 7.44719 3.39441L7.46312 3.38644C7.89872 3.1686 8.23585 3 9 3C9.76417 3 10.1013 3.16859 10.5369 3.38643L10.5528 3.39439C11.1094 3.67266 11.7734 3.9999 13 3.99993C13.7927 3.99996 14.4598 3.86581 15 3.68373V19C15 19.783 15.1678 20.448 15.4635 21H5C4.42498 21 4.0602 20.8591 3.82033 20.6992C3.57419 20.5351 3.39761 20.3092 3.26943 20.0528C3.13928 19.7925 3.06923 19.5201 3.03327 19.3044C3.01637 19.2029 3.00612 19.1024 3.00332 19ZM19.3044 20.9667C19.5201 20.9308 19.7925 20.8607 20.0528 20.7306C20.3092 20.6024 20.5351 20.4258 20.6992 20.1797C20.8591 19.9398 21 19.575 21 19V15.999C21 15.4474 20.5529 15 20 15H17L17 19C17 19.575 17.1409 19.9398 17.3008 20.1797C17.4649 20.4258 17.6908 20.6024 17.9472 20.7306C18.2075 20.8607 18.4799 20.9308 18.6957 20.9667C18.8012 20.9843 18.8869 20.9927 18.9423 20.9967C19.0629 21.0053 19.1857 20.9865 19.3044 20.9667Z"
                                                        fill="#0F0F0F"/>
                                                <path
                                                    d="M5 8C5 7.44772 5.44772 7 6 7H12C12.5523 7 13 7.44772 13 8C13 8.55229 12.5523 9 12 9H6C5.44772 9 5 8.55229 5 8Z"
                                                    fill="#0F0F0F"/>
                                                <path
                                                    d="M5 12C5 11.4477 5.44772 11 6 11H12C12.5523 11 13 11.4477 13 12C13 12.5523 12.5523 13 12 13H6C5.44772 13 5 12.5523 5 12Z"
                                                    fill="#0F0F0F"/>
                                                <path
                                                    d="M5 16C5 15.4477 5.44772 15 6 15H12C12.5523 15 13 15.4477 13 16C13 16.5523 12.5523 17 12 17H6C5.44772 17 5 16.5523 5 16Z"
                                                    fill="#0F0F0F"/>
                                            </svg>
                                        </span>
                                        </a>
                                        <!-- View Button -->
                                        <!-- <a href="#"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            id="show_productSpecification_{{ $productSpecification->id }}"> -->
                                    <a href="{{ route('product-specification-show', $productSpecification->id) }}" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <span class="svg-icon svg-icon-3">
                                        <!-- Eye Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                height="24px" viewBox="0 0 24 24">
                                            <g stroke="none" stroke-width="1" fill="none"
                                                fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path
                                                    d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                                    fill="black" fill-rule="nonzero" opacity="0.7"/>
                                                <path
                                                    d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                                    fill="black" opacity="0.7"/>
                                            </g>
                                        </svg>
                                    </span>
                                        </a>
                                        <!-- Edit Button -->
                                        <!-- <a href="#"
                                            class="update_productSpecification btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            id="update_productSpecification_{{ $productSpecification->id }}"> -->
                                    <a href="{{ route('product-specification-edit', $productSpecification->id) }}" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <span class="svg-icon svg-icon-3">
                                        <!-- Edit Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                    d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                    fill="black"/>
                                            <path
                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                fill="black"/>
                                        </svg>
                                    </span>
                                        </a>
                                        <!-- Delete Button -->

                                        <form
                                            action="{{ route('product-specification-destroy', $productSpecification->id) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                    onclick="return confirmDelete()">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                        fill="black"/>
                                                    <path opacity="0.5"
                                                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                            fill="black"/>
                                                    <path opacity="0.5"
                                                            d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                            fill="black"/>
                                                </svg>
                                            </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                        </form>

                                        <div id="kt_activities_5_{{ $productSpecification->id }}"
                                                class="bg-body" data-kt-drawer="true"
                                                data-kt-drawer-name="activities"
                                                data-kt-drawer-activate="true"
                                                data-kt-drawer-overlay="true"
                                                data-kt-drawer-width="{default:'300px', 'lg': '70%'}"
                                                data-kt-drawer-direction="end"
                                                data-kt-drawer-toggle="#update_productSpecification_{{ $productSpecification->id }}"
                                                data-kt-drawer-close="#kt_activities_close">

                                            <div class="card shadow-none rounded-0 w-100">
                                                <!--begin::Header-->
                                                <div class="card-header" id="kt_activities_header">
                                                    <h3 class="card-title fw-bolder text-dark">Edit
                                                        Product Specification</h3>
                                                    <div class="card-toolbar">
                                                        <button type="button"
                                                                class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                                                                id="kt_activities_close">
                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                            <span class="svg-icon svg-icon-1">
                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24"
                                                                    viewBox="0 0 24 24" fill="none">
                                                                    <rect opacity="0.5" x="6"
                                                                            y="17.3137" width="16"
                                                                            height="2" rx="1"
                                                                            transform="rotate(-45 6 17.3137)"
                                                                            fill="black"/>
                                                                    <rect x="7.41422" y="6"
                                                                            width="16" height="2"
                                                                            rx="1"
                                                                            transform="rotate(45 7.41422 6)"
                                                                            fill="black"/>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Body-->
                                                <div class="card-body position-relative"
                                                        id="kt_activities_body">
                                                    <!--begin::Content-->
                                                    <div id="kt_activities_scroll"
                                                            class="position-relative scroll-y me-n5 pe-5"
                                                            data-kt-scroll="false"
                                                            data-kt-scroll-height="auto"
                                                            data-kt-scroll-wrappers="#kt_activities_body"
                                                            data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                                                            data-kt-scroll-offset="5px">
                                                        <!--begin::Timeline items-->
                                                        <!-- <div class="timeline"> -->

                                                        <!--begin::Tables Widget 9-->
                                                        <div class="card mb-5 mb-xl-8">
                                                            <!--begin::Header-->

                                                            <!--end::Header-->
                                                            <div>
                                                                <div class="row text-start">
                                                                    <div class="col-md-12 mx-auto">
                                                                        <div class="card-body">
                                                                            <form
                                                                                class="g-form w-100"
                                                                                action="{{ route('product-specification-update', $productSpecification->id) }}"
                                                                                enctype="multipart/form-data"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden"
                                                                                        name="form_ps_panel"
                                                                                        value="1">
                                                                                @method('PUT')
                                                                                <div class="row">
                                                                                    <!-- Product Dropdown -->

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <div
                                                                                            class="fv-row mb-5">
                                                                                            <label
                                                                                                class="form-label fw-bolder text-dark">Customer<span
                                                                                                    class="text-danger">*</span>

                                                                                            </label>

                                                                                            <select
                                                                                                name="customer_id"
                                                                                                class="form-control form-control-sm form-control-solid"
                                                                                                required
                                                                                                aria-label="Default select example">
                                                                                                @if (!empty($lead_customer))
                                                                                                    <option
                                                                                                        value="{{ $lead_customer->id }}">{{ $lead_customer->first_name . " " . $lead_customer->last_name }}</option>
                                                                                                @else
                                                                                                    <option
                                                                                                        value=""
                                                                                                        disabled
                                                                                                        selected>
                                                                                                        No
                                                                                                        customer
                                                                                                        assigned
                                                                                                    </option>
                                                                                                @endif
                                                                                            </select>
                                                                                            @if ($errors->has('customer_id'))
                                                                                                <span
                                                                                                    class="text-danger">{{ $errors->first('customer_id') }}</span>
                                                                                            @endif

                                                                                        </div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Product</label>
                                                                                        <select
                                                                                            id="product-select-ps-edit-{{ $productSpecification->id }}"
                                                                                            class="product-select-ps-edit form-control form-control-sm form-control-solid"
                                                                                            name="product_id[]"
                                                                                            multiple="multiple"
                                                                                            data-allow-clear="true"
                                                                                            data-kt-select2="select2">
                                                                                            @foreach ($products as $product)
                                                                                                <option
                                                                                                    value="{{ $product->id }}"
                                                                                                    {{ in_array($product->id, $productSpecification->product_ids ?? []) ? 'selected' : '' }}>
                                                                                                    {{ $product->name }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @if ($errors->has('product_id'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('product_id') }}</div>
                                                                                        @endif
                                                                                    </div>


                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Work
                                                                                            Order
                                                                                            Number</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="text"
                                                                                            name="work_order_number"
                                                                                            value="{{ old('work_order_number', $productSpecification->work_order_number) }}"/>
                                                                                        @error('work_order_number')
                                                                                        <div
                                                                                            class="text-danger">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>


                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Work
                                                                                            Order
                                                                                            Value</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="number"
                                                                                            name="work_order_value"
                                                                                            value="{{ old('work_order_value', $productSpecification->work_order_value) }}"/>
                                                                                        @error('work_order_value')
                                                                                        <div
                                                                                            class="text-danger">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>


                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Work
                                                                                            Order
                                                                                            File</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="file"
                                                                                            name="work_order_file"/>
                                                                                        @if ($productSpecification->work_order_file)
                                                                                            <div
                                                                                                id="work_order_file-file-container">
                                                                                                <a href="{{ asset('uploads/product_specification/' . $productSpecification->work_order_file) }}"
                                                                                                    target="_blank">View
                                                                                                    Current
                                                                                                    File</a>
                                                                                                <button
                                                                                                    type="button"
                                                                                                    class="btn btn-danger btn-sm p-2 delete-file-btn"
                                                                                                    data-type="work_order_file">
                                                                                                    <i class="fas fa-trash-alt pe-0"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        @endif
                                                                                        @error('work_order_file')
                                                                                        <div
                                                                                            class="text-danger">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>


                                                                                    <!-- new fields -->
                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Advance
                                                                                            Amount</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="text"
                                                                                            name="advance_amount"
                                                                                            value="{{ old('advance_amount', $productSpecification->advance_amount) }}"/>
                                                                                        @if ($errors->has('advance_amount'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('advance_amount') }}</div>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Total
                                                                                            Installment</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="text"
                                                                                            name="total_installment"
                                                                                            value="{{ old('total_installment', $productSpecification->total_installment) }}"/>
                                                                                        @if ($errors->has('total_installment'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('total_installment') }}</div>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Per
                                                                                            Month
                                                                                            Installment</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="text"
                                                                                            name="per_month_installment"
                                                                                            value="{{ old('per_month_installment', $productSpecification->per_month_installment) }}"/>
                                                                                        @if ($errors->has('per_month_installment'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('per_month_installment') }}</div>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Payment
                                                                                            Date
                                                                                            Cycle</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid flatpickr"
                                                                                            type="text"
                                                                                            id="common_dob"
                                                                                            name="payment_date_cycle"
                                                                                            value="{{ old('payment_date_cycle', $productSpecification->payment_date_cycle) }}"/>
                                                                                        @if ($errors->has('payment_date_cycle'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('payment_date_cycle') }}</div>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Remaining
                                                                                            Month</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="text"
                                                                                            name="remaining_month"
                                                                                            value="{{ old('remaining_month', $productSpecification->remaining_month) }}"/>
                                                                                        @if ($errors->has('remaining_month'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('remaining_month') }}</div>
                                                                                        @endif
                                                                                    </div>


                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Due
                                                                                            Balance</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="number"
                                                                                            name="due_balance"
                                                                                            value="{{ old('due_balance', $productSpecification->due_balance) }}"/>
                                                                                        @if ($errors->has('due_balance'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('due_balance') }}</div>
                                                                                        @endif
                                                                                    </div>
                                                                                    <!-- end new fields -->


                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Purchase
                                                                                            Order
                                                                                            Value</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="number"
                                                                                            name="purchase_order_value"
                                                                                            value="{{ old('purchase_order_value', $productSpecification->purchase_order_value) }}"/>
                                                                                        @error('purchase_order_value')
                                                                                        <div
                                                                                            class="text-danger">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Purchase
                                                                                            Order
                                                                                            File</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="file"
                                                                                            name="purchase_order_file"/>
                                                                                        @if ($productSpecification->purchase_order_file)
                                                                                            <div
                                                                                                id="purchase_order_file-file-container">
                                                                                                <a href="{{ asset('uploads/product_specification/' . $productSpecification->purchase_order_file) }}"
                                                                                                    target="_blank">View
                                                                                                    Current
                                                                                                    File</a>
                                                                                                <button
                                                                                                    type="button"
                                                                                                    class="btn btn-danger btn-sm p-2 delete-file-btn"
                                                                                                    data-type="purchase_order_file">
                                                                                                    <i class="fas fa-trash-alt pe-0"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        @endif
                                                                                        @if ($errors->has('purchase_order_file'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('purchase_order_file') }}</div>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">AMC
                                                                                            Start
                                                                                            Date</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid flatpickr"
                                                                                            type="text"
                                                                                            id="common_dob"
                                                                                            name="amc_start_date"
                                                                                            value="{{ old('amc_start_date', $productSpecification->amc_start_date) }}"/>
                                                                                        @error('amc_start_date')
                                                                                        <div
                                                                                            class="text-danger">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">AMC
                                                                                            Renewal
                                                                                            Date</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid flatpickr"
                                                                                            type="text"
                                                                                            id="common_dob"
                                                                                            name="amc_renewal_date"
                                                                                            value="{{ old('amc_renewal_date', $productSpecification->amc_renewal_date) }}"/>
                                                                                        @error('amc_renewal_date')
                                                                                        <div
                                                                                            class="text-danger">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">AMC
                                                                                            Rate
                                                                                            (%)</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="number"
                                                                                            name="amc_rate"
                                                                                            value="{{ old('amc_rate', $productSpecification->amc_rate) }}"
                                                                                            step="0.01"/>
                                                                                        @error('amc_rate')
                                                                                        <div
                                                                                            class="text-danger">{{ $message }}</div>
                                                                                        @enderror
                                                                                    </div>


                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Rental
                                                                                            Amount</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="number"
                                                                                            name="rental_amount"
                                                                                            value="{{ old('rental_amount', $productSpecification->rental_amount) }}"/>
                                                                                        @if ($errors->has('rental_amount'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('rental_amount') }}</div>
                                                                                        @endif
                                                                                    </div>


                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">AMC
                                                                                            Effective
                                                                                            Amount</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="number"
                                                                                            name="amc_effective_amount"
                                                                                            value="{{ old('amc_effective_amount', $productSpecification->amc_effective_amount) }}"/>
                                                                                        @if ($errors->has('amc_effective_amount'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('amc_effective_amount') }}</div>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">AMC
                                                                                            Agreement
                                                                                            Documents</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="file"
                                                                                            name="amc_agreement_documents"/>
                                                                                        @if ($errors->has('amc_agreement_documents'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('amc_agreement_documents') }}</div>
                                                                                        @endif
                                                                                        @if (!empty($productSpecification->amc_agreement_documents))
                                                                                            <div
                                                                                                id="amc_agreement_documents-file-container">
                                                                                                <a href="{{ asset('uploads/product_specification/' . $productSpecification->amc_agreement_documents) }}"
                                                                                                    target="_blank">View
                                                                                                    Current
                                                                                                    Document</a>
                                                                                                <button
                                                                                                    type="button"
                                                                                                    class="btn btn-danger btn-sm p-2 delete-file-btn"
                                                                                                    data-type="amc_agreement_documents">
                                                                                                    <i class="fas fa-trash-alt pe-0"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <div
                                                                                            class="fv-row mb-3">
                                                                                            <label
                                                                                                class="form-label fw-bolder text-dark">Service
                                                                                                Type</label>
                                                                                            <select
                                                                                                class="form-control form-control-sm form-control-solid"
                                                                                                name="service_type"
                                                                                                aria-label="Default select example">
                                                                                                <option
                                                                                                    value="">
                                                                                                    Select
                                                                                                    Service
                                                                                                    Type
                                                                                                </option>
                                                                                                <option
                                                                                                    value="Yearly" {{ $productSpecification->service_type === 'Yearly' ? 'selected' : '' }}>
                                                                                                    Yearly
                                                                                                </option>
                                                                                                <option
                                                                                                    value="Half-Yearly" {{ $productSpecification->service_type === 'Half-Yearly' ? 'selected' : '' }}>
                                                                                                    Half-Yearly
                                                                                                </option>
                                                                                                <option
                                                                                                    value="Quarterly" {{ $productSpecification->service_type === 'Quarterly' ? 'selected' : '' }}>
                                                                                                    Quarterly
                                                                                                </option>
                                                                                                <option
                                                                                                    value="Monthly" {{ $productSpecification->service_type === 'Monthly' ? 'selected' : '' }}>
                                                                                                    Monthly
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Software
                                                                                            Value</label>
                                                                                        <textarea
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            name="software_value"
                                                                                            rows="3">{{ old('software_value', $productSpecification->software_value) }}</textarea>
                                                                                        @if ($errors->has('software_value'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('software_value') }}</div>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Hardware
                                                                                            Value</label>
                                                                                        <textarea
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            name="hardware_value"
                                                                                            rows="3">{{ old('hardware_value', $productSpecification->hardware_value) }}</textarea>
                                                                                        @if ($errors->has('hardware_value'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('hardware_value') }}</div>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Implementation
                                                                                            Cost</label>
                                                                                        <textarea
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            name="implementation_value"
                                                                                            rows="3">{{ old('implementation_value', $productSpecification->implementation_value) }}</textarea>
                                                                                        @if ($errors->has('implementation_value'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('implementation_value') }}</div>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Invoice
                                                                                            Mushak
                                                                                            File</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="file"
                                                                                            name="invoice_mushak_file"/>
                                                                                        @if ($errors->has('invoice_mushak_file'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('invoice_mushak_file') }}</div>
                                                                                        @endif
                                                                                        @if (!empty($productSpecification->invoice_mushak_file))
                                                                                            <div
                                                                                                id="invoice_mushak_file-file-container">
                                                                                                <a href="{{ asset('uploads/product_specification/' . $productSpecification->invoice_mushak_file) }}"
                                                                                                    target="_blank">View
                                                                                                    Current
                                                                                                    File</a>
                                                                                                <button
                                                                                                    type="button"
                                                                                                    class="btn btn-danger btn-sm p-2 delete-file-btn"
                                                                                                    data-type="invoice_mushak_file">
                                                                                                    <i class="fas fa-trash-alt pe-0"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Tax
                                                                                            Exemption
                                                                                            Certificate</label>
                                                                                        <input
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            type="file"
                                                                                            name="tax_exemption_certificate"/>
                                                                                        @if ($errors->has('tax_exemption_certificate'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('tax_exemption_certificate') }}</div>
                                                                                        @endif
                                                                                        @if (!empty($productSpecification->tax_exemption_certificate))
                                                                                            <div
                                                                                                id="tax_exemption_certificate-file-container">
                                                                                                <a href="{{ asset('uploads/product_specification/' . $productSpecification->tax_exemption_certificate) }}"
                                                                                                    target="_blank">View
                                                                                                    Current
                                                                                                    Certificate</a>
                                                                                                <button
                                                                                                    type="button"
                                                                                                    class="btn btn-danger btn-sm p-2 delete-file-btn"
                                                                                                    data-type="tax_exemption_certificate">
                                                                                                    <i class="fas fa-trash-alt pe-0"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>

                                                                                    <div
                                                                                        class="col-md-4">
                                                                                        <label
                                                                                            class="form-label fw-bolder text-dark">Note</label>
                                                                                        <textarea
                                                                                            class="form-control form-control-sm form-control-solid"
                                                                                            name="note"
                                                                                            rows="3">{{ old('note', $productSpecification->note) }}</textarea>
                                                                                        @if ($errors->has('note'))
                                                                                            <div
                                                                                                class="text-danger">{{ $errors->first('note') }}</div>
                                                                                        @endif
                                                                                    </div>


                                                                                    <!-- Submit and Reset buttons -->
                                                                                    <div
                                                                                        class="card-footer d-flex justify-content-end py-6 px-9">
                                                                                        <button
                                                                                            type="submit"
                                                                                            class="btn btn-primary">
                                                                                            Update
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!--end::Tables Widget 9-->

                                                        <!-- </div> -->
                                                        <!--end::Timeline items-->
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Body-->
                                                <!--begin::Footer-->

                                                <!--end::Footer-->
                                            </div>
                                        </div>


                                        <div id="kt_activities_5_{{ $productSpecification->id }}"
                                                class="bg-body" data-kt-drawer="true"
                                                data-kt-drawer-name="activities"
                                                data-kt-drawer-activate="true"
                                                data-kt-drawer-overlay="true"
                                                data-kt-drawer-width="{default:'300px', 'lg': '50%'}"
                                                data-kt-drawer-direction="end"
                                                data-kt-drawer-toggle="#show_productSpecification_{{ $productSpecification->id }}"
                                                data-kt-drawer-close="#kt_activities_close">

                                            <div class="card shadow-none rounded-0 w-100">
                                                <!--begin::Header-->
                                                <div class="card-header" id="kt_activities_header">
                                                    <h3 class="card-title fw-bolder text-dark">
                                                        Product Specification Details</h3>
                                                    <div class="card-toolbar">
                                                        <button type="button"
                                                                class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                                                                id="kt_activities_close">
                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                            <span class="svg-icon svg-icon-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="24" height="24"
                                                                    viewBox="0 0 24 24" fill="none">
                                                                <rect opacity="0.5" x="6"
                                                                        y="17.3137" width="16"
                                                                        height="2" rx="1"
                                                                        transform="rotate(-45 6 17.3137)"
                                                                        fill="black"/>
                                                                <rect x="7.41422" y="6" width="16"
                                                                        height="2" rx="1"
                                                                        transform="rotate(45 7.41422 6)"
                                                                        fill="black"/>
                                                            </svg>
                                                        </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Body-->
                                                <div class="card-body position-relative"
                                                        id="kt_activities_body">
                                                    <!--begin::Content-->
                                                    <div id="kt_activities_scroll"
                                                            class="position-relative scroll-y me-n5 pe-5"
                                                            data-kt-scroll="false"
                                                            data-kt-scroll-height="auto"
                                                            data-kt-scroll-wrappers="#kt_activities_body"
                                                            data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                                                            data-kt-scroll-offset="5px">
                                                        <!--begin::Timeline items-->
                                                        <!-- <div class="timeline"> -->

                                                        <!--begin::Tables Widget 9-->
                                                        <div class="card mb-5 mb-xl-8">
                                                            <!--begin::Header-->

                                                            <!--end::Header-->
                                                            <div
                                                                style="border:1px solid #ddd;padding:20px">
                                                                <div class="row text-start">
                                                                    <div class="col-md-12 mx-auto">
                                                                        <div class="card-body p-4">

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Customer:</span>
                                                                                <span>{{$productSpecification->first_name?? '' }} {{$productSpecification->last_name?? '' }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Product Name:</span>
                                                                                <span>{{ $productSpecification->product_names ?? '' }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Work Order Number:</span>
                                                                                <span>{{ $productSpecification->work_order_number }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Work Order Value:</span>
                                                                                <span>{{ number_format($productSpecification->work_order_value, 2) }}</span>
                                                                            </div>

                                                                            @if($productSpecification->work_order_file)
                                                                                <div
                                                                                    class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                    <span
                                                                                        class="fw-bold w-lg-150px">Work Order File:</span>
                                                                                    <a href="{{ asset('uploads/product_specification/' . $productSpecification->work_order_file) }}"
                                                                                        target="_blank">Download</a>
                                                                                </div>
                                                                            @endif

                                                                            <!-- new data -->
                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Advance Amount:</span>
                                                                                <span>{{ number_format($productSpecification->advance_amount) }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Total Installment:</span>
                                                                                <span>{{ $productSpecification->total_installment }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Per Month Installment:</span>
                                                                                <span>{{ number_format($productSpecification->per_month_installment) }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Payment Date Cycle:</span>
                                                                                <span>{{ $productSpecification->payment_date_cycle }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Remaining Month:</span>
                                                                                <span>{{ $productSpecification->remaining_month }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Due Balance:</span>
                                                                                <span>{{ number_format($productSpecification->due_balance) }}</span>
                                                                            </div>
                                                                            <!-- end new data -->


                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Purchase Order Value:</span>
                                                                                <span>{{ number_format($productSpecification->purchase_order_value, 2) }}</span>
                                                                            </div>

                                                                            @if($productSpecification->purchase_order_file)
                                                                                <div
                                                                                    class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                    <span
                                                                                        class="fw-bold w-lg-150px">Purchase Order File:</span>
                                                                                    <a href="{{ asset('uploads/product_specification/' . $productSpecification->purchase_order_file) }}"
                                                                                        target="_blank">Download</a>
                                                                                </div>
                                                                            @endif


                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">AMC Start Date:</span>
                                                                                <span>{{ $productSpecification->amc_start_date ? \Carbon\Carbon::parse($productSpecification->amc_start_date)->format('d-m-Y') : '' }}
                                                                                    </span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">AMC Renewal Date:</span>
                                                                                <span>{{ $productSpecification->amc_renewal_date ? \Carbon\Carbon::parse($productSpecification->amc_renewal_date)->format('d-m-Y') : '' }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">AMC Rate (%):</span>
                                                                                <span>{{ !empty($productSpecification->amc_rate) ? $productSpecification->amc_rate . '%' : '' }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Rental Amount:</span>
                                                                                <span>{{ number_format($productSpecification->rental_amount, 2) }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">AMC Effective Amount:</span>
                                                                                <span>{{ number_format($productSpecification->amc_effective_amount, 2) }}</span>
                                                                            </div>

                                                                            @if($productSpecification->amc_agreement_documents)
                                                                                <div
                                                                                    class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                    <span
                                                                                        class="fw-bold w-lg-150px">AMC Agreement Documents:</span>
                                                                                    <a href="{{ asset('uploads/product_specification/' . $productSpecification->amc_agreement_documents) }}"
                                                                                        target="_blank">Download</a>
                                                                                </div>
                                                                            @endif


                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px">Service Type:</span>
                                                                                <span>{{ $productSpecification->service_type }}</span>
                                                                            </div>


                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px flex-shrink-0">Software Value:</span>
                                                                                <span>{{ $productSpecification->software_value }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px flex-shrink-0">Hardware Value:</span>
                                                                                <span>{{ $productSpecification->hardware_value }}</span>
                                                                            </div>

                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px flex-shrink-0">Implementation Cost:</span>
                                                                                <span>{{ $productSpecification->implementation_value }}</span>
                                                                            </div>

                                                                            @if($productSpecification->invoice_mushak_file)
                                                                                <div
                                                                                    class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                    <span
                                                                                        class="fw-bold w-lg-150px">Invoice Mushak File:</span>
                                                                                    <a href="{{ asset('uploads/product_specification/' . $productSpecification->invoice_mushak_file) }}"
                                                                                        target="_blank">Download</a>
                                                                                </div>
                                                                            @endif

                                                                            @if($productSpecification->tax_exemption_certificate)
                                                                                <div
                                                                                    class="d-flex align-items-center gap-2 bg-light p-3 mb-3">
                                                                                    <span
                                                                                        class="fw-bold w-lg-150px">Tax Exemption Certificate:</span>
                                                                                    <a href="{{ asset('uploads/product_specification/' . $productSpecification->tax_exemption_certificate) }}"
                                                                                        target="_blank">Download</a>
                                                                                </div>
                                                                            @endif


                                                                            <div
                                                                                class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                <span
                                                                                    class="fw-bold w-lg-150px flex-shrink-0">Notes:</span>
                                                                                <span>{{ $productSpecification->note }}</span>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!--end::Tables Widget 9-->

                                                        <!-- </div> -->
                                                        <!--end::Timeline items-->
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Body-->
                                                <!--begin::Footer-->

                                                <!--end::Footer-->
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                @else
                    <p>No results found.</p>
                @endif
                <!--end::Table-->
            </div>

        </div>
    </div>
</div>