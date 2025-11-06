@extends('layouts.master')

@section('content')

<!-- <div class="content d-flex flex-column flex-column-fluid" id="kt_content"> -->

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Product Template
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up Product Template </small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <a href="{{ route('dynamictable-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Product Template List</a>
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
                        <h3 class="fw-bolder m-0">Product Template Form</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body pt-1">

                    <!-- Start Form-->
                    <form class="g-form w-100" action="{{ route('product-form-store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Product Form Name</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="template_name" autocomplete="off" />
                                    @if ($errors->has('template_name'))
                                    <span class="text-danger">{{ $errors->first('template_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row justify-content-center align-items-center mb-3">


                            <div class="col-md-6" style="text-align: right;">
                                <button type="button" class="btn btn-sm btn-success" onclick="addField()"><i
                                        class="bi bi-plus-lg"></i> Add Field
                                </button>
                            </div>
                        </div>

                        <div class="row mb-3" id="fields">
                            @if(old('fields'))
                            @foreach(old('fields') as $index => $field)
                            <div class="row mb-3 field-group">
                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Name</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="fields[{{ $index }}][name]" value="{{ $field['name'] }}" autocomplete="off" />
                                        @if ($errors->has("fields.$index.name"))
                                        <span class="text-danger">{{ $errors->first("fields.$index.name") }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Value</label>
                                        <select class="form-control form-control-sm form-control-solid" name="fields[{{ $index }}][type]" aria-label="Default select example" required>
                                            <option value="">Select Field Value</option>
                                            <option value="varchar" @if($field['type']=='varchar' ) selected @endif>String</option>
                                            <option value="char" @if($field['type']=='char' ) selected @endif>Character</option>
                                            <option value="int" @if($field['type']=='int' ) selected @endif>Integer</option>
                                            <option value="date" @if($field['type']=='date' ) selected @endif>Date</option>
                                            <option value="text" @if($field['type']=='text' ) selected @endif>Text</option>
                                            <option value="boolean" @if($field['type']=='boolean' ) selected @endif>Boolean</option>
                                            <option value="file" @if($field['type']=='file' ) selected @endif>File</option>
                                            <option value="dropdown" @if($field['type']=='dropdown' ) selected @endif>Dropdown</option>
                                        </select>
                                        @if ($errors->has("fields.$index.type"))
                                        <span class="text-danger">{{ $errors->first("fields.$index.type") }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Character Length</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="fields[{{ $index }}][character_length]" value="{{ $field['character_length'] }}" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row mt-8 text-center" style="padding-left:34px">
                                        <button type="button" class="btn btn-sm btn-danger py-1 py-0" onclick="removeField(this)"><i class="bi bi-x pe-0 pb-1"></i></button>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="row mb-3 field-group">
                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Name</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="fields[0][name]" autocomplete="off" />
                                        @if ($errors->has('fields.0.name'))
                                        <span class="text-danger">{{ $errors->first('fields.0.name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Value</label>
                                        <select class="form-control form-control-sm form-control-solid" name="fields[0][type]" aria-label="Default select example" required>
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
                                        @if ($errors->has('fields.0.type'))
                                        <span class="text-danger">{{ $errors->first('fields.0.type') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Character Length</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="fields[0][character_length]" autocomplete="off" />
                                    </div>
                                </div>


                                <div class="col-md-2">
                                    <div class="fv-row mt-8 text-center" style="padding-left:34px">
                                        <button type="button" class="btn btn-sm btn-danger p-1 py-0" onclick="removeField(this)"><i class="bi bi-x pe-0 pb-1"></i></button>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>


                        <div class="card-footer d-flex justify-content-end pt-4 pb-0 px-0">
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes
                            </button>
                        </div>
                    </form>
                    <!-- End Form-->

                </div>
            </div>
        </div>
    </div>
</div>

<!--end::Toolbar-->
<script>
    let fieldIndex = {{old('fields') ? count(old('fields')) : 1}};

    function addField() {
        const fieldsContainer = document.getElementById('fields');
        const fieldGroup = document.createElement('div');
        fieldGroup.classList.add('row', 'mb-3', 'field-group');
        fieldGroup.innerHTML = `
            <div class="col-md-2">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Field Name</label>
                    <input class="form-control form-control-sm form-control-solid" type="text" name="fields[${fieldIndex}][name]" autocomplete="off" />
                </div>
            </div>

            <div class="col-md-2">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Field Value</label>
                    <select class="form-control form-control-sm form-control-solid" name="fields[${fieldIndex}][type]" aria-label="Default select example" required>
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
                    <input class="form-control form-control-sm form-control-solid" type="text" name="fields[${fieldIndex}][character_length]" autocomplete="off" />
                </div>
            </div>

            <div class="col-md-2">
                <div class="fv-row mt-8 text-center" style="padding-left:34px">
                    <button type="button" class="btn btn-sm btn-danger p-1 py-0" onclick="removeField(this)"><i class="bi bi-x pe-0 pb-1"></i></button>
                </div>
            </div>
        `;
        fieldsContainer.appendChild(fieldGroup);
        fieldIndex++;
    }

    function removeField(button) {
        const fieldGroup = button.closest('.field-group');
        fieldGroup.remove();
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formViewRadio = document.getElementById('form_view');
        const tableViewRadio = document.getElementById('table_view');
        const formSizeContainer = document.getElementById('form_size_container');
        //show or hide the form size dropdown based on the selected radio button
        function toggleFormSizeDropdown() {
            if (formViewRadio.checked) {
                formSizeContainer.style.display = 'block';
            } else {
                formSizeContainer.style.display = 'none';
            }
        }
        //attach event listeners to the radio buttons
        formViewRadio.addEventListener('change', toggleFormSizeDropdown);
        tableViewRadio.addEventListener('change', toggleFormSizeDropdown);

        //initial check on page load
        toggleFormSizeDropdown();
    });
</script>



@endsection
