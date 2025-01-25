<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @section('head_links')
        <title>DealsMachi | Terms And Conditions</title>
        <meta name="description" content="Terms And Conditions for DealsMachi." />
        <link rel="canonical" href="https://dealsmachi.com/terms_conditions" />
        <link rel="icon" href="{{ asset('assets/images/home/favicon.ico') }}" />

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">

        <!-- Vendor CSS Files -->
        {{-- Boostrap css  --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        {{-- Custom Css  --}}
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @show
</head>

<body>
    <section class="home-section">
        @include('nav.header')
        <div class="container home-content" style="margin-top: 100px">
            <h1>Terms and Conditions for dealsMachi.com</h1>
            <p class="fw-bold">Welcome to dealsMachi.com!</p>
            <p>These Terms and Conditions ("Terms") govern your access to and use of the dealsmachi.com website (the
                "Website") and its services (the "Services") offered by [DealsMachi] ("we," "us," or "our"). By
                accessing or using the Website or Services, you agree to be bound by these Terms. If you disagree with
                any part of these Terms, you may not access or use the Website or Services.</p>
            <div class="mt-5">
                <h2>1. Use of the Website and Services</h2>
                <ul>
                    <li>
                        You must be at least 18 years old or of legal age to enter into a contract to use the Website or
                        Services.
                    </li>
                    <li>
                        You are responsible for maintaining the confidentiality of your account information, including
                        your login credentials.
                    </li>
                    <li>
                        You are responsible for all activities that occur under your account. </li>
                    <li>
                        You agree to use the Website and Services only for lawful purposes and in accordance with these
                        Terms. </li>
                    <li>
                        You agree not to use the Website or Services in any way that could damage, disable, overburden,
                        or impair the Website or Services. </li>
                    <li>
                        You agree not to use the Website or Services to collect or harvest any personal information of
                        other users. </li>

                </ul>
            </div>
            <div>
                <h2>2. User Content</h2>
                <ul>
                    <li>
                        You may submit content (text, images, videos, etc.) to the Website ("User Content").
                    </li>
                    <li>
                        You retain all ownership rights to your User Content.
                    </li>
                    <li>
                        By submitting User Content, you grant us a non-exclusive, royalty-free, worldwide license to
                        use, reproduce, modify, publish, and distribute your User Content on the Website and in
                        connection with the Services.
                    </li>
                    <li>
                        You warrant that your User Content does not violate any third-party rights, including
                        intellectual property rights.
                    </li>
                    <li>
                        You are responsible for the accuracy and completeness of your User Content.
                    </li>
                </ul>
            </div>
            <div>
                <h2>3. Deals and Offers</h2>
                <ul>
                    <li>
                        The Website may display deals and offers from various merchants.
                    </li>
                    <li>
                        We are not responsible for the accuracy, availability, or quality of the deals and offers.
                    </li>
                    <li>
                        You are responsible for reviewing the terms and conditions of any deal or offer before using it.
                    </li>
                    <li>
                        We are not responsible for any disputes between you and a merchant. </li>
                </ul>
            </div>
            <div>
                <h2>4. Disclaimers</h2>
                <ul>
                    <li>
                        The Website and Services are provided "as is" and without warranties of any kind, express or
                        implied.
                    </li>
                    <li>
                        We disclaim all warranties, including but not limited to, warranties of merchantability, fitness
                        for a particular purpose, and non-infringement.
                    </li>
                    <li>
                        We do not warrant that the Website or Services will be uninterrupted, error-free, or virus-free.
                    </li>
                </ul>
            </div>
            <div>
                <h2>5. Limitation of Liability</h2>
                <ul>
                    <li>
                        We shall not be liable for any direct, indirect, incidental, consequential, or special damages
                        arising out of or in any way connected with your use of the Website or Services.
                    </li>

                </ul>
            </div>
            <div>
                <h2>6. Termination</h2>
                <ul>
                    <li>
                        We may terminate your access to the Website or Services for any reason, at any time, without
                        notice.
                    </li>
                    <li>You may terminate your use of the Website or Services at any time.</li>
                </ul>
            </div>
            <div>
                <h2>7. Governing Law</h2>
                <ul>
                    <li>
                        These Terms shall be governed by and construed in accordance with the laws of India.
                    </li>
                </ul>
            </div>
            <div>
                <h2>8. Entire Agreement</h2>
                <ul>
                    <li>
                        These Terms constitute the entire agreement between you and us regarding your use of the Website
                        and Services.
                    </li>
                </ul>
            </div>
            <div>
                <h2>9. Changes to the Terms</h2>
                <ul>
                    <li>
                        We may update these Terms at any time. We will notify you of any changes by posting the new
                        Terms on the Website.
                    </li>
                    <li>
                        Your continued use of the Website or Services after the posting of the revised Terms constitutes
                        your acceptance of the revised Terms.
                    </li>
                </ul>

            </div>
            <div>
                <h2>9. Contact Us</h2>
                <ul>
                    <li>
                        If you have any questions about these Terms, please contact us at
                        <a href="mailto:info.dealsmachi@gmail.com">info.dealsmachi@gmail.com</a>
                    </li>

                </ul>

            </div>
        </div>
        @include('nav.footer')
        </div>
    </section>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/5b8838406b.js" crossorigin="anonymous"></script>
    <!-- Page Scripts -->
    @stack('scripts')
</body>

</html>
