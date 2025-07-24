@extends('layouts.master')
@php
use Carbon\Carbon;
@endphp

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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Product Details
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Show Product Details</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">

            <a href="{{ route('product-list') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Product List</a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->

<!--**********************************
                                Tables View
                  ***********************************-->
<div class="container-fluid">
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
    <div class="row">
        <div class="col-xxl-8 mx-auto">
            <div class="card mt-4">
                <div class="card-header bg-light bd-cyan">
                    <div class="card-title">
                        <h2>Product Details</h2>
                    </div>
                </div>
                <!--begin::Body-->
                <div class="card-body p-1">


                <div class="g-p-feature-details-area mb-5">
                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Name</span>
                        <span>{{ $product->name }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Code</span>
                        <span>{{ $product->product_code }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Product Type</span>
                        {{ config('constants.PRODUCT_TYPE')[$product->product_type] }}
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Cost</span>
                        <span>{{ $product->product_cost }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Value</span>
                        <span>{{ $product->product_value }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px flex-shrink-0">Description</span>
                        <span>{{ $product->description }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Image</span>
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-140px symbol-fixed position-relative">
                                @if ($product->img_path)
                                <img src="{{ asset('uploads/products/' . $product->img_path) }}" alt="Product Image" />
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 bg-light p-3 mb-1">
                        <span class="fs-6 fw-bolder mb-1 text-gray-900 text-hover-primary w-lg-100px w-xxl-150px">Status</span>
                        @if ($product->status === 1)
                        <span>Active</span>
                        @elseif ($product->status === 0)
                        <span>Inactive</span>
                        @endif
                    </div>

                </div>








                </div>


            </div>

        </div>
    </div>



    <div class="row">
        <div class="col-xxl-8 mx-auto">
            <div class="card mt-4">
                <div class="card-header bg-light bd-cyan">
                    <div class="card-title">
                        <h2>Product Feature List</h2>
                    </div>
                </div>
                <!--begin::Body-->
                <div class="card-body p-1">
				<!--begin::Table container-->
				<div class="table-responsive">
				@if($productFeatures->isNotEmpty())
					<!--begin::Table-->
					<table class="table table-sm table-condensed table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
						<!--begin::Table head-->
						<thead>
						<tr class="fw-bolder text-muted bg-light bd-cyan">
						    <th class="ps-4 rounded-start min-w-40px">SL</th>
							<th class="min-w-150px">Product Feature Name</th>
							<th class="min-w-140px">Unit Price</th>
                            <th class="min-w-100px text-end-new">Actions</th>
						</tr>
						</thead>
						<!--end::Table head-->
						<!--begin::Table body-->
						<tbody>
						@foreach ($productFeatures as $key => $productFeature)
						<tr>
							<td class="ps-5 text-dark fs-6">{{ $key + 1 }}</td>
							<td class="text-dark fs-6">{{ $productFeature->p_feature_name }}</td>
							<td class="text-dark fs-6">{{ $productFeature->unit_price }}</td>
							<td>
								<div
                                                    class="d-inline-flex justify-content-end gap-1 w-100 border-bottom-0">
								
									<a title="Edit" href="#"
									class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editFeatureModal"
                                            data-id="{{ $productFeature->id }}"
                                            data-name="{{ $productFeature->p_feature_name }}"
                                            data-price="{{ $productFeature->unit_price }}">
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

                                    <form action="{{ route('product-feature-destroy', $productFeature->id) }}" method="POST" style="display: inline;">
										@csrf
										@method('DELETE')
										<button title="Delete" type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"  onclick="return confirmDelete()">
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
								
								</div>
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

                <!-- Edit Modal -->
        <div class="modal fade" id="editFeatureModal" tabindex="-1" aria-labelledby="editFeatureModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFeatureModalLabel">Edit Product Feature</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editFeatureForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" id="editFeatureId" name="id">

                            <div class="mb-3">
                                <label for="editFeatureName" class="form-label fw-bolder text-dark">Product Feature Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm form-control-solid" id="editFeatureName" name="p_feature_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="editUnitPrice" class="form-label fw-bolder text-dark">Unit Price<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm form-control-solid" id="editUnitPrice" name="unit_price" required>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success w-auto">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
				<!--end::Table container-->
			</div>


            </div>

        </div>
    </div>


    <div class="row">
        <div class="col-xxl-8 mx-auto">
            <div class="card mt-4">
                <div class="card-header bg-light bd-cyan">
                    <div class="card-title">
                        <h2>Add Product Feature</h2>
                    </div>
                </div>
                <!--begin::Body-->
                <div class="card-body p-1">


                    <form class="g-form w-100" action="{{ route('add-product-feature') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Product Feature Name<span class="text-danger">*</span></label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid"
                                        type="text" name="p_feature_name" autocomplete="off" value="{{ old('p_feature_name') }}" />
                                    <!--end::Input-->
                                    @if ($errors->has('p_feature_name'))
                                    <span class="text-danger">{{ $errors->first('p_feature_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Unit Price<span class="text-danger">*</span></label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid"
                                        type="text" name="unit_price" autocomplete="off" value="{{ old('unit_price') }}" />
                                    <!--end::Input-->
                                    @if ($errors->has('unit_price'))
                                    <span class="text-danger">{{ $errors->first('unit_price') }}</span>
                                    @endif
                                </div>
                            </div>

                        <div class="col-md-2 d-flex align-items-center">
                            <button type="submit"  style="margin-top: 20px;" class="btn btn-sm btn-success w-100">
                                Submit
                            </button>

                        </div>

                        </div>

                    </form>






                </div>


            </div>

        </div>
    </div>





</div>

<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete Product Feature?")) {
            document.getElementById('deleteForm').submit();
        }
        return false;
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        var editFeatureModal = document.getElementById("editFeatureModal");

        editFeatureModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget; // button that triggered the modal
            var id = button.getAttribute("data-id");
            var name = button.getAttribute("data-name");
            var price = button.getAttribute("data-price");

            //Set form values
            document.getElementById("editFeatureId").value = id;
            document.getElementById("editFeatureName").value = name;
            document.getElementById("editUnitPrice").value = price;

            //update form dynamically
            var baseUrl = '{{ url('/') }}'; 
            document.getElementById("editFeatureForm").action = `${baseUrl}/product-feature-update/${id}`;
        });
    });
</script>



<!-- End Tables View-->


<!-- </div> -->
<!--end::Content-->

@endsection