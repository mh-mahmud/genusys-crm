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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Blog Category Edit Forms
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Blog category edit form</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <a href="{{ route('blogger-category-list') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Category List</a>
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
                <!-- <div class="card card-xxl-stretch"> -->
                <div class="card-header bg-light bd-cyan">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Blog Category Edit</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form w-100" action="{{ route('blogger-category-update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $category->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Category Name</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="category_name" value="{{ old('category_name', $category->category_name) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('category_name'))
                                    <span class="text-danger">{{ $errors->first('category_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Parent Name</label>
                                    <select class=" form-control form-control-sm form-control-solid" name="parent_id"
                                            aria-label="Default select example">
                                            <option value="">Select Parent</option>
                                                @foreach($parents as $id => $name)
                                                    <option value="{{ $id }}" {{ $category->parent_id == $id ? 'selected' : '' }}>{{$name}}</option>
                                                @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label  fw-bolder text-dark">Category Image Upload</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid" type="file" name="category_image" autocomplete="off" />

                                    @if ($category->category_image)
                                    <div class="mt-3" id="profile-image-container">
                                        <img src="{{ asset('uploads/blogger_categories/' . $category->category_image) }}" alt="Category Image" width="100px">
                                        <button type="button" class="btn btn-danger btn-sm p-2" id="delete-profile-image">
                                            <i class="fas fa-trash-alt pe-0"></i>
                                        </button>
                                    </div>

                                    @else
                                        <img alt="Logo" src="{{ asset('uploads/noimage.jpg') }}" width="100px"/>
                                    @endif

                                    <!--end::Input-->
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Status</label>
                                    <select class="form-control form-control-sm form-control-solid" name="status" aria-label="Default select example">
                                        <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Category Description</label>
                                    <textarea class="form-control form-control-sm  form-control-solid" name="category_description" rows="3">{{ $category->category_description }}</textarea>
                                </div>
                            </div>


                        </div>
                        <!--End Row-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update Changes
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#delete-profile-image').click(function() {
            if (confirm('Are you sure you want to delete your Blogger category image?')) {
                $.ajax({
                    url: '{{ route('update-blogger-category-image', $category->id) }}', // Using the correct route
                    type: 'PUT', // Correct HTTP method
                    data: {
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#profile-image-container').remove();
                           // alert('Profile image deleted successfully');
                        } else {
                            alert('Error deleting blogger category image');
                        }
                    },
                    error: function() {
                        alert('Error deleting blogger category image');
                    }
                });
            }
        });
    });
    </script>

@endsection