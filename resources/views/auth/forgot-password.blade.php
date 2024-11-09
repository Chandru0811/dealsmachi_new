<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dealslah | Login </title>
    <link rel="canonical" href="https://dealslah.com/login" />
    <meta name="description" content="Dealslah Shop Smart, Save Big!" />
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

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body>
    <section class="container-fluid">
        <div class="row m-0">
            <div class="col-md-6 col-12 pt-5 login-text-container">
                <div class="px-5">
                    <h3 class="py-4">Hello,</h3>
                    <h6 class="login-text">You are just a step away from an awesome purchase</h6>
                    <h6 class="login-text">Register or Login to complete the process</h6>
                </div>
                <div class="d-flex justify-content-center align-items-center py-5">
                    <img src="{{ asset('assets/images/home/email_logo.png') }}" alt="header_logo" class="img-fluid" />
                </div>
            </div>
            <div class="col-md-6 col-12 d-flex justify-content-center align-items-center login-container">
                <div class="d-flex flex-column justify-content-center align-items-center w-100">
                    <h3 class="login-title text-center mb-4">Forgot Password</h3>
                    <form id="loginForm" class="w-75">
                        <div class="mb-5 email-container">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" />
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn login-btn w-100">Reset Password</button>
                        </div>
                        <div class="text-end">
                            <p class="" style="color: #fff;">Go Back to <a
                                    href="{{ url('login') }}"  style="color: #fff;">Login</a></p>
                        </div>
                        <div class="d-flex justify-content-center align-items-center mb-3 line-divider-container">
                            <hr class="line-divider" />
                            <span class="mx-2 line-divider-text">or</span>
                            <hr class="line-divider" />
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div
                                class="btn btn-light social-btn d-flex align-items-center justify-content-center w-100 me-2">
                                <img src="{{ asset('assets/images/home/google.png') }}" class="me-2" alt="google_logo"
                                    width="20">
                                <span style="color: #333;">Sign in with Google</span>
                            </div>
                            <div
                                class="btn btn-light social-btn d-flex align-items-center justify-content-center w-100 ms-2">
                                <img src="{{ asset('assets/images/home/facebook.png') }}" class="me-2"
                                    alt="facebook_logo" width="20">
                                <span style="color: #333;">Continue with Facebook</span>
                            </div>
                        </div>
                        {{-- <div class="text-center">
                            <p class="mb-0" style="color: #fff;">Don't have an account? <a
                                    href="{{ url('register') }}" style="color: #fff;">Register</a></p>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> <!-- jQuery Validation Plugin -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/5b8838406b.js" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>
