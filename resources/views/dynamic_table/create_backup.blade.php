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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dynamic Table
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up Dynamic Table </small>
                <!--end::Description--></h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <a href="{{ route('dynamictable-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Dynamic Table List</a>
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
                        <h3 class="fw-bolder m-0">Dynamic Table Create</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->
                    <form class="g-form w-100" action="{{ route('dynamictable-store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Form Name</label>
                                    <select class="form-control form-control-sm form-control-solid" name="form_id" aria-label="Default select example">
                                        <option value="">Select Form Name</option>
                                        @foreach($formName as $id => $name)
                                            <option value="{{ $id }}">{{$name}}</option>
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
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="table_name" autocomplete="off" />
                                    @if ($errors->has('table_name'))
                                        <span class="text-danger">{{ $errors->first('table_name') }}</span>
                                    @endif
                                </div>
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
                                                    <option value="varchar" @if($field['type'] == 'varchar') selected @endif>String</option>
                                                    <option value="char" @if($field['type'] == 'char') selected @endif>Character</option>
                                                    <option value="int" @if($field['type'] == 'int') selected @endif>Integer</option>
                                                    <option value="date" @if($field['type'] == 'date') selected @endif>Date</option>
                                                    <option value="text" @if($field['type'] == 'text') selected @endif>Text</option>
                                                    <option value="boolean" @if($field['type'] == 'boolean') selected @endif>Boolean</option>
                                                </select>
                                                @if ($errors->has("fields.$index.type"))
                                                    <span class="text-danger">{{ $errors->first("fields.$index.type") }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="fv-row">
                                                <label class="form-label fw-bolder text-dark">Character Length</label>
                                                <input class="form-control form-control-sm form-control-solid" type="number" name="fields[{{ $index }}][character_length]" value="{{ $field['character_length'] }}" autocomplete="off" />
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="fv-row mb-3">
                                                <label class="form-label fw-bolder text-dark">Is Index</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="fields[{{ $index }}][is_index]" value="1" @if(isset($field['is_index'])) checked @endif>
                                                    <label class="form-check-label">Is Index</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="fv-row mb-3">
                                                <label class="form-label fw-bolder text-dark">Is Null</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="fields[{{ $index }}][is_null]" value="1" @if(isset($field['is_null'])) checked @endif>
                                                    <label class="form-check-label">Is Null</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="fv-row mb-3">
                                                <label class="form-label fw-bolder text-dark">Is Unique</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="fields[{{ $index }}][is_unique]" value="1" @if(isset($field['is_unique'])) checked @endif>
                                                    <label class="form-check-label">Is Unique</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="fv-row mt-8 text-center" style="padding-left:34px">
                                                <button type="button" class="btn btn-sm btn-danger" onclick="removeField(this)"><i class="bi bi-x-lg"></i></button>
                                            </div>
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
                                            </select>
                                            @if ($errors->has('fields.0.type'))
                                                <span class="text-danger">{{ $errors->first('fields.0.type') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="fv-row">
                                            <label class="form-label fw-bolder text-dark">Character Length</label>
                                            <input class="form-control form-control-sm form-control-solid" type="number" name="fields[0][character_length]" autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">Is Index</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fields[0][is_index]" value="1">
                                                <label class="form-check-label">Is Index</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">Is Null</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fields[0][is_null]" value="1">
                                                <label class="form-check-label">Is Null</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">Is Unique</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="fields[0][is_unique]" value="1">
                                                <label class="form-check-label">Is Unique</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="fv-row mt-8 text-center" style="padding-left:34px">
                                            <button type="button" class="btn btn-sm btn-danger" onclick="removeField(this)"><i class="bi bi-x-lg"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" onclick="addField()">Add New Field</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
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
    let fieldIndex = {{ old('fields') ? count(old('fields')) : 1 }};

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
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Character Length</label>
                    <input class="form-control form-control-sm form-control-solid" type="number" name="fields[${fieldIndex}][character_length]" autocomplete="off" />
                </div>
            </div>

            <div class="col-md-1">
                <div class="fv-row mb-3">
                    <label class="form-label fw-bolder text-dark">Is Index</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="fields[${fieldIndex}][is_index]" value="1">
                        <label class="form-check-label">Is Index</label>
                    </div>
                </div>
            </div>

            <div class="col-md-1">
                <div class="fv-row mb-3">
                    <label class="form-label fw-bolder text-dark">Is Null</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="fields[${fieldIndex}][is_null]" value="1">
                        <label class="form-check-label">Is Null</label>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="fv-row mb-3">
                    <label class="form-label fw-bolder text-dark">Is Unique</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="fields[${fieldIndex}][is_unique]" value="1">
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
        fieldsContainer.appendChild(fieldGroup);
        fieldIndex++;
    }

    function removeField(button) {
        const fieldGroup = button.closest('.field-group');
        fieldGroup.remove();
    }
</script>

@endsection
