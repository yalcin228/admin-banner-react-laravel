<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>@yield('title')</title>

    <meta name="description" content=""/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('admin/admin-panel/assets/img/favicon/favicon.ico')}}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('admin/admin-panel/assets/vendor/fonts/boxicons.css')}}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('admin/admin-panel/assets/vendor/css/core.css')}}"
          class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{asset('admin/admin-panel/assets/vendor/css/theme-default.css')}}"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{asset('admin/admin-panel/assets/css/demo.css')}}"/>
    <!-- FlatPicker CSS -->
    <link href="{{asset('admin/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/flatpickr/custom-flatpickr.css')}}" rel="stylesheet" type="text/css">
    <!-- Vendors CSS -->
    <link rel="stylesheet"
          href="{{asset('admin/admin-panel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}"/>

    <link rel="stylesheet" href="{{asset('admin/admin-panel/assets/vendor/libs/apex-charts/apex-charts.css')}}"/>

    <!-- Toastr cdn-->
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- SweetAlert2 cdn-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/sweetalert2.min.css') }}">

    {{--      Fontawesome--}}
    <script src="https://kit.fontawesome.com/e53c870345.js" crossorigin="anonymous"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@yield('css')

<!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('admin/admin-panel/assets/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('admin/admin-panel/assets/js/config.js')}}"></script>

    <!-- Ckeditor cdn-->
{{--    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>--}}

    <!-- SweetAlert2 cdn-->
    <script src="{{ asset('admin/sweetalert2.min.js') }}"></script>


</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar ">
    <div class="layout-container">
        <!-- Menu -->
    @include('admin.particles.left-sidebar')
    <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

        @include('admin.particles.navbar')

        <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">

            {{-- content --}}
            @yield('content')
            <!-- content end-->

                <!-- Footer -->
            @include('admin.particles.footer')
            <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('admin/jquery-3.6.0.min.js') }}"></script>

<script src="{{asset('admin/admin-panel/assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('admin/admin-panel/assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('admin/admin-panel/assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('admin/admin-panel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

<script src="{{asset('admin/admin-panel/assets/vendor/js/menu.js')}}"></script>
<!-- endbuild -->

<!-- FlatPicker JS -->
<script src="{{asset('admin/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('admin/flatpickr/custom-flatpickr.js')}}"></script>

<!-- Vendors JS -->
<script src="{{asset('admin/admin-panel/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

<!-- Main JS -->
<script src="{{asset('admin/admin-panel/assets/js/main.js')}}"></script>

<!-- Page JS -->
<script src="{{asset('admin/admin-panel/assets/js/dashboards-analytics.js')}}"></script>


<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- toastr cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{{-- @include('admin.components.notify') --}}
@yield('scripts')
</body>

</html>
