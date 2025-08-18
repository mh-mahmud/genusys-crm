@extends('layouts.master')

@section('content')

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
             data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
             class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Result Action
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Result Action</small>
            </h1>
        </div>

        <div class="d-flex align-items-center py-1">
            <a href="{{ route('result-action-list') }}" class="btn btn-sm btn-primary">Result Action List</a>
        </div>
    </div>
</div>
<!--end::Toolbar-->

<div class="container-xxl">
    <div class="row">
        <div class="col-xl-12">
            <div class="card card-xxl-stretch mt-4">
                <div class="card-header bg-light bd-cyan">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Result Action Create</h3>
                    </div>
                </div>

                <div class="card-body pb-2">
                    <form class="g-form w-100" action="{{ route('add-result-action-pro') }}" method="POST">
                        @csrf
                        <div class="row">

                            <!-- Rule Code -->
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Rule Code<span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm form-control-solid"
                                           type="text" name="rule_code" value="{{ old('rule_code') }}" />
                                    @if ($errors->has('rule_code'))
                                        <span class="text-danger">{{ $errors->first('rule_code') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Rule Description -->
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Rule Description<span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm form-control-solid"
                                           type="text" name="rule_description" value="{{ old('rule_description') }}" />
                                    @if ($errors->has('rule_description'))
                                        <span class="text-danger">{{ $errors->first('rule_description') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Rule Based -->
                            <div class="col-md-4">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Rule Based</label>
                                    <select class="form-control form-control-sm form-control-solid" name="rule_based">
                                        <option value="">Select</option>
                                        <option value="Yes" {{ old('rule_based') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ old('rule_based') == 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Callback -->
                            <div class="col-md-4">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Callback</label>
                                    <select class="form-control form-control-sm form-control-solid" name="callback">
                                        <option value="">Select</option>
                                        <option value="Yes" {{ old('callback') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ old('callback') == 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Dead -->
                            <div class="col-md-4">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Dead</label>
                                    <select class="form-control form-control-sm form-control-solid" name="dead">
                                        <option value="">Select</option>
                                        <option value="Yes" {{ old('dead') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ old('dead') == 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Number of Attempts -->
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Attempts</label>
                                    <input class="form-control form-control-sm form-control-solid"
                                           type="number" name="num_attempts" value="{{ old('num_attempts') }}" />
                                </div>
                            </div>

                            <!-- Next Dist -->
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Next Dist</label>
                                    <input class="form-control form-control-sm form-control-solid"
                                           type="text" name="next_dist" value="{{ old('next_dist') }}" />
                                </div>
                            </div>

                            <!-- Lead Status -->
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Lead Status</label>
                                    <select class="form-control form-control-sm form-control-solid" name="lead_status_id">
                                        <option value="">Select</option>
                                        @foreach($lead_status as $status)
                                            <option value="{{ $status->id }}" {{ old('lead_status_id') == $status->id ? 'selected' : '' }}>
                                                {{ $status->status_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Result Code -->
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Result Code</label>
                                    <select class="form-control form-control-sm form-control-solid" name="result_code">
                                        <option value="">Select</option>
                                        @foreach($result_code as $code)
                                            <option value="{{ $code->id }}" {{ old('result_code') == $code->id ? 'selected' : '' }}>
                                                {{ $code->code }} - {{ $code->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Active Status -->
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Active</label>
                                    <select class="form-control form-control-sm form-control-solid" name="status">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer d-flex justify-content-end">
                            <input type="reset" value="Reset" class="btn btn-sm btn-light me-2">
                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
