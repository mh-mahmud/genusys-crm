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
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Customer Form
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the form</small>
                                <!--end::Description--></h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">
                            <!--begin::Button-->
                            <a href="{{ route('customers') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Customer List</a>
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
                                        <h3 class="fw-bolder m-0">Add Customer</h3>
                                    </div>
                                    <!--end::Card title-->
                                </div>

                                <!-- Card Body-->
                                <div class="card-body">

                                    <!-- Start Form-->

                                    <form class="g-form w-100" action="{{ route('post-add-customer') }}"  enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $cus->id }}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">First Name</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" readonly name="first_name" value="{{$cus->first_name}}"/>
                                                    @if ($errors->has('first_name'))
                                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Last Name</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" readonly name="last_name" value="{{$cus->last_name}}"/>
                                                    @if ($errors->has('last_name'))
                                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Phone</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" readonly name="phone" value="{{$cus->phone}}"/>
                                                    @if ($errors->has('phone'))
                                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Email</label>
                                                    <input class="form-control form-control-sm form-control-solid" type="text" readonly name="email" value="{{$cus->email}}"/>
                                                    @if ($errors->has('email'))
                                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Customer ID</label>
                                                    <input class="form-control form-control-sm form-control-solid" readonly type="text" name="customer_id" autocomplete="off" value="{{ $rand_str }}" />
                                                    @if ($errors->has('customer_id'))
                                                        <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Product</label>
                                                    <select class=" form-control form-control-sm form-control-solid" id="product_id" name="product_id" aria-label="Default select example">
                                                        <option value=''>Select</option>
                                                        @foreach($products as $product)
                                                            <option value="{{$product->id}}">{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>

                                                    @if ($errors->has('product_id'))
                                                        <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                                    @endif
                                                </div>
                                            </div> -->

                                            <div class="col-md-6">
                                                <label class="form-label fw-bolder text-dark">Product</label>
                                                <select id="product-select" class="form-control form-control-sm form-control-solid"
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

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Customer Group</label>
                                                    <select class=" form-control form-control-sm form-control-solid" id="customer_group" name="customer_group" aria-label="Default select example">
                                                        <option value=''>Select</option>
                                                        @foreach($groups as $key=>$val)
                                                            <option value="{{$val}}">{{ $val }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Customer Listing Date</label>
                                                    <input class="form-control form-control-sm form-control-solid flatpickr" type="text" id="common_dob" name="customer_listing_date" value="{{ old('customer_listing_date') }}" />
                                                    @if ($errors->has('customer_listing_date'))
                                                    <div class="text-danger">{{ $errors->first('customer_listing_date') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                           <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Customer Notes</label>
                                                    <textarea class="form-control form-control-sm  form-control-solid" name="customer_notes" rows="3"></textarea>
                                                </div>
                                            </div>

                                     </div>
                                        <!--End Row-->
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <a href="{{ route('leadsform-create') }}" class="btn btn-light me-2">Back</a>
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

<script>

document.addEventListener('DOMContentLoaded', function() {
        $('#product-select').select2({
            placeholder: "Select Products",
            allowClear: true,
        });
    });
</script>


@endsection
