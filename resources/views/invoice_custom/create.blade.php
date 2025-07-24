@extends('layouts.master')

@section('content')

<!-- <div class="content d-flex flex-column flex-column-fluid" id="kt_content"> -->

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">

    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Custom Invoice Forms
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Custom Invoice form</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->

            <!--end::Wrapper-->
            <!--begin::Button-->
            <a href="{{ route('invoice-custom-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Custom Invoice List</a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--begin::Container-->

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
                <!-- <div class="card card-xxl-stretch"> -->
                <div class="card-header bg-light bd-cyan">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Custom Invoice Create</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form w-100" action="{{ route('invoice-custom-store') }}" enctype="multipart/form-data" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Invoice Name</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="invoice_name" value="{{ old('invoice_name') }}" autocomplete="off" />
                                    @if ($errors->has('invoice_name'))
                                    <span class="text-danger">{{ $errors->first('invoice_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        
                        <div class="row justify-content-center align-items-center mb-3">
                            <div class="col-md-6">
                                <h3>Item Section</h3>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-sm btn-success" onclick="addItemField()"><i class="bi bi-plus-lg"></i> Add Field</button>
                            </div>
                        </div>

                        
                        <div id="item-field-group-container">
                            <div class="row mb-3 item-field-group">
                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Name</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="field_details[0][field_name]" autocomplete="off" />
                                        @error('field_details.0.field_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Sum</label>
                                        <select class="form-control form-control-sm form-control-solid" name="field_details[0][is_sum]">
                                            <option value=''>Select</option>
                                            <option value='1'>Yes</option>
                                            <option value='0'>No</option>
                                        </select>   
                                        {{-- @error('field_details.0.is_sum')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror --}}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Is Mandatory</label>
                                        <select class="form-control form-control-sm form-control-solid" name="field_details[0][is_mandatory]">
                                            <option value=''>Select</option>
                                            <option value='1'>Yes</option>
                                            <option value='0'>No</option>
                                        </select>   
                                        {{-- @error('field_details.0.is_mandatory')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror --}}
                                    </div>
                                </div>

                                <div class="col-md-2 text-center" style="padding-top: 1.5rem;">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeItemField(this)"><i class="bi bi-x"></i></button>
                                </div>
                            </div>
                        </div>

                       
                        {{-- <div class="row justify-content-center align-items-center mb-3">
                            <div class="col-md-6">
                                <h3>Footer Section</h3>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-sm btn-success" onclick="addFooterField()"><i class="bi bi-plus-lg"></i> Add Field</button>
                            </div>
                        </div> --}}

                       
                        {{-- <div id="footer-field-group-container">
                            <div class="row mb-3 footer-field-group">
                                <div class="col-md-4">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Name</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="footer_details[0][field_name]" autocomplete="off" />
                                        @error('footer_details.0.field_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Value</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="footer_details[0][field_value]" autocomplete="off" />
                                        @error('footer_details.0.field_value')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 text-center" style="padding-top: 1.5rem;">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeFooterField(this)"><i class="bi bi-x"></i></button>
                                </div>
                            </div>
                        </div> --}}

                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark">Total in Words</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="total_in_word" value="Yes" id="total-in-words-yes" {{ old('total_in_word') == 'Yes' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="total-in-words-yes">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="total_in_word" value="No" id="total-in-words-no" {{ old('total_in_word') == 'No' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="total-in-words-no">No</label>
                                    </div>
                                    @if ($errors->has('total_in_word'))
                                    <span class="text-danger">{{ $errors->first('total_in_word') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark">Bank Details</label>
                                    <textarea class="form-control form-control-sm form-control-solid editor" name="bank_details" rows="3">{{ old('bank_details') }}</textarea>
                                    @if ($errors->has('bank_details'))
                                    <span class="text-danger">{{ $errors->first('bank_details') }}</span>
                                    @endif
                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark">Issued By</label>
                                    <textarea class="form-control form-control-sm form-control-solid editor" name="issued_by" rows="3">{{ old('issued_by') }}</textarea>
                                    @if ($errors->has('issued_by'))
                                    <span class="text-danger">{{ $errors->first('issued_by') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('invoice-custom-create') }}" class="btn btn-light me-2">Reset</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
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



<script>
    let itemFieldIndex = 1;
    let footerFieldIndex = 1;

    // Function to add new item field
    function addItemField() {
        const container = document.getElementById('item-field-group-container');
        const newItemFieldGroup = document.createElement('div');
        newItemFieldGroup.className = 'row mb-3 item-field-group';

        newItemFieldGroup.innerHTML = `
            <div class="col-md-2">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Field Name</label>
                    <input class="form-control form-control-sm form-control-solid" type="text" name="field_details[${itemFieldIndex}][field_name]" autocomplete="off" />
                </div>
            </div>

            <div class="col-md-2">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Sum</label>
                    <select class="form-control form-control-sm form-control-solid" name="field_details[${itemFieldIndex}][is_sum]">
                        <option value=''>Select</option>
                        <option value='1'>Yes</option>
                        <option value='0'>No</option>
                    </select>   
                </div>
            </div>

            <div class="col-md-2">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Is Mandatory</label>
                    <select class="form-control form-control-sm form-control-solid" name="field_details[${itemFieldIndex}][is_mandatory]">
                        <option value=''>Select</option>
                        <option value='1'>Yes</option>
                        <option value='0'>No</option>
                    </select>   
                </div>
            </div>

            <div class="col-md-2 text-center" style="padding-top: 1.5rem;">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeItemField(this)"><i class="bi bi-x"></i></button>
            </div>
        `;

        container.appendChild(newItemFieldGroup);
        itemFieldIndex++;
    }

    // Function to remove item field
    function removeItemField(button) {
        const fieldGroup = button.closest('.item-field-group');
        fieldGroup.remove();
    }

    // Function to add new footer field
    // function addFooterField() {
    //     const container = document.getElementById('footer-field-group-container');
    //     const newFooterFieldGroup = document.createElement('div');
    //     newFooterFieldGroup.className = 'row mb-3 footer-field-group';

    //     newFooterFieldGroup.innerHTML = `
    //         <div class="col-md-4">
    //             <div class="fv-row">
    //                 <label class="form-label fw-bolder text-dark">Field Name</label>
    //                 <input class="form-control form-control-sm form-control-solid" type="text" name="footer_details[${footerFieldIndex}][field_name]" autocomplete="off" />
    //             </div>
    //         </div>

    //         <div class="col-md-4">
    //             <div class="fv-row">
    //                 <label class="form-label fw-bolder text-dark">Field Value</label>
    //                 <input class="form-control form-control-sm form-control-solid" type="text" name="footer_details[${footerFieldIndex}][field_value]" autocomplete="off" />
    //             </div>
    //         </div>

    //         <div class="col-md-4 text-center" style="padding-top: 1.5rem;">
    //             <button type="button" class="btn btn-sm btn-danger" onclick="removeFooterField(this)"><i class="bi bi-x"></i></button>
    //         </div>
    //     `;

    //     container.appendChild(newFooterFieldGroup);
    //     footerFieldIndex++;
    // }

    // Function to remove footer field
    // function removeFooterField(button) {
    //     const fieldGroup = button.closest('.footer-field-group');
    //     fieldGroup.remove();
    // }
</script>

<script>
    $(document).ready(function() {
        $('.editor').summernote({
            height: 0, // set the height to 200px
            toolbar: [
                // customize toolbar options as needed
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
    });
</script>

<!-- End Forms-->


<!-- </div> -->
<!--end::Content-->


@endsection