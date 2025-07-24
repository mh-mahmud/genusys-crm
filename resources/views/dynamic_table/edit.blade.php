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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dynamic Table
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up Dynamic Table</small>
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
                <a href="{{ route('dynamictable-index') }}" class="btn btn-sm btn-primary">Dynamic Table List</a>
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
                        <h3 class="fw-bolder m-0">Dynamic Table Edit</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->
                    <form class="g-form w-100" action="{{ route('dynamictable-update', $tableDetails[0]->table_name) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-sm btn-success" onclick="addField()"><i class="bi bi-plus-lg"></i> Add Field</button>
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Form Name</label>
                                    <select class="form-control form-control-sm form-control-solid" name="form_id" disabled aria-label="Default select example">
                                        <option value="">Select Form Name</option>
                                        @foreach($formName as $id => $name)
                                        <option value="{{ $id }}" {{ $id == $tableDetails[0]->form_id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="form_id" value="{{ $tableDetails[0]->form_id }}">
                                    @if ($errors->has('form_id'))
                                    <span class="text-danger">{{ $errors->first('form_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Table Name</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="table_name" value="{{ old('table_name', $tableDetails[0]->table_name) }}" autocomplete="off" readonly />
                                    @if ($errors->has('table_name'))
                                    <span class="text-danger">{{ $errors->first('table_name') }}</span>
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
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" value="table_view" id="table_view"
                                        name="view_type" {{ $selectedViewType == 'table_view' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="table_view">
                                        Table View
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="radio" value="form_view" id="form_view"
                                        name="view_type" {{ $selectedViewType == 'form_view' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="form_view">
                                        Form View
                                    </label>
                                </div>

                                <!-- Form Size Dropdown -->
                                <div id="form_size_container" class="form-check flex-grow-1 mb-3" style="{{ $selectedViewType == 'form_view' ? 'display: block;' : 'display: none;' }}">
                                    <label class="form-label fw-bolder text-dark">Form Size</label>
                                    <select class="form-control form-control-sm form-control-solid" name="form_size" aria-label="Default select example">
                                        <option value="">Select Form Size</option>
                                        <option value="col-md-3" {{ $selectedFormSize == 'col-md-3' ? 'selected' : '' }}>col-md-3</option>
                                        <option value="col-md-6" {{ $selectedFormSize == 'col-md-6' ? 'selected' : '' }}>col-md-6</option>
                                        <option value="col-md-9" {{ $selectedFormSize == 'col-md-9' ? 'selected' : '' }}>col-md-9</option>
                                        <option value="col-md-12" {{ $selectedFormSize == 'col-md-12' ? 'selected' : '' }}>col-md-12</option>
                                    </select>
                                    @if ($errors->has('form_size'))
                                    <span class="text-danger">{{ $errors->first('form_size') }}</span>
                                    @endif
                                </div>
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

                                <div class="col-md-1">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Is Index</label>
                                        <div class="form-check form-check-custom form-check-sm">
                                            <input class="form-check-input" type="checkbox" name="fields[{{ $key }}][is_index]" value="1" {{ $detail->is_index ? 'checked' : '' }}>
                                            <label class="form-check-label">Is Index</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Is Null</label>
                                        <div class="form-check form-check-custom form-check-sm">
                                            <input class="form-check-input" type="checkbox" name="fields[{{ $key }}][is_null]" value="1" {{ $detail->is_null ? 'checked' : '' }}>
                                            <label class="form-check-label">Is Null</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row mb-3">
                                        <label class="form-label fw-bolder text-dark">Is Unique</label>
                                        <div class="form-check form-check-custom form-check-sm">
                                            <input class="form-check-input" type="checkbox" name="fields[{{ $key }}][is_unique]" value="1" {{ $detail->is_unique ? 'checked' : '' }}>
                                            <label class="form-check-label">Is Unique</label>
                                        </div>
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
                            <a href="{{ route('dynamictable-edit', $tableDetails[0]->table_name) }}" class="btn btn-light me-2">Reset</a>
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
            <div class="col-md-1">
                <div class="fv-row mb-3">
                    <label class="form-label fw-bolder text-dark">Is Index</label>
                    <div class="form-check form-check-custom form-check-sm">
                        <input class="form-check-input" type="checkbox" name="fields[${index}][is_index]" value="1">
                        <label class="form-check-label">Is Index</label>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <div class="fv-row mb-3">
                    <label class="form-label fw-bolder text-dark">Is Null</label>
                    <div class="form-check form-check-custom form-check-sm">
                        <input class="form-check-input" type="checkbox" name="fields[${index}][is_null]" value="1">
                        <label class="form-check-label">Is Null</label>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="fv-row mb-3">
                    <label class="form-label fw-bolder text-dark">Is Unique</label>
                    <div class="form-check form-check-custom form-check-sm">
                        <input class="form-check-input" type="checkbox" name="fields[${index}][is_unique]" value="1">
                        <label class="form-check-label">Is Unique</label>
                    </div>
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
