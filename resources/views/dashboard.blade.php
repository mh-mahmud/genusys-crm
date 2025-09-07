@extends('layouts.master')


@section('content')

    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dashboard
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Hi {{ Auth::user()->first_name }}, Welcome to genusys crm</small>
                </h1>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-3">

        <!--Table Alert Message-->
        <!-- Display Success and Error Messages using SweetAlert2 -->
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success')}}',
                    showConfirmButton: false,
                    timer: 2000
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
                    timer: 2000
                });
            </script>
        @endif
        

        <!--End Table Alert Message-->
        <!--end::Toolbar-->

        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">


                <!--begin::Row-->
                <div class="row gy-5 g-xl-8 pb-2" style="padding-top:20px !important;">
                    <!--begin::Col-->
                     <div class="col-sm-3">
                        <div class="card card-flush h-md-20 mb-5 mb-xl-10">
                            <!--begin::Header-->

                            <div class="card-header bg-primary card-header-dashboard pt-5">

                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Currency-->
                                        <!-- <span class="fs-4 fw-semibold text-gray-501 me-1 align-self-start">$</span> -->
                                        <!--end::Currency-->

                                        <!--begin::Amount-->
                                        <span class="fs-2 fw-bold text-gray-901 me-2 lh-1 ls-n2">{{$count_lead}}</span>
                                        <!--end::Amount-->

                                        <!--begin::Badge-->
                                        <!-- <span class="badge badge-light-success fs-base">
                                            <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1"><span class="path1"></span><span class="path2"></span></i>
                                            2.2%
                                        </span>  -->
                                        <!--end::Badge-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Subtitle-->
                                    <a href="{{ route('total-lead') }}">
                                        <span class="text-gray-501 pt-1 fw-semibold fs-6">Total Leads</span>
                                    </a>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="card card-flush  h-md-20 mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header bg-primary card-header-dashboard pt-5">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Currency-->
                                        <!-- <span class="fs-4 fw-semibold text-gray-501 me-1 align-self-start">$</span> -->
                                        <!--end::Currency-->

                                        <!--begin::Amount-->
                                        <span
                                            class="fs-2 fw-bold text-gray-901 me-2 lh-1 ls-n2">{{$total_customers}}</span>
                                        <!--end::Amount-->

                                        <!--begin::Badge-->
                                        <!-- <span class="badge badge-light-success fs-base">
                                            <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1"><span class="path1"></span><span class="path2"></span></i>
                                            2.2%
                                        </span>  -->
                                        <!--end::Badge-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Subtitle-->
                                    <a href="{{ route('customers') }}">
                                        <span class="text-gray-501 pt-1 fw-semibold fs-6">Total Customers</span>
                                    </a>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card card-flush  h-md-20 mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header bg-primary card-header-dashboard pt-5">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Currency-->
                                        <!-- <span class="fs-4 fw-semibold text-gray-501 me-1 align-self-start">$</span> -->
                                        <!--end::Currency-->

                                        <!--begin::Amount-->
                                        <span class="fs-2 fw-bold text-gray-901 me-2 lh-1 ls-n2">{{$invoice_count}}</span>
                                        <!--end::Amount-->

                                        <!--begin::Badge-->
                                        <!-- <span class="badge badge-light-success fs-base">
                                            <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1"><span class="path1"></span><span class="path2"></span></i>
                                            2.2%
                                        </span> --> 
                                        <!--end::Badge-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Subtitle-->
                                    <a href="{{ route('invoice-index') }}">
                                        <span class="text-gray-501 pt-1 fw-semibold fs-6">Unpaid Invoice</span>
                                    </a>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card card-flush h-md-20 mb-5 mb-xl-10">
                            <!--begin::Header-->
                            <div class="card-header bg-primary card-header-dashboard pt-5">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column">
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Currency-->
                                        <!-- <span class="fs-4 fw-semibold text-gray-501 me-1 align-self-start">$</span> -->
                                        <!--end::Currency-->

                                        <!--begin::Amount-->
                                        <span class="fs-2 fw-bold text-gray-901 me-2 lh-1 ls-n2">{{$active_products}}</span>
                                        <!--end::Amount-->

                                        <!--begin::Badge-->
                                        <!-- <span class="badge badge-light-success fs-base">
                                            <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1"><span class="path1"></span><span class="path2"></span></i>
                                            2.2%
                                        </span>  -->
                                        <!--end::Badge-->
                                    </div>
                                    <!--end::Info-->

                                    <!--begin::Subtitle-->
                                    <a href="{{ route('product-list') }}">
                                        <span class="text-gray-501 pt-1 fw-semibold fs-6">Total Products</span>
                                    </a>
                                    <!--end::Subtitle-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->

                <!--begin::Row-->
                <div class="row gy-5 g-xl-8 pb-2">
                    &nbsp;
                </div>
                <!--end::Row-->

                <!-- start chart -->
                {{--
                <div class="row g-5 g-xl-8">
					<div class="col-xl-6">
						<!--begin::Charts Widget 3-->
						<div class="card card-xl-stretch mb-xl-8">
							<!--begin::Header-->
							<div class="card-header border-0 pt-5">
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label fw-bolder fs-3 mb-1">Recent Transactions</span>
									<span class="text-muted fw-bold fs-7">More than 1000 new records</span>
								</h3>
								<!--begin::Toolbar-->
								<div class="card-toolbar" data-kt-buttons="true">
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="kt_charts_widget_3_year_btn">Year</a>
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="kt_charts_widget_3_month_btn">Month</a>
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4" id="kt_charts_widget_3_week_btn">Week</a>
								</div>
								<!--end::Toolbar-->
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body">
								<!--begin::Chart-->
								<div id="kt_charts_widget_3_chart" style="height: 350px"></div>
								<!--end::Chart-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::Charts Widget 3-->
					</div>
					<div class="col-xl-6">
						<!--begin::Charts Widget 4-->
						<div class="card card-xl-stretch mb-5 mb-xl-8">
							<!--begin::Header-->
							<div class="card-header border-0 pt-5">
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label fw-bolder fs-3 mb-1">Recent Customers</span>
									<span class="text-muted fw-bold fs-7">More than 500 new customers</span>
								</h3>
								<!--begin::Toolbar-->
								<div class="card-toolbar" data-kt-buttons="true">
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="kt_charts_widget_4_year_btn">Year</a>
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="kt_charts_widget_4_month_btn">Month</a>
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4" id="kt_charts_widget_4_week_btn">Week</a>
								</div>
								<!--end::Toolbar-->
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body">
								<!--begin::Chart-->
								<div id="kt_charts_widget_4_chart" style="height: 350px"></div>
								<!--end::Chart-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::Charts Widget 4-->
					</div>
				</div>

				<div class="row g-5 g-xl-8">
					<div class="col-xl-6">
						<!--begin::Charts Widget 5-->
						<div class="card card-xl-stretch mb-xl-8">
							<!--begin::Header-->
							<div class="card-header border-0 pt-5">
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label fw-bolder fs-3 mb-1">Recent Customers</span>
									<span class="text-muted fw-bold fs-7">More than 500 new customers</span>
								</h3>
								<!--begin::Toolbar-->
								<div class="card-toolbar" data-kt-buttons="true">
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="kt_charts_widget_5_year_btn">Year</a>
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="kt_charts_widget_5_month_btn">Month</a>
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4" id="kt_charts_widget_5_week_btn">Week</a>
								</div>
								<!--end::Toolbar-->
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body">
								<!--begin::Chart-->
								<div id="kt_charts_widget_5_chart" style="height: 350px"></div>
								<!--end::Chart-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::Charts Widget 5-->
					</div>
					<div class="col-xl-6">
						<!--begin::Charts Widget 5-->
						<div class="card card-xl-stretch mb-5 mb-xl-8">
							<!--begin::Header-->
							<div class="card-header border-0 pt-5">
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label fw-bolder fs-3 mb-1">Recent Orders</span>
									<span class="text-muted fw-bold fs-7">More than 500+ new orders</span>
								</h3>
								<!--begin::Toolbar-->
								<div class="card-toolbar" data-kt-buttons="true">
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="kt_charts_widget_6_sales_btn">Sales</a>
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="kt_charts_widget_6_expenses_btn">Expenses</a>
								</div>
								<!--end::Toolbar-->
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body">
								<!--begin::Chart-->
								<div id="kt_charts_widget_6_chart" style="height: 350px"></div>
								<!--end::Chart-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::Charts Widget 5-->
					</div>
				</div>

				<div class="row g-5 g-xl-8">
					<div class="col-xl-6">
						<!--begin::Charts Widget 7-->
						<div class="card card-xl-stretch mb-xl-8">
							<!--begin::Header-->
							<div class="card-header border-0 pt-5">
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label fw-bolder fs-3 mb-1">Recent Users</span>
									<span class="text-muted fw-bold fs-7">More than 500 new users</span>
								</h3>
								<!--begin::Toolbar-->
								<div class="card-toolbar" data-kt-buttons="true">
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="kt_charts_widget_7_year_btn">Year</a>
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="kt_charts_widget_7_month_btn">Month</a>
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4" id="kt_charts_widget_7_week_btn">Week</a>
								</div>
								<!--end::Toolbar-->
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body">
								<!--begin::Chart-->
								<div id="kt_charts_widget_7_chart" style="height: 350px" class="card-rounded-bottom"></div>
								<!--end::Chart-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::Charts Widget 7-->
					</div>
					<div class="col-xl-6">
						<!--begin::Charts Widget 8-->
						<div class="card card-xl-stretch mb-5 mb-xl-8">
							<!--begin::Header-->
							<div class="card-header border-0 pt-5">
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label fw-bolder fs-3 mb-1">Recent Orders</span>
									<span class="text-muted fw-bold fs-7">More than 500 new orders</span>
								</h3>
								<!--begin::Toolbar-->
								<div class="card-toolbar" data-kt-buttons="true">
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="kt_charts_widget_8_year_btn">Year</a>
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="kt_charts_widget_8_month_btn">Month</a>
									<a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4" id="kt_charts_widget_8_week_btn">Week</a>
								</div>
								<!--end::Toolbar-->
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							<div class="card-body">
								<!--begin::Chart-->
								<div id="kt_charts_widget_8_chart" style="height: 350px" class="card-rounded-bottom"></div>
								<!--end::Chart-->
							</div>
							<!--end::Body-->
						</div>
						<!--end::Charts Widget 8-->
					</div>
				</div>
                --}}
                <!-- end chart -->

                <!--begin::Row-->
                <div class="row gy-5 g-xl-8">
                    <!--begin::Col-->
                    <!-- <div class="col-xl-4">
                       
                        <div class="card card-xl-stretch mb-xl-8">
                          
                            <div class="card-header card-header-dashboard border-0 bd-cyan-2">
                                <h3 class="card-title fw-bolder"><span class="card-label fw-bolder fs-3">Todo List</span></h3>
                                <div class="card-toolbar">
                                  
                                    <button type="button"
                                            class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                 viewBox="0 0 24 24">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"/>
                                                    <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000"
                                                          opacity="0.3"/>
                                                    <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000"
                                                          opacity="0.3"/>
                                                    <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000"
                                                          opacity="0.3"/>
                                                </g>
                                            </svg>
                                        </span>
                                      
                                    </button>

                                </div>
                            </div>
                        
                            <div class="card-body pt-2">

                                @php
                                    $i=1;
                                @endphp
                                @foreach($todo_list as $key=>$val)

                                    @php
                                        switch($i) {
                                            case($i==1):
                                                $bg_color = 'bg-success';
                                            break;

                                            case($i==2):
                                                $bg_color = 'bg-danger';
                                            break;

                                            case($i==3):
                                                $bg_color = 'bg-warning';
                                            break;

                                            case($i==4):
                                                $bg_color = 'bg-primary';
                                            break;
                                            default:
                                                $bg_color = 'bg-default';
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center mb-8">
                                    
                                        <span class="bullet bullet-vertical h-40px {{$bg_color}}"></span>
                                   
                                        <div class="form-check form-check-custom form-check-solid mx-5">
                                            <input class="form-check-input" type="checkbox" value=""/>
                                        </div>
                                       
                                        <div class="flex-grow-1">
                                            <a href="{{ route('task-list') }}"
                                               class="text-gray-800 text-hover-primary fw-bolder fs-6">{{$val->task_name}}</a>
                                            <span class="text-muted d-block"
                                                  style="color: red !important;font-size:10px;">Due Date: {{substr($val->due_date, 0, 10)}}</span>
                                        </div>
                                      
                                        <span class=""
                                              style="text-align:center;width:70px !important;font-size:9px;color:#fff;background-color:#3B71CA;padding:5px; border-radius:5px;">{{@$const_task[$val->status]}}</span>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach

                            </div>
                           
                        </div>
                       
                    </div> -->

                    <div class="col-xl-4">
                       
                       <div class="card card-xl-stretch mb-xl-8">
                         
                           <div class="card-header card-header-dashboard border-0 bd-cyan-2">
                               <h3 class="card-title fw-bolder"><span class="card-label fw-bolder fs-3">Notifications</span></h3>
                               <div class="card-toolbar">
													<!--begin::Menu-->
													<button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
														<!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
														<span class="svg-icon svg-icon-2">
															<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
																	<rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																	<rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																	<rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
																</g>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</button>
													<!--begin::Menu 3-->
												
													<!--end::Menu 3-->
													<!--end::Menu-->
												</div>
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body pt-0">
                                                                        
                                                @foreach ($notifications as $notification)
                                                    <!-- Notification Link -->
                                                    <div class="d-flex align-items-center bg-light-success rounded p-1 mb-2 notification-item" data-id="{{ $notification->id }}">
                                                        <span class="svg-icon {{ $notification->notify_seen ? 'svg-icon-success' : 'svg-icon-danger' }} me-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black"/>
                                                                <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black"/>
                                                        </svg>
                                                        </span>
                                                        <div class="flex-grow-1 me-2 single-line-text">
                                                            <!-- Notification Title -->
                                                            <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-7 notification-link " data-bs-toggle="modal" data-bs-target="#notificationModal_{{ $notification->id }}" data-id="{{ $notification->id }}">
                                                                {{ $notification->notify_msg }}
                                                            </a>
                                                            <span class="text-muted fw-bold d-block">
                                                                Due in {{ \Carbon\Carbon::parse($notification->notify_datetime)->diffForHumans() }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="notificationModal_{{ $notification->id }}" tabindex="-1" aria-hidden="true">
                                                        <!--begin::Modal dialog-->
                                                        <div class="modal-dialog modal-lg">
                                                            <!--begin::Modal content-->
                                                            <div class="modal-content">
                                                                <!--begin::Modal header-->
                                                                <div class="modal-header pb-0 border-0 justify-content-end">
                                                                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                                        <span class="svg-icon svg-icon-1">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                                                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                                                            </svg>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <!--end::Modal header-->

                                                                <!-- Modal Body -->
                                                                <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                                                                                                                        <div class="card mt-4">
                                                                        <div class="card-header bg-light bd-cyan">
                                                                            <div class="card-title">
                                                                                <h2>Notification Details</h2>
                                                                            </div>
                                                                        </div>
                                                                        <!--begin::Body-->
                                                                        <div class="card-body p-1">
                                                                        
                                                                            <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Notify Message</span>
                                                                                <span>{{ $notification->notify_msg }}</span>
                                                                            </div>

                                                                        
                                                                            <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Notify Date</span>
                                                                                <span>{{ \Carbon\Carbon::parse($notification->notify_datetime)->format('Y-m-d h:i A') }}</span>
                                                                            </div>

                                                                        
                                                                         
                                                                            <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Lead</span>
                                                                                <span>{{ $notification->lead_first_name . ' ' . $notification->lead_last_name . ' <' . $notification->lead_email . '>' }}</span>
                                                                            </div>
                                                                          

                                                                            
                                                                           
                                                                            <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Notified By</span>
                                                                                <span>
                                                                                    @if(empty($notification->user_first_name) && empty($notification->user_last_name))
                                                                                        System User
                                                                                    @else
                                                                                        {{ $notification->user_first_name . ' ' . $notification->user_last_name . ' <' . $notification->user_email . '>' }}
                                                                                    @endif
                                                                                </span>
                                                                            </div>

                                                                           

                                                                        
                                                                            <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                                                                                <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Send SMS</span>
                                                                                <span>{{ $notification->send_sms == 1 ? 'Yes' : ($notification->send_sms == 0 ? 'No' : '') }}</span>
                                                                            </div>

                                                                             
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            </div>
                                                                            
                                                                           
                                                                        </div>



                                                                    </div>
                                                                
                                                                </div>
                                                                <!--end::Modal body-->
                                                            </div>
                                                            <!--end::Modal content-->
                                                        </div>
                                                        <!--end::Modal dialog-->
                                                    </div>
                                                    @endforeach


											
											</div>
											<!--end::Body-->
										</div>
										<!--end::List Widget 6-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-xl-8">
                        <!--begin::Tables Widget 9-->
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <!--begin::Header-->
                            <div class="card-header card-header-dashboard border-0 bd-cyan-2">
                                <h3 class="card-title align-items-start flex-column text-dark">
                                    <span class="card-label fw-bolder fs-3">New Leads</span>
                                </h3>
                                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top"
                                     data-bs-trigger="hover" title="">

                                     <div class="d-flex align-items-center gap-3">
                                     <a href="/gplexCRM/lead/create?form_id=6820060189"
                                       class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal"
                                       data-bs-target="#add_quick_lead_modal">

                                        <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                                  transform="rotate(-90 11.364 20.364)" fill="black"/>
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black"/>
                                        </svg>
                                    </span>Quick Lead</a>

                                    <a href="/gplexCRM/lead/create?form_id=6820060189"
                                       class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal"
                                       data-bs-target="#add_lead_modal">

                                        <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                                  transform="rotate(-90 11.364 20.364)" fill="black"/>
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black"/>
                                        </svg>
                                    </span>Create Lead</a>
                                     </div>
                                 
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-3">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                        <!--begin::Table head-->
                                        <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th class="w-25px">
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                           data-kt-check="true" data-kt-check-target=".widget-9-check"/>
                                                </div>
                                            </th>
                                            <th class="min-w-150px th-data">Name</th>
                                            <th class="min-w-140px th-data">Email</th>
                                            <th class="min-w-120px th-data">Phone</th>
                                            <th class="min-w-120px th-data">Gender</th>
                                            <th class="min-w-120px th-data">Age</th>
                                        </tr>
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody>
                                        @foreach($lead_list as $key=>$val)
                                            <tr>
                                                <td>
                                                    <div
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input widget-9-check" type="checkbox"
                                                               value="1"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!-- <div class="symbol symbol-45px me-5">
                                                            <img src="assets/media/avatars/150-3.jpg" alt="" />
                                                        </div> -->
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <a href="{{ URL::to("lead/$val->id") }}"
                                                               class="text-dark fw-bolder text-hover-primary fs-6">{{ $val->first_name }}</a>
                                                            <span class="text-muted fw-bold text-muted d-block fs-7">Lead Source: {{$val->lead_source}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                       class="text-dark fw-bolder text-hover-primary d-block fs-6">{{$val->email}}</a>
                                                   
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex flex-column w-100 me-2">
                                                        <div class="d-flex flex-stack mb-2">
                                                            <span
                                                                class="text-muted me-2 fs-7 fw-bold">{{$val->phone}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex flex-column w-100 me-2">
                                                        <div class="d-flex flex-stack mb-2">
                                                            <span
                                                                class="text-muted me-2 fs-7 fw-bold">{{$val->gender}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="d-flex flex-column w-100 me-2">
                                                        <div class="d-flex flex-stack mb-2">
                                                            <span
                                                                class="text-muted me-2 fs-7 fw-bold">{{$val->age}}</span>
                                                        </div>
                                                    </div>
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
                        <!--end::Tables Widget 9-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row gy-5 g-xl-8">
                    <!--begin::Col-->
                    {{-- <div class="col-xl-4">
                       
                        <div class="card card-xl-stretch mb-xl-8">
                            
                            <div class="card-header card-header-dashboard border-0 bd-cyan-2">
                                <h3 class="card-title fw-bolder text-dark"><span class="card-label fw-bolder fs-3">Agents</span></h3>
                                <div class="card-toolbar">
                                   
                                    <button type="button"
                                            class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                       
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                 viewBox="0 0 24 24">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"/>
                                                    <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000"
                                                          opacity="0.3"/>
                                                    <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000"
                                                          opacity="0.3"/>
                                                    <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000"
                                                          opacity="0.3"/>
                                                </g>
                                            </svg>
                                        </span>
                                      
                                    </button>

                                 
                                </div>
                            </div>
                     
                            <div class="card-body pt-2">

                                @foreach($agent_list as $key=> $val)
                                    <div class="d-flex align-items-center mb-7">
                                       
                                        <div class="symbol symbol-50px me-5">
                                            @if($val->user->profile_image && file_exists("uploads/agents/".$val->user->profile_image))
                                                <img src="uploads/agents/{{$val->user->profile_image}}" class=""
                                                     alt=""/>
                                            @else
                                                <img src="assets/media/avatars/blank.png" class="" alt=""/>
                                            @endif
                                        </div>
                                    
                                        <div class="flex-grow-1">
                                            <a href="{{ route('agents-show', $val->agent_id) }}"
                                               class="text-dark fw-bolder text-hover-primary fs-6">{{$val->first_name}} {{$val->last_name}}</a>
                                            <span class="text-muted d-block fw-bold">Agent Id: {{$val->agent_id}}</span>
                                        </div>
                                      
                                    </div>
                                @endforeach

                            </div>
                           
                        </div>
                       
                    </div> --}}

                    <div class="col-xl-4">
                        
                        <div class="card card-xl-stretch mb-xl-8">
                            
                            <div class="card-header card-header-dashboard border-0 bd-cyan-2">
                                <h3 class="card-title fw-bolder"><span class="card-label fw-bolder fs-3">Todo List</span></h3>
                                <div class="card-toolbar">
                                    
                                    <button type="button"
                                            class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                    viewBox="0 0 24 24">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"/>
                                                    <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000"
                                                            opacity="0.3"/>
                                                    <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000"
                                                            opacity="0.3"/>
                                                    <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000"
                                                            opacity="0.3"/>
                                                </g>
                                            </svg>
                                        </span>
                                        
                                    </button>

                                </div>
                            </div>
                        
                            <div class="card-body pt-2">

                                @php
                                    $i=1;
                                @endphp
                                @foreach($todo_list as $key=>$val)

                                    @php
                                        switch($i) {
                                            case($i==1):
                                                $bg_color = 'bg-success';
                                            break;

                                            case($i==2):
                                                $bg_color = 'bg-danger';
                                            break;

                                            case($i==3):
                                                $bg_color = 'bg-warning';
                                            break;

                                            case($i==4):
                                                $bg_color = 'bg-primary';
                                            break;
                                            default:
                                                $bg_color = 'bg-default';
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center mb-8">
                                    
                                        <span class="bullet bullet-vertical h-40px {{$bg_color}}"></span>
                                    
                                        <div class="form-check form-check-custom form-check-solid mx-5">
                                            <input class="form-check-input" type="checkbox" value=""/>
                                        </div>
                                        
                                        <div class="flex-grow-1">
                                            <a href="{{ route('task-list') }}"
                                                class="text-gray-800 text-hover-primary fw-bolder fs-6">{{$val->task_name}}</a>
                                            <span class="text-muted d-block"
                                                    style="color: red !important;font-size:10px;">Due Date: {{substr($val->due_date, 0, 10)}}</span>
                                        </div>
                                        
                                        <span class=""
                                                style="text-align:center;width:70px !important;font-size:9px;color:#fff;background-color:#3B71CA;padding:5px; border-radius:5px;">{{@$const_task[$val->status]}}</span>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach

                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="col-xl-8">
                        <!--begin::Tables Widget 9-->
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <!--begin::Header-->
                            <div class="card-header card-header-dashboard border-0 bd-cyan-2">
                                <h3 class="card-title align-items-start flex-column text-dark">
                                    <span class="card-label fw-bolder fs-3">Lead Distribution</span>
                                </h3>
                                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top"
                                     data-bs-trigger="hover" title="">                                 
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-3">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                        <!--begin::Table head-->
                                        <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th class="w-25px">
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                           data-kt-check="true" data-kt-check-target=".widget-9-check"/>
                                                </div>
                                            </th>
                                            <th class="min-w-150px th-data">Full Name</th>
                                            <th class="min-w-140px th-data">Assigned To</th>
                                            <th class="min-w-120px th-data">Priority</th>
                                            <th class="min-w-120px th-data">No of Attempt</th>
                                            <th class="min-w-150px th-data">Cycle Time</th>
                                            <th class="min-w-120px th-data">Status</th>

                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($dist_list as $key=>$val)
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input widget-9-check" type="checkbox" value="1"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-left">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <span class="text-dark fw-bold fs-6">{{ $val->first_name }} {{ $val->last_name }}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <span class="text-dark fw-bold fs-6">{{ $val->username }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <span class="text-dark fw-bold fs-6">{{$val->priority}}</span>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <span class="text-dark fw-bold fs-6">{{ $val->no_of_attempt }}</span>
                                                    </div>
                                                </td>

                                                 <td class="text-center">
                                                    <div class="d-flex flex-column w-100 me-2">
                                                        <div class="d-flex flex-stack mb-2">
                                                            <span class="text-muted me-2 fs-7 fw-bold">{{ $val->cycle_time }}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <span class="text-dark fw-bold fs-6">
                                                            @if($val->status==1)
                                                                Active
                                                            @elseif($val->status==0)
                                                                Pending
                                                            @elseif($val->status==3)
                                                                Failed
                                                            @endif
                                                        </span>
                                                    </div>
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
                        <!--end::Tables Widget 9-->
                    </div>
                    {{--
                        <div class="col-xl-8">
                            <!--begin::Tables Widget 9-->
                            <div class="card card-xl-stretch mb-5 mb-xl-8">
                                <div class="card-header card-header-dashboard border-0 bd-cyan-2">
                                    <h3 class="card-title align-items-start flex-column py-2 text-dark">
                                        <span class="card-label fw-bolder fs-3">Campaign</span>
                                    </h3>
                                </div>

                                <div class="card-body py-3">
                                    <div class="table-responsive">
                                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                            <!--begin::Table head-->
                                            <thead>
                                            <tr class="fw-bolder text-muted">
                                                <th class="w-25px">
                                                    <div
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1" data-kt-check="true" data-kt-check-target=".widget-9-check"/>
                                                    </div>
                                                </th>
                                                <th class="min-w-150px th-data">Campaign Title</th>
                                                <th class="min-w-140px th-data">Start date</th>
                                                <th class="min-w-120px th-data">End Start</th>
                                                <th class="min-w-120px th-data">Type</th>
                                                <th class="min-w-120px th-data">Limit</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($camp_list as $key=>$val)
                                                <tr>
                                                    <td>
                                                        <div
                                                            class="form-check form-check-sm form-check-custom form-check-solid">
                                                            <input class="form-check-input widget-9-check" type="checkbox"
                                                                value="1"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="d-flex justify-content-start flex-column">
                                                                <a href="{{ route('campaign-show', $val->id) }}"
                                                                class="text-dark fw-bolder text-hover-primary fs-6">{{ $val->campaign_title }}</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="#"
                                                        class="text-dark fw-bolder text-hover-primary d-block fs-6">{{$val->start_date}}</a>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex flex-column w-100 me-2">
                                                            <div class="d-flex flex-stack mb-2">
                                                                <span
                                                                    class="text-muted me-2 fs-7 fw-bold">{{$val->end_date}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex flex-column w-100 me-2">
                                                            <div class="d-flex flex-stack mb-2">
                                                                <span
                                                                    class="text-muted me-2 fs-7 fw-bold">{{$val->campaign_type}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex flex-column w-100 me-2">
                                                            <div class="d-flex flex-stack mb-2">
                                                                <span
                                                                    class="text-muted me-2 fs-7 fw-bold">{{$val->campaign_limit}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <!--end::Tables Widget 9-->
                        </div>
                        --}}

                    </div>

                </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->

        <!-- add modal -->
        <div class="modal fade" id="add_lead_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog mw-400px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--begin::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                        <!--begin::Heading-->
                        <!--begin::Textarea-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Form Name</label>
                                    <select class="form-control form-control-sm form-control-solid" id="form_id"
                                            name="form_id" aria-label="Default select example">
                                        <option value="">Select Form Name</option>
                                        @foreach($formName as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('form_id'))
                                        <span class="text-danger">{{ $errors->first('form_id') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end py-0 px-0">
                            
                            <button type="button" class="btn btn-primary btn-sm" id="submit_button">Submit</button>
                        </div>
                        <!--end::Textarea-->
                    </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>



        <div class="modal fade" id="add_quick_lead_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog mw-800px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header pb-0 border-0 justify-content-end">
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="black"/>
                            </svg>
                        </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--begin::Modal header-->
                    <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                                <!--begin::Heading-->
                                <!--begin::Textarea-->
                    <div class="row">
                    <div class="col-xxl-12">
                        <div class="card card-xxl-stretch mt-4">
                            <div class="card-header bg-light bd-cyan">
                                <!--begin::Card title-->
                                <div class="card-title m-0">
                                    <h3 class="fw-bolder m-0">Lead Create</h3>
                                </div>
                                <!--end::Card title-->
                            </div>

                            <!-- Card Body-->
                            <div class="card-body">

                                <!-- Start Form-->

                                <form class="g-form w-100" action="{{ route('quick-lead-store') }}" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">Form Name</label>
                                            <select class="form-control form-control-sm form-control-solid" id="form_id"
                                                    name="form_id" aria-label="Default select example">
                                                <option value="">Select Form Name</option>
                                                @foreach($formName as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('form_id'))
                                                <span class="text-danger">{{ $errors->first('form_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                        <div class="col-md-6">
                                            <div class="fv-row mb-3">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bolder text-dark">First Name</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input class="form-control form-control-sm form-control-solid" type="text" name="first_name" value="{{ old('first_name') }}" autocomplete="off" />
                                                <!--end::Input-->
                                                @if ($errors->has('first_name'))
                                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                                @endif
                                                
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="fv-row mb-3">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bolder text-dark">Last Name</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input class="form-control form-control-sm form-control-solid"  type="text" name="last_name" value="{{ old('last_name') }}" autocomplete="off" />
                                                <!--end::Input-->
                                                @if ($errors->has('last_name'))
                                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="fv-row mb-3">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bolder text-dark">Email</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input class="form-control form-control-sm form-control-solid" type="email" name="email" value="{{ old('email') }}" autocomplete="off" />
                                                <!--end::Input-->
                                                @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="fv-row mb-3">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bolder text-dark">Phone</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input class="form-control form-control-sm form-control-solid"  type="text" value="{{ old('phone') }}" name="phone" autocomplete="off" />
                                                <!--end::Input-->
                                                @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                                @endif
                                                
                                            </div>
                                        </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-3">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">Lead Start Date</label>
                                            <input class="form-control form-control-sm form-control-solid flatpickr" type="text" id="common_dob" name="lead_start_date" value="{{ old('lead_start_date') }}" />
                                            @if ($errors->has('lead_start_date'))
                                            <div class="text-danger">{{ $errors->first('lead_start_date') }}</div>
                                            @endif
                                        </div>
                                      </div>

                                     <div class="col-md-6">
                                        <div class="fv-row mb-3">
                                            <label class="form-label fw-bolder text-dark">Lead Status</label>
                                            <select class="form-control form-control-sm form-control-solid" name="lead_status">
                                                <option value="1" {{ old('lead_status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ old('lead_status', '1') == '0' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @if ($errors->has('lead_status'))
                                            <span class="text-danger">{{ $errors->first('lead_status') }}</span>
                                            @endif
                                        </div>
                                     </div>

                                    
                                    <!--End Row-->
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Submit</button>
                                    </div>

                                </form>
                                <!-- End Form-->

                                <!-- End Form-->

                            </div>
                            <!--End Card body-->

                            <!--begin::Actions-->

                            <!--end::Actions-->
                        </div>
                    </div>
                </div>
                        <!--end::Textarea-->
             </div>
                    <!--end::Modal body-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>

        <script>
            document.getElementById('submit_button').addEventListener('click', function () {
                var formId = document.getElementById('form_id').value;
                if (formId) {
                    var baseUrl = '{{ url('/') }}';
                    //window.location.href = 'http://localhost/gplexCRM/public/lead/create?form_id=' + formId;
                    window.location.href = baseUrl + '/lead/create?form_id=' + formId;
                } else {
                    alert('Please select a form.');
                }
            });
        </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.notification-link').forEach(function (element) {
            element.addEventListener('click', function (e) {
                e.preventDefault();

                let notificationId = this.getAttribute('data-id');
                let baseUrl = "{{ url('/') }}"; // base url get

                fetch(`${baseUrl}/notification/mark-as-read/${notificationId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          let notificationItem = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
                          if (notificationItem) {
                              let icon = notificationItem.querySelector('.svg-icon');
                              icon.classList.remove('svg-icon-danger');
                              icon.classList.add('svg-icon-success');
                          }
                      }
                  })
                  .catch(error => console.error('Error:', error));
            });
        });
    });
</script>

<script>
    $(document).ready(function(){
        @if ($errors->any())
            $("#add_quick_lead_modal").modal('show'); 
        @endif
    });
</script>



@endsection
