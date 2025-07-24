@extends('layouts.master')

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
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Send SMS
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the send SMS form</small>
                    <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <a href="{{ route('send-sms-list') }}" class="btn btn-sm btn-primary">SMS List</a>

        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->

    <!--**********************************
                    Forms
      ***********************************-->
    <div class="container-xxl">
        <div class="row">
            <div class="col-xxl-8 mx-auto">
                <div class="card card-xxl-stretch mt-4">
                    <div class="card-header bg-light bd-cyan">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bolder m-0">Send Bulk SMS</h3>
                        </div>
                        <!--end::Card title-->
                    </div>

                    <!-- Card Body-->
                    <div class="card-body">

                        <!-- Start Form-->

                        <form class="g-form w-100" action="{{ route('send-bulk-sms-pro') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            {{-- <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Select Lead</label>
                                    <select class=" form-control form-control-sm form-control-solid" name="status"
                                            aria-label="Default select example">
                                        <option value=''>Select</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Mobile No.<span
                                                class="text-danger">*</span></label>
                                        <input type="file" name="file"
                                               class="form-control form-control-sm form-control-solid">
                                        <span class="text-danger">csv, xlsx, xls allowed.</span>
                                        @if ($errors->has('file'))
                                            <span class="text-danger">{{ $errors->first('file') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">SMS Template</label>
                                        <select class=" form-control form-control-sm form-control-solid"
                                                name="template_id" id="template_id" aria-label="Default select example">
                                            <option value=''>Select</option>
                                            @foreach($templates as $template)
                                                <option
                                                    value="{{$template->id}}" {{ old('template_id') == $template->id ? 'selected' : '' }}>{{ $template->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label fw-bolder text-dark" for="textarea">Content<span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-sm  form-control-solid"
                                                  name="sms_text" id="sms_text"
                                                  rows="5">{{ old('sms_text') }}</textarea>
                                        @if ($errors->has('sms_text'))
                                            <span class="text-danger">{{ $errors->first('sms_text') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--End Row-->
                            <div class="d-flex justify-content-end mt-5">
                                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
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

@endsection

@section('endScript')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const templates = @json($templates);

            document.getElementById('template_id').addEventListener('change', function () {
                const selectedId = this.value;
                const selectedTemplate = templates.find(template => template.id == selectedId);
                if (selectedTemplate) {
                    document.getElementById('sms_text').innerText = selectedTemplate.description;
                } else {
                    document.getElementById('sms_text').innerText = '';
                }
            });

            document.getElementById('reset_btn').addEventListener('click', function () {
                document.getElementById('sms_text').innerText = '';
            });
        });
    </script>
@endsection
