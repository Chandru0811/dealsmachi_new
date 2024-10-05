<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @section('head_links')
        <title>DealsMachi – Deals that matter in Singapore</title>
        <meta name="description"
            content="Get the best deals in Singapore. Electronics, Beauty, Travel and every category you can imagine! Get our apps and stay ahead of every else in deals." />
        <link rel="canonical" href="https://dealsmachi.com/" />
        <link rel="icon" href="{{ asset('assets/images/home/favicon.ico') }}" />

        <meta property="og:title" content="DealsMachi - Deals that Matter in Singapore !" />
        <meta property="og:description" content="Shop Big, Earn Big Save Big, DealsMachi – Deals that matters in Singapore" />
        <meta property="og:url" content="https://dealsmachi.com" />
        <meta property="og:site_name" content="DealsMachi" />
        <meta property="og:image" content="{{ asset('assets/images/social/DealsMachi_og.png') }}" />

        <meta property="og:image:width" content="512" />
        <meta property="og:image:height" content="512" />
        <meta property="og:image:alt" content="Get the best deals and discounts in Singapore" />
        <meta property="og:image:type" content="image/png" />


        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="DealsMachi - Deals that Matter in Singapore !" />
        <meta name="twitter:description"
            content="Shop Big, Earn Big Save Big, DealsMachi – Deals that matters in Singapore" />
        <meta name="twitter:site" content="@dealsmachi" />

        <meta name="twitter:image" content="{{ asset('assets/images/social/DealsMachi_twitter.png') }}" />


        <!-- Vendor CSS Files -->
        {{-- Boostrap css  --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
        <!-- Main CSS File -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

        {{-- Custom Css  --}}
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @show
</head>

<body>
    <section class="home-section">
        @include('nav.header')
        <div class="home-content">
            <div>
                @yield('content')
            </div>
            @include('nav.footer')
        </div>
    </section>

    <!-- ======= Script  ======= -->


    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/5b8838406b.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!-- Page Scripts -->
    @yield('scripts')
</body>

</html>
