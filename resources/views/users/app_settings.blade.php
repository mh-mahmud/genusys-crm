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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Settings Forms
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the settings form</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Dashboard</a>
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

    <!--Table Alert Message-->
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


    <div class="row">
        <div class="col-xxl-12">
            <div class="card card-xxl-stretch mt-4">
                <!-- <div class="card card-xxl-stretch"> -->
                <div class="card-header bg-light bd-cyan">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">App Settings</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->
                    <form class="g-form w-100" action="{{ route('save-app-settings') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Facebook Link</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="facebook_link" value="{{ old('facebook_link', $data->facebook_link) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('facebook_link'))
                                    <span class="text-danger">{{ $errors->first('facebook_link') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Whats App Link</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="whats_app_link" value="{{ old('whats_app_link', $data->whats_app_link) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('whats_app_link'))
                                    <span class="text-danger">{{ $errors->first('whats_app_link') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Instagram Link</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="instagram_link" value="{{ old('instagram_link', $data->instagram_link) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('instagram_link'))
                                    <span class="text-danger">{{ $errors->first('instagram_link') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Youtube Link</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="youtube_link" value="{{ old('youtube_link', $data->youtube_link) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('youtube_link'))
                                    <span class="text-danger">{{ $errors->first('youtube_link') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Twitter Link</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="twitter_link" value="{{ old('twitter_link', $data->twitter_link) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('twitter_link'))
                                    <span class="text-danger">{{ $errors->first('twitter_link') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Linkedin Link</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="linkedin_link" value="{{ old('linkedin_link', $data->linkedin_link) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('linkedin_link'))
                                    <span class="text-danger">{{ $errors->first('linkedin_link') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{--
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Messanger Link</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="messanger_link" value="{{ old('messanger_link', $data->messanger_link) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('messanger_link'))
                                    <span class="text-danger">{{ $errors->first('messanger_link') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Whats App Chat Link</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="whats_app_chat_link" value="{{ old('whats_app_chat_link', $data->whats_app_chat_link) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('whats_app_chat_link'))
                                    <span class="text-danger">{{ $errors->first('whats_app_chat_link') }}</span>
                                    @endif
                                </div>
                            </div>
                            --}}

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Google Map Link</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="google_map_link" value="{{ old('google_map_link', $data->google_map_link) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('google_map_link'))
                                    <span class="text-danger">{{ $errors->first('google_map_link') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Official Phone Number</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="office_phone_number" value="{{ old('office_phone_number', $data->office_phone_number) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('office_phone_number'))
                                    <span class="text-danger">{{ $errors->first('office_phone_number') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Phone Number 2</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="phone_number_2" value="{{ old('phone_number_2', $data->phone_number_2) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('phone_number_2'))
                                    <span class="text-danger">{{ $errors->first('phone_number_2') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Phone Number 3</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="phone_number_3" value="{{ old('phone_number_3', $data->phone_number_3) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('phone_number_3'))
                                    <span class="text-danger">{{ $errors->first('phone_number_3') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{--
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Delivery Charge (Dhaka)</label>
                                    <input class="form-control form-control-sm form-control-solid" type="number" name="charge_inside_dhaka" value="{{ old('charge_inside_dhaka', $data->charge_inside_dhaka) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('charge_inside_dhaka'))
                                    <span class="text-danger">{{ $errors->first('charge_inside_dhaka') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Delivery Charge (Outside of Dhaka)</label>
                                    <input class="form-control form-control-sm form-control-solid" type="number" name="charge_outside_dhaka" value="{{ old('charge_outside_dhaka', $data->charge_outside_dhaka) }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('charge_outside_dhaka'))
                                    <span class="text-danger">{{ $errors->first('charge_outside_dhaka') }}</span>
                                    @endif
                                </div>
                            </div>
                            --}}


                            {{--
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label  fw-bolder text-dark">product Image Upload</label>
                                    <input class="form-control form-control-sm form-control-solid" type="file" name="img_path" autocomplete="off" />

                                    @if ($data->img_path)
                                    <div class="mt-3" id="profile-image-container">
                                        <img src="{{ asset('uploads/products/' . $data->img_path) }}" alt="Image" width="100px">
                                        <button type="button" class="btn btn-danger btn-sm p-2" id="delete-profile-image">
                                            <i class="fas fa-trash-alt pe-0"></i>
                                        </button>
                                    </div>
                                    @else
                                        <img alt="Logo" src="{{ asset('uploads/noimage.jpg') }}" width="100px"/>
                                    @endif
                                </div>
                            </div>
                            --}}

                           <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Email API</label>
                                    <textarea class="form-control form-control-sm  form-control-solid" name="email_api" rows="3">{{ $data->email_api }}</textarea>
                                    @if ($errors->has('email_api'))
                                        <span class="text-danger">{{ $errors->first('email_api') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">SMS API</label>
                                    <textarea class="form-control form-control-sm  form-control-solid" name="sms_api" rows="3">{{ $data->sms_api }}</textarea>
                                    @if ($errors->has('sms_api'))
                                        <span class="text-danger">{{ $errors->first('sms_api') }}</span>
                                    @endif
                                </div>
                            </div>


                            {{--
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Stock Status</label>
                                    <select class=" form-control form-control-sm form-control-solid" name="stock_status" aria-label="Default select example">

                                        <option value="">-- select one --</option>
                                        <option value="In Stock" {{ ($data->stock_status == 'In Stock') ? 'selected' : '' }}>In Stock</option>
                                        <option value="Out of Stock" {{ ($data->stock_status == 'Out of Stock') ? 'selected' : '' }}>Out of Stock</option>
                                        <option value="Limit Out" {{ ($data->stock_status == 'Limit Out') ? 'selected' : '' }}>Limit Out</option>

                                    </select>
                                </div>
                            </div>
                            --}}


                           <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">About Us</label>
                                    <textarea
                                        class="form-control form-control-sm  form-control-solid editor" name="about_us" rows="3">{{ $data->about_us }}</textarea>
                                    @if ($errors->has('about_us'))
                                        <span class="text-danger">{{ $errors->first('about_us') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Contact Address</label>
                                    <textarea class="form-control form-control-sm  form-control-solid editor" name="contact_address" rows="3">{{ $data->contact_address }}</textarea>
                                    @if ($errors->has('contact_address'))
                                        <span class="text-danger">{{ $errors->first('contact_address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Return Policy</label>
                                    <textarea
                                        class="form-control form-control-sm  form-control-solid editor" name="return_policy"
                                        rows="3">{{ $data->return_policy }}</textarea>
                                    @if ($errors->has('return_policy'))
                                        <span class="text-danger">
                                            {{ $errors->first('return_policy') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Terms & Conditions</label>
                                    <textarea
                                        class="form-control form-control-sm  form-control-solid editor" name="terms_and_conditions"
                                        rows="3">{{ $data->terms_and_conditions }}</textarea>
                                    @if ($errors->has('terms_and_conditions'))
                                        <span class="text-danger">
                                            {{ $errors->first('terms_and_conditions') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{--
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Footer Message</label>
                                    <textarea
                                        class="form-control form-control-sm  form-control-solid editor" name="footer_message"
                                        rows="3">{{ $data->footer_message }}</textarea>
                                    @if ($errors->has('footer_message'))
                                        <span class="text-danger">
                                            {{ $errors->first('footer_message') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            --}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">FAQ</label>
                                    <textarea
                                        class="form-control form-control-sm  form-control-solid editor" name="faq"
                                        rows="3">{{ $data->faq }}</textarea>
                                    @if ($errors->has('faq'))
                                        <span class="text-danger">
                                            {{ $errors->first('faq') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <!--End Row-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update Settings</button>
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


    {{--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#delete-profile-image').click(function() {
            if (confirm('Are you sure you want to delete your product image?')) {
                $.ajax({
                    url: '{{ route('update-product-image', $data->id) }}', // Using the correct route
                    type: 'PUT', // Correct HTTP method
                    data: {
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#profile-image-container').remove();
                           // alert('Profile image deleted successfully');
                        } else {
                            alert('Error deleting product image');
                        }
                    },
                    error: function() {
                        alert('Error deleting product image');
                    }
                });
            }
        });
    });
    </script>--}}

@endsection
@section('endScript')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var summernoteElement = document.querySelectorAll('.editor');         
            document.getElementById('resetButton').addEventListener('click', function() {
                $(summernoteElement).summernote('code', ''); // Clear the content of Summernote
            });
        });
    </script>
@endsection