<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('images/fav.png') }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <div class="container-scroller">
        @include('layouts.partials.navbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            @if (auth()->user()->role_id === 1)
                @include('layouts.partials.sidebarAdmin')
            @elseif (auth()->user()->role_id === 2)
                @include('layouts.partials.sidebarPayment')
            @elseif (auth()->user()->role_id === 3)
                @include('layouts.partials.sidebarMenu')
            @endif
            
            @yield('container')
        </div>
        <!-- page-body-wrapper ends -->
        @include('layouts.partials.footer')
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/misc.js') }}"></script> --}}
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <!-- End custom js for this page -->

    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
    @yield('scripts')

</body>

</html>