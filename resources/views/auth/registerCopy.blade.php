<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DealsMachi | Register</title>
    <link rel="canonical" href="https://dealsmachi.com/register" />
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

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body>
    <section class="register-container">
        <div class="container-fluid d-flex justify-content-center align-items-center"
            style="background-color: #f2f2f2;">
            <div class="card shadow-lg p-3 rounded my-5" style="width: 100%; max-width: 400px;">
                <div class="d-flex justify-content-around mb-2">
                    <h3 class="register-title py-2">Register</h3>
                </div>
                <form id="registerForm">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" />
                    </div>
                    <div class="mb-3 password-container">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" />
                        <i class="fa-solid fa-eye fa-sm" id="toggleRegisterPassword"></i>
                    </div>
                    <div class="mb-4 password-container">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" />
                        <i class="fa-solid fa-eye fa-sm" id="toggleRegisterConfirmPassword"></i>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn register-btn">Register</button>
                    </div>
                    <div class="mb-3 text-center fw-light">
                        <a href="#" class="text-decoration-none" style="color:  #ff0060;">Become a Vendor</a>
                    </div>
                    <div class="mb-3 text-center fw-light">
                        <p>Already have an account? <a href="{{ url('login') }}" class="text-decoration-none"
                                style="color:  #ff0060;">Login</a></p>
                    </div>
                </form>
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
