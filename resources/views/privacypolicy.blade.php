<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @section('head_links')
        <title>DealsMachi | Privacy Policy</title>
        <meta name="description" content="Privacy Policy for DealsMachi." />
        <link rel="canonical" href="https://dealsmachi.com/privacyPolicy" />
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
        <div class="home-content container" style="margin-top: 100px">
            <div class="mt-5 mb-5">
                <h1>DealsMachi Privacy Policy</h1>
                <h3>Effective Date: October 21, 2024</h3>
            </div>
            <div>
                <h2>1. Introduction</h2>
                <p>This Privacy Policy describes how dealsmachi.com ("DealsMachi", "we", "us", or "our") collects, uses,
                    and discloses your personal information when you use our website (dealsmachi.com).</p>
            </div>
            <div>
                <h2>2. Information We Collect</h2>
                <p>We collect several types of information when you use the Website: </p>
                <ul>
                    <li>
                        <span class="fw-normal">Personal Information: </span>This includes information that can be used
                        to identify you directly, such as your name, email address, phone number (optional), and any
                        other information you voluntarily provide to us when you create an account or contact us.
                    </li>
                    <li>
                        <span class="fw-normal">Non-Personal Information: </span>This includes information that cannot
                        be used to identify you directly, such as your browsing history on the Website, IP address,
                        device type, operating system, and geographic location. We may also collect information about
                        your interactions with the Website, such as the pages you visit and the links you click.
                    </li>
                </ul>
            </div>
            <div>
                <h2>3. How We Collect Information</h2>
                <p>We collect information in the following ways: </p>
                <ul>
                    <li>
                        <span class="fw-normal">When you create an account: </span>We collect your name and email
                        address when you create an account on the Website.
                    </li>
                    <li>
                        <span class="fw-normal">When you contact us: </span>We collect your name, email address, and any
                        other information you provide when you contact us through a form or email.
                    </li>
                    <li>
                        <span class="fw-normal">When you use the Website: </span>We collect non-personal information
                        through cookies and other tracking technologies.
                    </li>

                </ul>
            </div>
            <div>
                <h2>4. Cookies and Other Tracking Technologies</h2>
                <p>We use cookies and other tracking technologies to collect non-personal information about your use of
                    the Website. These technologies help us remember your preferences, understand how you use the
                    Website, and improve your overall experience.</p>
                <p>You can control the use of cookies by adjusting the settings on your web browser. However, if you
                    disable cookies, you may not be able to use all of the features of the Website.</p>
            </div>
            <div>
                <h2>5. How We Use Your Information</h2>
                <p>We use your information for the following purposes:</p>
                <ul>
                    <li>
                        To provide and operate the Website.
                    </li>
                    <li>
                        To create and manage your account.
                    </li>
                    <li>
                        To personalize your experience on the Website.
                    </li>
                    <li>
                        To communicate with you about deals, promotions, and other news. </li>
                    <li>
                        To improve the Website. </li>
                    <li>
                        To comply with the law.
                    </li>
                </ul>
            </div>
            <div>
                <h2>6. Sharing Your Information</h2>
                <p>We may share your information with third-party service providers who help us operate the Website.
                    These service providers are contractually obligated to keep your information confidential and to use
                    it only for the purposes we have specified.</p>
                <P>We will not share your personal information with any third party for marketing purposes without your
                    consent.</P>
            </div>
            <div>
                <h2>7. Data Security</h2>
                <p>We take reasonable steps to protect your information from unauthorized access, disclosure,
                    alteration, or destruction. However, no website or internet transmission is completely secure. We
                    cannot guarantee the security of your information.</p>
            </div>
            <div>
                <h2>8. Your Rights</h2>
                <p>You have the following rights regarding your information:</p>
                <ul>
                    <li>
                        The right to access and update your personal information.</li>
                    <li>
                        The right to request that we delete your personal information.</li>
                    <li>
                        The right to object to the processing of your personal information.</li>


                </ul>
            </div>
            <div>
                <h2>9. Children's Privacy</h2>
                <p>Our Website is not intended for children under the age of 18. We do not knowingly collect personal
                    information from children under 18. If you are a parent or guardian and you believe that your child
                    has provided us with personal information, please contact us. We will delete such information from
                    our records.</p>
            </div>
            <div>
                <h2>10. Changes to this Privacy Policy</h2>
                <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the
                    new Privacy Policy on the Website. You are advised to review this Privacy Policy periodically for
                    any changes.</p>
            </div>
            <div>
                <h2>11. Contact Us</h2>
                <p>If you have any questions about this Privacy Policy, please contact us by email at
                    <a href="mailto:info.dealsmachi@gmail.com">info.dealsmachi@gmail.com</a>
                 </p>
            </div>
        </div>
        @include('nav.footer')
    </section>
    <!-- ======= Script  ======= -->

    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/5b8838406b.js" crossorigin="anonymous"></script>

    <!-- Page Scripts -->
    @stack('scripts')
</body>

</html>
