@extends('layouts.master')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Lead Upload
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Here is Lead Upload</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->


    <!--**********************************
                                Tables View
                  ***********************************-->
    <div class="container-fluid">
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500
            });
        </script>
        @endif

        @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{!! session('error') !!}',
                showConfirmButton: false,
                timer: 2500
            });
        </script>
        @endif
        <div class="row">
            <div class="col-xxl-8 mx-auto">
                <div class="card mb-5">
                    <div class="card-header">
                        <div class="card-title w-100">
                            <div class="d-flex flex-wrap justify-content-between align-items-center w-100">


                                <h2>Lead File Upload Here</h2>
                               
                                    <a href="{{ route('campaign-sample-file', ['template_type' => $campaign->template_type]) }}" role="button" class="btn btn-sm btn-success d-flex align-items-center">
                                    <i class="bi bi-file-earmark-text-fill fs-2"></i> Download Sample File
                                </a>
                            </div>

                        </div>
                    </div>
                    <!--begin::Body-->
                    <div class="card-body py-5">
                        <!-- Upload  -->
                        <form id="file-upload-form" class="uploader" action="{{ route('campaign-lead-upload-file') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input id="file-upload" type="file" name="fileUpload" accept=".csv" />
                            <input type="hidden" name="campaign_id" value="{{ $campaign->id }}" />
                            <input type="hidden" name="email_template_id" value="{{ $campaign->email_template_id }}" />
                            <input type="hidden" name="sms_template_id" value="{{ $campaign->sms_template_id }}" />
                            <input type="hidden" name="template_type" value="{{ $campaign->template_type }}" />
                           

                            <label for="file-upload" id="file-drag">
                                <img id="file-image" src="#" alt="Preview" class="hidden">
                                <div id="start">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    <div>Select a CSV file or drag here(Ex.sample-file.csv)</div>
                                    <div id="notimage" class="hidden">Please select a CSV file</div>
                                    <span id="file-upload-btn" class="btn btn-primary">Select a file</span>

                                </div>
                               
                                <div id="response" class="hidden">
                                    <div id="messages"></div>
                                    <progress class="progress" id="file-progress" value="0">
                                        <span>0</span>%
                                    </progress>
                                </div>
                            </label>
                            <div class="text-center">
                            <button type="submit" class="btn btn-success mt-3 ">Upload</button>
                            </div>

                        </form>


                    </div>

                    <!--begin::Body-->

                </div>


            </div>
        </div>
    </div>

    <!-- End Tables View-->


</div>
<!--end::Content-->




<!-- </div> -->
<!--end::Content-->


@endsection