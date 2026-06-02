<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login - SPK SMART</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <style>
        .container {
            max-width: 450px !important;
            margin: 0 auto;
        }
        .login-logo {
            width: 200px;
            height: 200px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="main-panel w-100">
            <!-- Main Content -->
            <div class="container">
                <div class="page-inner">
                    {{-- Message Alert --}}
                    <div class="col-12">
                        @include('dashboard.message')
                    </div>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-2">
                                    <div class="card-header text-center">
                                        <img src="{{ asset('assets/img/logo.jpeg') }}"
                                            alt="Logo"
                                            class="login-logo mb-3">
                                        <div class="card-title text-center">Login Here</div>
                                    </div>
                                    <div class="card-body px-5 py-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    {{-- User Email Field --}}
                                                    <div class="form-group col-md-12">
                                                        <label for="email">Email</label>
                                                        <input type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            value="{{ old('email') }}" name="email" id="email"
                                                            placeholder="Enter your Email" />
                                                    </div>
                                                    @error('email')
                                                        <p class="invalid-feedback">{{ $message }}</p>
                                                    @enderror
                                                    {{-- User Password Field --}}
                                                    <div class="form-group col-md-12">
                                                        <label for="password">Password</label>
                                                        <input type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password" id="password" placeholder="Password" />
                                                    </div>
                                                    @error('password')
                                                        <p class="invalid-feedback">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div
                                                    class="action-btns mt-3 d-flex align-items-center justify-content-between">
                                                    <button type="submit" class="btn btn-primary">Login</button>
                                                    {{-- <div class="form-check p-0">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="remember" name="remember">
                                                        <label class="form-check-label m-0" for="remember">
                                                            Remember Me
                                                        </label>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="link text-center">
                                    <p class="m-0">
                                        Don't have an account?
                                        <a href="{{ route('admin.register') }}">Sign Up</a>
                                    </p>
                                </div> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>


</body>

</html>
