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
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Proposal Details
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Proposal Details</small>
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
                             Tables View
    ***********************************-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-8 mx-auto">
                <!-- <div class="card mb-5"> -->
                <div class="card mt-4">
                    <div class="card-header bg-light bd-cyan">
                        <div class="card-title">
                            <h2>Proposal Details</h2>
                        </div>
                    </div>
                    <!--begin::Body-->
                    <div class="card-body p-1">

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">File</span>
                            <div class="me-7 mb-4">
                                <div class="symbol symbol-100px symbol-lg-140px symbol-fixed position-relative">
                                    @if($data->proposal_file_name != '')
                                        <a href="{{ url('uploads/proposals/'.$data->proposal_file_name) }}" download="{{$data->proposal_file_name}}"><img src="{{ asset('uploads/common/file-test.png') }}" alt="{{ $data->proposal_file_name }}"></a>
                                    @else
                                        <img alt="Logo" src="{{ asset('uploads/common/no-file.png') }}"/>
                                    @endif



                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Subject</span>
                            <span>{{ $data->subject }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Company Name</span>
                            <span>{{ $data->company_name }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Full Name</span>
                            <span>{{ $data->first_name }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Send To</span>
                            <span>{{ $data->send_to }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Proposal Date</span>
                            <span>{{ date("Y-m-d", strtotime($data->start_date)) }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Exripe Date</span>
                            <span>{{ date("Y-m-d", strtotime($data->end_date)) }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Address</span>
                            <span>{{ $data->address }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">City</span>
                            <span>{{ $data->city }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">State</span>
                            <span>{{ $data->state }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Zip Code</span>
                            <span>{{ $data->zip_code }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Country Name</span>
                            <span>{{ $data->country_name }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Phone</span>
                            <span>{{ $data->phone }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Offer Details</span>
                            <span>
                                <table class="table table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered table-bordered">
                                    <thead>
                                    <tr class="fw-bolder bg-light ">
                                        <th>Item Name</th>
                                        <th>Item Description</th>
                                        <th>Price</th>
                                        <th>Offer Price</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>Tax Amount</th>
                                        <th>Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ $data->item_name }}</td>
                                        <td>{{ $data->item_description }}</td>
                                        <td>{{ $data->price }}</td>
                                        <td>{{ $data->offer_price }}</td>
                                        <td>{{ $data->discount }}</td>
                                        <td>{{ $data->tax_percent }}</td>
                                        <td>{{ $data->tax_amount }}</td>
                                        <td>{{ $data->total_price }}</td>
                                    </tr>
                                </tbody>
                                </table>
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Proposal Status</span>
                            <span>{{ $data->status }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                            <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Createed At</span>
                            <span>{{ $data->created_at }}</span>
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
