<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @section('head_links')
        <title>DealsMachi – Deals that matter in Chennai</title>
        <meta name="description"
            content="Get the best deals in Chennai. Electronics, Beauty, Travel and every category you can imagine! Get our apps and stay ahead of every else in deals." />
        <link rel="canonical" href="https://dealslah.com/" />
        <link rel="icon" href="{{ asset('assets/images/home/favicon.ico') }}" />

        <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
        href="https://fonts.googleapis.com/css2?family=Kanit&display=swap"
        rel="stylesheet">
    

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @show
</head>

<body>
    <section class="home-section">
        @include('layouts.header')
        <div class="home-content">
            <div>
                @include('home')
            </div>
            @include('layouts.footer')
        </div>
    </section>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/5b8838406b.js" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>



    <script>
        $(document).ready(function() {
            function updateDropdownToggle() {
                if ($(window).width() < 992) {
                    $(".dropdown-toggle").attr("data-bs-toggle", "dropdown");
                } else {
                    $(".dropdown-toggle").removeAttr("data-bs-toggle");
                }
            }

            updateDropdownToggle();

            $(window).resize(function() {
                updateDropdownToggle();
            });
        });
    </script>
</body>

</html>