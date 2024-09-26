<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @section('head_links')
        <title>DealsMachi Shop Smart, Save Big !</title>
        <link rel="canonical" href="https://dealsmachi.com/productview" />
        <meta name="description" content="DealsMachi Shop Smart, Save Big!" />

        <link rel="icon" href="{{ asset('assets/images/home/favicon.ico') }}" />

        <!-- Boostrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- Google Fonts -->
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
            <div>
                <section>
                    <div class="container my-5">
                        <div class="row">
                            <div class="col-md-8 col-12 mb-3">
                                <div class="card productViewCard mb-4 px-md-4 px-3 py-3">
                                    <div class="row">
                                        <div class="col-lg-7 col-12 mb-3 d-flex  flex-column justify-content-center">
                                            <h4>24k Luxury Salon</h4>
                                            <div>
                                                <div class="d-flex">
                                                    <p class="info pe-3"><i class="fa-solid fa-circle"
                                                            style="color: #fdbf46; font-size: 8px;"></i>&nbsp;&nbsp;Open
                                                        until 9:00 pm</p>
                                                    <p class="info"><i class="fa-solid fa-circle"
                                                            style="color: #fdbf46; font-size: 8px;"></i>&nbsp;&nbsp;6
                                                        Years
                                                        in Business</p>
                                                </div>
                                                <div class="d-flex">
                                                    <p>602 <span style="font-size: 11px; color: #5C5C5C;">people</span>
                                                    </p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <p>4.6 <span>&nbsp;<i class="fa-solid fa-star fa-xs"
                                                                style="color: #fdbf46;cursor: pointer"></i></span></p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-2 pe-0">
                                                                <i class="fa-solid fa-location-dot fa-lg"
                                                                    style="color: #ff0060 ;"></i>
                                                            </div>
                                                            <div class="col-10 ps-2"
                                                                style="font-size: 12px; color: #5C5C5C;">
                                                                No:23 Rajaji St ,Anna Nagar, Chennai.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-2 pe-0">
                                                                <i class="fa-solid fa-user-group fa-lg"
                                                                    style="color: #ff0060 ;"></i>
                                                            </div>
                                                            <div class="col-10 ps-4"
                                                                style="font-size: 12px; color: #5C5C5C;">
                                                                24 people recently enquired
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex mt-3 gap-2">
                                                <button class="btn mb-2 showNumBtn">
                                                    <i class="fa-solid fa-phone fa-xs"></i>&nbsp;&nbsp;Show
                                                    Number</button>
                                                <button class="btn mb-2 sendEnqBtn">Send Enquiry</button>
                                                <button class="btn mb-2 sendEnqBtn"><i
                                                        class="fa-brands fa-whatsapp"></i>&nbsp;&nbsp;Chat</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-12 d-flex flex-column justify-content-center">
                                            <div class="d-flex justify-content-between">
                                                <p class="productViewStar" style="cursor: pointer">
                                                    Rate Now
                                                    <span>
                                                        <i class="fa-solid fa-star" style="color: #fdbf46;"></i>
                                                        <i class="fa-solid fa-star" style="color: #fdbf46;"></i>
                                                        <i class="fa-solid fa-star" style="color: #fdbf46;"></i>
                                                        <i class="fa-solid fa-star" style="color: #fdbf46;"></i>
                                                        <i class="fa-solid fa-star" style="color: #fdbf46;"></i>
                                                    </span>
                                                </p>
                                                <div class="d-flex productViewIcons">
                                                    <p style="height:fit-content;cursor:pointer" class="p-1 px-2"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Bookmark">
                                                        <i class="fa-regular fa-bookmark wishlist-icon"
                                                            style="color: #ff0060;"
                                                            onclick="toggleBookmark(this, event)"></i>
                                                    </p>&nbsp;&nbsp;&nbsp;
                                                    <p style="height: fit-content;cursor:pointer" class="p-1 px-2"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Share">
                                                        <i class="fa-solid fa-share-nodes" style="color: #ff0060;"></i>
                                                    </p>
                                                </div>
                                            </div>
                                            <img src="{{ asset('assets/images/product_view/product_main_image.webp') }}"
                                                alt="Adverstiment" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="productViewTabs">
                                    <!-- Tabs navigation -->
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active mb-1" id="overview-tab"
                                                data-bs-toggle="tab" data-bs-target="#overview" type="button"
                                                role="tab" aria-controls="overview"
                                                aria-selected="true">Overview</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link  mb-1" id="photos-tab" data-bs-toggle="tab"
                                                data-bs-target="#photos" type="button" role="tab"
                                                aria-controls="photos" aria-selected="false">Photos</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link  mb-1" id="quickinfo-tab" data-bs-toggle="tab"
                                                data-bs-target="#quickinfo" type="button" role="tab"
                                                aria-controls="quickinfo" aria-selected="false">Quick Info</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link  mb-1" id="reviews-tab" data-bs-toggle="tab"
                                                data-bs-target="#reviews" type="button" role="tab"
                                                aria-controls="reviews" aria-selected="false">Reviews</button>
                                        </li>
                                    </ul>

                                    <!-- Tab content -->
                                    <div class="tab-content rounded" id="myTabContent">
                                        <!-- Overview Tab -->
                                        <div class="tab-pane sub-tabs fade show active" id="overview"
                                            role="tabpanel" aria-labelledby="overview-tab">
                                            <p class="quickInfo">At 24k Luxury Salon, we specialize in expert hair
                                                styling and vibrant hair coloring services, tailored to enhance your
                                                unique look.
                                                Our team of professional stylists uses premium products and cutting-edge
                                                techniques to deliver flawless results, ensuring your hair
                                                stays healthy, radiant, and beautifully styled. Experience the perfect
                                                blend of luxury and creativity in a serene, upscale environment.</p>
                                            <p class="fw-medium mb-1">Appointment Booking</p>
                                            <p class="quickInfo">Appointments recommended to avoid waiting; walk-ins
                                                are welcome based on availability.</p>
                                            <p class="fw-medium mb-1">Services Offered</p>
                                            <ul class="quickInfo">
                                                <li>Haircuts & Styling</li>
                                                <li>Color & Highlights</li>
                                                <li>Manicure & Pedicure</li>
                                                <li>Facials & Skin Treatments</li>
                                                <li>Massages & Spa Therapies</li>
                                                <li>Bridal & Event Makeovers</li>
                                            </ul>
                                            <p class="fw-medium mb-1">Exclusive Offers</p>
                                            <p class="quickInfo">Loyalty programs and special packages available for
                                                regular clients.</p>
                                            <p class="fw-medium mb-1">Payment Options</p>
                                            <p class="quickInfo">All major credit cards, debit cards, and mobile
                                                payments accepted.</p>
                                        </div>

                                        <!-- Photos Tab -->
                                        <div class="tab-pane sub-tabs fade" id="photos" role="tabpanel"
                                            aria-labelledby="photos-tab">
                                            <p class="text-end add_photos"><i class="fa-solid fa-plus"></i> Add
                                                Photos</p>
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    <img src="{{ asset('assets/images/product_view/product_view_1.webp') }}"
                                                        alt="Product View Image 1" class="img-fluid pb-3">
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <img src="{{ asset('assets/images/product_view/product_view_2.webp') }}"
                                                        alt="Product View Image 2" class="img-fluid pb-3">
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <img src="{{ asset('assets/images/product_view/product_view_3.webp') }}"
                                                        alt="Product View Image 3" class="img-fluid pb-3">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Quick Info Tab -->
                                        <div class="tab-pane sub-tabs fade" id="quickinfo" role="tabpanel"
                                            aria-labelledby="quickinfo-tab">
                                            <div class="row">
                                                <div class="col-12 col-md-4 pe-5">
                                                    <p class="fw-medium info-head">Business Summary</p>
                                                    <p class="quickInfo">24k Luxury salon offering expert hair styling
                                                        and vibrant hair coloring services.</p>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <p class="fw-medium info-head">Year of Establishment</p>
                                                    <p class="quickInfo">2018</p>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <p class="fw-medium info-head">Timings</p>
                                                    <p class="quickInfo">Mon - Sat<span class="ps-3">10.00 am - 9.00
                                                            pm</span></p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Reviews Tab -->
                                        <div class="tab-pane sub-tabs fade" id="reviews" role="tabpanel"
                                            aria-labelledby="reviews-tab">
                                            <div class="d-flex align-items-center mb-4"
                                                style="border-bottom: 1.5px solid #ff0060 ;">
                                                <h2 class="ratingNum">4.6</h2>
                                                <p class="px-1 mb-0"><i class="fa-solid fa-star fa-lg"
                                                        style="color: #fdbf46;"></i></p>
                                                <div>
                                                    <p class="mb-0">769 Ratings</p>
                                                    <p class="quickInfo">Jd rating index based on 769 ratings across
                                                        the web</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6 mb-3 review-card">
                                                    <div class="card h-100 p-3">
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <img src="{{ asset('assets/images/product_view/profile.webp') }}"
                                                                    alt="Profile 1" class="img-fluid">
                                                            </div>
                                                            <div class="col-10">
                                                                <p class="fw-medium mb-0">Nithish Kumar</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <p class="mb-0">
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star-half-stroke fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                    </p>
                                                                    <p class="quickInfo mb-0">21 Jul 2024</p>
                                                                </div>
                                                                <p class="quickInfo">Did my haircut recently and the
                                                                    experience was absolutely amazing.I would especially
                                                                    like to mention hair stylist Milan for his stunning
                                                                    scissors work and attention to detail. His skills
                                                                    truly transformed my look and made the visit worth
                                                                    every minute!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6 mb-3 review-card">
                                                    <div class="card h-100 p-3">
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <img src="{{ asset('assets/images/product_view/profile.webp') }}"
                                                                    alt="Profile 1" class="img-fluid">
                                                            </div>
                                                            <div class="col-10">
                                                                <p class="fw-medium mb-0">Manikandan</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <p class="mb-0">
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                    </p>
                                                                    <p class="quickInfo mb-0">16 Jul 2024</p>
                                                                </div>
                                                                <p class="quickInfo">Did my haircut recently and the
                                                                    experience was absolutely amazing.I would especially
                                                                    like to mention hair stylist Milan for his stunning
                                                                    scissors work and attention to detail. His skills
                                                                    truly transformed my look and made the visit worth
                                                                    every minute!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6 mb-3 review-card">
                                                    <div class="card h-100 p-3">
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <img src="{{ asset('assets/images/product_view/profile.webp') }}"
                                                                    alt="Profile 1" class="img-fluid">
                                                            </div>
                                                            <div class="col-10">
                                                                <p class="fw-medium mb-0">Pooja</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <p class="mb-0">
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                    </p>
                                                                    <p class="quickInfo">04 Jul 2024</p>
                                                                </div>
                                                                <p class="quickInfo mb-0">Did my haircut recently and
                                                                    the experience was absolutely amazing.I would
                                                                    especially like to mention hair stylist Milan for
                                                                    his stunning scissors work and attention to detail.
                                                                    His skills truly transformed my look and made the
                                                                    visit worth every minute!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6 mb-3 review-card">
                                                    <div class="card h-100 p-3">
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <img src="{{ asset('assets/images/product_view/profile.webp') }}"
                                                                    alt="Profile 1" class="img-fluid">
                                                            </div>
                                                            <div class="col-10">
                                                                <p class="fw-medium mb-0">Sangeetha</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <p class="mb-0">
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                    </p>
                                                                    <p class="quickInfo mb-0">01 Jul 2024</p>
                                                                </div>
                                                                <p class="quickInfo">Did my haircut recently and the
                                                                    experience was absolutely amazing.I would especially
                                                                    like to mention hair stylist Milan for his stunning
                                                                    scissors work and attention to detail. His skills
                                                                    truly transformed my look and made the visit worth
                                                                    every minute!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6 mb-3 review-card hidden-review">
                                                    <div class="card p-3">
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <img src="{{ asset('assets/images/product_view/profile.webp') }}"
                                                                    alt="Profile 1" class="img-fluid">
                                                            </div>
                                                            <div class="col-10">
                                                                <p class="fw-medium mb-0">Kishore Kumar</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <p class="mb-0">
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star-half-stroke fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                    </p>
                                                                    <p class="quickInfo">21 Jul 2024</p>
                                                                </div>
                                                                <p class="quickInfo mb-0">Did my haircut recently and
                                                                    the experience was absolutely amazing.I would
                                                                    especially like to mention hair stylist Milan for
                                                                    his stunning scissors work and attention to detail.
                                                                    His skills truly transformed my look and made the
                                                                    visit worth every minute!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6 mb-3 review-card hidden-review">
                                                    <div class="card p-3">
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <img src="{{ asset('assets/images/product_view/profile.webp') }}"
                                                                    alt="Profile 1" class="img-fluid">
                                                            </div>
                                                            <div class="col-10">
                                                                <p class="fw-medium mb-0">Dhilip</p>
                                                                <div class="d-flex justify-content-between">
                                                                    <p class="mb-0">
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                        <i class="fa-solid fa-star-half-stroke fa-2xs"
                                                                            style="color: #fdbf46;"></i>
                                                                    </p>
                                                                    <p class="quickInfo">21 Jul 2024</p>
                                                                </div>
                                                                <p class="quickInfo mb-0">Did my haircut recently and
                                                                    the experience was absolutely amazing.I would
                                                                    especially like to mention hair stylist Milan for
                                                                    his stunning scissors work and attention to detail.
                                                                    His skills truly transformed my look and made the
                                                                    visit worth every minute!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="javascript:void(0);" id="read-more-btn"
                                                style="color: #ff0060;">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12 mb-3">
                                <div class="mx-2">
                                    <div class="row productViewCard mb-3">
                                        <div class="card p-3" style="border-radius: 5px;border-color: #ff0060 ">
                                            <div class="container">
                                                <div class="d-flex ">
                                                    <p class="fw-medium">Contact:</p>&nbsp;&nbsp;
                                                    <p class="fw-light">7937902038</p>
                                                </div>
                                                <hr>
                                                <div class="d-flex ">
                                                    <p class="fw-medium">Address:</p>&nbsp;&nbsp;
                                                    <p class="fw-light">No:112/89 Anna Salai,Thousand light,Chennai
                                                        -12.
                                                    </p>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-5 col-5">
                                                        <a href="#" class="contactCard">
                                                            <i class="fa fa-location"
                                                                style="color: #000;"></i>&nbsp;&nbsp;
                                                            Get Directions
                                                        </a>
                                                    </div>
                                                    <div class="col-md-12 col-lg-7 col-7">
                                                        <a href="#" class="contactCard">
                                                            <i class="fa-regular fa-envelope"
                                                                style="color: #000;"></i>&nbsp;&nbsp;
                                                            Send Enquiry by mail
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="position: sticky; top: 110px">
                                        <div class="row mb-4">
                                            <div class="card p-4 enquiryForm" style="border-color:#ff0060 ;">
                                                <h6 class="fw-medium mb-3">Get the list of best <span
                                                        style="color:#ff0060 ;">”Wedding Suits On Rent”</span></h6>
                                                <form>
                                                    <input class="form-control mb-3" placeholder="Name*" />
                                                    <input class="form-control mb-3" placeholder="Mobile Number*" />
                                                    <input class="form-control mb-3"
                                                        placeholder="Email ID(Optional)" />
                                                    <button class="btn enquiryBtn">Send Enquiry</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/product_view/adverstiment.webp') }}"
                                                alt="Adverstiment" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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

    <!-- Review Read More Button -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var readMoreButton = document.getElementById('read-more-btn');

            if (readMoreButton) {
                readMoreButton.addEventListener('click', function() {
                    var hiddenReviews = document.querySelectorAll('.hidden-review');

                    if (readMoreButton.textContent === "Read More") {
                        hiddenReviews.forEach(function(review) {
                            review.style.display = 'block';
                        });

                        readMoreButton.textContent = "Read Less";
                    } else {
                        hiddenReviews.forEach(function(review) {
                            review.style.display = 'none';
                        });

                        readMoreButton.textContent = "Read More";
                    }
                });
            }
        });
    </script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>
