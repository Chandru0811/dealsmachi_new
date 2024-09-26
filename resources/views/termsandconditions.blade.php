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

    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
        href="https://fonts.googleapis.com/css2?family=Kanit&display=swap"
        rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @show
</head>

<body>
    <section class="home-section">
        @include('layouts.header')
        <div class="home-content" style="margin-top: 100px">
            <div class="container mb-5">
                <h1>Terms and Conditions for DealsMachi</h1>
                <div class="mt-4">
                    <h2>1. Introduction</h2>
                    <ul>
                        <li>
                            <span class="fw-regular">Agreement: </span>This agreement governs your use of DealsMachi.com, a
                            website that provides deals and offers from various merchant
                        </li>
                        <li>
                            <span class="fw-regular">Acceptance: </span>By using DealsMachi, you agree to these terms and
                            conditions.
                        </li>
                    </ul>
                </div>
                <div>
                    <h2>2. User Account</h2>
                    <ul>
                        <li>
                            <span class="fw-regular">Registration: </span>You may need to create an account to access certain
                            features of DealsMachi.
                        </li>
                        <li>
                            <span class="fw-regular">Account Information: </span> You agree to provide accurate and up-to-date
                            information.
                        </li>
                        <li>
                            <span class="fw-regular">Password Security: </span>You are responsible for maintaining the
                            confidentiality
                            of your password
                        </li>
                    </ul>
                </div>
                <div>
                    <h2>3. Deals and Offers</h2>
                    <ul>
                        <li>
                            <span class="fw-regular">Accuracy: </span> While we strive for accuracy, we cannot guarantee the
                            accuracy or completeness of the deals and offers listed on DealsMachi.
                        </li>
                        <li>
                            <span class="fw-regular">Merchant Responsibility: </span>DealsMachi is not responsible for the quality,
                            availability, or delivery of products or services offered by merchants.
                        </li>
                        <li>
                            <span class="fw-regular">Changes: </span>Merchants may modify or cancel deals without notice.
                        </li>
                    </ul>
                </div>
                <div>
                    <h2>4. User Conduct</h2>
                    <ul>
                        <li>
                            <span class="fw-regular">Prohibited Conduct: </span>You agree not to:
                            <ul>
                                <li>
                                    Use DealsMachi for any unlawful or harmful purpose.
                                </li>
                                <li>
                                    Post or transmit any offensive, harmful, or misleading content.
                                </li>
                                <li>
                                    Violate any applicable laws or regulations.
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span class="fw-regular">Intellectual Property: </span>
                            You acknowledge that DealsMachi and its content
                            are protected by intellectual property rights.
                        </li>
                    </ul>
                </div>
                <div>
                    <h2>5. Limitation of Liability</h2>
                    <ul>
                        <li>
                            <span class="fw-regular">No Warranty: </span>
                            DealsMachi provides the website on an "as is" basis without
                            warranties.
                        </li>
                        <li>
                            <span class="fw-regular">Liability: </span>
                            DealsMachi shall not be liable for any indirect, incidental, or
                            consequential damages arising from your use of the website.
                        </li>
                    </ul>
                </div>
                <div>
                    <h2>6. Indemnification</h2>
                    <ul>
                        <li>
                            <span class="fw-regular">Indemnify: </span>
                            You agree to indemnify and hold DealsMachi harmless from
                            any claims arising from your use of the website.
                        </li>
                    </ul>
                </div>
                <div>
                    <h2>7. Governing</h2>
                    <ul>
                        <li>
                            <span class="fw-regular">Indian Law: </span>
                            This agreement shall be governed by and construed in
                            accordance with the laws of India.
                        </li>
                    </ul>
                </div>
                <div>
                    <h2>8. Changes</h2>
                    <ul>
                        <li>
                            <span class="fw-regular">Modifications: </span>
                            DealsMachi may modify these terms and conditions from
                            time to time.
                        </li>
                        <li>
                            <span class="fw-regular">Notice: </span>
                            We will provide notice of any material changes.
                        </li>
                    </ul>
                </div>
                <div>
                    <h2>9. Contact Information</h2>
                    <ul>
                        <li>
                            <span class="fw-regular">Contact: </span>
                            For inquiries or concerns, please contact us at
                            info@dealsmachi.com
                        </li>
                    </ul>
                    <h2>Additional Considerations: </h2>
                    <ul>
                        <li>
                            <span class="fw-regular">Privacy Policy: </span>
                            Ensure a clear and comprehensive privacy policy that
                            outlines how you collect, use, and protect user data.
                        </li>
                        <li>
                            <span class="fw-regular">Dispute Resolution: </span>
                            Consider including a dispute resolution clause, such
                            as arbitration or mediation.
                        </li>
                        <li>
                            <span class="fw-regular">Cookies and Tracking: </span>
                            Address your use of cookies and other tracking
                            technologies.
                        </li>
                        <li>
                            <span class="fw-regular">Affiliate Marketing: </span>
                            If applicable, outline your affiliate marketing program
                            or partnerships.
                        </li>
                    </ul>
                </div>
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
</body>

</html>