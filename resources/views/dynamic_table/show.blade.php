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
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dynamic Table Details
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Dynamic Table Details</small>
                    <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center py-1">

                <a href="{{ route('dynamictable-index') }}" class="btn btn-sm btn-primary"
                   id="kt_toolbar_primary_button">Dynamic Table List</a>
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
            <div class="col-xxl-12 mx-auto">
                <div class="card mt-4">
                    <div class="card-header bg-light bd-cyan">
                        <div class="card-title">
                            <h2>Dynamic Table Details</h2>
                        </div>
                    </div>
                    <!--begin::Body-->
                    <div class="card-body p-1">


                        <div class="table-responsive">
                            @if($dynamicTableDetails->isNotEmpty())
                                <h4>Table Name: {{ $tableName }}</h4>
                                <!--begin::Table-->
                                <table
                                    class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr class="fw-bolder">
                                        <th class="min-w-150px">SL</th>
                                        <!-- <th class="min-w-150px">Form ID</th> -->
                                        <th class="min-w-150px">Field Name</th>
                                        <th class="min-w-140px">Field Value</th>
                                        <th class="min-w-140px">Is Index</th>
                                        <th class="min-w-140px">Is Null</th>
                                        <th class="min-w-140px">Is Unique</th>

                                    </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                    @foreach ($dynamicTableDetails  as $detail)
                                        <tr>

                                            <td class="text-dark fs-6">{{$loop->iteration}}</td>

                                            <td class="text-dark fs-6">{{ $detail->field_name }}</td>
                                            <td class="text-dark fs-6">{{ $detail->field_value }}</td>
                                            <td class="text-dark fs-6">{{ $detail->is_index ? 'Yes' : 'No' }}</td>
                                            <td class="text-dark fs-6">{{ $detail->is_null ? 'Yes' : 'No' }}</td>
                                            <td class="text-dark fs-6">{{ $detail->is_unique ? 'Yes' : 'No' }}</td>


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


                    </div>


                </div>

            </div>
        </div>
    </div>


    <!-- End Tables View-->


    <!-- </div> -->
    <!--end::Content-->

@endsection
