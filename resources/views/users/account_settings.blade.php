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
		<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
			<!--begin::Title-->
			<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Account Setting
				<!--begin::Separator-->
				<span class="h-20px border-gray-200 ms-3 mx-2" style="border-left:1px solid #000!important"></span>
				<!--end::Separator-->
				<!--begin::Description-->
				<small class="text-muted fs-7 fw-bold my-1 ms-1">Show Profile</small>
				<!--end::Description-->
			</h1>
			<!--end::Title-->
		</div>
		<!--end::Page title-->
		<!--begin::Actions-->
		<div class="d-flex align-items-center py-1">
			<!--begin::Button-->
			<!-- <a href="{{ route('create-user') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Create</a> -->

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


	<div class="row">
		<div class="col-xxl-12">
			<div class="card mb-5 mb-xl-10">
				<!--begin::Card header-->
				<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
					<!--begin::Card title-->
					<div class="card-title m-0">
						<h3 class="fw-bolder m-0">Profile Details</h3>
					</div>
					<!--end::Card title-->
				</div>
				<!--begin::Card header-->
				<!--begin::Content-->


				<!--begin::Card body-->
				<div class="card-body border-top p-9">
					<!--begin::Form-->
					<form action="{{ route('profile-update', $user->id) }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<!-- <input type="hidden" name="id" value="{{ $user->user_id }}"> -->
						<div class="row mb-6">
							<label class="col-lg-4 col-form-label fw-bold fs-6">Profile Image</label>
							<div class="col-lg-8">
								<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{ url('uploads/noimage.jpg') }}')">
									@if($user->profile_image != '')
									<div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{ $user->profile_image ? asset('uploads/agents/' . $user->profile_image) : url('uploads/noimage.jpg') }}')"></div>
									@else
									<div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{ url('uploads/noimage.jpg') }}')"></div>
									@endif
									<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
										<i class="bi bi-pencil-fill fs-7"></i>
										<input type="file" name="profile_image" accept=".png, .jpg, .jpeg" />
										<input type="hidden" name="avatar_remove" />
									</label>
									<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
										<i class="bi bi-x fs-2"></i>
									</span>
									<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
										<i class="bi bi-x fs-2"></i>
									</span>
								</div>
								<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
							</div>
						</div>

						<div class="row mb-6">
							<label class="col-lg-4 col-form-label required fw-bold fs-6">Full Name</label>
							<div class="col-lg-8">
								<div class="row">
									<div class="col-lg-6 fv-row">
										<input type="text" name="first_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="" value="{{ $user->first_name }}" />
										@if ($errors->has('first_name'))
										<span class="text-danger">{{ $errors->first('first_name') }}</span>
										@endif
									</div>
									<div class="col-lg-6 fv-row">
										<input type="text" name="last_name" class="form-control form-control-lg form-control-solid" placeholder="" value="{{ $user->last_name }}" />
										@if ($errors->has('last_name'))
										<span class="text-danger">{{ $errors->first('last_name') }}</span>
										@endif
									</div>
								</div>
							</div>
						</div>

						<div class="row mb-6">
							<label class="col-lg-4 col-form-label required fw-bold fs-6">Email</label>
							<div class="col-lg-8 fv-row">
								<input type="email" name="email" class="form-control form-control-lg form-control-solid" placeholder="" value="{{ $user->email }}" />
								@if ($errors->has('email'))
								<span class="text-danger">{{ $errors->first('email') }}</span>
								@endif
							</div>
						</div>

						<div class="row mb-6">
							<label class="col-lg-4 col-form-label fw-bold fs-6">
								<span>Phone Number</span>
								<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i>
							</label>
							<div class="col-lg-8 fv-row">
								<input type="text" name="phone_number" class="form-control form-control-lg form-control-solid" placeholder="" value="{{ $user->phone_number }}" />
							</div>
						</div>

						<div class="row mb-6">
							<label class="col-lg-4 col-form-label fw-bold fs-6">
								<span>Gender</span>
							</label>
							<div class="col-lg-8 fv-row">
								<select name="gender" aria-label="Select a Gender" data-control="select2" data-placeholder="Select a Gender..." class="form-select form-select-solid form-select-lg">
									<option value="">Select Gender</option>
									<option value="Male" {{ $user->gender === 'Male' ? 'selected' : '' }}>Male</option>
									<option value="Female" {{ $user->gender === 'Female' ? 'selected' : '' }}>Female</option>
									<option value="Other" {{ $user->gender === 'Other' ? 'selected' : '' }}>Other</option>
								</select>
							</div>
						</div>

						<div class="row mb-6">
							<label class="col-lg-4 col-form-label fw-bold fs-6">Address</label>
							<div class="col-lg-8 fv-row">
								<textarea name="address" class="form-control form-control-lg form-control-solid" rows="2">{{ $user->address }}</textarea>
							</div>
						</div>

						<div class="row mb-6">
								<!--begin::Label-->
								<label class="col-lg-4 col-form-label fw-bold fs-6">Status</label>
								<!--end::Label-->
								<!--begin::Col-->
								<div class="col-lg-8 fv-row">
									<!--begin::Input-->
									<select name="status" aria-label="Select a Status" data-control="select2" data-placeholder="Select a Status..." class="form-select form-select-solid form-select-lg">
										<option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
										<option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>

									</select>
									<!--end::Input-->
									<!--begin::Hint-->

									<!--end::Hint-->
								</div>
								<!--end::Col-->
							</div>

						

						<div class="row mb-6">
							<label class="col-lg-4 col-form-label fw-bold fs-6">Current Password</label>
							<div class="col-lg-8 fv-row">
								<input type="password" name="current_password" class="form-control form-control-lg form-control-solid" value="" placeholder="" />
								@if ($errors->has('current_password'))
								<span class="text-danger">{{ $errors->first('current_password') }}</span>
								@endif
							</div>
						</div>

						<div class="row mb-6">
							<label class="col-lg-4 col-form-label fw-bold fs-6">New Password</label>
							<div class="col-lg-8 fv-row">
								<input type="password" name="password" class="form-control form-control-lg form-control-solid" value="" placeholder="" />
								@if ($errors->has('password'))
								<span class="text-danger">{{ $errors->first('password') }}</span>
								@endif
							</div>
						</div>

						<div class="row mb-6">
							<label class="col-lg-4 col-form-label fw-bold fs-6">Confirm Password</label>
							<div class="col-lg-8 fv-row">
								<input type="password" name="password_confirmation" class="form-control form-control-lg form-control-solid" value="" placeholder="" />
								@if ($errors->has('password_confirmation'))
								<span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
								@endif
							</div>
						</div>

						<div class="card-footer d-flex justify-content-end py-6 px-9">
						    <a href="{{ route('profile-edit', $user->id) }}" class="btn btn-light me-2">Reset</a>
							<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
						</div>
					</form>
					<!--end::Form-->

					<!--end::Input group-->
				</div>
				<!--end::Card body-->
				<!--begin::Actions-->


				<!--end::Content-->
			</div>



		</div>
	</div>
</div>



<!-- End Tables-->

@endsection