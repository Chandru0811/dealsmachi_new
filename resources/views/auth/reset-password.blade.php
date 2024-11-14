<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DealsMachi | Reset Password</title>
    <link rel="canonical" href="https://dealsmachi.com/reset-password" />
    <meta name="description" content="DealsMachi Shop Smart, Save Big!" />
    <link rel="icon" href="{{ asset('assets/images/home/favicon.ico') }}" />

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body>
    <section class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                style="position: absolute; top: 15px; right: 40px;">
                {{ session('status') }}
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                style="position: absolute; top: 15px; right: 40px;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row m-0">
            <div class="col-md-6 col-12 pt-3 login-text-container">
                <div class="px-5">
                    <h5 class="py-4">Hello,</h5>
                    <h6 class="login-text">You are just a step away from an awesome purchase</h6>
                    <h6 class="login-text">Register or Login to complete the process</h6>
                </div>
                <div class="d-flex justify-content-center align-items-center" style="min-height: 300px">
                    <img src="{{ asset('assets/images/home/email_logo.png') }}" alt="header_logo" class="img-fluid" />
                </div>
            </div>
            <div class="col-md-6 col-12 d-flex justify-content-center align-items-center login-container">
                <div class="d-flex flex-column justify-content-center align-items-center w-100">
                    <h3 class="login-title text-center mb-4">Reset Password</h3>
                    <form id="loginForm" class="w-75" method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <div class="mb-3 email-container">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" readonly />
                            @error('email')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 password-container">
                            <div class="d-flex justify-content-between">
                                <label class="form-label">Password</label>
                            </div>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    aria-label="password">
                                <span class="input-group-text" id="togglePassword">
                                    <i class="fa fa-eye" id="eyeIconPassword"></i>
                                </span>
                            </div>
                            @error('password')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4 password-container">
                            <div class="d-flex justify-content-between">
                                <label class="form-label">Confirm Password</label>
                            </div>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" aria-label="password_confirmation">
                                <span class="input-group-text" id="toggleConfirmPassword">
                                    <i class="fa fa-eye" id="eyeIconConfirm"></i>
                                </span>
                            </div>
                            @error('password_confirmation')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 mt-5 text-center">
                            <button type="submit" class="btn btn-light w-100" style="color: #ff0060">Reset
                                Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script> <!-- jQuery -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/5b8838406b.js" crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>
