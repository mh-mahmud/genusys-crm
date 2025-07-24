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
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Agent Grid List
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Agent Grid List</small>
                                <!--end::Description--></h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Page title-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">
                            <!--begin::Wrapper-->
                            <div class="me-4">
                                <!--begin::Menu-->
                                <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder"
                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                    <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
												<path
                                                    d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                                    fill="black"/>
											</svg>
										</span>
                                    <!--end::Svg Icon-->Filter</a>
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
                                    <div class="px-7 py-5">
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bold">Status:</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div>
                                                <select class="form-select form-select-solid" data-kt-select2="true"
                                                        data-placeholder="Select option"
                                                        data-dropdown-parent="#kt_menu_61484bf44d957"
                                                        data-allow-clear="true">
                                                    <option></option>
                                                    <option value="1">Approved</option>
                                                    <option value="2">Pending</option>
                                                    <option value="2">In Process</option>
                                                    <option value="2">Rejected</option>
                                                </select>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bold">Member Type:</label>
                                            <!--end::Label-->
                                            <!--begin::Options-->
                                            <div class="d-flex">
                                                <!--begin::Options-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                    <input class="form-check-input" type="checkbox" value="1"/>
                                                    <span class="form-check-label">Author</span>
                                                </label>
                                                <!--end::Options-->
                                                <!--begin::Options-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="2"
                                                           checked="checked"/>
                                                    <span class="form-check-label">Customer</span>
                                                </label>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bold">Notifications:</label>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            <div
                                                class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value=""
                                                       name="notifications" checked="checked"/>
                                                <label class="form-check-label">Enabled</label>
                                            </div>
                                            <!--end::Switch-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset"
                                                    class="btn btn-sm btn-light btn-active-light-primary me-2"
                                                    data-kt-menu-dismiss="true">Reset
                                            </button>
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                    data-kt-menu-dismiss="true">Apply
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Form-->
                                </div>
                                <!--end::Menu 1-->
                                <!--end::Menu-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Button-->
                            <a href="{{ route('agents.create') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Create</a>

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
<div class="text-center">
	<div class="row">
		<div class="col-md-5 mx-auto">
		   @if (session('success'))
		    <div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>{{ session('success') }}</strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert"
						aria-label="Close"></button>
			</div>
			@endif
			@if (session('error'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong> {{ session('error') }}</strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert"
						aria-label="Close"></button>
			</div>
			@endif


		</div>
	</div>
</div>

<!--End Table Alert Message-->


<div class="row">
	<div class="col-xxl-12">
		<div class="card mb-5">
			<!--begin::Header-->
			<div class="d-flex justify-content-between align-items-start card-header border-0 pt-5">
				<h3 class="card-title align-items-start flex-column">
					<span class="card-label fw-bolder fs-3 mb-1">Agent List</span>
					<span class="text-muted mt-1 fw-bold fs-7">Table data here</span>
				</h3>

				<div class="d-flex flex-wrap gap-2">
					<!--begin::Input group start date-->
					<div class="position-relative">
						<input type="text" class="form-control form-control-solid flatpickr"
							   placeholder="Start date" name="date-table">
					</div>
					<!--end::Input group-->

					<!--begin::Input group end date-->
					<div class="position-relative">
						<input type="text" class="form-control form-control-solid"
							   placeholder="End date" name="date-table"/>
					</div>

					<!--end::Input group-->

					<!--begin::Input group-->
					<div class="d-flex align-items-center position-relative">
						<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
						<span class="svg-icon svg-icon-1 position-absolute ms-6">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
									 viewBox="0 0 24 24" fill="none">
									<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
										  height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
										  fill="black"></rect>
									<path
										d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
										fill="black"></path>
								</svg>
							</span>
						<!--end::Svg Icon-->
						<input type="text" data-kt-customer-table-filter="search"
							   class="form-control form-control-solid w-250px ps-15"
							   placeholder="Search Customers">
					</div>
					<!--end::Input group-->

					<button type="button" class="btn btn-primary">Search</button>


				</div>


			</div>
			<!--end::Header-->
			<!--begin::Body-->
			 <div class="card-body p-1">
				<!--begin::Table container-->
				<div class="table-responsive">
					<!--begin::Table-->
					<table
						class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
						<!--begin::Table head-->
						<thead>
						<tr class="fw-bolder text-muted">
						    <th class="min-w-150px">SL</th>
							<th class="min-w-150px">Agent ID</th>
							<th class="min-w-140px">Name</th>
							<th class="min-w-120px">Email</th>
							<th class="min-w-120px">Phone Number</th>
							<th class="min-w-120px">Date Of Birth</th>
							<th class="min-w-120px">Status</th>
							<th class="min-w-100px text-end">Actions</th>
						</tr>
						</thead>
						<!--end::Table head-->
						<!--begin::Table body-->
						<tbody>
						@foreach ($agents as $agent)
						<tr>

						    <td class="text-dark fs-6">{{$loop->iteration}}</td>
							<td class="text-dark fs-6">{{$agent->agent_id}}</td>
							<td class="text-dark fs-6">{{$agent->name }}</td>
							<td class="text-dark fs-6">{{$agent->user->email}}</td>
							<td class="text-dark fs-6">{{$agent->phone_number}}</td>
							<td class="text-dark fs-6">{{ \Carbon\Carbon::parse($agent->birth_day)->format('d-m-Y') }}</td>

							<td>
								@if ($agent->status == 1)
									<span class="badge badge-light-success">Active</span>
								@elseif ($agent->status == 0)
									<span class="badge badge-light-danger">Inactive</span>
								@endif
                            </td>
							<td class="text-end">
								<a href="{{ route('agents.show', $agent->agent_id) }}"
								   class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
									<!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
									<span class="svg-icon svg-icon-3">
												<svg xmlns="http://www.w3.org/2000/svg"
													 width="24px" height="24px" viewBox="0 0 24 24">
														<g stroke="none" stroke-width="1"
														   fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24"
																  height="24"/>
															<path
																d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
																fill="black" fill-rule="nonzero"
																opacity="0.7"/>
															<path
																d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
																fill="black" opacity="0.7"/>
														</g>
													</svg>
											</span>
									<!--end::Svg Icon-->
								</a>
								<a href="{{ route('agents.edit', $agent->agent_id) }}"
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
								<form action="{{ route('agents.destroy', $agent->agent_id) }}" method="POST" style="display: inline;">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
										<!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
										<span class="svg-icon svg-icon-3">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black"/>
												<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black"/>
												<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black"/>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</button>
								</form>
							</td>
						</tr>
						@endforeach

						</tbody>
						<!--end::Table body-->
					</table>
					<!--end::Table-->
				</div>
				<!--end::Table container-->
			</div>
			<!--begin::Body-->

		</div>

		<!--Table Pagination-->
		<ul class="pagination">
			<li class="page-item previous disabled"><span class="page-link">Previous</span></span>
			</li>
			<li class="page-item "><a href="#" class="page-link">1</a></li>
			<li class="page-item active"><a href="#" class="page-link">2</a></li>
			<li class="page-item "><a href="#" class="page-link">3</a></li>
			<li class="page-item "><a href="#" class="page-link">4</a></li>
			<li class="page-item "><a href="#" class="page-link">5</a></li>
			<li class="page-item "><a href="#" class="page-link">6</a></li>
			<li class="page-item next"><a class="page-link" href="#">Next</span></a></li>
		</ul>
		<!--End Table Pagination-->

	</div>
</div>
</div>

<!-- End Tables-->

@endsection
