@extends('layouts.master')
@php
use Carbon\Carbon;
@endphp

@section('content')

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Product Specification
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Product Specification List</small>
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
            <a href="{{ route('product-specification-init') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Create</a>

            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
<!--**********************************
                   Tables
     ***********************************-->
<div class="container-fluid">

    <!--Table Alert Message-->
    <!-- Display Success and Error Messages using SweetAlert2 -->
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success')}}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error')}}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    @endif

    <!--End Table Alert Message-->

    @foreach ($productSpecifications as $productSpecification)
    <div class="modal fade" id="add_invoice_modal_{{ $productSpecification->id }}" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                    </div>
                </div>
                <!--end::Modal header-->

                <!-- Modal Body -->
                <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                    <div class="table-responsive">
                        @php
                        $invoices = $invoicesGroupedByPsId[$productSpecification->id] ?? collect([]);
                        @endphp
                        @if($invoices->isNotEmpty())
                        <table class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                            <thead>
                                <tr class="fw-bolder text-muted bg-light bd-cyan">
                                    <th class="ps-4 min-w-50px">SL</th>
                                    <th class="min-w-150px">Invoice No</th>
                                    <th class="min-w-140px">Amount</th>
                                    <th class="min-w-140px">Total Tax</th>
                                    <th class="min-w-140px">Discount</th>
                                    <th class="min-w-140px">Date</th>
                                    <th class="min-w-120px">Customer</th>
                                    <th class="min-w-120px">Due Date</th>
                                    <th class="min-w-120px">Status</th>
                                    <th class="min-w-140px text-center">Payment</th>
                                    <th class="min-w-140px text-center">Due</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $index => $invoice)
                                @php
                                
                                $paymentDetails = collect($invoice->payment_details);
                                $totalPayments = $paymentDetails->sum('payment');
                                $dueAmount = $paymentDetails->last()['due'] ?? $invoice->total_amount;

                               
                                if ($totalPayments == $invoice->total_amount) {
                                    $status = 'Paid';
                                    $statusClass = 'badge-light-success';
                                } elseif ($totalPayments == 0) {
                                    $status = 'Unpaid';
                                    $statusClass = 'badge-light-danger';
                                } elseif ($totalPayments > 0 && $totalPayments < $invoice->total_amount) {
                                    $status = 'Partial Paid';
                                    $statusClass = 'badge-light-warning';
                                }
                               @endphp
                                <tr>
                                    <td class="ps-5 text-dark fs-6">{{ $index + 1 }}</td>
                                    <td class="text-dark fs-6">{{ $invoice->invoice_number }}</td>
                                    <td class="text-dark fs-6">{{ $invoice->total_amount }}</td>
                                    <td class="text-dark fs-6">{{ $invoice->total_tax }}</td>
                                    <td class="text-dark fs-6">{{ $invoice->discount ?? '0.00' }}</td>
                                    <td class="text-dark fs-6">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</td>
                                    <td class="text-dark fs-6">{{ $invoice->first_name }} {{ $invoice->last_name }}</td>

                                    <td class="text-dark fs-6">{{ \Carbon\Carbon::parse($invoice->due_date)->format('d-m-Y') }}</td>
                                    <td>
                                   <span class="badge {{ $statusClass }}">{{ $status }}</span>
                                   </td>
                                    <td class="text-dark fs-6 text-center">
                                        {{ collect($invoice->payment_details)->sum('payment') ?? '0.00' }}
                                    </td>
                                    <td class="text-dark fs-6 text-center">
                                        {{ collect($invoice->payment_details)->last()['due'] ?? $invoice->total_amount }}
                                    </td>
                                </tr>
                                @endforeach

                                
                                <tr class="fw-bold bg-light">
                                    <td colspan="2" class="text-center">Total</td>
                                    <td class="text-dark fs-6">{{ $invoices->sum('total_amount') }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-dark fs-6 text-center">
                                        {{ $invoices->sum(function ($invoice) {return collect($invoice->payment_details)->sum('payment');}) }}
                                    </td>
                                    <td class="text-dark fs-6 text-center">
                                        {{ $invoices->sum(function ($invoice) {return collect($invoice->payment_details)->last()['due'] ?? $invoice->total_amount;}) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <p>No results found.</p>
                        @endif
                    </div>
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    @endforeach



    <div class="row">
        <div class="col-xxl-12">
            <!-- <div class="card mb-1"> -->
            <div class="card mt-4">
                <!--begin::Header-->
                <div class="d-flex justify-content-between align-items-start card-header border-0 p-1">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Product Specification List</span>
                        <!-- <span class="text-muted mt-1 fw-bold fs-7">Agent data here</span> -->
                    </h3>

                    <div class="d-flex flex-wrap gap-2">
                        <form action="{{ route('product-specification-search') }}" method="POST" class="d-flex">
                            @csrf
                            <!--begin::Input group-->
                            <div class="d-flex align-items-center position-relative">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                            height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                            fill="black"></rect>
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="black"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <input type="text" name="search"
                                    class="form-control form-control-sm form-control-solid w-250px ps-15"
                                    value="{{ request('search') }}" placeholder="Search by work order number">
                            </div>
                            <!--end::Input group-->
                            <button type="submit" class="btn btn-primary btn-sm ms-2">Search</button>
                        </form>
                    </div>


                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body p-1">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        @if($productSpecifications->isNotEmpty())
                        <!--begin::Table-->
                        <table class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder text-muted bg-light bd-cyan">
                                    <th class="ps-4 min-w-50px">SL</th>
                                    <th class="min-w-120px">Customer</th>
                                    <th class="min-w-150px">Product Name</th>
                                    <th class="min-w-140px">Work Order Number</th>
                                    <th class="min-w-140px">Work Order Value</th>
                                    <th class="min-w-140px">Work Order Rate (%)</th>
                                    <th class="min-w-140px">Purchase Order Value</th>
                                    <th class="min-w-120px">AMC Start Date</th>
                                    <th class="min-w-120px">AMC Rate (%)</th>
                                    <th class="min-w-100px">Service Type</th>
                                    <th class="min-w-100px text-end-new">Actions</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach ($productSpecifications as $productSpecification)
                                <tr>
                                    <td class="ps-5 text-dark fs-6">{{ ($productSpecifications->currentPage() - 1) * $productSpecifications->perPage() + $loop->iteration }}</td>
                                    <td class="text-dark fs-6 w-120px">{{$productSpecification->first_name}} {{$productSpecification->last_name}}</td>
                                    <td class="text-dark fs-6 w-150px">{{ $productSpecification->product_names ?? '' }}</td>
                                    <td class="text-dark fs-6 w-140px">{{ $productSpecification->work_order_number }}</td>
                                    <td class="text-dark fs-6 w-140px">{{ number_format($productSpecification->work_order_value, 2) }}</td>
                                    <td class="text-dark fs-6 w-140px">{{ !empty($productSpecification->work_order_rate) ? $productSpecification->work_order_rate . '%' : '' }}</td>
                                    <td class="text-dark fs-6 w-140px">{{ number_format($productSpecification->purchase_order_value, 2) }}</td>
                                    <td class="text-dark fs-6 w-120px">{{ $productSpecification->amc_start_date ? \Carbon\Carbon::parse($productSpecification->amc_start_date)->format('d-m-Y') : '' }}</td>
                                    <td class="text-dark fs-6 w-120px"> {{ !empty($productSpecification->amc_rate) ? $productSpecification->amc_rate . '%' : '' }}</td>
                                    <td class="text-dark fs-6 w-120px">{{ $productSpecification->service_type }}</td>
                                    <td class="text-end">
                                        <div class="d-inline-flex justify-content-end gap-1">
                                            <!-- View Button -->
                                            <a href="#" title="Show Invoices" 
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#add_invoice_modal_{{ $productSpecification->id }}">
                                                <span class="svg-icon svg-icon-3">
                                                    <!-- Eye Icon -->
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.55281 1.60553C7.10941 1.32725 7.77344 1 9 1C10.2265 1 10.8906 1.32722 11.4472 1.6055L11.4631 1.61347C11.8987 1.83131 12.2359 1.99991 13 1.99993C14.2371 1.99998 14.9698 1.53871 15.2141 1.35512C15.5944 1.06932 16.0437 1.09342 16.3539 1.2369C16.6681 1.38223 17 1.72899 17 2.24148L17 13H20C21.6562 13 23 14.3415 23 15.999V19C23 19.925 22.7659 20.6852 22.3633 21.2891C21.9649 21.8867 21.4408 22.2726 20.9472 22.5194C20.4575 22.7643 19.9799 22.8817 19.6331 22.9395C19.4249 22.9742 19.2116 23.0004 19 23H5C4.07502 23 3.3148 22.7659 2.71092 22.3633C2.11331 21.9649 1.72739 21.4408 1.48057 20.9472C1.23572 20.4575 1.11827 19.9799 1.06048 19.6332C1.03119 19.4574 1.01616 19.3088 1.0084 19.2002C1.00194 19.1097 1.00003 19.0561 1 19V2.24146C1 1.72899 1.33184 1.38223 1.64606 1.2369C1.95628 1.09341 2.40561 1.06931 2.78589 1.35509C3.03019 1.53868 3.76289 1.99993 5 1.99993C5.76415 1.99993 6.10128 1.83134 6.53688 1.6135L6.55281 1.60553ZM3.00332 19L3 3.68371C3.54018 3.86577 4.20732 3.99993 5 3.99993C6.22656 3.99993 6.89059 3.67269 7.44719 3.39441L7.46312 3.38644C7.89872 3.1686 8.23585 3 9 3C9.76417 3 10.1013 3.16859 10.5369 3.38643L10.5528 3.39439C11.1094 3.67266 11.7734 3.9999 13 3.99993C13.7927 3.99996 14.4598 3.86581 15 3.68373V19C15 19.783 15.1678 20.448 15.4635 21H5C4.42498 21 4.0602 20.8591 3.82033 20.6992C3.57419 20.5351 3.39761 20.3092 3.26943 20.0528C3.13928 19.7925 3.06923 19.5201 3.03327 19.3044C3.01637 19.2029 3.00612 19.1024 3.00332 19ZM19.3044 20.9667C19.5201 20.9308 19.7925 20.8607 20.0528 20.7306C20.3092 20.6024 20.5351 20.4258 20.6992 20.1797C20.8591 19.9398 21 19.575 21 19V15.999C21 15.4474 20.5529 15 20 15H17L17 19C17 19.575 17.1409 19.9398 17.3008 20.1797C17.4649 20.4258 17.6908 20.6024 17.9472 20.7306C18.2075 20.8607 18.4799 20.9308 18.6957 20.9667C18.8012 20.9843 18.8869 20.9927 18.9423 20.9967C19.0629 21.0053 19.1857 20.9865 19.3044 20.9667Z" fill="#0F0F0F" />
                                                        <path d="M5 8C5 7.44772 5.44772 7 6 7H12C12.5523 7 13 7.44772 13 8C13 8.55229 12.5523 9 12 9H6C5.44772 9 5 8.55229 5 8Z" fill="#0F0F0F" />
                                                        <path d="M5 12C5 11.4477 5.44772 11 6 11H12C12.5523 11 13 11.4477 13 12C13 12.5523 12.5523 13 12 13H6C5.44772 13 5 12.5523 5 12Z" fill="#0F0F0F" />
                                                        <path d="M5 16C5 15.4477 5.44772 15 6 15H12C12.5523 15 13 15.4477 13 16C13 16.5523 12.5523 17 12 17H6C5.44772 17 5 16.5523 5 16Z" fill="#0F0F0F" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <a title="Show Work Order" href="{{ route('product-specification-show', $productSpecification->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <span class="svg-icon svg-icon-3">
                                                    <!-- Eye Icon -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="black" fill-rule="nonzero" opacity="0.7" />
                                                            <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="black" opacity="0.7" />
                                                        </g>
                                                    </svg>
                                                </span>
                                            </a>
                                            <!-- Edit Button -->
                                            <a title="Edit" href="{{ route('product-specification-edit', $productSpecification->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <span class="svg-icon svg-icon-3">
                                                    <!-- Edit Icon -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <!-- Delete Button -->

                                            <form action="{{ route('product-specification-destroy', $productSpecification->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button title="Delete" type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="return confirmDelete()">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        @else
                        <p>No results found.</p>
                        @endif
                        <!--end::Table-->
                    </div>

                    <!--end::Table container-->
                </div>
                <!--begin::Body-->

            </div>

            @include('components.pagination', ['paginator' => $productSpecifications])


            <!--End Table Pagination-->

        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete Product Specification?")) {
            document.getElementById('deleteForm').submit();
        }
        return false;
    }
</script>

<!-- End Tables-->

@endsection