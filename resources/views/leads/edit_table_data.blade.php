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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{ ucwords(str_replace('_', ' ', $tableName)) }}
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the {{ ucwords(str_replace('_', ' ', $tableName)) }}</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">

            <!--begin::Button-->
           <a href="{{ route('lead-show', ['id' => $leads->lead_id]) }}" class="btn btn-sm btn-danger" id="kt_toolbar_primary_button">Back</a>

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

@if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: '{{ implode(' ', $errors->all()) }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
    <div class="row">
        <div class="container-xxl">
    <div class="row">
        <div class="col-xxl-12">
            <form class="g-form w-100" action="{{ route('update-tabledata') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" name="tableName" value="{{ $tableName }}">
                <input type="hidden" name="form_id" value="{{ $leads->form_id }}">
                <input type="hidden" name="lead_id" value="{{ $leads->id }}">
                <input type="hidden" name="last_four_digit" value="{{ $lastFourDigits }}">
                <input type="hidden" name="lead_table_id" value="{{ $leads->lead_id }}">

                @foreach($tableData as $tbl => $data)
                    <div class="card card-xxl-stretch mt-4">
                        <div class="card-header bg-light bd-cyan">
                            <div class="card-title m-0">
                                <h3 class="fw-bolder m-0">{{ ucwords(str_replace('_', ' ', $tbl)) }}</h3>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @foreach($data['columns'] as $column)
                                    @if(!in_array($column, ['lead_id', 'form_id', 'created_at', 'updated_at']))
                                        <div class="col-md-4">
                                            <div class="fv-row mb-3">
                                                <label class="form-label fw-bolder text-dark" for="{{ $column }}">
                                                    {{ ucwords(str_replace('_', ' ', $column)) }}
                                                </label>

                                                @php
                                                    $inputType = 'text';
                                                    $type = strtolower($data['types'][$column] ?? '');
                                                    $value = $data['existingData']->$column ?? '';

                                                    if (strpos($type, 'int') !== false || strpos($type, 'numeric') !== false) $inputType = 'number';
                                                    elseif (strpos($type, 'date') !== false) $inputType = 'date';
                                                    elseif (strpos($type, 'email') !== false) $inputType = 'email';
                                                    elseif (strpos($type, 'text') !== false || strpos($type, 'blob') !== false) $inputType = 'textarea';
                                                    elseif ($type == 'file') $inputType = 'file';
                                                    elseif ($type == 'dropdown') $inputType = 'dropdown';
                                                @endphp

                                                @if($inputType === 'textarea')
                                                    <textarea class="form-control form-control-sm form-control-solid" id="{{ $column }}" name="{{ $tbl }}[{{ $column }}]">{{ $value }}</textarea>
                                                @elseif($inputType === 'file' || $inputType === 'email' || $inputType === 'number' || $inputType === 'text')
                                                    <input type="{{ $inputType }}" class="form-control form-control-sm form-control-solid" id="{{ $column }}" name="{{ $tbl }}[{{ $column }}]" value="{{ $value }}">
                                                @elseif($inputType === 'date')
                                                    <input type="{{ $inputType }}" class="form-control form-control-sm form-control-solid" id="common_dob" name="{{ $tbl }}[{{ $column }}]" value="{{ $value }}">
                                                @elseif($inputType === 'dropdown')
                                                    <select class="form-control form-control-sm form-control-solid" id="{{ $column }}" name="{{ $tbl }}[{{ $column }}]">
                                                        <option value="">Select {{ ucwords(str_replace('_', ' ', $column)) }}</option>
                                                        @foreach($data['dropdownOptions'][$column] ?? [] as $option)
                                                            <option value="{{ $option }}" {{ $value == $option ? 'selected' : '' }}>{{ ucfirst($option) }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                     <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update Changes
                </button>
                </div>

            </form>
        </div>
    </div>
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
