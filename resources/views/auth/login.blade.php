<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>Management Info</title>

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
    <!-- Content area -->
    <div class="content d-flex justify-content-center align-items-center">

        <!-- Login form -->
        <form class="login-form" method="POST" action="{{route('login')}}">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @auth
                <script>window.location = "{{ URL('/') }}";</script>
            @endauth

            @guest
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                                <img src="/global_assets/images/demo/logos/3.svg" class="h-48px" alt="">
                            </div>
                            <h5 class="mb-0">Login to your account</h5>
                            <span class="d-block text-muted">Enter your credentials below</span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="form-control-feedback form-control-feedback-start">
                                <input type="text" name="email" class="form-control" placeholder="example@email.com">
                                <span></span>
                                <div class="form-control-feedback-icon">
                                    <i class="ph-user-circle text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="form-control-feedback form-control-feedback-start">
                                <input type="password" name="password" class="form-control" placeholder="•••••••••••">
                                <span></span>
                                <div class="form-control-feedback-icon">
                                    <i class="ph-lock text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Sign in</button>
                        </div>

                        <div class="text-center">
                            <a href="">Forgot password?</a>
                        </div>
                    </div>
                </div>
            @endguest
        </form>
        <!-- /login form -->

    </div>
    <!-- /content area -->
</body>
</html>
