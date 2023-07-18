<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>Restaurent POS</title>

        <!-- Global stylesheets -->
        <link href="{{asset('global_assets/fonts/inter/inter.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('global_assets/icons/phosphor/styles.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/ltr/all.min.css')}}" id="stylesheet" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- /global stylesheets -->

        <!-- Core JS files -->
        <script src="{{asset('global_assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('global_assets/js/jquery/jquery.min.js')}}"></script>
        <!-- /core JS files -->

        <!-- Datatable JS -->
        {{-- <script src="{{asset('global_assets/js/vendor/tables/datatables/datatables.min.js')}}"></script> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script> --}}


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>

        <!-- Toaster files -->
        <script src="{{asset('global_assets/js/toastr/toastr.min.js')}}"></script>
        <link href="{{asset('global_assets/js/toastr/toastr.css')}}" rel="stylesheet">

        <!-- Theme JS files -->
        <script src="{{asset('assets/js/app.js')}}"></script>
        <!-- /theme JS files -->

    </head>

    <body>
        <!-- Main navbar -->
        @include('layouts.navbar')
        <!-- /main navbar -->

        <!-- Page content -->
        <div class="page-content">

            <!-- Main sidebar -->
            @include('layouts.sidebar')
            <!-- /main sidebar -->

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                @include('layouts.header')
                <!-- /page header -->

                <!-- Inner content -->
                <div class="content-inner">

                    <!-- Content area -->
                    <div class="content">
                        <!-- Basic card -->
                        <div class="card p-1">
                           @yield('content')
                        </div>
                        <!-- /basic card -->
                    </div>
                    <!-- /content area -->

                    <!-- Footer -->
                    @include('layouts.footer')
                    <!-- /footer -->

                </div>
                <!-- /inner content -->
            </div>
            <!-- /main content -->
        </div>
    </body>
</html>
