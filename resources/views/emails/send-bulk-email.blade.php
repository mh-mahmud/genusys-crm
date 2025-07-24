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
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Send Email
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Send Email Form</small>
                    <!--end::Description--></h1>
                <!--end::Title-->
            </div>
            <a href="{{ route('send-email-list') }}" class="btn btn-sm btn-primary">Email List</a>
            <!--end::Page title-->
        </div>
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
                            <h3 class="fw-bolder m-0">Send Bulk Email</h3>
                        </div>
                        <!--end::Card title-->
                    </div>

                    <!-- Card Body-->
                    <div class="card-body">

                        <!-- Start Form-->

                        <form class="g-form w-100" action="{{ route('send-bulk-email-process') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Email<span
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
                                        <label class="form-label fw-bolder text-dark">Email Template</label>
                                        <select class=" form-control form-control-sm form-control-solid"
                                                id="template_id" name="template_id"
                                                aria-label="Default select example">
                                            <option value=''>Select</option>
                                            @foreach($templates as $template)
                                                <option
                                                    value="{{$template->id}}">{{ $template->email_subject }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Email Subject<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control form-control-sm form-control-solid"
                                               type="text" id="email_subject" name="email_subject" autocomplete="off"
                                               value="{{ old('email_subject') }}"/>
                                        @if ($errors->has('email_subject'))
                                            <span class="text-danger">{{ $errors->first('email_subject') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label fw-bolder text-dark" for="textarea">Content<span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-sm  form-control-solid editor"
                                                  id="email_content" name="email_content"
                                                  rows="3">{{ old('email_content') }}</textarea>
                                        @if ($errors->has('email_content'))
                                            <span class="text-danger">{{ $errors->first('email_content') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end pt-5">
                                <input type="reset" id="resetButton" value="Reset" class="btn btn-light me-2">
                                <button type="submit" class="btn btn-primary"
                                        id="kt_account_profile_details_submit">Send
                                </button>
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
                    // document.getElementById('email_subject').value = selectedTemplate.email_subject;
                    $('.editor').summernote('code', selectedTemplate.email_content);

                } else {
                    // document.getElementById('email_subject').value = '';
                    $('.editor').summernote('code', '');

                }
            });

            var summernoteElement = document.querySelectorAll('.editor');
            document.getElementById('resetButton').addEventListener('click', function () {
                $(summernoteElement).summernote('code', ''); // Clear the content of Summernote
            });
        });
    </script>
@endsection
