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
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Add Task
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Task Create Form</small>
                                <!--end::Description--></h1>
                            <!--end::Title-->
                        </div>

                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">
                            <!--begin::Wrapper-->
                            <div class="me-4">
                                <!--begin::Menu-->

                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                     id="kt_menu_61484bf44d957">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->
                                    <!--begin::Form-->

                                    <!--end::Form-->
                                </div>
                                <!--end::Menu 1-->
                                <!--end::Menu-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Button-->
                            <a href="{{ route('task-list') }}" class="btn btn-sm btn-primary">Task List</a>
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
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title m-0">
                                        <h3 class="fw-bolder m-0">Add Task</h3>
                                    </div>
                                    <!--end::Card title-->
                                </div>

                                <!-- Card Body-->
                                <div class="card-body">

                                    <!-- Start Form-->

                                    <form class="g-form w-100" action="{{ route('add-task-pro') }}"  method="POST">
                                         @csrf
                                        <div class="row pb-3">
                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Task Name<span class="text-danger">*</span></label>
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" id="task_name" name="task_name" autocomplete="off" value="{{ old('task_name') }}"/>
                                                    @if ($errors->has('task_name'))
                                                        <span class="text-danger">{{ $errors->first('task_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            @if (Auth::user()->hasPermission('can-see-tasks'))
                                                <div class="col-md-6">
                                                    <div class="fv-row mb-3">
                                                        <label class="form-label fw-bolder text-dark">Assigned To<span class="text-danger">*</span></label>
                                                        <select class=" form-control form-control-sm form-control-solid" id="assigned_to" name="assigned_to"
                                                                aria-label="Default select example">
                                                            <option value=''>Select</option>
                                                            @foreach($users as $user)
                                                                <option value="{{$user->id}}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('assigned_to'))
                                                            <span class="text-danger">{{ $errors->first('assigned_to') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">
                                                        Due Date<span class="text-danger">*</span></label>

                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-sm form-control-solid flatpickr date" placeholder="Due Date" name="due_date" value="{{ old('due_date') }}">
                                                        @if ($errors->has('due_date'))
                                                            <span class="text-danger">{{ $errors->first('due_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark" for="textarea">Description</label>
                                                    <textarea class="form-control form-control-sm  form-control-solid" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!--End Row-->
                                        <div class="card-footer d-flex justify-content-end p-2">
                                            <input type="reset" value="Reset" class="btn btn-light btn-sm me-2">
                                            <button type="submit" class="btn btn-primary btn-sm"
                                                    id="kt_account_profile_details_submit">Send
                                            </button>
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
         <!-- Display Success and Error Messages using SweetAlert2 -->
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success')}}',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error')}}',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif

<!--End Table Alert Message-->

@endsection
