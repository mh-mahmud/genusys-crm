@extends('layouts.master')
@php
    use Carbon\Carbon;
    $notShowTable = ["vehicle_attributes", "driver_attributes"]
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
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Lead Details
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Lead Details</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center py-1">

                @if($customer_id==null)
                    <a href="{{ route('add-customer', $lead->id) }}" class="btn btn-sm btn-danger"
                       id="kt_toolbar_primary_button">Add as Customer</a>
                @else
                    <span
                        style="border: 1px solid #14A44D;padding:6px;color:#FFF;background-color:#14A44D;border-radius:5px;">Customer ID: {{ $customer_id }}</span>
                @endif

                &nbsp;
                <a href="{{ route('lead-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Lead List</a>
                @if(!empty($customer_id))
                &nbsp;
                <a href="{{ route('customers') }}" class="btn btn-sm btn-warning">Customer List</a>
                @endif
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
    <div class="container-fluid container">
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


        <div class="modal fade" id="add_feedback_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog mw-600px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>


                    <!-- Modal Body -->
                    <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                        <form action="{{ url('/meeting-update-feedback/') }}" method="POST" name="star-rating-form">
                            @csrf <!-- Token for form security -->
                            <input type="hidden" name="form_meeting_feedback" value="1">

                            <!-- Feedback Textarea -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Feedback</label>
                                        <textarea class="form-control form-control-sm form-control-solid"
                                                  name="meeting_feedback" rows="2"></textarea>
                                        @if ($errors->has('meeting_feedback'))
                                            <span class="text-danger">{{ $errors->first('meeting_feedback') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Star Rating -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="fv-row mb-3">
                                        <h6 id="title" class="call-to-action-text">Select a rating:</h6>
                                        <div class="star-wrap">
                                            <!-- Skip Rating -->
                                            <input class="star" checked type="radio" value="" id="skip-star"
                                                   name="rating"/>
                                            <label class="star-label hidden"></label>

                                            <!-- Star Ratings -->
                                            <input class="star" type="radio" id="st-1" value="1" name="rating"/>
                                            <label class="star-label" for="st-1">
                                                <div class="star-shape"></div>
                                            </label>

                                            <input class="star" type="radio" id="st-2" value="2" name="rating"/>
                                            <label class="star-label" for="st-2">
                                                <div class="star-shape"></div>
                                            </label>

                                            <input class="star" type="radio" id="st-3" value="3" name="rating"/>
                                            <label class="star-label" for="st-3">
                                                <div class="star-shape"></div>
                                            </label>

                                            <input class="star" type="radio" id="st-4" value="4" name="rating"/>
                                            <label class="star-label" for="st-4">
                                                <div class="star-shape"></div>
                                            </label>

                                            <input class="star" type="radio" id="st-5" value="5" name="rating"/>
                                            <label class="star-label" for="st-5">
                                                <div class="star-shape"></div>
                                            </label>

                                            <!-- Skip Button for Removing Rating -->
                                            <!-- <label class="skip-button" for="skip-star">&times;</label> -->
                                        </div>
                                        <p id="result">Not chosen</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="card-footer d-flex justify-content-end py-0 px-0">
                                <a href="{{ route('meeting-index') }}" class="btn btn-light me-2 btn-sm">Back</a>
                                <button type="submit" class="btn btn-primary btn-sm" id="submit_button">Submit</button>
                            </div>
                        </form>
                    </div>


                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>


        @foreach ($productSpecifications as $productSpecification)
            <div class="modal fade" id="add_invoice_modal_{{ $productSpecification->id }}" tabindex="-1"
                 aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-xl">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header pb-0 border-0 justify-content-end">
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                            </div>
                        </div>
                        <!--end::Modal header-->

                        <!-- Modal Body -->
                        <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                            <div class="table-responsive">
                                @php
                                    $invoices_ps = $invoicesGroupedByPsId[$productSpecification->id] ?? collect([]);
                                @endphp
                                @if($invoices_ps->isNotEmpty())
                                    <table
                                        class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
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
                                        @foreach ($invoices_ps as $index => $invoice)
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
                                            <td class="text-dark fs-6">{{ $invoices_ps->sum('total_amount') }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-dark fs-6 text-center">
                                                {{ $invoices_ps->sum(function ($invoice) {return collect($invoice->payment_details)->sum('payment');}) }}
                                            </td>
                                            <td class="text-dark fs-6 text-center">
                                                {{ $invoices_ps->sum(function ($invoice) {return collect($invoice->payment_details)->last()['due'] ?? $invoice->total_amount;}) }}
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
            <div class="col-xxl-12 mx-auto">
                <!--**********************************
                                 Table Tabs
                     ***********************************-->
                <div class="card mt-2">
                    <div class="card-header">
                        <ul class="nav nav-tabs nav-stretch fs-6 border-0">
                            <li class="nav-item">
                                <a class="nav-link @if(session('success') || session('error')) @else active @endif"
                                   data-bs-toggle="tab" href="#g_lead_details" data-tab="g_lead_details"
                                   id="g_lead_details_tab"
                                   data-bs-target="#g_lead_details" role="tab" aria-controls="g_lead_details"
                                   aria-selected="true">Lead Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(session('success') || session('error')) active @endif"
                                   data-bs-toggle="tab" href="#g_lead_table" data-tab="g_lead_table"
                                   id="g_lead_table_tab"
                                   data-bs-target="#g_lead_table" role="tab" aria-controls="g_lead_table"
                                   aria-selected="true">Custom Data</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link "
                                   data-bs-toggle="tab" href="#g_RAKIB_lead_table2" data-tab="g_RAKIB_lead_table2"
                                   id="g_RAKIB_lead_table_tab2"
                                   data-bs-target="#g_RAKIB_lead_table2" role="tab" aria-controls="g_RAKIB_lead_table2"
                                   aria-selected="true">Notes/Reminders</a>
                            </li>

                            <!-- <li class="nav-item">
                                <a class="nav-link @if(session('success') || session('error'))
                                active


                            @endif"
                                   data-bs-toggle="tab" href="#g_lead_dashboard" data-tab="g_lead_dashboard"
                                   id="g_lead_dashboard_tab"
                                   data-bs-target="#g_lead_dashboard" role="tab" aria-controls="g_lead_dashboard"
                                   aria-selected="true">Dashboard</a>
                            </li> -->

                            @if(in_array("email_module", $menu_access))
                            <li class="nav-item">
                                <a class="nav-link {{ session('active_tab') === 'g_lead_dashboard_tab' ? 'active' : '' }}"
                                   data-bs-toggle="tab" href="#g_lead_dashboard" data-tab="g_lead_dashboard"
                                   id="g_lead_dashboard_tab"
                                   data-bs-target="#g_lead_dashboard" role="tab" aria-controls="g_lead_dashboard"
                                   aria-selected="true">Dashboard</a>
                            </li>
                            @endif

                            @if(in_array("email_module", $menu_access))
                            <li class="nav-item">
                                <a class="nav-link {{ session('active_tab') === 'g_lead_email_tab' ? 'active' : '' }}"
                                   data-bs-toggle="tab" href="#g_lead_email" data-tab="g_lead_email"
                                   id="g_lead_email_tab"
                                   data-bs-target="#g_lead_email" role="tab" aria-controls="g_lead_email"
                                   aria-selected="true">Email</a>
                            </li>
                            @endif

                            @if(in_array("sms_module", $menu_access))
                            <li class="nav-item">
                                <a class="nav-link {{ session('active_tab') === 'g_lead_sms_tab' ? 'active' : '' }}"
                                   data-bs-toggle="tab" href="#g_lead_sms" data-tab="g_lead_sms" id="g_lead_sms_tab"
                                   data-bs-target="#g_lead_sms" role="tab" aria-controls="g_lead_sms"
                                   aria-selected="true">SMS</a>
                            </li>
                            @endif

                            {{--@if(in_array("meeting", $menu_access))--}}
                            <li class="nav-item">
                                <a class="nav-link {{ session('active_tab') === 'g_lead_meeting_tab' ? 'active' : '' }}"
                                   data-bs-toggle="tab" href="#g_lead_meeting" data-tab="g_lead_meeting"
                                   id="g_lead_meeting_tab"
                                   data-bs-target="#g_lead_meeting" role="tab" aria-controls="g_lead_meeting"
                                   aria-selected="true">Meetings</a>
                            </li>
                            {{--@endif--}}

                            @if(in_array("proposal", $menu_access))
                            <li class="nav-item">
                                <a class="nav-link {{ session('active_tab') === 'g_lead_proposals_tab' ? 'active' : '' }}"
                                   data-bs-toggle="tab" href="#g_lead_proposals" data-tab="g_lead_proposals"
                                   id="g_lead_proposals_tab"
                                   data-bs-target="#g_lead_proposals" role="tab" aria-controls="g_lead_proposals"
                                   aria-selected="true">Proposals</a>
                            </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link {{ session('active_tab') === 'g_lead_products_tab' ? 'active' : '' }}"
                                   data-bs-toggle="tab" href="#g_lead_products" data-tab="g_lead_products"
                                   id="g_lead_products_tab"
                                   data-bs-target="#g_lead_products" role="tab" aria-controls="g_lead_products"
                                   aria-selected="true">Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ session('active_tab') === 'g_lead_invoice_tab' ? 'active' : '' }}"
                                   data-bs-toggle="tab" href="#g_lead_invoice" data-tab="g_lead_invoice"
                                   id="g_lead_invoice_tab"
                                   data-bs-target="#g_lead_invoice" role="tab" aria-controls="g_lead_invoice"
                                   aria-selected="true">Invoice</a>
                            </li>

                            @if(in_array("tickets", $menu_access))
                            <li class="nav-item">
                                <a class="nav-link {{ session('active_tab') === 'g_lead_tickets_tab' ? 'active' : '' }}"
                                   data-bs-toggle="tab" href="#g_lead_tickets" data-tab="g_lead_tickets"
                                   id="g_lead_tickets_tab"
                                   data-bs-target="#g_lead_tickets" role="tab" aria-controls="g_lead_tickets"
                                   aria-selected="true">Tickets</a>
                            </li>
                            @endif
                            
                            <li class="nav-item">
                                <a class="nav-link {{ session('active_tab') === 'g_lead_activity_log_tab' ? 'active' : '' }}"
                                   data-bs-toggle="tab" href="#g_lead_activity_log" data-tab="g_lead_activity_log"
                                   id="g_lead_activity_log_tab"
                                   data-bs-target="#g_lead_activity_log" role="tab" aria-controls="g_lead_activity_log"
                                   aria-selected="true">Activity Logs</a>
                            </li>


                        </ul>

                        @if(!empty($lead->profile_image))
                            <img class="py-1" height="50px" alt="Logo" src="{{ asset('uploads/leads/' . $lead->profile_image) }}"/>
                        @endif
                    </div>
                </div>
                {{--End Table Tabs--}}

                {{--Tab Content--}}
                <div class="tab-content" id="myTabContent">
                   
                    @include('leads.lead-details.contact-info')   
                    @include('leads.lead-details.custom-data')   
                    

                    <!-- Notes/Reminders -->
                    @include('leads.lead-details.notes')   

                    <!-- End notes or section -->

                    <!-- <div class="tab-pane fade show @if(session('success') || session('error'))
                        active
                    @endif"
                         id="g_lead_dashboard" role="tabpanel" aria-labelledby="g_lead_dashboard_tab"> -->
                    <div
                        class="tab-pane fade {{ session('active_tab') === 'g_lead_dashboard_tab' ? 'active show' : '' }}"
                        id="g_lead_dashboard" role="tabpanel" aria-labelledby="g_lead_dashboard_tab">
                        <div class="card">
                            <div class="card-body">

                                <div class="row g-5 g-xl-8">
                                    <div class="col-xl-3">
                                        <!--begin::Statistics Widget 5-->
                                        <div class="card bg-success  card-xl-stretch mb-xl-8">
                                            <!--begin::Body-->
                                            <div class="card-body">
                                                <div
                                                    class="text-white fw-bolder fs-2 mb-2 mt-5">{{$totalWorkOrderNumber}}</div>
                                                <div class="fw-bold text-white">
                                                    <a class="text-white">
                                                        Total Work Order
                                                    </a>
                                                </div>
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Statistics Widget 5-->
                                    </div>
                                    <div class="col-xl-3">
                                        <!--begin::Statistics Widget 5-->
                                        <div class="card bg-danger  card-xl-stretch mb-xl-8">
                                            <!--begin::Body-->
                                            <div class="card-body">
                                                <div
                                                    class="text-gray-100 fw-bolder fs-2 mb-2 mt-5">{{$totalWorkOrderValue}}</div>
                                                <div class="fw-bold text-gray-100">
                                                    <a class="text-white">
                                                        Total Work Order Value
                                                    </a>
                                                </div>
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Statistics Widget 5-->
                                    </div>
                                    <div class="col-xl-3">
                                        <!--begin::Statistics Widget 5-->
                                        <div class="card bg-warning card-xl-stretch mb-xl-8">
                                            <!--begin::Body-->
                                            <div class="card-body">
                                                <div
                                                    class="text-white fw-bolder fs-2 mb-2 mt-5">{{$totalAmcEffectiveAmount}}</div>
                                                <div class="fw-bold text-white">
                                                    <a class="text-white">
                                                        Total AMC Amount
                                                    </a>
                                                </div>
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Statistics Widget 5-->
                                    </div>
                                    <div class="col-xl-3">
                                        <!--begin::Statistics Widget 5-->
                                        <div class="card bg-info card-xl-stretch mb-5 mb-xl-8">
                                            <!--begin::Body-->
                                            <div class="card-body">
                                                <div
                                                    class="text-white fw-bolder fs-2 mb-2 mt-5">{{ $totalAmcRate ? number_format($totalAmcRate, 2) . '%' : '0%' }}</div>
                                                <div class="fw-bold text-white">
                                                    <a class="text-white">
                                                        Total AMC Rate
                                                    </a>
                                                </div>
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Statistics Widget 5-->
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Email section start --}}
                    @include('leads.lead-details.email')                     
                    {{-- Email section end --}}

                    {{-- SMS section start --}}
                    @include('leads.lead-details.sms')                                         
                    {{-- SMS section end --}}

                    {{-- Meeting section start --}}
                    @include('leads.lead-details.meeting')                                         
                    {{-- Meeting section end --}}

                    {{-- Proposal section start --}}
                    @include('leads.lead-details.proposal')                                                         
                    {{-- Proposal section end --}}

                    {{-- Product section start --}}
                    @include('leads.lead-details.products')   
                    {{-- Product section start --}}

                    {{-- Invoice section start --}}
                    @include('leads.lead-details.invoice')   
                    {{-- Invoice section end --}}

                    {{-- Ticket section start --}}
                    @include('leads.lead-details.ticket')   
                    {{-- Ticket section end --}}
                    
                    {{-- Activity log section start --}}
                    @include('leads.lead-details.activity-log')   
                    {{-- Activity log section end --}}


                </div>
                {{--End Tab Content--}}


            </div>
        </div>



        <!-- modal code add -->
        <div class="modal fade" id="showViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog mt-5" style="max-width: 85%; width: 100%; margin: auto;">
            <div class="modal-content">
            <div class="modal-header pb-0 border-0 justify-content-end">
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-xxl-12">
                <div id="modalContent">Loading...</div>
                </div>
             </div>
            </div>
            </div>
        </div>
        </div>


        <!-- end modal code -->
    </div>

    <!-- End Tables View-->


    <!-- </div> -->
    <!--end::Content-->

    <!--begin::Email drawer-->
    <div id="kt_activities" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities"
         data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
         data-kt-drawer-width="{default:'300px', 'lg': '50%'}" data-kt-drawer-direction="end"
         data-kt-drawer-toggle="#kt_activities_toggle" data-kt-drawer-close="#kt_activities_close">
        <div class="card shadow-none rounded-0 w-100">
            <!--begin::Header-->
            <div class="card-header" id="kt_activities_header">
                <h3 class="card-title fw-bolder text-dark">Send Email</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                            id="kt_activities_close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body position-relative" id="kt_activities_body">
                <!--begin::Content-->
                <div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="false"
                     data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body"
                     data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                     data-kt-scroll-offset="5px">
                    <!--begin::Timeline items-->
                    <!-- <div class="timeline"> -->

                    <!--begin::Tables Widget 9-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->

                        <!--end::Header-->
                        <div style="border:1px solid #ddd;padding:20px">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <form class="g-form w-100" action="{{ route('send-email-process') }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                        <input type="hidden" name="form_lead_panel" value="1">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">To<span
                                                            class="text-danger">*</span></label>
                                                    {{-- <input required
                                                           class="form-control form-control-sm form-control-solid"
                                                           type="text" id="to_email" name="to_email" autocomplete="off"
                                                           value="{{ $lead->email }}"/> --}}
                                                    <select class="form-control form-control-sm form-control-solid js-email-select select2-email"
                                                            name="to_email[]" id="to_email" multiple="multiple">
                                                        @if(old('to_email'))
                                                            @foreach(old('to_email') as $email)
                                                                <option value="{{ $email }}" selected>{{ $email }}</option>
                                                            @endforeach
                                                        @elseif(isset($lead) && $lead->email)
                                                            <option value="{{ $lead->email }}" selected>{{ $lead->email }}</option>
                                                        @endif
                                                    </select>
                                                    @if ($errors->has('to_email'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('to_email') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="fv-row mb-3">
                                                <label class="form-label fw-bolder text-dark">CC</label>
                                                {{-- <input class="form-control form-control-sm form-control-solid"
                                                       type="text" id="email_cc" name="email_cc" autocomplete="off"
                                                       value="{{ old('email_cc') }}"/> --}}
                                                <select class="form-control form-control-sm form-control-solid js-email-select select2-email"
                                                        name="email_cc[]" id="email_cc" multiple="multiple">
                                                    @if(old('email_cc'))
                                                        @foreach(old('email_cc') as $email)
                                                            <option value="{{ $email }}" selected>{{ $email }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-3">
                                                <label class="form-label fw-bolder text-dark">BCC</label>
                                                 <select class="form-control form-control-sm form-control-solid js-email-select select2-email"
                                                        name="email_bcc[]" id="email_bcc" multiple="multiple">
                                                    @if(old('email_bcc'))
                                                        @foreach(old('email_bcc') as $email)
                                                            <option value="{{ $email }}" selected>{{ $email }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Email Template</label>
                                                    <select class=" form-control form-control-sm form-control-solid"
                                                            id="template_id"
                                                            name="template_id"
                                                            aria-label="Default select example">
                                                        <option value=''>Select</option>
                                                        @foreach($templates as $template)
                                                            <option
                                                                value="{{$template->id}}" {{ old('template_id') == $template->id ? 'selected' : '' }}>{{ $template->email_subject }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Email Subject<span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           required type="text" id="email_subject" name="email_subject"
                                                           autocomplete="off"
                                                           value="{{ old('email_subject') }}"/>
                                                    @if ($errors->has('email_subject'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('email_subject') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Content<span
                                                            class="text-danger">*</span></label>
                                                    <textarea
                                                        class="form-control form-control-sm required form-control-solid editor"
                                                        id="email_content" name="email_content"
                                                        rows="3">{{ old('email_content') }}</textarea>
                                                    @if ($errors->has('email_content'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('email_content') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!--End Row-->
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <button type="submit" class="btn btn-primary"
                                                    id="">Send
                                            </button>
                                        </div>

                                    </form>
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
    <!--end::Activities drawer-->

    <!--begin::SMS activities drawer-->
    <div id="kt_activities_2" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities"
         data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
         data-kt-drawer-width="{default:'300px', 'lg': '50%'}" data-kt-drawer-direction="end"
         data-kt-drawer-toggle="#kt_activities_toggle_2" data-kt-drawer-close="#kt_activities_close">
        <div class="card shadow-none rounded-0 w-100">
            <!--begin::Header-->
            <div class="card-header" id="kt_activities_header">
                <h3 class="card-title fw-bolder text-dark">Send SMS</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                            id="kt_activities_close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body position-relative" id="kt_activities_body">
                <!--begin::Content-->
                <div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="false"
                     data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body"
                     data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                     data-kt-scroll-offset="5px">
                    <!--begin::Timeline items-->
                    <!-- <div class="timeline"> -->

                    <!--begin::Tables Widget 9-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->

                        <!--end::Header-->
                        <div style="border:1px solid #ddd;padding:20px">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <form class="g-form w-100" action="{{ route('send-sms-pro') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                        <input type="hidden" name="form_lead_panel" value="1">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Mobile No.<span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="sms_to" id="sms_to" autocomplete="off"
                                                           value="{{ $lead->phone }}"/>
                                                    @if ($errors->has('sms_to'))
                                                        <span class="text-danger">{{ $errors->first('sms_to') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">SMS Template</label>
                                                    <select class=" form-control form-control-sm form-control-solid" name="template_id" id="sms_template_id" aria-label="Default select example">
                                                        <option value=''>Select</option>
                                                        @foreach($sms_templates as $template)
                                                            <option value="{{$template->id}}" {{ old('template_id') == $template->id ? 'selected' : '' }}>{{ $template->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Content<span class="text-danger">*</span></label>
                                                    <textarea required
                                                              class="form-control form-control-sm  form-control-solid"
                                                              name="sms_text" id="sms_text"
                                                              rows="5">{{ old('sms_text') }}</textarea>
                                                    @if ($errors->has('sms_text'))
                                                        <span class="text-danger">{{ $errors->first('sms_text') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                        <!--End Row-->
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <button type="submit" class="btn btn-primary" id="">Save Changes</button>
                                        </div>

                                    </form>
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
    <!--end::SMS activities drawer-->

    <!--begin::Meeting activities drawer-->
    <div id="kt_activities_3" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities"
         data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
         data-kt-drawer-width="{default:'300px', 'lg': '50%'}" data-kt-drawer-direction="end"
         data-kt-drawer-toggle="#kt_activities_toggle_3" data-kt-drawer-close="#kt_activities_close">
        <div class="card shadow-none rounded-0 w-100">
            <!--begin::Header-->
            <div class="card-header" id="kt_activities_header">
                <h3 class="card-title fw-bolder text-dark">Create Meeting</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                            id="kt_activities_close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body position-relative" id="kt_activities_body">
                <!--begin::Content-->
                <div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="false"
                     data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body"
                     data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                     data-kt-scroll-offset="5px">
                    <!--begin::Timeline items-->
                    <!-- <div class="timeline"> -->

                    <!--begin::Tables Widget 9-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->

                        <!--end::Header-->
                        <div style="border:1px solid #ddd;padding:20px">
                            <div class="row">
                                <div class="col-md-12 mx-auto">

                                    <form class="g-form w-100" action="{{ route('meeting-store') }}"
                                          enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                        <input type="hidden" name="form_lead_panel" value="1">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Select Lead</label>
                                                    <select class=" form-control form-control-sm form-control-solid"
                                                            name="recipients" aria-label="Default select example">
                                                        <option value="{{$lead->id}}">
                                                            @if($lead->first_name || $lead->last_name || $lead->email)
                                                                {{ trim(($lead->first_name ?? '') . ' ' . ($lead->last_name ?? '') .
                                                                ($lead->email ? ' <' . $lead->email . '>' : '')) }}
                                                            @endif
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Meeting
                                                        Subject</label>
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           required type="text" name="meeting_subject"
                                                           value="{{ old('meeting_subject') }}" autocomplete="off"/>
                                                    @if ($errors->has('meeting_subject'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('meeting_subject') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Meeting Date</label>
                                                    <input type="text"
                                                           class="form-control form-control-sm form-control-solid flatpickr"
                                                           required name="meeting_date"
                                                           value="{{ old('meeting_date') }}"/>
                                                    @if ($errors->has('meeting_date'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('meeting_date') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Meeting
                                                        Description</label>
                                                    <textarea class="form-control form-control-sm form-control-solid"
                                                              name="meeting_description"
                                                              rows="2">{{ old('meeting_description') }}</textarea>
                                                    @if ($errors->has('meeting_description'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('meeting_description') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Meeting Link</label>
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="url" name="meeting_link"
                                                           value="{{ old('meeting_link') }}" autocomplete="off"/>
                                                    @if ($errors->has('meeting_link'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('meeting_link') }}</span>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Duration</label>
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="duration" value="{{ old('duration') }}"
                                                           autocomplete="off"/>
                                                    @if ($errors->has('duration'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('duration') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Attachments</label>
                                                    <input type="file"
                                                           class="form-control form-control-sm form-control-solid"
                                                           name="attachments"/>
                                                    @if ($errors->has('attachments'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('attachments') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Status</label>
                                                    <select class=" form-control form-control-sm form-control-solid"
                                                            name="status"
                                                            aria-label="Default select example">

                                                        <option
                                                            value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                                                            Active
                                                        </option>
                                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                            Inactive
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="fv-row mt-10 form-check form-check-custom form-check-sm">
                                                    <input class="form-check-input form-check-sm" type="checkbox"
                                                           name="send_email" id="sendEmail"
                                                           value="1" {{ old('send_email') ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bolder text-dark" for="sendEmail">
                                                        Send Email
                                                    </label>
                                                </div>

                                            </div>

                                            <div class="col-md-2">
                                                <div class="fv-row mt-10 form-check form-check-custom form-check-sm">
                                                    <input class="form-check-input" type="checkbox" name="send_sms"
                                                           id="sendSMS"
                                                           value="1" {{ old('send_sms') ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bolder text-dark" for="sendSMS">
                                                        Send SMS
                                                    </label>
                                                </div>
                                            </div>


                                        </div>
                                        <!--End Row-->
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <button type="submit" class="btn btn-primary"
                                                    id="">Save Changes
                                            </button>
                                        </div>
                                    </form>

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
    <!--end::Meeting activities drawer-->



    <!--begin::Product activities drawer-->
    <div id="kt_activities_6" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities"
         data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
         data-kt-drawer-width="{default:'300px', 'lg': '50%'}" data-kt-drawer-direction="end"
         data-kt-drawer-toggle="#kt_activities_toggle_6" data-kt-drawer-close="#kt_activities_close">
        <div class="card shadow-none rounded-0 w-100">
            <!--begin::Header-->
            <div class="card-header" id="kt_activities_header">
                <h3 class="card-title fw-bolder text-dark">Add Product</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                            id="kt_activities_close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body position-relative" id="kt_activities_body">
                <!--begin::Content-->
                <div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="false"
                     data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body"
                     data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                     data-kt-scroll-offset="5px">
                    <!--begin::Timeline items-->
                    <!-- <div class="timeline"> -->

                    <!--begin::Tables Widget 9-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->

                        <!--end::Header-->
                        <div style="border:1px solid #ddd;padding:20px">
                            <div class="row">
                                <div class="col-md-12 mx-auto">

                                    <form class="g-form w-100" action="{{ route('meeting-store') }}"
                                          enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                        <input type="hidden" name="form_lead_panel" value="1">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Select Lead</label>
                                                    <select class=" form-control form-control-sm form-control-solid"
                                                            name="recipients" aria-label="Default select example">
                                                        <option value="{{$lead->id}}">
                                                            @if($lead->first_name || $lead->last_name || $lead->email)
                                                                {{ trim(($lead->first_name ?? '') . ' ' . ($lead->last_name ?? '') .
                                                                ($lead->email ? ' <' . $lead->email . '>' : '')) }}
                                                            @endif
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Meeting
                                                        Subject</label>
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           required type="text" name="meeting_subject"
                                                           value="{{ old('meeting_subject') }}" autocomplete="off"/>
                                                    @if ($errors->has('meeting_subject'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('meeting_subject') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Meeting Date</label>
                                                    <input type="text"
                                                           class="form-control form-control-sm form-control-solid flatpickr"
                                                           required name="meeting_date"
                                                           value="{{ old('meeting_date') }}"/>
                                                    @if ($errors->has('meeting_date'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('meeting_date') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Meeting
                                                        Description</label>
                                                    <textarea class="form-control form-control-sm form-control-solid"
                                                              name="meeting_description"
                                                              rows="2">{{ old('meeting_description') }}</textarea>
                                                    @if ($errors->has('meeting_description'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('meeting_description') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Meeting Link</label>
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="url" name="meeting_link"
                                                           value="{{ old('meeting_link') }}" autocomplete="off"/>
                                                    @if ($errors->has('meeting_link'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('meeting_link') }}</span>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Duration</label>
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="duration" value="{{ old('duration') }}"
                                                           autocomplete="off"/>
                                                    @if ($errors->has('duration'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('duration') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Attachments</label>
                                                    <input type="file"
                                                           class="form-control form-control-sm form-control-solid"
                                                           name="attachments"/>
                                                    @if ($errors->has('attachments'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('attachments') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Status</label>
                                                    <select class=" form-control form-control-sm form-control-solid"
                                                            name="status"
                                                            aria-label="Default select example">

                                                        <option
                                                            value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                                                            Active
                                                        </option>
                                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                            Inactive
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="fv-row mt-10 form-check form-check-custom form-check-sm">
                                                    <input class="form-check-input form-check-sm" type="checkbox"
                                                           name="send_email" id="sendEmail"
                                                           value="1" {{ old('send_email') ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bolder text-dark" for="sendEmail">
                                                        Send Email
                                                    </label>
                                                </div>

                                            </div>

                                            <div class="col-md-2">
                                                <div class="fv-row mt-10 form-check form-check-custom form-check-sm">
                                                    <input class="form-check-input" type="checkbox" name="send_sms"
                                                           id="sendSMS"
                                                           value="1" {{ old('send_sms') ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bolder text-dark" for="sendSMS">
                                                        Send SMS
                                                    </label>
                                                </div>
                                            </div>


                                        </div>
                                        <!--End Row-->
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <button type="submit" class="btn btn-primary"
                                                    id="">Save Changes
                                            </button>
                                        </div>
                                    </form>

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
    <!--end::Product activities drawer-->



    <!--begin::Proposal drawer-->
    <div id="kt_activities_4" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities"
         data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
         data-kt-drawer-width="{default:'300px', 'lg': '70%'}" data-kt-drawer-direction="end"
         data-kt-drawer-toggle="#kt_activities_toggle_4" data-kt-drawer-close="#kt_activities_close">
        <div class="card shadow-none rounded-0 w-100">
            <!--begin::Header-->
            <div class="card-header" id="kt_activities_header">
                <h3 class="card-title fw-bolder text-dark">Send Proposal</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                            id="kt_activities_close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body position-relative" id="kt_activities_body">
                <!--begin::Content-->
                <div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="false"
                     data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body"
                     data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                     data-kt-scroll-offset="5px">
                    <!--begin::Timeline items-->
                    <!-- <div class="timeline"> -->

                    <!--begin::Tables Widget 9-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->

                        <!--end::Header-->
                        <div style="border:1px solid #ddd;padding:20px">
                            <div class="row">
                                <div class="col-md-12 mx-auto">

                                    <form class="g-form g-proposal w-100" action="{{ route('store-proposal') }}"
                                          enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="row">
                                            <!--Left Part-->
                                            <div class="col-xl-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="fv-row mb-5">
                                                            <!--begin::Label-->
                                                            <label class="form-label fw-bolder text-dark">Subject<span
                                                                    class="text-danger">*</span></label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid"
                                                                type="text" required name="subject"
                                                                value="{{ old('subject') }}"/>
                                                            @if ($errors->has('subject'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('subject') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="fv-row mb-5">
                                                            <label class="form-label fw-bolder text-dark">Lead ID<span
                                                                    class="text-danger">*</span>
                                                            </label>
                                                            <select name="lead_id"
                                                                    class=" form-control form-control-sm form-control-solid"
                                                                    required aria-label="Default select example">
                                                                <option
                                                                    value="{{ $lead->id }}">{{ $lead->first_name . " " . $lead->last_name }}</option>
                                                            </select>
                                                            @if ($errors->has('lead_id'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('lead_id') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="fv-row mb-5">
                                                            <label class="form-label fw-bolder text-dark">Company
                                                                Name</label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid"
                                                                type="text" name="company_name"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="fv-row mb-5">
                                                            <label class="form-label fw-bolder text-dark">Date<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="position-relative">
                                                                <input type="text"
                                                                       class="form-control form-control-sm form-control-solid flatpickr date"
                                                                       required placeholder="Date" name="start_date"
                                                                       value="{{ old('start_date') }}">
                                                                @if ($errors->has('start_date'))
                                                                    <span
                                                                        class="text-danger">{{ $errors->first('start_date') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">

                                                        <div class="fv-row mb-5">
                                                            <label class="form-label fw-bolder text-dark">Open Till<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="position-relative">
                                                                <input type="text"
                                                                       class="form-control form-control-sm form-control-solid flatpickr date"
                                                                       required placeholder="Open Till" name="end_date"
                                                                       value="{{ old('end_date') }}">
                                                                @if ($errors->has('end_date'))
                                                                    <span
                                                                        class="text-danger">{{ $errors->first('end_date') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>

                                                    
                                                    <div class="col-md-12">
                                                        <div class="fv-row mb-5">
                                                            <label class="form-label fw-bolder text-dark">Currency<span class="text-danger">*</span></label>
                                                            <select class=" form-control form-control-sm form-control-solid" required id="currency" name="currency"
                                                                    aria-label="Default select example">
                                                                <option value="BDT">BDT</option>
                                                                {{--
                                                                @foreach($currencies as $currency)
                                                                <option value="{{$currency->name}}" {{ old("currency") == $currency->name ? "selected" : "" }}>
                                                                    {{ $currency->name }}
                                                                </option>
                                                                @endforeach
                                                                --}}
                                                            </select>
                                                            @if ($errors->has('currency'))
                                                                <span class="text-danger">{{ $errors->first('currency') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    

                                                    <div class="col-md-12">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label  fw-bolder text-dark">Upload PDF,
                                                                xcel or Word</label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid"
                                                                required accept=".csv,.xls,.xlsx,.docx,.pdf" type="file"
                                                                name="upload_file"/>
                                                            @if ($errors->has('upload_file'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('upload_file') }}</span>
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
                                                            <label class="form-label fw-bolder text-dark">Status<span
                                                                    class="text-danger">*</span></label>
                                                            <select
                                                                class=" form-control form-control-sm form-control-solid"
                                                                required id="status" name="status"
                                                                aria-label="Default select example">
                                                                <option value=''>Select</option>
                                                                @foreach(config('constants.proposal_status') as $key => $status)
                                                                    <option
                                                                        value="{{$status}}" {{ old('status') == $key ? 'selected' : '' }}>{{ $status }} </option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('status'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('status') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="fv-row mb-5">
                                                            <label class="form-label fw-bolder text-dark">First
                                                                Name</label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid"
                                                                type="text" name="first_name"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="fv-row mb-5">
                                                            <label class="form-label fw-bolder text-dark">Email To<span
                                                                    class="text-danger">*</span></label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid"
                                                                required type="email" id="send_to" name="send_to"
                                                                value="{{ old('send_to') }}"/>
                                                            @if ($errors->has('send_to'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('send_to') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="fv-row mb-5">
                                                            <label class="form-label fw-bolder text-dark"
                                                                   for="textarea">Address</label>
                                                            <textarea
                                                                class="form-control form-control-sm  form-control-solid"
                                                                id="address" name="address"
                                                                rows="3">{{ old('address') }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="fv-row mb-5">
                                                            <!--begin::Label-->
                                                            <label class="form-label fw-bolder text-dark">City</label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid"
                                                                type="text" id="city" name="city"
                                                                value="{{ old('city') }}"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="fv-row mb-5">
                                                            <label class="form-label fw-bolder text-dark">State</label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid"
                                                                type="text" id="state" name="state"
                                                                value="{{ old('state') }}"/>
                                                        </div>
                                                    </div>

                                                    {{--
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
                                                    --}}

                                                    <div class="col-md-6">
                                                        <div class="fv-row mb-5">
                                                            <label class="form-label fw-bolder text-dark">Zip
                                                                Code</label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid"
                                                                type="text" id="zip_code" name="zip_code"
                                                                value="{{ old('zip_code') }}"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label fw-bolder text-dark">Phone</label>
                                                            <input
                                                                class="form-control form-control-sm form-control-solid"
                                                                type="text" id="phone" name="phone"
                                                                value="{{ old('phone') }}"/>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>


                                        </div>
                                        <!--End Row-->

                                        <div class="mt-2 overflow-hidden">

                                            <div class="card">
                                                <div class="card-header">
                                                    <div
                                                        class="g-proposal-add-item d-flex flex-wrap justify-content-between align-items-center w-100 gap-3">


                                                    </div>
                                                </div>


                                                <div class="table-responsive">
                                                    <!--Proposal Table Preview-->
                                                    <table
                                                        class="table table-rounded table-sm table-striped border align-middle gs-2">
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
                                                                <textarea
                                                                    class="form-control form-control-sm min-w-250px"
                                                                    required name="item_name" cols="30" rows="2"
                                                                    placeholder=""></textarea>
                                                                @if ($errors->has('item_name'))
                                                                    <span
                                                                        class="text-danger">{{ $errors->first('item_name') }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <textarea
                                                                    class="form-control form-select-sm min-w-250px"
                                                                    required name="item_description" cols="30" rows="2"
                                                                    placeholder="Long Description"></textarea>
                                                                @if ($errors->has('item_description'))
                                                                    <span
                                                                        class="text-danger">{{ $errors->first('item_description') }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <input id="price" class="form-control form-control-sm"
                                                                       required type="number" name="price">
                                                                @if ($errors->has('price'))
                                                                    <span
                                                                        class="text-danger">{{ $errors->first('price') }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <input id="offer_price"
                                                                       class="form-control form-control-sm" required
                                                                       type="number" name="offer_price">
                                                                @if ($errors->has('offer_price'))
                                                                    <span
                                                                        class="text-danger">{{ $errors->first('offer_price') }}</span>
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
                                                            <table
                                                                class="table table-sm table-row-bordered align-middle">
                                                                <tr>
                                                                    <th class="text-end"><strong>Sub Total:</strong>
                                                                    </th>
                                                                    <td class="text-end"><b><span
                                                                                class="cur-data">BDT</span></b> <span
                                                                            id="sub_total">0</span></td>
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
                                                                                <input id="tax_amount"
                                                                                       class="form-control form-control-sm rounded-end-0 border-end"
                                                                                       type="text" name="tax_percent">
                                                                            </div>
                                                                            <select
                                                                                class="form-select form-select-sm form-control-sm"
                                                                                name="tax_type" id="tax_type"
                                                                                style="width:40%">
                                                                                <!-- <option value="fixed">Fixed Amount</option> -->
                                                                                <option value="percentage">%</option>
                                                                            </select>
                                                                        </div>
                                                                    </th>
                                                                    <td class="text-end"><b><span
                                                                                class="cur-data">BDT</span></b> <span
                                                                            id="tax_field">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th><strong>Discount :</strong>
                                                                        <input id="discount" disabled
                                                                               class="form-control form-control-sm"
                                                                               type="text" name="discount">
                                                                    </th>
                                                                    <td class="text-end"><b><span
                                                                                class="cur-data">BDT</span></b> <span
                                                                            id="discount_right">0</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-end"><strong>Total with
                                                                            Tax: </strong></th>
                                                                    <td class="text-end">
                                                                        <b><span class="cur-data">BDT</span></b> <span
                                                                            id="total_amount_final">0</span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <!--End Proposal Calculations-->
                                                    </div>
                                                </div>


                                                <!--begin::Actions-->
                                                <div class="card-footer d-flex justify-content-end py-4 pe-0">
                                                    <button type="submit" class="btn btn-primary" id="">Submit</button>
                                                </div>
                                                <!--end::Actions-->
                                            </div>

                                        </div>

                                    </form>

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
    <!--end::Proposal drawer-->

    <!--Begin::Product drawer-->
    <div id="kt_activities_5" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities"
         data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
         data-kt-drawer-width="{default:'300px', 'lg': '70%'}" data-kt-drawer-direction="end"
         data-kt-drawer-toggle="#kt_activities_toggle_5" data-kt-drawer-close="#kt_activities_close">
        <div class="card shadow-none rounded-0 w-100">
            <!--begin::Header-->
            <div class="card-header" id="kt_activities_header">
                <h3 class="card-title fw-bolder text-dark">Create Product Specification</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                            id="kt_activities_close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body position-relative" id="kt_activities_body">
                <!--begin::Content-->
                <div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="false"
                     data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body"
                     data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                     data-kt-scroll-offset="5px">
                    <!--begin::Timeline items-->
                    <!-- <div class="timeline"> -->

                    <!--begin::Tables Widget 9-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->

                        <!--end::Header-->
                        <div style="border:1px solid #ddd;padding:20px">
                            <div class="row">
                                <div class="col-md-12 mx-auto">

                                    <form class="g-form w-100" action="{{ route('product-specification-store') }}"
                                          enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <input type="hidden" name="form_ps_panel" value="1">
                                        <div class="row">


                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Product Name<span class="text-danger">*</span></label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" name="name" autocomplete="off" value="{{ old('name') }}" />
                                                    @if ($errors->has('name'))
                                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Product Code (sku)<span class="text-danger">*</span></label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" name="product_code" autocomplete="off" value="{{ old('product_code') }}" />
                                                    @if ($errors->has('product_code'))
                                                        <span class="text-danger">{{ $errors->first('product_code') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Product Type<span class="text-danger">*</span></label>
                                                    <select class="form-control form-control-sm form-control-solid"
                                                            id="assigned_to" name="product_type" aria-label="Default select example">
                                                        <option value='' {{ old('product_type', '') === '' ? 'selected' : '' }}>Select</option>
                                                        @foreach (config('constants.PRODUCT_TYPE') as $key => $type)
                                                            <option value="{{ $key }}" {{ old('product_type') === (string)$key ? 'selected' : '' }}>
                                                                {{ $type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('product_type'))
                                                        <span class="text-danger">{{ $errors->first('product_type') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Purchase Rate</label>
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="product_cost" autocomplete="off" value="{{ old('product_cost') }}" />
                                                    @if ($errors->has('product_cost'))
                                                        <span class="text-danger">{{ $errors->first('product_cost') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Sale Price</label>
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="product_value" autocomplete="off" value="{{ old('product_value') }}" />
                                                    @if ($errors->has('product_value'))
                                                        <span class="text-danger">{{ $errors->first('product_value') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Description</label>
                                                    <textarea class="form-control form-control-sm  form-control-solid" name="description" rows="3">{{ old('description') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Image</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="file" name="img_path" autocomplete="off" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Status</label>
                                                    <select class=" form-control form-control-sm form-control-solid" name="status" aria-label="Default select example">
                                                        <option value="1" selected>Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Product Template</label>
                                                    <select id="product-template" class=" form-control form-control-sm form-control-solid" name="template_name" aria-label="Default select example">
                                                    <option value="">-- select custom fields --</option>
                                                    @foreach ($templates as $key => $val)
                                                        <option value="{{ $val->template_id }}" {{ old('template_name') === $val->name ? 'selected' : '' }}>{{ $val->name }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="card-footer d-flex justify-content-end py-6 px-9">

                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>

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
    <!--End::Product drawer-->

@endsection

@section('endScript')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            //alert('sdsds');
            //active tab from local storage
            const activeTab = localStorage.getItem('activeTab');

            if (activeTab) {
                // activate the stored tab
                const tabElement = document.querySelector(`a[data-tab="${activeTab}"]`);
                if (tabElement) {
                    new bootstrap.Tab(tabElement).show();
                }
            }

            // add event to save the active tab
            document.querySelectorAll('.nav-link').forEach(tab => {
                //alert('sdsds');
                tab.addEventListener('click', function () {
                    const selectedTab = this.getAttribute('data-tab');
                    localStorage.setItem('activeTab', selectedTab);
                });
            });

            // Loading email template content
            const templates = @json($templates);
            document.getElementById('template_id').addEventListener('change', function () {
                const selectedId = this.value;
                const selectedTemplate = templates.find(template => template.id == selectedId);
                if (selectedTemplate) {
                    // document.getElementById('email_subject').value = selectedTemplate.email_subject;
                    $('.editor').summernote('code', selectedTemplate.email_content);

                } else {
                    // document.getElementById('email_subject').value = '';
                    $('.editor').summernote('code', '');

                }
            });

            // Loading sms template content
            const sms_templates = @json($sms_templates);
            document.getElementById('sms_template_id').addEventListener('change', function() {

                const sms_selectedId = this.value;

                const selectedTemplate = sms_templates.find(template => template.id == sms_selectedId);
                if (selectedTemplate) {
                    document.getElementById('sms_text').innerText = selectedTemplate.description;
                } else {
                    document.getElementById('sms_text').innerText = '';
                }
            });

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('[name="meeting_date"]').flatpickr({
                enableTime: true,  //time picker
                dateFormat: "Y-m-d H:i",//date format
                time_24hr: true,  // 24 hour time format
                onOpen: function (selectedDates, dateStr, instance) {
                    if (!dateStr) { //set current date if no date selected
                        instance.setDate(new Date());  //set current date and time when opened
                    }
                }
            });
        });
    </script>


    <script>
        function displayValue() {
            starVal = document.forms["star-rating-form"]["rating"].value;
            if (starVal == '') {
                document.getElementById("result").innerText = "Not Chosen";
            } else {
                document.getElementById("result").innerText =
                    "You chose: " + starVal +
                    " out of 5.";
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            displayValue();
            document.forms["star-rating-form"]["rating"].forEach((star) => {
                star.addEventListener("change", () => {
                    displayValue();
                });
            });
        });
    </script>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- <script src="{{url('/')}}/assets/js/jquery-3.6.0.min.js"></script> -->
    <script>
        $(document).ready(function () {
            //Trigger modal and load data
            $('a[data-bs-target="#add_feedback_modal"]').on('click', function () {
                let meetingId = $(this).data('id');
                //Set the form action dynamically with meeting ID using route
                let formAction = "{{ route('meeting-update-feedback', ':id') }}"; // ':id' is a placeholder
                formAction = formAction.replace(':id', meetingId); // Replace ':id' with actual meetingId
                $('form[name="star-rating-form"]').attr('action', formAction);
                //Make an AJAX call to fetch the meeting data
                let fetchUrl = "{{ route('meeting-feedback', ':id') }}"; // Define the route for fetching data
                fetchUrl = fetchUrl.replace(':id', meetingId); // Replace ':id' with actual meetingId
                $.ajax({
                    url: fetchUrl,
                    type: 'GET',
                    success: function (data) {
                        //Populate the modal fields with AJAX response
                        $('textarea[name="meeting_feedback"]').val(data.meeting_feedback);
                        //Update the rating value in the modal
                        $('input[name="rating"]').prop('checked', false); // Uncheck all ratings first
                        if (data.rating) {
                            $('input[name="rating"][value="' + data.rating + '"]').prop('checked', true);
                        } else {
                            $('#skip-star').prop('checked', true); // Select skip if no rating
                        }
                    }
                });
            });
            $('.select2-email').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: "Enter email addresses",
                width: '100%'
            });

        });
    </script>


    <script>

        $('#tblPS').find('tr').find('td:first').each(function (){
            let id = $(this).attr('id');
            $('#product-select-ps-edit-'+id).select2({
                placeholder: "Select Products",
                allowClear: true,
            });
        })

        $('#product-select').select2({
            placeholder: "Select Products",
            allowClear: true,
        });

        $('#product-select-ps').select2({
            placeholder: "Select Products",
            allowClear: true,
        });
</script>

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

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn-show-details").forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            const url = this.getAttribute("href");

            // load data via AJAX
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById("modalContent").innerHTML = html;
                    // show modal after loading content
                    new bootstrap.Modal(document.getElementById("showViewModal")).show();
                })
                .catch(err => {
                    document.getElementById("modalContent").innerHTML = "<p class='text-danger'>Error loading data.</p>";
                });
        });
    });
});
</script>


@endsection
