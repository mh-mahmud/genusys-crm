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

                            @if(in_array("meeting", $menu_access))
                            <li class="nav-item">
                                <a class="nav-link {{ session('active_tab') === 'g_lead_meeting_tab' ? 'active' : '' }}"
                                   data-bs-toggle="tab" href="#g_lead_meeting" data-tab="g_lead_meeting"
                                   id="g_lead_meeting_tab"
                                   data-bs-target="#g_lead_meeting" role="tab" aria-controls="g_lead_meeting"
                                   aria-selected="true">Meetings</a>
                            </li>
                            @endif

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
                    <div class="tab-pane fade show @if(session('success') || session('error')) @else active @endif"
                         id="g_lead_details" role="tabpanel" aria-labelledby="g_lead_details_tab">
                        <div class="card" style="margin-top:0px;padding:20px;">

                            <div class="card-header bg-light bd-cyan align-items-center">
                                <div class="card-title">
                                    <h4>Client Contact Information</h4>
                                </div>
                                <a href="{{ route('lead-edit', $lead_data_id) }}" class="btn btn-sm btn-success"
                                   id="kt_toolbar_primary_button">

							<span class="svg-icon svg-icon-3 me-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none">
                                            <path opacity="0.3"
                                                  d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                  fill="black"></path>
                                            <path
                                                d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                fill="black"></path>
                                    </svg>
                            </span>

                                </a>
                            </div>
                            <!--begin::Body-->
                            <div class="card-body py-2">

                                <div class="g-lead-details-area mb-5">


                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">FORM NAME</span>
                                        <span style="font-weight:bold">{{ $lead->leadsForm?->form_name ?? '' }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">First Name</span>
                                        <span>{{ $lead->first_name }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Middle Name</span>
                                        <span>{{ $lead->middlename }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Last Name</span>
                                        <span>{{ $lead->last_name }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Email</span>
                                        <span>{{ $lead->email }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Cell Phone</span>
                                        <span>{{ $lead->phone }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Home Phone</span>
                                        <span>{{ $lead->home_phone }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Work Phone</span>
                                        <span>{{ $lead->work_phone }}</span>
                                    </div>

                                    {{--
                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Alternative Number</span>
                                        <span>{{ $lead->alternative_number }}</span>
                                    </div>


                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Contact Person Name</span>
                                        <span>{{ $lead->contact_person_name }}</span>
                                    </div>
                                    --}}


                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Address</span>
                                        <span>{{ $lead->address }}</span>
                                    </div>

                                    {{--
                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Company</span>
                                        <span>{{ $lead->company }}</span>
                                    </div>
                                    --}}

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Status</span>
                                        @if ($lead->lead_status == "New")
                                        <span class="badge badge-light-primary">New</span>
                                        @elseif ($lead->lead_status == "Qualified")
                                        <span class="badge badge-light-primary">Qualified</span>
                                        @elseif ($lead->lead_status == "Proposition")
                                        <span class="badge badge-light-warning">Proposition</span>
                                        @elseif ($lead->lead_status == "Ongoing")
                                        <span class="badge badge-light-warning">Ongoing</span>
                                        @elseif ($lead->lead_status == "Won")
                                        <span class="badge badge-light-success">Won</span>
                                        @elseif ($lead->lead_status == "Lost")
                                        <span class="badge badge-light-danger">Lost</span>
                                        @endif
                                    </div>

                                    {{--
                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Lead Rating</span>
                                        <span>{{ $lead->lead_rating }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Website</span>
                                        <span>{{ $lead->website }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Lead Owner</span>
                                        <span>{{ $lead->lead_owner }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Industry</span>
                                        <span>{{ $lead->industry }}</span>
                                    </div>
                                    --}}


                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Lead Source</span>
                                        <span>
                                        @if(in_array($lead->lead_source, config('constants.lead_source')))
                                                {{ $lead->lead_source }}
                                            @else

                                            @endif
                                    </span>
                                    </div>

                                    {{--
                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Street</span>
                                        <span>{{ $lead->street }}</span>
                                    </div>
                                    --}}

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">City</span>
                                        <span>{{ $lead->city }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Zip</span>
                                        <span>{{ $lead->zip }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">State</span>
                                        <span>{{ $lead->state }}</span>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Country</span>
                                        <span>{{ $lead->country }}</span>
                                    </div>

                                    {{--
                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Lead Start Date</span>
                                        <span>{{ $lead->lead_start_date ? \Carbon\Carbon::parse($lead->lead_start_date)->format('d-m-Y') : '' }}</span>
                                    </div>
                                    --}}

                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                    <span
                                        class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Lead Notes</span>
                                        <span>{{ $lead->lead_notes }}</span>
                                    </div>

                                    {{--
                                    <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                        <span
                                            class="fs-7 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Profile Image</span>
                                        <span></span>
                                        @if(!empty($lead->profile_image))
                                            <img src="{{ asset('uploads/leads/' . $lead->profile_image) }}" width="150">
                                        @endif
                                    </div>
                                    --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show @if(session('success') || session('error')) active @endif"
                         id="g_lead_table" role="tabpanel" aria-labelledby="g_lead_table_tab">
                        <div class="card">
                            <div class="card-body">

                                <div class="row mb-1">
                                @foreach ($tableData as $tableName => $data)
                                    <!-- @if (!empty($data))
                                        -->
                                        @php
                                            $field = $fields->firstWhere('table_name', $tableName);
                                            $viewType = $field->view_type ?? 'table_view'; // Default to table_view if view_type is not set

                                            //Initialize arrays to store column sizes and form data
                                            //Iterate over all rows to collect column information
                                            $columnSizes = [];
                                            $formData = [];

                                        @endphp
                                        @if ($viewType === 'form_view')
                                            @foreach ($data as $row)
                                                @foreach ($row as $key => $value)
                                                    @if (!in_array($key, ['id', 'lead_id', 'form_id', 'created_at', 'updated_at']))
                                                        @php
                                                            $field = $fields->where('field_name', $key)->first();
                                                            $formSize = $field->form_size ?? 'col-md-6';
                                                            $isFile = $field && $field->field_value === 'file';

                                                            //Map the column size to the corresponding mb- class
                                                            $columnSize = '';
                                                            switch ($formSize) {
                                                            case 'col-md-3':
                                                            $columnSize = '1';
                                                            break;
                                                            case 'col-md-6':
                                                            $columnSize = '2';
                                                            break;
                                                            case 'col-md-9':
                                                            $columnSize = '3';
                                                            break;
                                                            case 'col-md-12':
                                                            default:
                                                            $columnSize = '4';
                                                            break;
                                                            }

                                                            // Store column sizes and form data
                                                            if (!isset($columnSizes[$formSize])) {
                                                            $columnSizes[$formSize] = $formSize;
                                                            }

                                                            if (!isset($formData[$formSize])) {
                                                            $formData[$formSize] = [];
                                                            }

                                                            $formData[$formSize][] = [
                                                            'key' => $key,
                                                            'value' => $value,
                                                            'isFile' => $isFile
                                                            ];
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endforeach

                                            
                                                
                                                @foreach ($columnSizes as $formSize)
                                                    
                                                    <div class="{{ $formSize }}">
                                                        <div class="fs-3 {{ $formSize }}" style="width:100%;border:1px solid #DDD;padding:7px;margin-bottom:10px;margin-top:30px;background-color:#54B4D3;">
                                                        {{ ucwords(str_replace('_', ' ', $tableName)) }}

                                                        <a href="{{ route('lead-edit-tabledata', ['tableName' => $tableName, 'leadId' => $row->id]) }}"
                                                        class="btn btn-icon btn-sm btn-success">
                                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3"
                                                        d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                        fill="black"/>
                                                        <path
                                                        d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                        fill="black"/>
                                                        </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                        </a>
                                                        </div>


                                                        <div class="g-lead-details mb-5" style="columns: {{ $columnSize }}">
                                                            @foreach ($formData[$formSize] as $dataItem)
                                                                <div class="d-flex align-items-center gap-2 bg-light p-1 mb-1">
                                                                    <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">{{ ucwords(str_replace('_', ' ', $dataItem['key'])) }}</span>
                                                                    @if ($dataItem['isFile'])
                                                                        @if (!empty($dataItem['value']))
                                                                            <span><a href="{{ url('uploads/files/' . $dataItem['value']) }}"
                                                                                    download>Download</a></span>
                                                                        @else
                                                                            <span></span>
                                                                        @endif
                                                                    @else
                                                                        <span>{{ $dataItem['value'] }}</span>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            
                                        @endif
                                    @endif
                                @endforeach
                                </div>

                                {{-- Display table_view after form_view --}}
                                @foreach ($tableData as $tableName => $data)
                                    @if (!empty($data) && !in_array($tableName, $notShowTable))
                                        @php
                                            $field = $fields->firstWhere('table_name', $tableName);
                                            $viewType = $field->view_type ?? 'table_view'; // Default to table_view if view_type is not set
                                        @endphp

                                        @if ($viewType === 'table_view')
                                            <div class="mb-10 bg-light p-5 rounded-3">
                                                <div class="d-flex justify-content-between align-items-center py-2">
                                                    <strong
                                                        class="fs-5">{{ ucwords(str_replace('_', ' ', $tableName)) }}</strong>
                                                    <button type="button" class="btn btn-success btn-sm"
                                                            onclick="window.location='{{ route('leads-add', ['tableName' => $tableName, 'leadId' => $lead->id]) }}'">
                                                        <i class="bi bi-plus-lg"></i>
                                                        Add New
                                                    </button>
                                                </div>
                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                                        <thead>
                                                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                                                            @if ($data->isNotEmpty() && $data->first() !== null)
                                                                <th class="ps-4 min-w-50px">SL</th>
                                                                <!-- @foreach ($data->first() as $key => $value)
                                                                    @if (!in_array($key, ['id', 'lead_id', 'form_id', 'created_by', 'created_at', 'updated_at']))
                                                                        <th class="ps-4 min-w-150px">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                                                    @endif
                                                                @endforeach -->
                                                                @php $count = 0; @endphp
                                                                @foreach ($data->first() as $key => $value)
                                                                    @if (!in_array($key, ['id', 'lead_id', 'form_id', 'created_by', 'created_at', 'updated_at']))
                                                                        @php $count++; @endphp
                                                                        @if($count > 5) @break @endif
                                                                        <th class="ps-4 min-w-150px">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                                                    @endif
                                                                @endforeach

                                                                <th class="ps-4 min-w-150px">Created By</th>
                                                                <th class="min-w-50px text-end pe-4">Action</th>
                                                            @else
                                                                <th class="ps-4 min-w-150px">&nbsp;</th>
                                                            @endif
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if ($data->isNotEmpty())

                                                            @foreach ($data as $index => $row)
                                                            @php
                                                            $i=1;
                                                            @endphp
                                                                <tr>
                                                                    <td class="ps-4 text-dark fs-6">{{ $index + 1 }}</td>
                                                                    @php $i = 0; @endphp
                                                                    @foreach ($row as $key => $value)
                                                                        @if (!in_array($key, ['id', 'lead_id', 'form_id','created_by', 'created_at', 'updated_at']))
                                                                            @php
                                                                                //if($i==70) {
                                                                                    //continue;
                                                                                //}
                                                                                 $i++;
                                                                                if ($i > 5) break; 
                                                                                $field = $fields->where('field_name', $key)->first();
                                                                                $isFile = $field && $field->field_value === 'file';
                                                                                $isDate = $field && $field->field_value === 'date';
                                                                                //$i++;
                                                                            @endphp

                                                                            @if ($isFile)
                                                                                <td class="ps-5 text-dark fs-6">
                                                                                    @if (!empty($value))
                                                                                        <a href="{{ url('uploads/files/' . $value) }}"
                                                                                           download>Download</a>
                                                                                    @else
                                                                                        <span></span>
                                                                                    @endif
                                                                                </td>
                                                                            @elseif ($isDate)
                                                                                <td class="ps-5 text-dark fs-6">
                                                                                    {{ !empty($value) ? $value : ' ' }}
                                                                                </td>
                                                                            @else
                                                                                <td class="ps-5 text-dark fs-6">{{ $value }}</td>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                    <td class="ps-5 text-dark fs-6">{{ $row->created_by }}</td>
                                                                    <td class="d-flex align-items-center justify-content-end gap-1">

                                                                    <a href="{{ route('lead-show-table-details', ['tableName' => $tableName, 'leadId' => $row->id]) }}" class="btn btn-icon btn-sm btn-success btn-show-details">

                                                                       <span class="svg-icon svg-icon-3">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                    <rect x="0" y="0" width="24" height="24" />
                                                                                    <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="black" fill-rule="nonzero" opacity="0.7" />
                                                                                    <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="black" opacity="0.7" />
                                                                                </g>
                                                                            </svg>
                                                                        </span>
                                                                        <!--end::Svg Icon-->
                                                                        </a>
                                                                        <a href="{{ route('lead-edit-tabledata', ['tableName' => $tableName, 'leadId' => $row->id]) }}"
                                                                           class="btn btn-icon btn-sm btn-success">
                                                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                                        <span class="svg-icon svg-icon-3">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none">
                                                                                <path opacity="0.3"
                                                                                    d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                                    fill="black"/>
                                                                                <path
                                                                                    d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                                    fill="black"/>
                                                                            </svg>
                                                                        </span>
                                                                            <!--end::Svg Icon-->
                                                                        </a>
                                                                        <form
                                                                            action="{{ route('delete-tabledata', ['tableName' => $tableName, 'id' => $row->id, 'leadId' => $lead->id]) }}"
                                                                            method="POST" style="display: inline;"
                                                                            onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                    class="btn btn-danger btn-icon btn-sm px-3 py-2">
                                                                                <i class="bi bi-x p-0"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>

                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="100%" class="text-center">No data
                                                                    available
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif
                                        
                                    @endif
                                @endforeach

                                <!-- add api data -->
                                <div class="mb-10 bg-light p-5 rounded-3">
                                    <div class="d-flex justify-content-between align-items-center py-2">
                                        <strong class="fs-5">Rate Analysis Data</strong>
                                    </div>
                                    <div class="table-responsive">
                                        <table
                                            class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                            <thead>
                                            <tr class="fw-bolder text-muted bg-light bd-cyan">
                                                <th class="ps-4 min-w-50px">SL</th>
                                                <th class="ps-4 min-w-150px">Company Name</th>
                                                <th class="ps-4 min-w-150px">Term</th>
                                                <th class="ps-4 min-w-150px">Down Payment</th>
                                                <th class="ps-4 min-w-150px">Payment Amount</th>
                                                <th class="ps-4 min-w-150px">Total Premium</th>
                                                <th class="ps-4 min-w-150px">Purchased</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if (!empty($rate_api_data))
                                                @foreach ($rate_api_data as $index => $row)
                                                    <tr>
                                                        <td class="ps-4 text-dark fs-6">{{ $index + 1 }}</td>
                                                        <td class="ps-4 text-dark fs-6">{{ $row->CompanyName }}</td>
                                                        <td class="ps-4 text-dark fs-6">{{ $row->Term }}</td>
                                                        <td class="ps-4 text-dark fs-6">{{ $row->DownPayment }}</td>
                                                        <td class="ps-4 text-dark fs-6">{{ $row->PaymentAmount }}</td>
                                                        <td class="ps-4 text-dark fs-6">{{ $row->TotalPremium }}</td>
                                                        <td class="ps-4 text-dark fs-6">{{ ($row->Purchased==true) ? "Yes" : "No" }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="100%" class="text-center">No data available
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <!-- Notes/Reminders -->

                    <div class="tab-pane fade" id="g_RAKIB_lead_table2" role="tabpanel" aria-labelledby="g_RAKIB_lead_table_tab2">
                        <div class="card">
                            <div class="card-body">

                                <div class="row mb-1">
                                    <div class="col-md-5" style="border:1px solid #ddd;">
                                        <div class="row">
                                            <h5 class="mb-2" style="border:1px solid #DDD;padding:7px;background-color:#54B4D3;color:#f7f7f7">Note Section</h5>
                                            <form class="g-form w-100" action="{{ route('save-lead-note') }}" enctype="multipart/form-data" method="POST">
                                            @csrf
                                            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                            <div class="col-md-12">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Write a Note</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <textarea class="form-control form-control-sm form-control-solid" name="lead_notes" rows="3">{{ old('lead_notes') }}</textarea>
                                                    <!--end::Input-->
                                                    @if ($errors->has('lead_notes'))
                                                    <span class="text-danger">{{ $errors->first('lead_notes') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Result Code</label>
                                                    <select class="form-control form-control-sm form-control-solid" name="result_codes_id">
                                                        <option value="" disabled {{ old('result_codes_id') == '' ? 'selected' : '' }}>Select Code</option>
                                                        @foreach($lead_result_codes as $result_code)
                                                        <option value="{{ $result_code->id }}" {{ old('result_codes_id') == $result_code->id ? 'selected' : '' }}>
                                                            {{ $result_code->title }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('result_codes_id'))
                                                    <span class="text-danger">{{ $errors->first('result_codes_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                <button type="submit" class="btn btn-primary" id="">Submit</button>
                                            </div>
                                            </form>

                                        </div>

                                        
                                    </div>

                                    <div class="col-md-7">
                                        <div class="mb-10 bg-light p-5 rounded-3">
                                            <div class="d-flex justify-content-between align-items-center py-2">
                                                <strong class="fs-5">Note Logs</strong>
                                            </div>
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                                    <thead>
                                                    <tr class="fw-bolder text-muted bg-light bd-cyan">
                                                        <th class="ps-4 min-w-50px">SL</th>
                                                        <th class="ps-4 min-w-150px">Result Code</th>
                                                        <th class="ps-4 min-w-150px">Notes</th>
                                                        <th class="ps-4 min-w-150px">Created at</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if (!empty($notelogs))
                                                        @foreach ($notelogs as $index => $row)
                                                            <tr>
                                                                <td class="ps-4 text-dark fs-6">{{ $index + 1 }}</td>
                                                                <td class="ps-4 text-dark fs-6">{{ $row->lead_res_code->title }}</td>
                                                                <td class="ps-4 text-dark fs-6">{{ $row->lead_notes }}</td>
                                                                <td class="ps-4 text-dark fs-6">{{ $row->created_at }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="100%" class="text-center">No data available
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- action information -->
                                        <div class="mb-10 bg-light p-5 rounded-3">

                                            <h5 class="mb-3" style="border:1px solid #DDD;padding:7px;background-color:#54B4D3;color:#f7f7f7">Action Information</h5>

                                            {{--<div class="mb-5">
                                                <h5 class="custom-bottom-border">Dates</h5>
                                                <table class="custom-table">
                                                        <tr>
                                                            <td>Created</td>
                                                            <td>{{ date("Y-m-d") }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Last modified</td>
                                                            <td>Not yet quoted</td>
                                                        </tr>
                                                </table>
                                            </div>--}}

                                             <div class="mb-9">
                                                <h5 class="custom-bottom-border">Producer Info</h5>
                                                <form class="g-form w-100" action="{{ route('save-assign-lead') }}" enctype="multipart/form-data" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                                    <table class="custom-table">
                                                            <tr>
                                                                <td>Assigned To</td>
                                                                <td>
                                                                    <select class="form-control form-control-sm form-control-solid" name="assigned_to">
                                                                        <option value="" {{ old('assigned_to') == '' ? 'selected' : '' }}>-- Select Lead --</option>
                                                                        @foreach($users as $value)
                                                                        <option value="{{ $value->id }}" {{ $lead->assigned_to == $value->id ? 'selected' : '' }}>
                                                                            {{ $value->first_name . " " . $value->last_name }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if ($errors->has('assigned_to'))
                                                                    <span class="text-danger">{{ $errors->first('assigned_to') }}</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td>Created by</td>
                                                                <td>{{ @$lead->created_name->username }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Last modified</td>
                                                                <td>{{ @$lead->updated_name->username }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Created at</td>
                                                                <td>{{ $lead->created_at }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Updated at</td>
                                                                <td>{{ $lead->updated_at }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Language</td>
                                                                <td>{{ $lead->language }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Bound</td>
                                                                <td></td>
                                                            </tr>
                                                                <td>Region</td>
                                                                <td>None</td>
                                                            </tr>
                                                    </table>
                                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                        <button type="submit" class="btn btn-primary" id="">Submit</button>
                                                    </div>
                                                </form>
                                            </div>


                                        </div>
                                    </div>


                                </div>


                            </div>
                        </div>
                    </div>

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

                    <div class="tab-pane fade {{ session('active_tab') === 'g_lead_email_tab' ? 'active show' : '' }}"
                         id="g_lead_email" role="tabpanel" aria-labelledby="g_lead_email_tab">
                        <div class="card">
                            <div class="card-body">

                                <!--begin::Body-->
                                <div class="card-body p-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="fs-3">Emails</strong>
                                        <a class="btn btn-success btn-sm" id="kt_activities_toggle">
                                            <i class="bi bi-plus-lg"></i>
                                            Send Email
                                        </a>
                                    </div>
                                    <div class="table-responsive">
                                        
                                        @if(count($emails) > 0)
                                            <table
                                                class="table table-sm table-condensed table-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                                <thead>
                                                <tr class="fw-bolder text-muted bg-light bd-cyan">
                                                    <th class="ps-4 rounded-start min-w-50px">SL</th>
                                                    <th class="min-w-150px">To</th>
                                                    <th class="min-w-150px">Lead</th>
                                                    <th class="min-w-150px">Email Subject</th>
                                                    <th class="min-w-140px">Time</th>
                                                    <th class="rounded-end min-w-50px">Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $i=1;
                                                @endphp
                                                @foreach ($emails as $email)
                                                    <tr>
                                                        <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                                        <td class="text-dark fs-6">{{ implode(', ', $email->email_to) }}</td>
                                                        <td class="text-dark fs-6">{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                                        <td class="text-dark fs-6">{{ $email->email_subject }}</td>
                                                        <td class="text-dark fs-6">{{ Carbon::parse($email->log_time)->format('d-m-Y h:i A') }}</td>
                                                        <td class="text-dark fs-6">
                                                            @if ($email->send_status == config('constants.campaign_status')["Success"])
                                                                <span class="badge badge-light-success">Success</span>
                                                            @elseif ($email->status == 0)
                                                                <span class="badge badge-light-danger">Fail</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach

                                                </tbody>
                                            </table>
                                        @else
                                            <p>No results found.</p>
                                        @endif
                                    </div>
                                </div>
                                <!--end::Body-->

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade {{ session('active_tab') === 'g_lead_sms_tab' ? 'active show' : '' }}"
                         id="g_lead_sms" role="tabpanel" aria-labelledby="g_lead_sms_tab">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="fs-3">SMS List</strong>
                                    <a class="btn btn-success btn-sm" id="kt_activities_toggle_2"><i
                                            class="bi bi-plus-lg"></i>Send SMS</a>
                                </div>


                                <div class="table-responsive">
                                    @if(count($sms) > 0)
                                        <!--begin::Table-->
                                        <table
                                            class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                                            <!--begin::Table head-->
                                            <thead>
                                            <tr class="fw-bolder text-muted bg-light bd-cyan">
                                                <th class="ps-4">SL</th>
                                                <th class="min-w-150px">To</th>
                                                <th class="min-w-150px">Lead</th>
                                                <th class="min-w-150px">SMS Body</th>
                                                <th class="min-w-140px">Send Time</th>
                                                <th class=" min-w-120px">Status</th>
                                            </tr>
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach ($sms as $value)
                                                <tr>
                                                    <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                                    <td class="text-dark fs-6">{{ $value->sms_to }}</td>
                                                    <td class="text-dark fs-6">{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                                    <td class="text-dark fs-6">{{ $value->sms_text }}</td>
                                                    <td class="text-dark fs-6">{{ Carbon::parse($value->log_time)->format('d-m-Y h:i A') }}</td>
                                                    <td>
                                                        @if ($value->send_status == 1)
                                                            <span class="badge badge-light-success">Success</span>
                                                        @elseif ($value->status == 0)
                                                            <span class="badge badge-light-danger">Fail</span>
                                                        @endif
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


                                <!-- </div> -->
                                <!--end::Body-->

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade {{ session('active_tab') === 'g_lead_meeting_tab' ? 'active show' : '' }}"
                         id="g_lead_meeting" role="tabpanel" aria-labelledby="g_lead_meeting_tab">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="fs-3">Meetings</strong>
                                    <a class="btn btn-success btn-sm" id="kt_activities_toggle_3"><i
                                            class="bi bi-plus-lg"></i>Meeting Request</a>
                                </div>

                                <div class="table-responsive">
                                    @if(count($meetings) > 0)
                                        <!--begin::Table-->
                                        <table
                                            class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                                            <!--begin::Table head-->
                                            <thead>
                                            <tr class="fw-bolder text-muted bg-light bd-cyan">
                                                <th class=" ps-4">SL</th>
                                                <!-- <th class="min-w-150px">Form ID</th> -->
                                                <th class="min-w-150px">Meeting Subject</th>
                                                <!-- <th class="min-w-150px">Promotion</th> -->
                                                <th class="min-w-140px">Meeting Date</th>
                                                <th class="min-w-140px">Duration</th>
                                                <th class="min-w-140px">Created By</th>
                                                <th class="min-w-120px">Status</th>
                                                <th class="min-w-120px">Rating</th>
                                                <th class="min-w-100px text-center text-center-new">Actions</th>
                                            </tr>
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach ($meetings as $meeting)
                                                <tr>
                                                    <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                                    <td class="text-dark fs-6 w-250px">{{$meeting->meeting_subject }}</td>
                                                    <td class="text-dark fs-6">{{ \Carbon\Carbon::parse($meeting->meeting_date)->format('Y-m-d h:i A') }}</td>
                                                    <td class="text-dark fs-6">{{$meeting->duration }}</td>
                                                    <td class="text-dark fs-6">{{$meeting->user->username ?? 'N/A'}}</td>

                                                    <td>
                                                        @if ($meeting->status == 1)
                                                            <span class="badge badge-light-success">Active</span>
                                                        @elseif ($meeting->status == 0)
                                                            <span class="badge badge-light-danger">Inactive</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-dark fs-6">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if($i <=$meeting->rating)
                                                                <i class="fa fa-star text-warning"></i>
                                                                <!-- Yellow star for ratings -->
                                                            @else
                                                                <i class="fa fa-star text-muted"></i>
                                                                <!-- Grey star for remaining -->
                                                            @endif
                                                        @endfor
                                                    </td>


                                                    <td>
                                                        <div
                                                            class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">
                                                            <a href="#"
                                                               class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                               data-bs-toggle="modal"
                                                               data-bs-target="#add_feedback_modal"
                                                               data-id="{{ $meeting->id }}">
                                                                <!-- Pass meeting ID here -->
                                                                <!-- Svg Icon -->
                                                                <span class="svg-icon svg-icon-3">
                                                            <svg fill="#000000" width="800px" height="800px"
                                                                 viewBox="0 0 1920 1920"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M84 0v1423.143h437.875V1920l621.235-496.857h692.39V0H84Zm109.469 109.464H1726.03V1313.57h-621.235l-473.452 378.746V1313.57H193.469V109.464Z"
                                                                    fill-rule="evenodd"/>
                                                            </svg>
                                                        </span>
                                                            </a>

                                                            <a target="_blank"
                                                               href="#"
                                                               class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                               id="show_meeting_{{ $meeting->id }}">
                                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                                <span class="svg-icon svg-icon-3">
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
                                                            <!-- <a target="_blank"
                                                               href="{{ route('meeting-edit', $meeting->id) }}"
                                                               class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">

                                                                <span class="svg-icon svg-icon-3">
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

                                                            </a> -->

                                                            <a
                                                                href="#"
                                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                                id="update_meeting_{{ $meeting->id }}">

                                                                <span class="svg-icon svg-icon-3">
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


                                                            <!--begin::Meeting activities drawer-->
                                                            <div id="kt_activities_3_{{ $meeting->id }}" class="bg-body"
                                                                 data-kt-drawer="true" data-kt-drawer-name="activities"
                                                                 data-kt-drawer-activate="true"
                                                                 data-kt-drawer-overlay="true"
                                                                 data-kt-drawer-width="{default:'300px', 'lg': '50%'}"
                                                                 data-kt-drawer-direction="end"
                                                                 data-kt-drawer-toggle="#update_meeting_{{ $meeting->id }}"
                                                                 data-kt-drawer-close="#kt_activities_close">
                                                                <div class="card shadow-none rounded-0 w-100">
                                                                    <!--begin::Header-->
                                                                    <div class="card-header" id="kt_activities_header">
                                                                        <h3 class="card-title fw-bolder text-dark">Edit
                                                                            Meeting</h3>
                                                                        <div class="card-toolbar">
                                                                            <button type="button"
                                                                                    class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                                                                                    id="kt_activities_close">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                                                <span class="svg-icon svg-icon-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                         height="24" viewBox="0 0 24 24" fill="none">
                                                                        <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                                              height="2" rx="1"
                                                                              transform="rotate(-45 6 17.3137)"
                                                                              fill="black"/>
                                                                        <rect x="7.41422" y="6" width="16" height="2"
                                                                              rx="1" transform="rotate(45 7.41422 6)"
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
                                                                                    <div class="row">
                                                                                        <div class="col-md-12 mx-auto">

                                                                                            <form
                                                                                                action="{{ route('meeting-update', $meeting->id) }}"
                                                                                                method="POST"
                                                                                                enctype="multipart/form-data">
                                                                                                @csrf
                                                                                                @method('PUT')
                                                                                                <input type="hidden"
                                                                                                       name="lead_id"
                                                                                                       value="{{ $lead->id }}">
                                                                                                <input type="hidden"
                                                                                                       name="form_lead_panel"
                                                                                                       value="1">
                                                                                                <div class="row">

                                                                                                    <div
                                                                                                        class="col-md-6">
                                                                                                        <div
                                                                                                            class="fv-row mb-3">
                                                                                                            <label
                                                                                                                class="form-label fw-bolder text-dark">Select
                                                                                                                Lead</label>
                                                                                                            <select
                                                                                                                class=" form-control form-control-sm form-control-solid"
                                                                                                                name="recipients"
                                                                                                                aria-label="Default select example">
                                                                                                                <option
                                                                                                                    value="{{$lead->id}}">
                                                                                                                    @if($lead->first_name || $lead->last_name || $lead->email)
                                                                                                                        {{ trim(($lead->first_name ?? '') . ' ' . ($lead->last_name ?? '') .
                                                                                                                        ($lead->email ? ' <' . $lead->email . '>' : '')) }}
                                                                                                                    @endif
                                                                                                                </option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div
                                                                                                        class="col-md-6">
                                                                                                        <div
                                                                                                            class="fv-row mb-3">
                                                                                                            <label
                                                                                                                class="form-label fw-bolder text-dark">Meeting
                                                                                                                Subject</label>
                                                                                                            <input
                                                                                                                class="form-control form-control-sm form-control-solid"
                                                                                                                required
                                                                                                                type="text"
                                                                                                                name="meeting_subject"
                                                                                                                value="{{ old('meeting_subject', $meeting->meeting_subject ?? '') }}"
                                                                                                                autocomplete="off"/>
                                                                                                            @if ($errors->has('meeting_subject'))
                                                                                                                <span
                                                                                                                    class="text-danger">{{ $errors->first('meeting_subject') }}</span>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div
                                                                                                        class="col-md-6">
                                                                                                        <div
                                                                                                            class="fv-row mb-3">
                                                                                                            <label
                                                                                                                class="form-label fw-bolder text-dark">Meeting
                                                                                                                Date</label>
                                                                                                            <input
                                                                                                                type="text"
                                                                                                                class="form-control form-control-sm form-control-solid flatpickr"
                                                                                                                name="meeting_date"
                                                                                                                value="{{ old('meeting_date', $meeting->meeting_date ?? '') }}"
                                                                                                                required/>
                                                                                                            @if ($errors->has('meeting_date'))
                                                                                                                <span
                                                                                                                    class="text-danger">{{ $errors->first('meeting_date') }}</span>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div
                                                                                                        class="col-md-6">
                                                                                                        <div
                                                                                                            class="form-group">
                                                                                                            <label
                                                                                                                class="form-label fw-bolder text-dark"
                                                                                                                for="textarea">Meeting
                                                                                                                Description</label>
                                                                                                            <textarea
                                                                                                                class="form-control form-control-sm form-control-solid"
                                                                                                                name="meeting_description"
                                                                                                                rows="2">{{ old('meeting_description', $meeting->meeting_description ?? '') }}</textarea>
                                                                                                            @if ($errors->has('meeting_description'))
                                                                                                                <span
                                                                                                                    class="text-danger">{{ $errors->first('meeting_description') }}</span>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div
                                                                                                        class="col-md-6">
                                                                                                        <div
                                                                                                            class="fv-row mb-3">
                                                                                                            <label
                                                                                                                class="form-label fw-bolder text-dark">Meeting
                                                                                                                Link</label>
                                                                                                            <input
                                                                                                                class="form-control form-control-sm form-control-solid"
                                                                                                                type="url"
                                                                                                                name="meeting_link"
                                                                                                                value="{{ old('meeting_link', $meeting->meeting_link ?? '') }}"
                                                                                                                autocomplete="off"/>
                                                                                                            @if ($errors->has('meeting_link'))
                                                                                                                <span
                                                                                                                    class="text-danger">{{ $errors->first('meeting_link') }}</span>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div
                                                                                                        class="col-md-6">
                                                                                                        <div
                                                                                                            class="fv-row mb-3">
                                                                                                            <label
                                                                                                                class="form-label fw-bolder text-dark">Duration</label>
                                                                                                            <input
                                                                                                                class="form-control form-control-sm form-control-solid"
                                                                                                                type="text"
                                                                                                                name="duration"
                                                                                                                value="{{ old('duration', $meeting->duration ?? '') }}"
                                                                                                                autocomplete="off"/>
                                                                                                            @if ($errors->has('duration'))
                                                                                                                <span
                                                                                                                    class="text-danger">{{ $errors->first('duration') }}</span>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div
                                                                                                        class="col-md-6">
                                                                                                        <div
                                                                                                            class="fv-row mb-3">
                                                                                                            <label
                                                                                                                class="form-label fw-bolder text-dark">Attachments</label>
                                                                                                            <input
                                                                                                                type="file"
                                                                                                                class="form-control form-control-sm form-control-solid"
                                                                                                                name="attachments"/>
                                                                                                            @if ($meeting->attachments)
                                                                                                                <div
                                                                                                                    class="mt-3"
                                                                                                                    id="attachments-file-container">
                                                                                                                    @php

                                                                                                                        $fileExtension = pathinfo($meeting->attachments, PATHINFO_EXTENSION);
                                                                                                                    @endphp

                                                                                                                        <!-- Show a link for non-image attachments -->
                                                                                                                    <a href="{{ asset('uploads/meetings/' . $meeting->attachments) }}"
                                                                                                                       target="_blank">
                                                                                                                        View {{ strtoupper($fileExtension) }}
                                                                                                                        Attachment
                                                                                                                    </a>


                                                                                                                    <!-- Replace the trash icon with a new "remove" icon -->
                                                                                                                    <button
                                                                                                                        type="button"
                                                                                                                        class="btn btn-danger btn-sm p-1"
                                                                                                                        id="delete-attachments-file">
                                                                                                                        <i class="fas fa-times-circle pe-0"></i>
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                            @endif
                                                                                                            @if ($errors->has('attachments'))
                                                                                                                <span
                                                                                                                    class="text-danger">{{ $errors->first('attachments') }}</span>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div
                                                                                                        class="col-md-6">
                                                                                                        <div
                                                                                                            class="fv-row mb-3">
                                                                                                            <label
                                                                                                                class="form-label fw-bolder text-dark">Status</label>
                                                                                                            <select
                                                                                                                class=" form-control form-control-sm form-control-solid"
                                                                                                                name="status"
                                                                                                                aria-label="Default select example">
                                                                                                                <option
                                                                                                                    value="1" {{ old('status', $meeting->status ?? '1') == '1' ? 'selected' : '' }}>
                                                                                                                    Active
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="0" {{ old('status', $meeting->status ?? '') == '0' ? 'selected' : '' }}>
                                                                                                                    Inactive
                                                                                                                </option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>


                                                                                                    <div
                                                                                                        class="col-md-2">
                                                                                                        <div
                                                                                                            class="fv-row mt-10 form-check form-check-custom form-check-sm">
                                                                                                            <input
                                                                                                                class="form-check-input form-check-sm"
                                                                                                                type="checkbox"
                                                                                                                name="send_email"
                                                                                                                id="sendEmail"
                                                                                                                value="1" {{ old('send_email', $meeting->send_email) ? 'checked' : '' }}>
                                                                                                            <label
                                                                                                                class="form-check-label fw-bolder text-dark"
                                                                                                                for="sendEmail">
                                                                                                                Send
                                                                                                                Email
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div
                                                                                                        class="col-md-2">
                                                                                                        <div
                                                                                                            class="fv-row mt-10 form-check form-check-custom form-check-sm">
                                                                                                            <input
                                                                                                                class="form-check-input"
                                                                                                                type="checkbox"
                                                                                                                name="send_sms"
                                                                                                                id="sendSMS"
                                                                                                                value="1" {{ old('send_sms', $meeting->send_sms) ? 'checked' : '' }}>
                                                                                                            <label
                                                                                                                class="form-check-label fw-bolder text-dark"
                                                                                                                for="sendSMS">
                                                                                                                Send SMS
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>


                                                                                                </div>
                                                                                                <!--End Row-->
                                                                                                <div
                                                                                                    class="card-footer d-flex justify-content-end py-6 px-9">
                                                                                                    <button
                                                                                                        type="submit"
                                                                                                        class="btn btn-primary"
                                                                                                        id="">
                                                                                                        Save Changes
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

                                                            <!--begin::Meeting activities drawer-->
                                                            <div id="kt_activities_3_{{ $meeting->id }}" class="bg-body"
                                                                 data-kt-drawer="true" data-kt-drawer-name="activities"
                                                                 data-kt-drawer-activate="true"
                                                                 data-kt-drawer-overlay="true"
                                                                 data-kt-drawer-width="{default:'300px', 'lg': '50%'}"
                                                                 data-kt-drawer-direction="end"
                                                                 data-kt-drawer-toggle="#show_meeting_{{ $meeting->id }}"
                                                                 data-kt-drawer-close="#kt_activities_close">
                                                                <div class="card shadow-none rounded-0 w-100">
                                                                    <!--begin::Header-->
                                                                    <div class="card-header" id="kt_activities_header">
                                                                        <h3 class="card-title fw-bolder text-dark">
                                                                            Meeting Details</h3>
                                                                        <div class="card-toolbar">
                                                                            <button type="button"
                                                                                    class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                                                                                    id="kt_activities_close">
                                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                                                <span class="svg-icon svg-icon-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                         height="24" viewBox="0 0 24 24" fill="none">
                                                                        <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                                              height="2" rx="1"
                                                                              transform="rotate(-45 6 17.3137)"
                                                                              fill="black"/>
                                                                        <rect x="7.41422" y="6" width="16" height="2"
                                                                              rx="1" transform="rotate(45 7.41422 6)"
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
                                                                                    <div class="row">
                                                                                        <div class="col-md-12 mx-auto">

                                                                                            <div class="card-body p-1">

                                                                                                <!-- Show Lead Information if lead_id exists -->
                                                                                                @if($lead)
                                                                                                    <div
                                                                                                        class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                                        <span
                                                                                                            class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Lead</span>
                                                                                                        <span>{{ $lead->first_name . ' ' . $lead->last_name . ' <' . $lead->email . '>' }}</span>
                                                                                                    </div>
                                                                                                @endif

                                                                                                <div
                                                                                                    class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                                    <span
                                                                                                        class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Meeting Subject</span>
                                                                                                    <span>{{ $meeting->meeting_subject }}</span>
                                                                                                </div>

                                                                                                @php
                                                                                                    date_default_timezone_set('Asia/Dhaka');
                                                                                                    //assuming the $meeting->meeting_date is a datetime string
                                                                                                    $meetingDate = Carbon::parse($meeting->meeting_date); // Parse date with Carbon
                                                                                                    // Format pieces of the date and time
                                                                                                    $dayOfWeek = $meetingDate->format('l'); // full day name (example., Thursday)
                                                                                                    $day = $meetingDate->format('d'); // numeric day (example., 12)
                                                                                                    $monthYear = $meetingDate->format('F Y'); // full month and year (example., September 2024)
                                                                                                    $time = $meetingDate->format('g:i A'); // time with AM/PM (example., 2:00 PM)
                                                                                                    $timezone = $meetingDate->timezoneName; // timezone (example., Asia/Dhaka)
                                                                                                @endphp

                                                                                                <div
                                                                                                    class="position-relative d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                                    <!-- <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Meeting Date</span> -->
                                                                                                    <span>
                                                                                    <div
                                                                                        class="calendar-block position-relative">
                                                                                        <div class="calendar-left">
                                                                                            <!-- Display the day of the week -->
                                                                                            <div
                                                                                                class="calendar-header">{{ $dayOfWeek }}</div>
                                                                                            <!-- Display the numeric day -->
                                                                                            <div
                                                                                                class="calendar-date">{{ $day }}</div>
                                                                                            <!-- Display the month and year -->
                                                                                            <div
                                                                                                class="calendar-footer">
                                                                                                <div
                                                                                                    class="calendar-month-year">{{ $monthYear }}</div>
                                                                                                <div
                                                                                                    class="calendar-time-block">
                                                                                                    <!-- Display the time -->
                                                                                                    <div
                                                                                                        class="calendar-time">{{ $time }}</div>
                                                                                                    <!-- Display the timezone dynamically -->
                                                                                                    <div
                                                                                                        class="calendar-timezone">({{ $timezone }})</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </span>

                                                                                                    <!-- Event details placed behind the calendar using z-index -->
                                                                                                    <span
                                                                                                        class="event-details-block">
                                                                                    <div class="event-details">
                                                                                        <h3>Details of the event</h3>
                                                                                        <ul>
                                                                                            <li><strong>Description:</strong>{{ $meeting->meeting_description }}</li>
                                                                                            <li>
                                                                                                Please attend the meeting on time.<br><strong>How to Join:</strong> <a
                                                                                                    href="{{ $meeting->meeting_link }}">{{ $meeting->meeting_link }}</a></li>
                                                                                            <li><strong>Duration:</strong> {{ $meeting->duration }}</li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </span>
                                                                                                </div>


                                                                                                @if($meeting->attachments)
                                                                                                    <div
                                                                                                        class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                                        <span
                                                                                                            class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Attachments</span>
                                                                                                        <span> <a
                                                                                                                href="{{ asset('uploads/meetings/' . $meeting->attachments) }}"
                                                                                                                target="_blank">
                                                                                        <i class="fas fa-paperclip me-1"></i>Attachment
                                                                                    </a></span>
                                                                                                    </div>
                                                                                                @endif

                                                                                                <div
                                                                                                    class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                                    <span
                                                                                                        class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Status</span>
                                                                                                    @if ($meeting->status === 1)
                                                                                                        <span>Active</span>
                                                                                                    @elseif ($meeting->status === 0)
                                                                                                        <span>Inactive</span>
                                                                                                    @endif
                                                                                                </div>

                                                                                                <div
                                                                                                    class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                                    <span
                                                                                                        class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Created By</span>
                                                                                                    <span>{{ $meeting->user->username ?? 'N/A' }}</span>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                                    <span
                                                                                                        class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Rating</span>
                                                                                                    <span>
                                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                                                            @if($i <=$meeting->rating)
                                                                                                                <i class="fa fa-star text-warning"></i>
                                                                                                                <!-- yellow star ratings -->
                                                                                                            @else
                                                                                                                <i class="fa fa-star text-muted"></i>
                                                                                                                <!-- grey star remaining -->
                                                                                                            @endif
                                                                                                        @endfor
                                                                                </span>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                                    <span
                                                                                                        class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Meeting Feedback</span>
                                                                                                    <span>{{ $meeting->meeting_feedback }}</span>
                                                                                                </div>

                                                                                                <div
                                                                                                    class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                                    <span
                                                                                                        class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Send Email</span>
                                                                                                    @if ($meeting->send_email === 1)
                                                                                                        <span>Yes</span>
                                                                                                    @elseif ($meeting->send_email === 0 || $meeting->send_email === null)
                                                                                                        <span>No</span>
                                                                                                    @endif
                                                                                                </div>

                                                                                                <div
                                                                                                    class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                                    <span
                                                                                                        class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Send SMS</span>
                                                                                                    @if ($meeting->send_sms === 1)
                                                                                                        <span>Yes</span>
                                                                                                    @elseif ($meeting->send_sms === 0 || $meeting->send_sms === null)
                                                                                                        <span>No</span>
                                                                                                    @endif
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

                                                            {{--
                                                            <form action="{{ route('meeting-destroy', $meeting->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="return confirmDelete()">
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
                                                            --}}
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

                    <div class="tab-pane fade {{ session('active_tab') === 'g_lead_proposals_tab' ? 'active' : '' }}"
                         id="g_lead_proposals" role="tabpanel" aria-labelledby="g_lead_proposals_tab">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="fs-3">Proposals</strong>
                                    <a class="btn btn-success btn-sm" id="kt_activities_toggle_4"><i
                                            class="bi bi-plus-lg"></i>Send Proposal</a>
                                </div>

                                <div class="table-responsive">
                                    @if(count($proposals) > 0)
                                        <!--begin::Table-->

                                        <table
                                            class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                                            <!--begin::Table head-->
                                            <thead>
                                            <tr class="fw-bolder text-muted bg-light bd-cyan">
                                                <th class="ps-4 min-w-120px">SL</th>
                                                <th class="min-w-120px">Lead</th>
                                                <th class="min-w-150px">Subject</th>
                                                <th class="min-w-150px">Company</th>
                                                <th class="min-w-120px">Email</th>
                                                <!-- <th class="min-w-120px">Date</th> -->
                                                <!-- <th class="min-w-120px">Open Till</th> -->
                                                <th class="min-w-120px">Price</th>
                                                <th class="min-w-120px">Offer Price</th>
                                                <!-- <th class="min-w-120px">Offer Price with Tax</th> -->
                                                <!-- <th class="min-w-120px">Created At</th> -->
                                                <th class="min-w-120px">Status</th>
                                                <th class="min-w-100px text-end-new">Actions</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach ($proposals as $proposal)
                                                <tr>
                                                    <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                                    <td class="text-dark fs-6">{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                                    <td class="text-dark fs-6">{{ $proposal->subject }}</td>
                                                    <td class="text-dark fs-6">{{ $proposal->company_name }}</td>
                                                    <td class="text-dark fs-6">{{ $proposal->send_to }}</td>
                                                    <td class="text-dark fs-6">{{ $proposal->price }}</td>
                                                    <td class="text-dark fs-6">{{ $proposal->offer_price }}</td>
                                                    <td class="text-dark fs-6">{{ $proposal->status }}</td>

                                                    <td>
                                                        <div
                                                            class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">

                                                            <a target="_blank"
                                                               href="{{ route('proposal-show', $proposal->id) }}"
                                                               class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     width="24px" height="24px" viewBox="0 0 24 24">
                                                                        <g stroke="none" stroke-width="1"
                                                                           fill="none" fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24"
                                                                                  height="24"/>
                                                                            <path
                                                                                d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                                                                fill="black" fill-rule="nonzero"
                                                                                opacity="0.7"/>
                                                                            <path
                                                                                d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                                                                fill="black" opacity="0.7"/>
                                                                        </g>
                                                                    </svg>
                                                             </span>
                                                            </a>
                                                            <a target="_blank"
                                                               href="{{ route('proposal-edit', $proposal->id) }}"
                                                               class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                            <span class="svg-icon svg-icon-3">
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

                                                            {{--
                                                            <form action="{{ route('delete-proposal', $proposal->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"  onclick="return confirmDelete()">
                                                                <span class="svg-icon svg-icon-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none">
                                                                        <path
                                                                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                            fill="black" />
                                                                        <path opacity="0.5"
                                                                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                            fill="black" />
                                                                        <path opacity="0.5"
                                                                            d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                            fill="black" />
                                                                    </svg>
                                                                </span>
                                                                </button>

                                                            </form>
                                                            --}}
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

                    <div
                        class="tab-pane fade {{ session('active_tab') === 'g_lead_products_tab' ? 'active show' : '' }}"
                        id="g_lead_products" role="tabpanel" aria-labelledby="g_lead_products_tab">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="fs-3">Product Specification</strong>
                                    <!-- <a class="btn btn-success btn-sm" id="kt_activities_toggle_5"><i
                                            class="bi bi-plus-lg"></i>Add Specification</a> -->
                                    <a class="btn btn-success btn-sm" target="_blank"
                                       href="{{ route('product-specification-create', $lead->id) }}">
                                        <i class="bi bi-plus-lg"></i>
                                        Add Specification
                                    </a>
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

                    <div class="tab-pane fade {{ session('active_tab') === 'g_lead_invoice_tab' ? 'active show' : '' }}"
                         id="g_lead_invoice" role="tabpanel" aria-labelledby="g_lead_invoice_tab">

                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="fs-3">Invoices</strong>
                                    <a class="btn btn-success btn-sm" target="_blank"
                                       href="{{ route('invoice-create', $lead->id) }}">
                                        <i class="bi bi-plus-lg"></i>
                                        Create Invoice
                                    </a>
                                </div>

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
                                                <th class="min-w-100px text-end text-end-new">Actions</th>
                                            </tr>
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach ($invoices as $invoice)

                                                <tr>

                                                    <td class="ps-5 text-dark fs-6">{{ $i }}</td>
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
                                                        <div
                                                            class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">
                                                            <a href="{{ route('invoice-show', $invoice->id) }}"
                                                               target="_blank"
                                                               class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                                <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                                <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 width="24px" height="24px" viewBox="0 0 24 24">
                                                                <g stroke="none" stroke-width="1"
                                                                   fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24"
                                                                          height="24"/>
                                                                    <path
                                                                        d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                                                        fill="black" fill-rule="nonzero"
                                                                        opacity="0.7"/>
                                                                    <path
                                                                        d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                                                        fill="black" opacity="0.7"/>
                                                                </g>
                                                            </svg>
                                                        </span>
                                                                <!--end::Svg Icon-->
                                                            </a>
                                                            <a target="_blank"
                                                               href="{{ route('invoice-edit', $invoice->id) }}"
                                                               class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                                <span class="svg-icon svg-icon-3">
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
                                                                <!--end::Svg Icon-->
                                                            </a>

                                                            {{--
                                                            <form action="{{ route('invoice-destroy', $invoice->id) }}"
                                                                method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                                                    onclick="return confirmDelete()">
                                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                                    <span class="svg-icon svg-icon-3">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none">
                                                                            <path
                                                                                d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                                fill="black" />
                                                                            <path opacity="0.5"
                                                                                d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                                fill="black" />
                                                                            <path opacity="0.5"
                                                                                d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                                fill="black" />
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </button>
                                                            </form>
                                                            --}}

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

                    <div class="tab-pane fade {{ session('active_tab') === 'g_lead_tickets_tab' ? 'active show' : '' }}"
                         id="g_lead_tickets" role="tabpanel" aria-labelledby="g_lead_tickets_tab">
                        <div class="card">
                            <div class="card-body">
                                <div id="loader"
                                     style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.8); display: none; justify-content: center; align-items: center; z-index: 10;">
                                    <svg class="loader" width="50" height="50" viewBox="0 0 50 50">
                                        <circle class="loader-circle" cx="25" cy="25" r="20" fill="none"
                                                stroke-width="4"></circle>
                                    </svg>
                                </div>
                                <button class="btn btn-success btn-sm" id="createTicketButton">Create Ticket</button>
                                <button class="btn btn-success btn-sm" id="ticketListBtn">Ticket List</button>
                                <div id="ticketIframeContainer" style="margin-top: 20px; display: none;">
                                    <iframe
                                        id="ticketIframe"
                                        src=""
                                        style="width: 100%; height: 600px; border: none;"
                                        title="Create Ticket">
                                    </iframe>
                                </div>
                                <table id="ticketTable"
                                       class="table table-sm table-condensed table-bordered table-row-gray-100 align-middle gs-0 gy-3 mt-1">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr class="fw-bolder text-muted bg-light bd-cyan">
                                        <th class="min-w-150px">Ticket ID</th>
                                        <th class="min-w-150px"> Title</th>
                                        <th class="min-w-150px"> Group</th>
                                        <th class="min-w-150px"> Status</th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div
                        class="tab-pane fade {{ session('active_tab') === 'g_lead_activity_log_tab' ? 'active show' : '' }}"
                        id="g_lead_activity_log" role="tabpanel" aria-labelledby="g_lead_activity_log_tab">
                        <div class="card">
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="fs-3">Log History</strong>
                                </div>

                                <div class="table-responsive">
                                    @if (isset($logs) && $logs->isNotEmpty())
                                        <!--begin::Table-->
                                        <table
                                            class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                            <!--begin::Table head-->
                                            <thead>
                                            <tr class="fw-bolder text-muted bg-light bd-cyan">
                                                <th class="ps-4 rounded-start min-w-40px">SL</th>
                                                <th class="min-w-150px">Module</th>
                                                <th class="min-w-140px">Sub Module</th>
                                                <th class="min-w-140px">Log Message</th>
                                                <th class="min-w-140px">Lead</th>
                                                <th class="min-w-140px">Created By</th>
                                                <th class="min-w-120px">Created At</th>
                                            </tr>
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody>
                                            @php
                                                $i=1;
                                            @endphp
                                            @foreach ($logs as $log)
                                                <tr>
                                                    <td class="ps-5 text-dark fs-6">{{ $i }}</td>
                                                    <td class="text-dark fs-6">{{ $log->module }}</td>
                                                    <td class="text-dark fs-6">{{ $log->sub_module }}</td>
                                                    <td class="text-dark fs-6">{{ $log->log_message }}</td>
                                                    <td class="text-dark fs-6">{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                                    <td class="text-dark fs-6">{{ $log->first_name }} {{ $log->last_name }}</td>
                                                    <td>
                                                        {{ Carbon::parse($log->created_at)->format('d-m-Y h:i:s A') }}
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

    <!--begin::Proposal drawer-->
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
                                            <div class="col-md-4">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Customer<span
                                                            class="text-danger">*</span>

                                                    </label>

                                                    <select name="customer_id"
                                                            class="form-control form-control-sm form-control-solid"
                                                            required aria-label="Default select example">
                                                        @if (!empty($lead_customer))
                                                            <option
                                                                value="{{ $lead_customer->id }}">{{ $lead_customer->first_name . " " . $lead_customer->last_name }}</option>
                                                        @else
                                                            <option value="" disabled selected>No customer assigned
                                                            </option>
                                                        @endif
                                                    </select>
                                                    @if ($errors->has('customer_id'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('customer_id') }}</span>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Product</label>
                                                <select id="product-select"
                                                        class="form-control form-control-sm form-control-solid"
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

                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Work Order Number</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="text" name="work_order_number"
                                                       value="{{ old('work_order_number') }}"/>
                                                @if ($errors->has('work_order_number'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('work_order_number') }}</div>
                                                @endif
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Work Order File</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="file" name="work_order_file"/>
                                                @if ($errors->has('work_order_file'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('work_order_file') }}</div>
                                                @endif
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Work Order Value</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="number" name="work_order_value"
                                                       value="{{ old('work_order_value') }}"/>
                                                @if ($errors->has('work_order_value'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('work_order_value') }}</div>
                                                @endif
                                            </div>


                                            <!-- new fields -->
                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Advance Amount</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="text" name="advance_amount"
                                                       value="{{ old('advance_amount') }}"/>
                                                @if ($errors->has('advance_amount'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('advance_amount') }}</div>
                                                @endif
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Total Installment</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="text" name="total_installment"
                                                       value="{{ old('total_installment') }}"/>
                                                @if ($errors->has('total_installment'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('total_installment') }}</div>
                                                @endif
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Per Month
                                                    Installment</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="text" name="per_month_installment"
                                                       value="{{ old('per_month_installment') }}"/>
                                                @if ($errors->has('per_month_installment'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('per_month_installment') }}</div>
                                                @endif
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Payment Date Cycle</label>
                                                <input class="form-control form-control-sm form-control-solid flatpickr"
                                                       type="text" id="common_dob" name="payment_date_cycle"
                                                       value="{{ old('payment_date_cycle') }}"/>
                                                @if ($errors->has('payment_date_cycle'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('payment_date_cycle') }}</div>
                                                @endif
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Remaining Month</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="text" name="remaining_month"
                                                       value="{{ old('remaining_month') }}"/>
                                                @if ($errors->has('remaining_month'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('remaining_month') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Due Balance</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="number" name="due_balance"
                                                       value="{{ old('due_balance') }}"/>
                                                @if ($errors->has('due_balance'))
                                                    <div class="text-danger">{{ $errors->first('due_balance') }}</div>
                                                @endif
                                            </div>
                                            <!-- end new fields -->


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Purchase Order
                                                    Value</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="number" name="purchase_order_value"
                                                       value="{{ old('purchase_order_value') }}"/>
                                                @if ($errors->has('purchase_order_value'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('purchase_order_value') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Purchase Order
                                                    File</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="file" name="purchase_order_file"/>
                                                @if ($errors->has('purchase_order_file'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('purchase_order_file') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">AMC Start Date</label>
                                                <input class="form-control form-control-sm form-control-solid flatpickr"
                                                       type="text" id="common_dob" name="amc_start_date"
                                                       value="{{ old('amc_start_date') }}"/>
                                                @if ($errors->has('amc_start_date'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('amc_start_date') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">AMC Renewal Date</label>
                                                <input class="form-control form-control-sm form-control-solid flatpickr"
                                                       type="text" id="common_dob" name="amc_renewal_date"
                                                       value="{{ old('amc_renewal_date') }}"/>
                                                @if ($errors->has('amc_renewal_date'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('amc_renewal_date') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">AMC Rate (%)</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="number" name="amc_rate" value="{{ old('amc_rate') }}"
                                                       step="0.01"/>
                                                @if ($errors->has('amc_rate'))
                                                    <div class="text-danger">{{ $errors->first('amc_rate') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Rental Amount</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="number" name="rental_amount"
                                                       value="{{ old('rental_amount') }}"/>
                                                @if ($errors->has('rental_amount'))
                                                    <div class="text-danger">{{ $errors->first('rental_amount') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">AMC Effective
                                                    Amount</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="number" name="amc_effective_amount"
                                                       value="{{ old('amc_effective_amount') }}"/>
                                                @if ($errors->has('amc_effective_amount'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('amc_effective_amount') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">AMC Agreement
                                                    Documents</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="file" name="amc_agreement_documents"/>
                                                @if ($errors->has('amc_agreement_documents'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('amc_agreement_documents') }}</div>
                                                @endif
                                            </div>

                                            <div class="col-md-4">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Service Type</label>
                                                    <select class=" form-control form-control-sm form-control-solid"
                                                            name="service_type"
                                                            aria-label="Default select example">
                                                        <option value="">Select Service Type</option>
                                                        <option
                                                            value="Yearly" {{ old('service_type') == 'Yearly' ? 'selected' : '' }}>
                                                            Yearly
                                                        </option>
                                                        <option
                                                            value="Half-Yearly" {{ old('service_type') == 'Half-Yearly ' ? 'selected' : '' }}>
                                                            Half-Yearly
                                                        </option>
                                                        <option
                                                            value="Quarterly" {{ old('service_type') == 'Quarterly' ? 'selected' : '' }}>
                                                            Quarterly
                                                        </option>
                                                        <option
                                                            value="Monthly" {{ old('service_type') == 'Monthly ' ? 'selected' : '' }}>
                                                            Monthly
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Software Value</label>
                                                <textarea class="form-control form-control-sm form-control-solid"
                                                          name="software_value"
                                                          rows="3">{{ old('software_value') }}</textarea>
                                                @if ($errors->has('software_value'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('software_value') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Hardware Value</label>
                                                <textarea class="form-control form-control-sm form-control-solid"
                                                          name="hardware_value"
                                                          rows="3">{{ old('hardware_value') }}</textarea>
                                                @if ($errors->has('hardware_value'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('hardware_value') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Implementation
                                                    Cost</label>
                                                <textarea class="form-control form-control-sm form-control-solid"
                                                          name="implementation_value"
                                                          rows="3">{{ old('implementation_value') }}</textarea>
                                                @if ($errors->has('implementation_value'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('implementation_value') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Invoice Mushak
                                                    File</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="file" name="invoice_mushak_file"/>
                                                @if ($errors->has('invoice_mushak_file'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('invoice_mushak_file') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Tax Exemption
                                                    Certificate</label>
                                                <input class="form-control form-control-sm form-control-solid"
                                                       type="file" name="tax_exemption_certificate"/>
                                                @if ($errors->has('tax_exemption_certificate'))
                                                    <div
                                                        class="text-danger">{{ $errors->first('tax_exemption_certificate') }}</div>
                                                @endif
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label fw-bolder text-dark">Note</label>
                                                <textarea class="form-control form-control-sm form-control-solid"
                                                          name="note" rows="3">{{ old('note') }}</textarea>
                                                @if ($errors->has('note'))
                                                    <div class="text-danger">{{ $errors->first('note') }}</div>
                                                @endif
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
    <!--end::Proposal drawer-->

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
        var phone_no = @json($lead->phone);
        const ticketUrl = "http://192.168.11.220/";
        document.getElementById("ticketListBtn").style.display = 'none';

        function showLoader() {
            document.getElementById('loader').style.display = 'flex';
        }

        // Hide the full-page loader
        function hideLoader() {
            document.getElementById('loader').style.display = 'none';
        }

        function getTickets(phone_no) {
            showLoader();
            const ticketListUrl = ticketUrl + "ticket_crm/ticket_crm_api.php?TYPE=TICKET_LIST_BY_MOBILE&CLI=" + phone_no;

            fetch(ticketListUrl)
                .then(response => response.json())
                .then(data => {
                    populateTable(data);
                    hideLoader();
                })
                .catch(error => {
                    //console.error('Error fetching data:', error);
                    //alert('Failed to load the ticket creation form. Please try again.');
                });
        }

        function populateTable(data) {
            const tableBody = document.getElementById('ticketTable').getElementsByTagName('tbody')[0];

            tableBody.innerHTML = '';

            data.forEach(ticket => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td><a href="#" onclick="getTicketReplyFrame(${ticket.ticket_id})">${ticket.ticket_id || 'N/A'}</a></td>
                <td>${ticket.subject || 'N/A'}</td>
                <td>${ticket.group_name || 'N/A'}</td>
                <td>${ticket.status_name || 'N/A'}</td>
                `;

                tableBody.appendChild(row);
            });
        }

        // document.getElementById('g_lead_tickets_tab').addEventListener('click', function() {
        // getTickets(phone_no);

        // });

        function getTicketReplyFrame(ticket_id) {
            const ticketReplyUrl = ticketUrl + "ticket_crm/ticket_crm_api.php?TYPE=TICKET_REPLY&TICKET_ID=" + ticket_id;
            showLoader();
            document.getElementById("ticketListBtn").style.display = '';
            document.getElementById("createTicketButton").style.display = '';
            document.getElementById("ticketTable").style.display = 'none';
            fetch(ticketReplyUrl)
                .then(response => response.json())
                .then(data => {
                    const iframeHtml = data[0].iframe;
                    const iframeContainer = document.getElementById('ticketIframeContainer');
                    iframeContainer.innerHTML = iframeHtml;
                    iframeContainer.style.display = 'block';
                    hideLoader();
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('Failed to load the ticket creation form. Please try again.');
                });
        }

        document.getElementById('createTicketButton').addEventListener('click', function () {
            document.getElementById("ticketListBtn").style.display = '';
            document.getElementById("createTicketButton").style.display = 'none';
            document.getElementById("ticketTable").style.display = 'none';
            const ticketListUrl = ticketUrl + "ticket_crm/ticket_crm_api.php?TYPE=TICKET_CREATE&CLI=" + phone_no;
            showLoader();

            fetch(ticketListUrl)
                .then(response => response.json())
                .then(data => {
                    const iframeHtml = data[0].iframe;
                    const iframeContainer = document.getElementById('ticketIframeContainer');
                    iframeContainer.innerHTML = iframeHtml;
                    iframeContainer.style.display = 'block';
                    hideLoader();
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('Failed to load the ticket creation form. Please try again.');
                });
        });

        document.getElementById('ticketListBtn').addEventListener('click', function () {
            document.getElementById("ticketIframeContainer").style.display = 'none';
            document.getElementById("ticketListBtn").style.display = 'none';
            document.getElementById("createTicketButton").style.display = '';
            document.getElementById("ticketTable").style.display = '';
            getTickets(phone_no);
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
