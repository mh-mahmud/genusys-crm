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
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Product
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Product</small>
                                <!--end::Description--></h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">

                            <a href="{{ route('product-list') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Product List</a>
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
                                <div class="card-header align-items-center bg-light bd-cyan">
                                    <!--begin::Card title-->
                                    <div class="card-title d-flex justify-content-between m-0">
                                        <h3 class="fw-bolder m-0">Product Create</h3>
                                    </div>
                                    <!--end::Card title-->
                                    @include('help-section.help')
                                </div>

                                <!-- Card Body-->
                                <div class="card-body">

                                    <!-- Start Form-->

                                    <form class="g-form w-100" action="{{ route('add-product-pro') }}"  method="POST" enctype="multipart/form-data">
                                         @csrf
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

                                            <div class="row" id="custom-fields">

                                            </div>

                                        </div>

                                        <div class="card-footer d-flex gap-2 justify-content-end align-items-center p-2">
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
    // $(document).ready(function() {
    //     $("#product-template").on("change", function() {
    //         var loka = $(this).val();
    //         alert(loka);
    //     });
    // });

$(document).ready(function() {
    $('#product-template').on('change', function() {
        var templateId = $(this).val();
        var urldata = "{{route('get-template-fields')}}";

        if (templateId) {
            $.ajax({
                url: urldata,   // route URL
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    template_id: templateId
                },
                success: function(response) {
                    // Replace or append HTML
                    $('#custom-fields').html(response.html);
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        } else {
            $('#custom-fields').empty();
        }
    });
});


</script>
@endsection