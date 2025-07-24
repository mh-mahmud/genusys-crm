<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href="">
    <title>gPlex - CRM Dashboard </title>
    <meta name="description"
          content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free."/>
    <meta name="keywords"
          content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta charset="utf-8"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title"
          content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme"/>
    <meta property="og:url" content="https://keenthemes.com/metronic"/>
    <meta property="og:site_name" content="Keenthemes | Metronic"/>
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8"/>
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('/')}}/assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <script src="{{url('/')}}/assets/js/sweetalert2.min.js"></script>
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="bg-body">
<!--begin::Main-->
<div class="d-flex flex-column flex-root g-login-page-area">
    <!--begin::Authentication - Sign-in -->
    <div
        class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid px-3">
            <!--begin::Logo-->
            <a href="{{ route('login') }}" class="mb-12">
                <img alt="Logo" src="assets/media/logos/logo-1-light.svg" class="h-60px"/>
            </a>
            <!--end::Logo-->
            <!--begin::Wrapper-->
            <div class="w-lg-850px bg-body rounded shadow-sm mx-auto g-login-main">


                <div class="g-login-left">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" method="POST" action="{{ route('login.post') }}">
                        <!-- @csrf -->

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="mb-3 g-login-left-header">Sign In</h1>
                            <!--Alert Message-->
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
                            <!--End Alert Message-->
                            <!--end::Title-->
                            <!--begin::Link-->

                            <!--end::Link-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="form-label fs-6 fw-bolder text-dark">Username</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-lg form-control-solid" type="text" name="username"
                                   autocomplete="off"/>

                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack mb-2">
                                <!--begin::Label-->
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>


                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Input-->
                            <input class="form-control form-control-lg form-control-solid" type="password"
                                   name="password" autocomplete="off"/>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <!--begin::Submit button-->
                            <button type="submit" id="kt_sign_in_submit"
                                    class="btn btn-lg text-white w-100 mb-5 g-login-btn-gradient">
                                <span class="indicator-label">Continue</span>
                                <span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Submit button-->

                        </div>
                        <!--end::Actions-->
                    </form>
                </div>

                <div class="g-login-right">
                    <img width="280px" alt="Logo" src="{{url('/')}}/assets/media/logos/login-r-logo.svg"/>
                </div>

                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
        <!--begin::Footer-->
        <div class="d-flex flex-center flex-column-auto p-10">
            <!--begin::Links-->
            <div class="d-flex align-items-center fw-bold fs-6">
                <a href="{{ route('login') }}" class="text-muted text-hover-primary px-2"> Powered by
                    <img height="18px" alt="Logo" src="{{url('/')}}/assets/media/logos/logo-1-light.svg"  />
                </a>
            </div>
            <!--end::Links-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Main-->
<script>var hostUrl = "assets/";</script>
<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="assets/js/custom/authentication/sign-in/general.js"></script>
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
