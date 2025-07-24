@extends('layouts.master')
@php
    use Carbon\Carbon;
@endphp

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
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tasks
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <!--end::Separator-->
                    <!--begin::Description-->
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Task List</small>
                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center py-1">

                <a href="{{ route('add-task') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Add Task</a>

                <!--end::Button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--**********************************
                                    Tables
                      ***********************************-->
    <div class="container-fluid">

        <!--Table Alert Message-->
        <!-- Display Success and Error Messages using SweetAlert2 -->
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
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
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        @endif

        <!--End Table Alert Message-->


        <div class="row">
            <div class="col-xxl-12">
                <div class="card mt-4">
                    <!--begin::Header-->
                    <div class="d-flex justify-content-between align-items-start card-header border-0 p-1">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Task List</span>
                            <!-- <span class="text-muted mt-1 fw-bold fs-7">Leads Form data here</span> -->
                        </h3>

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-1">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            @if ($tasks->isNotEmpty())
                                <!--begin::Table-->

                                <table
                                    class="table table-sm table-condensed table-row-gray-100 align-middle gs-0 gy-3 table-row-bordered">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bolder text-muted bg-light bd-cyan">
                                            <th class="ps-4 min-w-120px">SL</th>
                                            <th class="min-w-150px">Task Name</th>
                                            @if (Auth::user()->user_type == 'admin')
                                                <th class="min-w-120px">Assigned To</th>
                                            @endif
                                            <th class="min-w-150px w-400px">Description</th>
                                            <th class="min-w-120px">Created At</th>
                                            <th class="min-w-120px">Due Date</th>
                                            <th class="min-w-120px">Status</th>
                                            <th class="min-w-100px text-end-new">Actions</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        @foreach ($tasks as $task)
                                            <tr>
												<form action="{{ route('task-status-change', $task->id) }}"
													method="POST" style="display: inline;">
													@csrf
													@method('PUT')
                                                <td class="ps-5 text-dark fs-6">
                                                    {{ ($tasks->currentPage() - 1) * $tasks->perPage() + $loop->iteration }}
                                                </td>
                                                <td class="text-dark fs-6">{{ $task->task_name }}</td>
                                                @if (Auth::user()->user_type == 'admin')
                                                    <td class="text-dark fs-6">{{ $task->first_name }}
                                                        {{ $task->last_name }}</td>
                                                @endif
                                                <td class="text-dark fs-6 w-400px">{{ $task->description }}</td>
                                                <td class="text-dark fs-6">
                                                    {{ Carbon::parse($task->created_at)->format('d-m-Y h:i:s A') }}
                                                </td>
                                                <td class="text-dark fs-6">
                                                    {{ Carbon::parse($task->due_date)->format('d-m-Y') }}</td>
                                                <td>
                                                    <select class=" form-control form-control-sm form-control-solid"
                                                        id="assigned_to" name="status" aria-label="Default select example">
                                                        <option value=''>Select</option>
                                                        @foreach (config('constants.TASK_STATUS') as $key => $status)
                                                            <option value="{{ $key }}"
                                                                {{ $task->status == $key ? 'selected' : '' }}>
                                                                {{ $status }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td>
                                                    <div
                                                    class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">
                                                        <button type="submit"
                                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">


                                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                        <path d="M9 19c-.512 0-1.024-.195-1.414-.586L3.586 14.414c-.781-.781-.781-2.047 0-2.828s2.047-.781 2.828 0L9 15.172l8.586-8.586c.781-.781 2.047-.781 2.828 0s.781 2.047 0 2.828l-10 10C10.024 18.805 9.512 19 9 19z" fill="black"/>
                                                                      </svg>

                                                                  </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('delete-task', $task->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
														<button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"  onclick="return confirmDelete()">

                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <path
                                                                    d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                                    fill="black" />
                                                                <path opacity="0.5"
                                                                    d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                                    fill="black" />
                                                                <path opacity="0.5"
                                                                    d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                                    fill="black" />
                                                            </svg>
                                                        </span>
														</button>
                                                        <!--end::Svg Icon-->
                                                    </form>
                                                    <div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            @else
                                <p>No results found.</p>
                            @endif
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                    </div>
                    <!--begin::Body-->

                </div>

                <!--Table Pagination-->

                @include('components.pagination', ['paginator' => $tasks])

                <!--End Table Pagination-->

            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            if (confirm("Are you sure you want to delete Email Template?")) {
                document.getElementById('deleteForm').submit();
            }
            return false;
        }
    </script>

    <!-- End Tables-->

@endsection
