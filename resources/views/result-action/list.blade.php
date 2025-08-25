@extends('layouts.master')
@php
    use Carbon\Carbon;
@endphp

@section('content')

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
             data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
             class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                Result Actions
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Result Action List</small>
            </h1>
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <a href="{{ route('add-result-action') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Add</a>
        </div>
        <!--end::Actions-->
    </div>
</div>
<!--end::Toolbar-->

<div class="container-fluid">

    <!-- Table Alert Messages -->
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

    <div class="row">
        <div class="col-xxl-12">
            <div class="card mt-4">
                <!-- Card Header -->
                <div class="d-flex justify-content-between align-items-start card-header border-0 p-1">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Result Action List</span>
                    </h3>
                    <div class="d-flex flex-wrap gap-2">
                        <form action="{{ route('result-action-list') }}" method="GET" class="d-flex">
                            <div class="d-flex align-items-center position-relative">
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <!-- SVG icon here -->
                                </span>
                                <input type="text" name="search" class="form-control form-control-sm form-control-solid w-250px ps-15"
                                       value="{{ request('search') }}" placeholder="Search by Rule Code or Description">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm ms-2">Search</button>
                        </form>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body p-1">
                    <div class="table-responsive">
                        @if($actions->isNotEmpty())
                            <table class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                <thead>
                                <tr class="fw-bolder text-muted bg-light bd-cyan">
                                    <th class="ps-4 rounded-start min-w-40px">SL</th>
                                    <th class="min-w-120px">Rule Code</th>
                                    <th class="min-w-150px">Rule Description</th>
                                    <th class="min-w-120px text-center">Rule Based</th>
                                    <th class="min-w-120px text-center">Attempts</th>
                                    <th class="min-w-120px text-center">Callback</th>
                                    <th class="min-w-120px text-center">Dead</th>
                                    <th class="min-w-120px text-center">Result Status</th>
                                    <th class="min-w-120px text-center">Next Dist</th>
                                    <th class="min-w-120px text-center">Result Code</th>
                                    <th class="min-w-120px text-center">Active</th>
                                    <th class="min-w-100px text-end-new">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($actions as $action)
                                    <tr>
                                        <td class="ps-5 text-dark fs-6">{{($actions->currentPage() - 1) * $actions->perPage() + $loop->iteration}}</td>
                                        <td class="text-dark fs-6">{{ $action->rule_code }}</td>
                                        <td class="text-dark fs-6">{{ $action->rule_description }}</td>
                                        <td class="text-dark fs-6 text-center">{{ $action->rule_type == 'General' ? 'Yes' : 'No' }}</td>
                                        <td class="text-dark fs-6 text-center">{{ $action->attempts_general }}</td>
                                        <td class="text-dark fs-6 text-center">{{ $action->rule_type == 'Callback' ? 'Yes' : 'No' }}</td>
                                        <td class="text-dark fs-6 text-center">{{ $action->rule_type == 'Dead' ? 'Yes' : 'No' }}</td>
                                        <td class="text-dark fs-6 text-center">{{ $action->leadStatus?->status_name }}</td>
                                        <td class="text-dark fs-6 text-center">{{ $action->distribution_time }}</td>
                                        <td class="text-dark fs-6 text-center">{{ $action->resultCode?->code }}</td>
                                        <td class="text-dark fs-6 text-center">
                                            @if ($action->status == 1)
                                                <span class="badge badge-light-success">Active</span>
                                            @else
                                                <span class="badge badge-light-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
										<div class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">

											<!-- View Button -->
											<!-- <a href="{{ route('result-action-show', $action->id) }}" target="_blank"
												class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
												title="View Result Action">
												<span class="svg-icon svg-icon-3">
													<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 
																	C21,12 16.9090909,18 12,18 
																	C5.45454545,18 3,12 3,12 Z"
																fill="black" fill-rule="nonzero" opacity="0.7" />
															<path d="M12,15 C10.3431458,15 9,13.6568542 9,12 
																	C9,10.3431458 10.3431458,9 12,9 
																	C13.6568542,9 15,10.3431458 15,12 
																	C15,13.6568542 13.6568542,15 12,15 Z"
																fill="black" opacity="0.7" />
														</g>
													</svg>
												</span>
											</a> -->

								

											 <a href="{{ route('result-action-edit', $action->id) }}"
                                                   class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                    <span class="svg-icon svg-icon-3">
												<svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                     height="24" viewBox="0 0 24 24" fill="none">
													<path opacity="0.3"
                                                          d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                          fill="black"/>
													<path
                                                        d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                        fill="black"/>
												</svg>
											</span>
                                                    <!--end::Svg Icon-->
                                                </a>

<!-- 											
											<form action="{{ route('result-action-delete', $action->id) }}" method="POST" style="display: inline;">
												@csrf
												@method('DELETE')
												<button type="submit"
													class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
													onclick="return confirm('Do you want to delete this Result Action?')"
													title="Delete Result Action">
													<span class="svg-icon svg-icon-3">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
															viewBox="0 0 24 24" fill="none">
															<path
																d="M5 9C5 8.44772 5.44772 8 6 8H18
																C18.5523 8 19 8.44772 19 9V18
																C19 19.6569 17.6569 21 16 21H8
																C6.34315 21 5 19.6569 5 18V9Z"
																fill="black" />
															<path opacity="0.5"
																d="M5 5C5 4.44772 5.44772 4 6 4H18
																C18.5523 4 19 4.44772 19 5V5
																C19 5.55228 18.5523 6 18 6H6
																C5.44772 6 5 5.55228 5 5V5Z"
																fill="black" />
															<path opacity="0.5"
																d="M9 4C9 3.44772 9.44772 3 10 3H14
																C14.5523 3 15 3.44772 15 4V4H9V4Z"
																fill="black" />
														</svg>
													</span>
												</button>
											</form> -->
										</div>
									</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No results found.</p>
                        @endif
                    </div>
                </div>
            </div>
            @include('components.pagination', ['paginator' => $actions])
        </div>
    </div>
</div>

@endsection
