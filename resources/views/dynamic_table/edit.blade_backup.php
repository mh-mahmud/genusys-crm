@extends('layouts.master')

@section('content')

<!-- Toolbar -->
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Dynamic Table
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Edit the Dynamic Table</small>
            </h1>
        </div>
        <div class="d-flex align-items-center py-1">
            <a href="{{ route('dynamic_table.index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Dynamic Table List</a>
        </div>
    </div>
</div>

<div class="container-xxl">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card card-xxl-stretch mt-4">
                <div class="card-header">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Edit Dynamic Table</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form class="g-form w-100" action="{{ route('dynamic_table.update', $tableDetails[0]->table_name) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Form Name</label>
                                    <select class="form-control form-control-sm form-control-solid" name="form_id">
                                        <option value="">Select Form Name</option>
                                        @foreach($formName as $id => $name)
                                        <option value="{{ $id }}" {{ $id == $tableDetails[0]->form_id ? 'selected' : '' }}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('form_id'))
                                    <span class="text-danger">{{ $errors->first('form_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Table Name</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="table_name" value="{{ old('table_name', $tableDetails[0]->table_name) }}" autocomplete="off" />
                                    @if ($errors->has('table_name'))
                                    <span class="text-danger">{{ $errors->first('table_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3" id="fields">
                            @foreach($tableDetails as $key => $detail)
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
                                    <label class="form-label fw-bolder text-dark">Type</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="fields[{{ $key }}][type]" value="{{ $detail->field_value }}" autocomplete="off" />
                                    @if ($errors->has("fields.{$key}.type"))
                                    <span class="text-danger">{{ $errors->first("fields.{$key}.type") }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="fv-row">
                                    <label class="form-label fw-bolder text-dark">Character Length</label>
                                    <input class="form-control form-control-sm form-control-solid" type="number" name="fields[{{ $key }}][character_length]" value="{{ $detail->character_length }}" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Is Index</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="fields[{{ $key }}][is_index]" value="1" {{ $detail->is_index ? 'checked' : '' }} />
                                        <label class="form-check-label">Is Index</label>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Is Null</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="fields[{{ $key }}][is_null]" value="1" {{ $detail->is_null ? 'checked' : '' }} />
                                        <label class="form-check-label">Is Null</label>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Is Unique</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="fields[{{ $key }}][is_unique]" value="1" {{ $detail->is_unique ? 'checked' : '' }} />
                                        <label class="form-check-label">Is Unique</label>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="fv-row mt-8 text-center">
                                    <button type="button" class="btn btn-sm btn-success" onclick="addField()"><i class="bi bi-plus-lg"></i></button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('dynamic_table.create') }}" class="btn btn-light me-2">Reset</a>
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addField() {
        const fields = document.getElementById('fields');
        const fieldCount = fields.children.length;
        const newFieldGroup = document.createElement('div');
        newFieldGroup.className = 'row mb-3 field-group';

        newFieldGroup.innerHTML = `
        <div class="col-md-2">
            <div class="fv-row">
                <label class="form-label fw-bolder text-dark">Field Name</label>
                <input class="form-control form-control-sm form-control-solid" type="text" name="fields[${fieldCount}][name]" autocomplete="off" required />
            </div>
        </div>

        <div class="col-md-2">
            <div class="fv-row">
                <label class="form-label fw-bolder text-dark">Field Value</label>
                <select class="form-control form-control-sm form-control-solid" name="fields[${fieldCount}][type]" aria-label="Default select example" required>
                    <option value="">Select Field Value</option>
                    <option value="varchar">String</option>
                    <option value="char">Character</option>
                    <option value="int">Integer</option>
                    <option value="date">Date</option>
                    <option value="text">Text</option>
                    <option value="boolean">Boolean</option>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="fv-row">
                <label class="form-label fw-bolder text-dark">Character Length</label>
                <input class="form-control form-control-sm form-control-solid" type="text" name="fields[${fieldCount}][character_length]" autocomplete="off" />
            </div>
        </div>

        <div class="col-md-1">
            <div class="fv-row mb-3">
                <label class="form-label fw-bolder text-dark">Is Index</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fields[${fieldCount}][is_index]" value="1">
                    <label class="form-check-label">Is Index</label>
                </div>
            </div>
        </div>

        <div class="col-md-1">
            <div class="fv-row mb-3">
                <label class="form-label fw-bolder text-dark">Is Null</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fields[${fieldCount}][is_null]" value="1">
                    <label class="form-check-label">Is Null</label>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="fv-row mb-3">
                <label class="form-label fw-bolder text-dark">Is Unique</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fields[${fieldCount}][is_unique]" value="1">
                    <label class="form-check-label">Is Unique</label>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="fv-row mt-8 text-center" style="padding-left:34px">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeField(this)"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>
    `;
        fields.appendChild(newFieldGroup);
    }

    function removeField(button) {
        const fieldGroup = button.closest('.field-group');
        fieldGroup.remove();
    }
</script>

@endsection
