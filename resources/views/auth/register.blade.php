<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deaslmachi | Register </title>
    <link rel="canonical" href="https://dealsmachi.com/register" />
    <meta name="description" content="Dealsmachi Shop Smart, Save Big!" />
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
    <section class="container-fluid p-0">
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
            <div class="col-md-6 col-12 pt-5 bg_login login-text-container text-center" style="background: #ffcbde">
                <div class="px-5 pt-5">
                    <h5 class="py-4" style="color: #CC004D">Login to your account</h5>
                    <p class="login-text">You're just one step away from securing your awesome purchase!
                        Sign up or log in now to complete your order effortlessly</p>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/images/bg_intro.webp') }}" alt="header_logo" class="img-fluid" />
                </div>
            </div>
            <div class="col-md-6 col-12 d-flex justify-content-center align-items-center login-container">
                <div class="d-flex flex-column justify-content-center align-items-center w-100">
                    <h3 class="login-title text-center mb-4">Register</h3>
                    <form id="loginForm" class="w-75" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3 email-container">
                            <input type="text" class="form-control" id="name" name="name" value=""
                                placeholder="Name" />
                            @error('name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 email-container">
                            <input type="email" class="form-control" id="email" name="email" value=""
                                placeholder="Email / Phone Number" />
                            @error('email')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 password-container">
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    aria-label="password" placeholder="Password">
                                <span class="input-group-text" id="togglePassword"
                                    style="cursor: pointer; background:#fff">
                                    <i class="fa fa-eye" id="eyeIconPassword"></i>
                                </span>
                            </div>
                            @error('password')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 password-container">
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" aria-label="password_confirmation"
                                    placeholder="Confirm Password">
                                <span class="input-group-text" id="toggleConfirmPassword"
                                    style="cursor: pointer; background:#fff">
                                    <i class="fa fa-eye" id="eyeIconConfirm"></i>
                                </span>
                            </div>
                            @error('password_confirmation')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <button type="submit" class="btn btn-light login-btn w-100"
                                style="color: #fff; background:#ff0060">Register</button>
                        </div>
                        <div class="d-flex justify-content-center align-items-center mb-3 line-divider-container">
                            <hr class="line-divider" />
                            <span class="mx-2 line-divider-text" style="color: #A2A2A2">or</span>
                            <hr class="line-divider" />
                        </div>
                        <div class="mb-3 row">
                            <div class="col-6">
                                <a href="/sociallogin/google/customer" style="text-decoration: none">
                                    <button type="button" class="btn btn-light social-btn w-100">
                                        <img src="{{ asset('assets/images/home/google.webp') }}" class="img-fluid "
                                            alt="google_logo" width="22px">
                                        &nbsp;&nbsp;<span style="font-size: small">Sign in with Google</span>
                                    </button>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="/sociallogin/facebook/customer">
                                    <button type="button" class="btn btn-light social-btn w-100 ">
                                        <img src="{{ asset('assets/images/home/facebook.webp') }}" class="img-fluid "
                                            alt="facebook_logo" width="22px">
                                        &nbsp;&nbsp;<span style="font-size: small">Sign in with Facebook</span>
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="mb-4 mt-1" style="font-size:12px;">Already have an account? &nbsp; <a
                                    href="{{ url('login') }}" style="color: #FF0060;font-size:12px;">Login</a></p>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPasswordInput = document.getElementById('password_confirmation');

            // Toggle password visibility
            togglePassword.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                togglePassword.querySelector('i').classList.toggle('fa-eye');
                togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
            });

            // Toggle confirm password visibility
            toggleConfirmPassword.addEventListener('click', () => {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);
                toggleConfirmPassword.querySelector('i').classList.toggle('fa-eye');
                toggleConfirmPassword.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>

</html>
