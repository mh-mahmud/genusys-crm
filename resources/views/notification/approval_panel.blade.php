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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Invoice
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Invoice List</small>
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
            <a href="{{ route('invoice-create') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Create</a>

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


    <div class="row">
        <div class="col-xxl-12">
            <!-- <div class="card mb-1"> -->
            <div class="card mt-4">
                <!--begin::Header-->
                <div class="d-flex justify-content-between align-items-start card-header border-0 p-1">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Invoice List</span>
                        <!-- <span class="text-muted mt-1 fw-bold fs-7">Agent data here</span> -->
                    </h3>

                    <div class="d-flex flex-wrap gap-2">
                        <form action="{{ route('invoice-search') }}" method="POST" class="d-flex">
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
                                    value="{{ request('search') }}" placeholder="Search by Invoice No or Date">
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
                        @if($invoices->isNotEmpty())
                        <!--begin::Table-->
                        <table
                            class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                            <!--begin::Table head-->
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
                                    <th class="min-w-140px text-center">Approval Status</th>
                                    <th class="min-w-100px text-end text-end-new">Actions</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach ($invoices as $invoice)
                                <tr>

                                    <td class="ps-5 text-dark fs-6">{{($invoices->currentPage() - 1) * $invoices->perPage() + $loop->iteration}}</td>
                                    <td class="text-dark fs-6">{{$invoice->invoice_number}}</td>
                                    <td class="text-dark fs-6 w-100px">{{$invoice->total_amount}}</td>
                                    <td class="text-dark fs-6 w-200px">{{$invoice->total_tax }}</td>
                                    <td class="text-dark fs-6 w-200px">{{ $invoice->discount ?? '0.00' }}</td>
                                    <td class="text-dark fs-6 w-200px">
                                        @if($invoice->invoice_date)
                                        {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}
                                        @endif
                                    </td>
                                    <td class="text-dark fs-6 w-200px">{{$invoice->first_name}} {{$invoice->last_name}}</td>
                                    <td class="text-dark fs-6 w-200px">
                                        @if($invoice->due_date)
                                        {{ \Carbon\Carbon::parse($invoice->due_date)->format('d-m-Y') }}
                                        @endif
                                    </td>

                                    @php

                                    $paymentDetails = collect($invoice->payment_details);
                                    $totalPayments = $paymentDetails->sum('payment');

                                    $lastPayment = $paymentDetails->last();
                                    $paymentAmount = $lastPayment['payment'] ?? '0.00';
                                    $dueAmount = $lastPayment['due'] ?? $invoice->total_amount;

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



                                        <td>
                                            <span class="badge {{ $statusClass }}">{{ $status }}</span>
                                        </td>

                                        <!-- Display Payment and Due from payment_details -->


                                        <td class="text-dark fs-6 w-200px text-center">{{ $totalPayments}}</td>
                                        <td class="text-dark fs-6 w-200px text-center">{{ $dueAmount }}</td>
                                       
                                        <td>
                                            <span class="badge {{ $invoice->approval_status == 'approved' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst($invoice->approval_status) }}
                                            </span>
                                        </td>
                                     

                                        <td>
                                            <div
                                                class="d-inline-flex justify-content-center gap-1 w-100 border-bottom-0">
                                                <!-- Approval Button -->
                                               
                                                <form action="{{ route('invoice-approve', $invoice->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Do you want to approve this Invoice?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-success btn-sm me-1" title="Approve Invoice" {{ $invoice->approval_status === 'approved' ? 'disabled' : '' }}>
                                                        <span class="svg-icon svg-icon-2x">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3"
                                                                    d="M12 22C17.5229 22 22 17.5229 22 12C22 6.47715 17.5229 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5229 6.47715 22 12 22Z"
                                                                    fill="black" />
                                                                <path
                                                                    d="M10.0004 14.0002L7.50037 11.5002L6.08594 12.9146L10.0004 16.829L18.0004 8.82898L16.586 7.41455L10.0004 14.0002Z"
                                                                    fill="black" />
                                                            </svg>
                                                        </span>
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

            @include('components.pagination', ['paginator' => $invoices])


            <!--End Table Pagination-->

        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete Invoice?")) {
            document.getElementById('deleteForm').submit();
        }
        return false;
    }
</script>

<!-- End Tables-->

@endsection