@extends('layouts.master')

@section('content')

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
             data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
             class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Result Action
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Update the Result Action</small>
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
                        <h3 class="fw-bolder m-0">Edit Result Action</h3>
                    </div>
                </div>

                <div class="card-body pb-2">
                    <form class="g-form w-100" action="{{ route('result-action-update-pro', $result_action->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <!-- Rule Code -->
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Rule Code<span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm form-control-solid"
                                           type="text" name="rule_code" 
                                           value="{{ old('rule_code', $result_action->rule_code) }}" />
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
                                           type="text" name="rule_description" 
                                           value="{{ old('rule_description', $result_action->rule_description) }}" />
                                    @if ($errors->has('rule_description'))
                                        <span class="text-danger">{{ $errors->first('rule_description') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Rule Type -->
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Type</label>
                                    <select class="form-control form-control-sm form-control-solid" name="rule_type" id="rule_type">
                                        <option value="">Select</option>
                                        <option value="Callback" {{ old('rule_type', $result_action->rule_type) == 'Callback' ? 'selected' : '' }}>Callback</option>
                                        <option value="Dead" {{ old('rule_type', $result_action->rule_type) == 'Dead' ? 'selected' : '' }}>Dead</option>
                                        <option value="PARK" {{ old('rule_type', $result_action->rule_type) == 'PARK' ? 'selected' : '' }}>PARK</option>
                                        <option value="General" {{ old('rule_type', $result_action->rule_type) == 'General' ? 'selected' : '' }}>General</option>
                                    </select>
                                       @if ($errors->has('rule_type'))
                                        <span class="text-danger">{{ $errors->first('rule_type') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Result Status -->
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Result Status</label>
                                    <select class="form-control form-control-sm form-control-solid" name="lead_status_id">
                                        <option value="">Select</option>
                                        @foreach($lead_status as $status)
                                            <option value="{{ $status->id }}" {{ old('lead_status_id', $result_action->lead_status_id) == $status->id ? 'selected' : '' }}>
                                                {{ $status->status_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                      @if ($errors->has('lead_status_id'))
                                        <span class="text-danger">{{ $errors->first('lead_status_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Active Status -->
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Active</label>
                                    <select class="form-control form-control-sm form-control-solid" name="status">
                                        <option value="1" {{ old('status', $result_action->status) == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('status', $result_action->status) == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                       @if ($errors->has('status'))
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Callback Fields -->
                            <div class="col-md-6" id="callback_fields" style="display: none;">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="fv-row mb-3">
                                                <label class="form-label fw-bolder text-dark">Distribution Priority (1-9)</label>
                                                <input type="number" class="form-control form-control-sm form-control-solid" 
                                                    name="distribution_priority_callback" min="1" max="9" 
                                                    value="{{ old('distribution_priority_callback', $result_action->distribution_priority) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fv-row mb-3">
                                                <label class="form-label fw-bolder text-dark">After 1st Park (1-9)</label>
                                                <input type="number" class="form-control form-control-sm form-control-solid" 
                                                    name="after_1st_park_priority_callback" min="1" max="9" 
                                                    value="{{ old('after_1st_park_priority_callback', $result_action->after_1st_park_priority) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fv-row mb-3">
                                                <label class="form-label fw-bolder text-dark">After 2nd Park (1-9)</label>
                                                <input type="number" class="form-control form-control-sm form-control-solid" 
                                                    name="after_2nd_park_priority_callback" min="1" max="9" 
                                                    value="{{ old('after_2nd_park_priority_callback', $result_action->after_2nd_park_priority) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Park Fields -->
                            <div class="col-md-12" id="park_fields" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">Distribution Time (min)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="distribution_time_park" value="{{ old('distribution_time_park', $result_action->distribution_time) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">After 1st Park (min)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="after_1st_park_min_park" value="{{ old('after_1st_park_min_park', $result_action->after_1st_park_time) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">After 2nd Park (min)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="after_2nd_park_min_park" value="{{ old('after_2nd_park_min_park', $result_action->after_2nd_park_time) }}">
                                        </div>
                                    </div>

                                    <!-- Priorities -->
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">Distribution Priority (1-9)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="distribution_priority_park" min="1" max="9"
                                                value="{{ old('distribution_priority_park', $result_action->distribution_priority) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">After 1st Park (1-9)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="after_1st_park_priority_park" min="1" max="9"
                                                value="{{ old('after_1st_park_priority_park', $result_action->after_1st_park_priority) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">After 2nd Park (1-9)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="after_2nd_park_priority_park" min="1" max="9"
                                                value="{{ old('after_2nd_park_priority_park', $result_action->after_2nd_park_priority) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- General Fields -->
                            <div class="col-md-12" id="general_fields" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">Distribution Time (min)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="distribution_time_general" value="{{ old('distribution_time_general', $result_action->distribution_time) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">After 1st Park (min)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="after_1st_park_min_general" value="{{ old('after_1st_park_min_general', $result_action->after_1st_park_time) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">After 2nd Park (min)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="after_2nd_park_min_general" value="{{ old('after_2nd_park_min_general', $result_action->after_2nd_park_time) }}">
                                        </div>
                                    </div>

                                    <!-- Priorities -->
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">Distribution Priority (1-9)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="distribution_priority_general" min="1" max="9"
                                                value="{{ old('distribution_priority_general', $result_action->distribution_priority) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">After 1st Park (1-9)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="after_1st_park_priority_general" min="1" max="9"
                                                value="{{ old('after_1st_park_priority_general', $result_action->after_1st_park_priority) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">After 2nd Park (1-9)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="after_2nd_park_priority_general" min="1" max="9"
                                                value="{{ old('after_2nd_park_priority_general', $result_action->after_2nd_park_priority) }}">
                                        </div>
                                    </div>

                                    <!-- Condition Checkbox -->
                                    <div class="col-md-12 d-flex align-items-center">
                                        <div class="form-check form-check-custom form-check-solid mt-2 mb-2">
                                            <input class="form-check-input" type="checkbox" name="apply_condition_general"
                                                 {{ old('apply_condition_general', $result_action->apply_condition) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label">Apply Condition (Park/Dead)</label>
                                        </div>
                                    </div>

                                    <!-- Attempts -->
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">No. of Attempts (1-99)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="attempts_general" min="1" max="99"
                                                value="{{ old('attempts_general', $result_action->attempts_general) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">After 1st Park (0-99)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="after_1st_park_priority_99" min="0" max="99"
                                                value="{{ old('after_1st_park_priority_99', $result_action->after_1st_park_priority_general) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">After 2nd Park (0-99)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="after_2nd_park_priority_99" min="0" max="99"
                                                value="{{ old('after_2nd_park_priority_99', $result_action->after_2nd_park_priority_general) }}">
                                        </div>
                                    </div>

                                    <!-- Result Code -->
                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">Result Code</label>
                                            <select class="form-control form-control-sm form-control-solid" name="result_code">
                                                <option value="">Select</option>
                                                @foreach($result_code as $code)
                                                    <option value="{{ $code->id }}" {{ old('result_code', $result_action->result_code) == $code->id ? 'selected' : '' }}>
                                                        {{ $code->code }} - {{ $code->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">Park Cycle Before Dead (0-99)</label>
                                            <input type="number" class="form-control form-control-sm form-control-solid"
                                                name="park_cycle_before_dead" min="0" max="99"
                                                value="{{ old('park_cycle_before_dead', $result_action->park_cycle_before_dead) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="card-footer d-flex justify-content-end">
                                <a href="{{ route('result-action-list') }}" class="btn btn-sm btn-light me-2">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">Update Changes</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const ruleType = document.getElementById('rule_type');
    const callbackFields = document.getElementById('callback_fields');
    const parkFields = document.getElementById('park_fields');
    const generalFields = document.getElementById('general_fields');

    function toggleFields() {
        // Hide all first
        callbackFields.style.display = 'none';
        parkFields.style.display = 'none';
        generalFields.style.display = 'none';

        // Show based on selection
          if (ruleType.value === 'Callback') {
            callbackFields.style.display = 'flex';
            parkFields.style.display = 'none';
            generalFields.style.display = 'none';
        } else if (ruleType.value === 'PARK') {
            parkFields.style.display = 'block';
            callbackFields.style.display = 'none';
            generalFields.style.display = 'none';
        } else if (ruleType.value === 'General') {
            generalFields.style.display = 'block';
            parkFields.style.display = 'none';
            callbackFields.style.display = 'none';
        } else {
            callbackFields.style.display = 'none';
            parkFields.style.display = 'none';
            generalFields.style.display = 'none';
        }
    }

    //run once on page load edit page preselected value
    toggleFields();

    ///run on page load if old value is selected
    ruleType.addEventListener('change', toggleFields);
  });
</script>

@endsection
