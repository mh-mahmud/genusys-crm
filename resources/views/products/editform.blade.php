@extends('layouts.master')

@section('content')

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Product Form
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up Product Form</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->
            <div class="me-4">
                <!--begin::Button-->
                <a href="{{ route('product-form-index') }}" class="btn btn-sm btn-primary">Product Form List</a>
                <!--end::Button-->
            </div>
            <!--end::Wrapper-->
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
                        <h3 class="fw-bolder m-0">Product Form Edit</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->
                    <form class="g-form w-100" action="{{ route('product-form-update', $tableDetails[0]->template_id) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-sm btn-success" onclick="addField()"><i class="bi bi-plus-lg"></i> Add Field</button>
                            </div>
                        </div> -->

                        <div class="row">
                            <input type="hidden" name="template_id" value="{{ $tableDetails[0]->template_id }}">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Template Name</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="template_name" value="{{ old('template_name', $tableDetails[0]->template_name) }}" autocomplete="off" />
                                    @if ($errors->has('template_name'))
                                    <span class="text-danger">{{ $errors->first('template_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        {{--<div class="row mb-3">
                            <div class="col-md-12" style="text-align: right;">
                                <button type="button" class="btn btn-sm btn-success" onclick="addField()"><i class="bi bi-plus-lg"></i> Add Field</button>
                            </div>
                        </div>--}}

                        <div class="row justify-content-center align-items-center mb-3">
                            <div class="col-md-6 d-flex gap-4">
                                
                            </div>


                            <div class="col-md-6" style="text-align: right;">
                                <button type="button" class="btn btn-sm btn-success" onclick="addField()"><i
                                        class="bi bi-plus-lg"></i> Add Field
                                </button>
                            </div>
                        </div>

                        <div id="fields">
                            @foreach($tableDetails as $key => $detail)
                            <div class="row mb-3 field-group">
                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Name</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="fields[{{ $key }}][name]" value="{{ $detail->field_name }}" autocomplete="off" />
                                        @if ($errors->has("fields.{$key}.name"))
                                        <span class="text-danger">{{ $errors->first("fields.{$key}.name") }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Value</label>
                                        <select class="form-control form-control-sm form-control-solid" name="fields[{{ $key }}][type]" aria-label="Default select example">
                                            <option value="">Select Field Value</option>
                                            <option value="varchar" {{ $detail->field_value == 'varchar' ? 'selected' : '' }}>String</option>
                                            <option value="char" {{ $detail->field_value == 'char' ? 'selected' : '' }}>Character</option>
                                            <option value="int" {{ $detail->field_value == 'int' ? 'selected' : '' }}>Integer</option>
                                            <option value="date" {{ $detail->field_value == 'date' ? 'selected' : '' }}>Date</option>
                                            <option value="text" {{ $detail->field_value == 'text' ? 'selected' : '' }}>Text</option>
                                            <option value="boolean" {{ $detail->field_value == 'boolean' ? 'selected' : '' }}>Boolean</option>
                                            <option value="file" {{ $detail->field_value == 'file' ? 'selected' : '' }}>File</option>
                                            <option value="dropdown" {{ $detail->field_value == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                                        </select>
                                        @if ($errors->has("fields.{$key}.type"))
                                        <span class="text-danger">{{ $errors->first("fields.{$key}.type") }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Character Length</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="fields[{{ $key }}][character_length]" value="{{ $detail->character_length }}" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row mt-8 text-center" style="padding-left:34px">
                                        <button type="button" class="btn btn-sm btn-danger p-1 py-0" onclick="removeField(this)"><i class="bi bi-x pe-0 pb-1"></i></button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-sm btn-success" onclick="addField()"><i class="bi bi-plus-lg"></i> Add Field</button>
                            </div>
                        </div> -->

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update Changes</button>
                        </div>
                    </form>
                    <!-- End Form-->
                </div>
                <!--End Card body-->
            </div>
        </div>
    </div>
</div>

<script>
    function addField() {
        const fields = document.getElementById('fields');
        const index = fields.children.length;
        const template = `
        <div class="row mb-3 field-group">
            <div class="col-md-2">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Field Name</label>
                    <input class="form-control form-control-sm form-control-solid" type="text" name="fields[${index}][name]" autocomplete="off" />
                </div>
            </div>
            <div class="col-md-2">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Field Value</label>
                    <select class="form-control form-control-sm form-control-solid" name="fields[${index}][type]" aria-label="Default select example">
                        <option value="">Select Field Value</option>
                        <option value="varchar">String</option>
                        <option value="char">Character</option>
                        <option value="int">Integer</option>
                        <option value="date">Date</option>
                        <option value="text">Text</option>
                        <option value="boolean">Boolean</option>
                        <option value="file">File</option>
                        <option value="dropdown">Dropdown</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Character Length</label>
                    <input class="form-control form-control-sm form-control-solid" type="text" name="fields[${index}][character_length]" autocomplete="off" />
                </div>
            </div>

            <div class="col-md-2">
                <div class="fv-row mt-8 text-center" style="padding-left:34px">
                    <button type="button" class="btn btn-sm btn-danger p-1 py-0" onclick="removeField(this)"><i class="bi bi-x pe-0 pb-1"></i></button>
                </div>
            </div>
        </div>`;
        fields.insertAdjacentHTML('beforeend', template);
    }

    function removeField(button) {
        const fieldGroup = button.closest('.field-group');
        fieldGroup.remove();
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const formViewRadio = document.getElementById('form_view');
        const tableViewRadio = document.getElementById('table_view');
        const formSizeContainer = document.getElementById('form_size_container');
        const formSizeSelect = document.querySelector('select[name="form_size"]');

        function toggleFormSize() {
            if (formViewRadio.checked) {
                formSizeContainer.style.display = 'block';
            } else {
                formSizeContainer.style.display = 'none';
                formSizeSelect.value = ''; // Ccear the form_size value
            }
        }

        formViewRadio.addEventListener('change', toggleFormSize);
        tableViewRadio.addEventListener('change', toggleFormSize);

        // initial call to set the correct display based on the selected view type
        toggleFormSize();
    });
</script>

@endsection
