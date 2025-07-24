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
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Blog Form
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Blog Form</small>
                                <!--end::Description--></h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">
                            <!--begin::Button-->
                            <a href="{{ route('blog-list') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Blog List</a>
                            <!--end::Button-->
                        </div>
                        <!--end::Actions-->
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
                                        <h3 class="fw-bolder m-0">Create Blog</h3>
                                    </div>
                                    <!--end::Card title-->
                                </div>

                                <!-- Card Body-->
                                <div class="card-body">

                                    <!-- Start Form-->

                                    <form class="g-form w-100" action="{{ route('blog-store') }}"  enctype="multipart/form-data" method="POST">
                                         @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Blog Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid" type="text" name="blog_name" autocomplete="off"/>
                                                    <!--end::Input-->
                                                    @if ($errors->has('blog_name'))
                                                        <span class="text-danger">{{ $errors->first('blog_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Category Name</label>
                                                    <select class=" form-control form-control-sm form-control-solid" name="blog_category_id" aria-label="Default select example">
                                                            <option value="">Select Category</option>
                                                            @foreach($parents as $id => $name)
                                                                <option value="{{ $id }}">{{$name}}</option>
                                                            @endforeach
                                                    </select>
                                                    @if ($errors->has('blog_category_id'))
                                                        <span class="text-danger">{{ $errors->first('blog_category_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label  fw-bolder text-dark">Upload Blog Image</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="file" name="blog_image" autocomplete="off"/>
                                                    @if ($errors->has('blog_image'))
                                                        <span class="text-danger">{{ $errors->first('blog_image') }}</span>
                                                    @endif
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

                                           <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Blog Description</label>
                                                    <textarea class="form-control form-control-sm editor form-control-solid" name="blog_description" rows="3"></textarea>
                                                    @if ($errors->has('blog_description'))
                                                        <span class="text-danger">{{ $errors->first('blog_description') }}</span>
                                                    @endif
                                                </div>
                                            </div>



                                     </div>
                                        <!--End Row-->
                                      <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Submit</button>
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


@endsection
@section('endScript')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var summernoteElement = document.querySelectorAll('.editor');         
            document.getElementById('resetButton').addEventListener('click', function() {
                $(summernoteElement).summernote('code', ''); // Clear the content of Summernote
            });
        });
    </script>
@endsection