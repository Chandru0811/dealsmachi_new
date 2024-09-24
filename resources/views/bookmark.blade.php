<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @section('head_links')
        <title>Dealslah | Wishlist </title>
        <link rel="canonical" href="https://dealslah.com/bookmark" />
        <meta name="description" content="Dealslah Shop Smart, Save Big!" />
        <link rel="icon" href="{{ asset('assets/images/home/favicon.ico') }}" />

        <!-- Vendor CSS Files -->
        {{-- Boostrap css  --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">
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
        @include('layouts.header')
        <div class="home-content" style="margin-top: 100px">
            <div class="container">
                <span class="d-flex">
                    <h5 class="pt-0 pb-2">Your Wishlist</h5> &nbsp;&nbsp;
                    <p>(312)</p>
                </span>
                <div class="row pb-4">
                    <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                        <div class="card sub_topCard h-100">
                            <div style="min-height: 50px">
                                <span class="badge trending-badge">EARLY BIRD</span>
                                <img src="{{ asset('assets/images/home/card_image_1.webp') }}"
                                    class="img-fluid card-img-top1" alt="card_image" />
                            </div>
                            <div class="card-body card_section">
                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                    <h5 class="card-title ps-3">Kids Wear</h5>
                                    <span class="badge p-0 mx-3 trending-wishlist-badge"><i
                                            class="fa-solid fa-bookmark"></i></span>
                                </div>
                                <span class="px-3">
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                </span>
                                <p class="px-3 fw-normal">
                                    Dealslah, deals that matter in Singapore! Get the best of
                                    Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                </p>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                    style="color:  #ff0060 "><span>$150 </span><span
                                        class="mx-3 px-2 couponBadge">DEALSLAH25</span></p>
                                <div class="card-divider"></div>
                                <div class="ps-3">
                                    <p>Regular Price</p>
                                    <p><s>$200 </s></p>
                                </div>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium" style="color:  #ff0060 "><i
                                        class="fa-solid fa-location-dot"></i>
                                    &nbsp;Singapore</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                        <div class="card sub_topCard h-100">
                            <div style="min-height: 50px">
                                <span class="badge trending-badge">TRENDING</span>
                                <img src="{{ asset('assets/images/home/card_image_3.webp') }}"
                                    class="img-fluid card-img-top1" alt="card_image" />
                            </div>
                            <div class="card-body card_section">
                                <h5 class="card-title mt-3 ps-3"></h5>
                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                    <h5 class="card-title ps-3">Beauty Spa</h5>
                                    <span class="badge p-0 mx-3 trending-wishlist-badge"><i
                                            class="fa-solid fa-bookmark"></i></span>
                                </div>
                                <span class="px-3">
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                </span>
                                <p class="px-3 fw-normal">
                                    Dealslah, deals that matter in Singapore! Get the best of
                                    Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                </p>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                    style="color:  #ff0060 "><span>$150 </span><span
                                        class="mx-3 px-2 couponBadge">DEALSLAH25</span></p>
                                <div class="card-divider"></div>
                                <div class="ps-3">
                                    <p>Regular Price</p>
                                    <p><s>$200 </s></p>
                                </div>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium" style="color:  #ff0060 "><i
                                        class="fa-solid fa-location-dot"></i>
                                    &nbsp;Singapore</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                        <div class="card sub_topCard h-100">
                            <div style="min-height: 50px">
                                <span class="badge trending-badge">POPULAR</span>
                                <img src="{{ asset('assets/images/home/card_image_2.webp') }}"
                                    class="img-fluid card-img-top1" alt="card_image" />
                            </div>
                            <div class="card-body card_section">
                                <h5 class="card-title mt-3 ps-3"></h5>
                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                    <h5 class="card-title ps-3">Men's Wear</h5>
                                    <span class="badge p-0 mx-3 trending-wishlist-badge"><i
                                            class="fa-solid fa-bookmark"></i></span>
                                </div>
                                <span class="px-3">
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                </span>
                                <p class="px-3 fw-normal">
                                    Dealslah, deals that matter in Singapore! Get the best of
                                    Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                </p>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                    style="color:  #ff0060 "><span>$150 </span><span
                                        class="mx-3 px-2 couponBadge">DEALSLAH25</span></p>
                                <div class="card-divider"></div>
                                <div class="ps-3">
                                    <p>Regular Price</p>
                                    <p><s>$200 </s></p>
                                </div>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium" style="color:  #ff0060 "><i
                                        class="fa-solid fa-location-dot"></i>
                                    &nbsp;Singapore</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                        <div class="card sub_topCard h-100">
                            <div style="min-height: 50px">
                                <span class="badge trending-badge">LIMITED TIME</span>
                                <img src="{{ asset('assets/images/home/card_image_4.webp') }}"
                                    class="img-fluid card-img-top1" alt="card_image" />
                            </div>
                            <div class="card-body card_section">
                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                    <h5 class="card-title ps-3">Beauty Spa</h5>
                                    <span class="badge p-0 mx-3 trending-wishlist-badge"><i
                                            class="fa-solid fa-bookmark"></i></span>
                                </div>
                                <span class="px-3">
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                </span>
                                <p class="px-3 fw-normal">
                                    Dealslah, deals that matter in Singapore! Get the best of
                                    Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                </p>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                    style="color:  #ff0060 "><span>$150 </span><span
                                        class="mx-3 px-2 couponBadge">DEALSLAH25</span></p>
                                <div class="card-divider"></div>
                                <div class="ps-3">
                                    <p>Regular Price</p>
                                    <p><s>$200 </s></p>
                                </div>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium" style="color:  #ff0060 "><i
                                        class="fa-solid fa-location-dot"></i>
                                    &nbsp;Singapore</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                        <div class="card sub_topCard h-100">
                            <div style="min-height: 50px">
                                <span class="badge trending-badge">LAST CHANCE</span>
                                <img src="{{ asset('assets/images/home/kids_wear_2.webp') }}"
                                    class="img-fluid card-img-top1" alt="card_image" />
                            </div>
                            <div class="card-body card_section">
                                <h5 class="card-title mt-3 ps-3"></h5>
                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                    <h5 class="card-title ps-3">Kids Wear</h5>
                                    <span class="badge p-0 mx-3 trending-wishlist-badge"><i
                                            class="fa-solid fa-bookmark"></i></span>
                                </div>
                                <span class="px-3">
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                </span>
                                <p class="px-3 fw-normal">
                                    Dealslah, deals that matter in Singapore! Get the best of
                                    Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                </p>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                    style="color:  #ff0060 "><span>$150 </span><span
                                        class="mx-3 px-2 couponBadge">DEALSLAH25</span></p>
                                <div class="card-divider"></div>
                                <div class="ps-3">
                                    <p>Regular Price</p>
                                    <p><s>$200 </s></p>
                                </div>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium" style="color:  #ff0060 "><i
                                        class="fa-solid fa-location-dot"></i>
                                    &nbsp;Singapore</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                        <div class="card sub_topCard h-100">
                            <div style="min-height: 50px">
                                <span class="badge trending-badge">EARLY BIRD</span>
                                <img src="{{ asset('assets/images/home/beauty2.webp') }}"
                                    class="img-fluid card-img-top1" alt="card_image" />
                            </div>
                            <div class="card-body card_section">
                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                    <h5 class="card-title ps-3">Beauty Spa</h5>
                                    <span class="badge p-0 mx-3 trending-wishlist-badge"><i
                                            class="fa-solid fa-bookmark"></i></span>
                                </div>
                                <span class="px-3">
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                </span>
                                <p class="px-3 fw-normal">
                                    Dealslah, deals that matter in Singapore! Get the best of
                                    Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                </p>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                    style="color:  #ff0060 "><span>$150 </span><span
                                        class="mx-3 px-2 couponBadge">DEALSLAH25</span></p>
                                <div class="card-divider"></div>
                                <div class="ps-3">
                                    <p>Regular Price</p>
                                    <p><s>$200 </s></p>
                                </div>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium" style="color:  #ff0060 "><i
                                        class="fa-solid fa-location-dot"></i>
                                    &nbsp;Singapore</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                        <div class="card sub_topCard h-100">
                            <div style="min-height: 50px">
                                <span class="badge trending-badge">TRENDING</span>
                                <img src="{{ asset('assets/images/home/restaurant.webp') }}"
                                    class="img-fluid card-img-top1" alt="card_image" />
                            </div>
                            <div class="card-body card_section">
                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                    <h5 class="card-title ps-3">Restaurants</h5>
                                    <span class="badge p-0 mx-3 trending-wishlist-badge"><i
                                            class="fa-solid fa-bookmark"></i></span>
                                </div>
                                <span class="px-3">
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                </span>
                                <p class="px-3 fw-normal">
                                    Dealslah, deals that matter in Singapore! Get the best of
                                    Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                </p>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                    style="color:  #ff0060 "><span>$150 </span><span
                                        class="mx-3 px-2 couponBadge">DEALSLAH25</span></p>
                                <div class="card-divider"></div>
                                <div class="ps-3">
                                    <p>Regular Price</p>
                                    <p><s>$200 </s></p>
                                </div>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium" style="color:  #ff0060 "><i
                                        class="fa-solid fa-location-dot"></i>
                                    &nbsp;Singapore</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                        <div class="card sub_topCard h-100">
                            <div style="min-height: 50px">
                                <span class="badge trending-badge">POPULAR</span>
                                <img src="{{ asset('assets/images/home/spa_two.webp') }}"
                                    class="img-fluid card-img-top1" alt="card_image" />
                            </div>
                            <div class="card-body card_section">
                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                    <h5 class="card-title ps-3">Beauty Spa</h5>
                                    <span class="badge p-0 mx-3 trending-wishlist-badge"><i
                                            class="fa-solid fa-bookmark"></i></span>
                                </div>
                                <span class="px-3">
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                    <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                </span>
                                <p class="px-3 fw-normal">
                                    Dealslah, deals that matter in Singapore! Get the best of
                                    Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                </p>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                    style="color:  #ff0060 "><span>$150 </span><span
                                        class="mx-3 px-2 couponBadge">DEALSLAH25</span></p>
                                <div class="card-divider"></div>
                                <div class="ps-3">
                                    <p>Regular Price</p>
                                    <p><s>$200 </s></p>
                                </div>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium" style="color:  #ff0060 "><i
                                        class="fa-solid fa-location-dot"></i>
                                    &nbsp;Singapore</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.footer')
    <!-- ======= Script  ======= -->



    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/5b8838406b.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!-- Page Scripts -->
    @stack('scripts')
</body>

</html>
