<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @section('head_links')
    <title>DealsMachi Shop Smart, Save Big !</title>
    <link rel="canonical" href="https://dealsmachi.com/productfilter" />
    <meta name="description" content="DealsMachi Shop Smart, Save Big!" />
    <link rel="icon" href="{{ asset('assets/images/home/favicon.ico') }}" />

    <!-- Boostrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
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
                <div class="p-4 topFilter">
                    <div class="row d-flex align-items-center">
                        <!-- Beauty Spa and Hair Section -->
                        <div class="col-12 col-md-5 mb-3 mb-md-0">
                            <div class="d-flex justify-content-start px-5">
                                <p class="topText mb-0">Beauty Spa <i class="arrow-icon me-2 fa-solid fa-angle-right"></i>
                                </p>
                                <p class="selectText mb-0">Hair</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-7">
                            <div class="d-flex justify-content-md-end justify-content-center align-items-center">
                                <div class="d-flex align-items-center me-3">
                                    <p class="mb-0 dropdownheading me-2">Per Page:</p>
                                    <select class="form-select dropdownproduct" aria-label="Default select example"
                                        style="color: #8A8FB9">
                                        <option selected>5</option>
                                        <option value="10" class="filterdropdown">10</option>
                                        <option value="15" class="filterdropdown">15</option>
                                        <option value="25" class="filterdropdown">25</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 dropdownheading me-2">Sort By:</p>
                                    <select class="form-select dropdownproduct" aria-label="Default select example"
                                        style="color: #8A8FB9">
                                        <option selected>Best Match</option>
                                        <option value="Trending" class="filterdropdown">Trending</option>
                                        <option value="Popular" class="filterdropdown">Popular</option>
                                        <option value="Early Bird" class="filterdropdown">Early Bird</option>
                                        <option value="Limited Chance" class="filterdropdown">Limited Chance</option>
                                        <option value="Limited Time" class="filterdropdown">Limited Time</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 d-lg-none filter-button d-flex justify-content-center align-items-center mb-3 mx-3 mt-2"
                    style="width: fit-content !important">
                    <button class="btn btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas"
                        aria-controls="filterOffcanvas" style="border: none;width: fit-content !important">
                        <i class="fa-solid fa-filter" style="color: #fff"></i> <span class="text-white ms-1">Filters</span>
                    </button>
                </div>
                <div class="row filterindSection m-0 mt-3">
                    {{-- Offcanvas --}}
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas"
                        aria-labelledby="filterOffcanvasLabel">
                        <div class="offcanvas-header">
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body " style="overflow-y: auto">

                            <div class="row">
                                <div class="col-6">
                                    <p class="canvas_topText2"> Filter Results</p>
                                </div>
                                <div class="col-6">
                                    <p class="canvas_selectText2">350 deals available</p>
                                </div>
                            </div>
                            <!-- Filter Content (The code you provided) -->
                            <div class="col-12">
                                <div class="productFilter">
                                    <div class="px-5 pb-3">
                                        <div class="d-flex flex-column">
                                            <p class="topText3 mb-1" style="border-bottom: 1px solid; width:fit-content">
                                                Brand</p>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="coasterFurniture">
                                            <label class="form-check-label categoryLable" for="coasterFurniture">
                                                Coaster Furniture
                                            </label>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="highFashion">
                                            <label class="form-check-label categoryLable" for="highFashion">
                                                Fusion Dot High Fashion
                                            </label>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="furnitureRestore">
                                            <label class="form-check-label categoryLable" for="furnitureRestore">
                                                Unique Furniture Restore
                                            </label>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="furnitureFlipping">
                                            <label class="form-check-label categoryLable" for="furnitureFlipping">
                                                Dream Furniture Flipping
                                            </label>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="Young Repurposed">
                                            <label class="form-check-label categoryLable" for="youngPurposed">
                                                Young Repurposed
                                            </label>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="diyFurniture">
                                            <label class="form-check-label categoryLable" for="diyFurniture">
                                                Green DIY furniture
                                            </label>
                                        </div>
                                    </div>
                                    <div class="px-5 pb-3">
                                        <div class="d-flex flex-column">
                                            <p class="topText3 mb-1">Discount Offer</p>
                                            <div class="textline2"></div>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="20%Cashbook">
                                            <label class="form-check-label categoryLable" for="20%Cashbook">
                                                20% Cashback
                                            </label>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="5%Cashbook">
                                            <label class="form-check-label categoryLable" for="5%Cashbook">
                                                5% Cashback Offer
                                            </label>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="25%Cashbook">
                                            <label class="form-check-label categoryLable" for="25%Cashbook">
                                                25% Discount Offer
                                            </label>
                                        </div>
                                    </div>
                                    <div class="px-5 pb-3">
                                        <div class="d-flex flex-column">
                                            <p class="topText3 mb-1">Rating Item</p>
                                            <div class="textline2"></div>
                                        </div>
                                        <div class="form-check d-flex align-items-center pt-3">
                                            <input class="form-check-input yellow-checkbox me-2" type="checkbox"
                                                value="" id="rating1">
                                            <label class="form-check-label categoryLable" for="rating1">
                                                <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                                <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                                <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                                <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                                <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                                <span class="topText4">(2341)</span>
                                            </label>
                                        </div>
                                        <div class="form-check d-flex align-items-center pt-3">
                                            <input class="form-check-input yellow-checkbox me-2" type="checkbox"
                                                value="" id="rating2">
                                            <label class="form-check-label categoryLable" for="rating2">
                                                <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                                <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                                <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                                <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                                <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                                <span class="topText4">(1726)</span>
                                            </label>
                                        </div>
                                        <div class="form-check d-flex align-items-center pt-3">
                                            <input class="form-check-input yellow-checkbox me-2" type="checkbox"
                                                value="" id="rating3">
                                            <label class="form-check-label categoryLable" for="rating3">
                                                <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                                <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                                <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                                <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                                <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                                <span class="topText4">(258)</span>
                                            </label>
                                        </div>
                                        <div class="form-check d-flex align-items-center pt-3">
                                            <input class="form-check-input yellow-checkbox me-2" type="checkbox"
                                                value="" id="rating4">
                                            <label class="form-check-label categoryLable" for="rating4">
                                                <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                                <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                                <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                                <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                                <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                                <span class="topText4">(25)</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="px-5 pb-4">
                                        <div class="d-flex flex-column">
                                            <p class="topText3 mb-1">Price Filter</p>
                                            <div class="textline2"></div>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="priceFilter1">
                                            <label class="form-check-label categoryLable" for="priceFilter1">
                                                ₹0.00 - ₹150.00
                                            </label>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="priceFilter2">
                                            <label class="form-check-label categoryLable" for="priceFilter2">
                                                ₹150.00 - ₹350.00
                                            </label>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="priceFilter3">
                                            <label class="form-check-label categoryLable" for="priceFilter3">
                                                ₹150.00 - ₹504.00
                                            </label>
                                        </div>
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="priceFilter4">
                                            <label class="form-check-label categoryLable" for="priceFilter4">
                                                ₹450.00 +
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-5 sticky-bottom d-flex justify-content-center align-items-center mb-3">
                            <!-- Buttons inside your offcanvas -->
                            <button class="btn btn-button clear-button" type="button" id="clearButton">Clear
                                All</button>
                            &nbsp;&nbsp;
                            <button class="btn btn-button apply-button" type="button" id="applyButton">Apply</button>

                        </div>
                    </div>
                    <!-- Filter Sidebar for larger screens (Visible only on large screens) -->
                    <div class="col-md-3 col-12 d-none d-lg-block">
                        <div class="productFilter filterlarge">
                            <div class="d-flex justify-content-center align-items-center pb-3">
                                <p class="me-2 topText2"> Filter Results</p>
                                &nbsp;&nbsp;
                                <p class="selectText2">350 deals available</p>
                            </div>
                            <div class="px-5 pb-3">
                                <div class="d-flex flex-column">
                                    <p class="topText3 mb-1" style="border-bottom: 1px solid; width:fit-content">Brand</p>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="Coaster Furniture">
                                    <label class="form-check-label categoryLable" for="Coaster Furniture">
                                        Coaster Furniture
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="Fusion Dot High Fashion">
                                    <label class="form-check-label categoryLable" for="Fusion Dot High Fashion">
                                        Fusion Dot High Fashion
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="Unique Furniture Restore">
                                    <label class="form-check-label categoryLable" for="Unique Furniture Restore">
                                        Unique Furniture Restore
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="Dream Furniture Flipping">
                                    <label class="form-check-label categoryLable" for="Dream Furniture Flipping">
                                        Dream Furniture Flipping
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="Young Repurposed">
                                    <label class="form-check-label categoryLable" for="Young Repurposed">
                                        Young Repurposed
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="Green DIY furniture">
                                    <label class="form-check-label categoryLable" for="Green DIY furniture">
                                        Green DIY furniture
                                    </label>
                                </div>
                            </div>
                            <div class="px-5 pb-3">
                                <div class="d-flex flex-column">
                                    <p class="topText3 mb-1">Discount Offer</p>
                                    <div class="textline2"></div>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value="" id="20% Cashback">
                                    <label class="form-check-label categoryLable" for="20% Cashback">
                                        20% Cashback
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="5% Cashback Offer">
                                    <label class="form-check-label categoryLable" for="5% Cashback Offer">
                                        5% Cashback Offer
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="25% Discount Offer">
                                    <label class="form-check-label categoryLable" for="25% Discount Offer">
                                        25% Discount Offer
                                    </label>
                                </div>
                            </div>
                            <div class="px-5 pb-3">
                                <div class="d-flex flex-column">
                                    <p class="topText3 mb-1">Rating Item</p>
                                    <div class="textline2"></div>
                                </div>
                                <div class="form-check d-flex align-items-center pt-3">
                                    <input class="form-check-input yellow-checkbox me-2" type="checkbox" value=""
                                        id="rating 1">
                                    <label class="form-check-label categoryLable" for="rating 1">
                                        <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                        <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                        <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                        <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                        <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                        <span class="topText4">(2341)</span>
                                    </label>
                                </div>
                                <div class="form-check d-flex align-items-center pt-3">
                                    <input class="form-check-input yellow-checkbox me-2" type="checkbox" value=""
                                        id="rating 2">
                                    <label class="form-check-label categoryLable" for="rating 2">
                                        <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                        <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                        <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                        <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                        <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                        <span class="topText4">(1726)</span>
                                    </label>
                                </div>
                                <div class="form-check d-flex align-items-center pt-3">
                                    <input class="form-check-input yellow-checkbox me-2" type="checkbox" value=""
                                        id="rating 3">
                                    <label class="form-check-label categoryLable" for="rating 3">
                                        <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                        <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                        <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                        <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                        <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                        <span class="topText4">(258)</span>
                                    </label>
                                </div>
                                <div class="form-check d-flex align-items-center pt-3">
                                    <input class="form-check-input yellow-checkbox me-2" type="checkbox" value=""
                                        id="rating 4">
                                    <label class="form-check-label categoryLable" for="rating 4">
                                        <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                        <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                        <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                        <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                        <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                        <span class="topText4">(25)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="px-5 pb-4">
                                <div class="d-flex flex-column">
                                    <p class="topText3 mb-1">Price Filter</p>
                                    <div class="textline2"></div>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value="" id="₹0.00 - ₹150.00">
                                    <label class="form-check-label categoryLable" for="₹0.00 - ₹150.00">
                                        ₹0.00 - ₹150.00
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="₹150.00 - ₹350.00">
                                    <label class="form-check-label categoryLable" for="₹150.00 - ₹350.00">
                                        ₹150.00 - ₹350.00
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="₹150.00 - ₹504.00">
                                    <label class="form-check-label categoryLable" for="₹150.00 - ₹504.00">
                                        ₹150.00 - ₹504.00
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" value="" id=" ₹450.00 +">
                                    <label class="form-check-label categoryLable" for=" ₹450.00 +">
                                        ₹450.00 +
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="px-3 sticky-bottom d-flex justify-content-center align-items-center mb-3">
                            <button class="btn btn-button clear-button">Clear All</button>
                            &nbsp;&nbsp;
                            <button class="btn btn-button apply-button">Apply</button>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-9 col-12">
                        <div class="row pb-4">
                            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                                <a href="{{ url('/products') }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">TRENDING</span>
                                            <img src="{{ asset('assets/images/home/kids_wear_2.webp') }}"
                                                class="img-fluid card-img-top1" alt="card_image" />
                                        </div>
                                        <div class="card-body card_section">
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title px-3">Kids Wear</h5>
                                                <span class="badge p-0 mx-3 trending-wishlist-badge">
                                                    <i class="fa-regular fa-bookmark wishlist-icon" onclick="toggleBookmark(this, event)"></i>
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal">
                                                DealsMachi, deals that matter in Chennai! Get the best of
                                                Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                            </p>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color:  #ff0060 "><span>₹150 </span><span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI25</span></p>
                                            <div class="card-divider"></div>
                                            <div class="px-3">
                                                <p>Regular Price</p>
                                                <p><s>₹200 </s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium"
                                                style="color:  #ff0060 ;font-weight: 400 !important;"><i
                                                    class="fa-solid fa-location-dot"></i>
                                                &nbsp;Chennai</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                                <a href="{{ url('/products') }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">POPULAR</span>
                                            <img src="{{ asset('assets/images/home/beauty2.webp') }}"
                                                class="img-fluid card-img-top1" alt="card_image" />
                                        </div>
                                        <div class="card-body card_section">
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title  px-3">Beauty Spa</h5>
                                                <span class="badge p-0 mx-3 trending-wishlist-badge">
                                                    <i class="fa-regular fa-bookmark wishlist-icon" onclick="toggleBookmark(this, event)"></i>
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal">
                                                DealsMachi, deals that matter in Chennai! Get the best of
                                                Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                            </p>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color:  #ff0060 "><span>₹150 </span><span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI25</span></p>
                                            <div class="card-divider"></div>
                                            <div class="px-3">
                                                <p>Regular Price</p>
                                                <p><s>₹200 </s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium"
                                                style="color:  #ff0060 ;font-weight: 400 !important;" ;font-weight: 400
                                                !important;><i class="fa-solid fa-location-dot"></i>
                                                &nbsp;Chennai</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                                <a href="{{ url('/products') }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">LIMITED TIME</span>
                                            <img src="{{ asset('assets/images/home/restaurant.webp') }}"
                                                class="img-fluid card-img-top1" alt="card_image" />
                                        </div>
                                        <div class="card-body card_section">
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title px-3">Restaurants</h5>
                                                <span class="badge p-0 mx-3 trending-wishlist-badge">
                                                    <i class="fa-regular fa-bookmark wishlist-icon" onclick="toggleBookmark(this, event)"></i>
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal">
                                                DealsMachi, deals that matter in Chennai! Get the best of
                                                Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                            </p>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color:  #ff0060 "><span>₹150 </span><span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI25</span></p>
                                            <div class="card-divider"></div>
                                            <div class="px-3">
                                                <p>Regular Price</p>
                                                <p><s>₹200 </s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium"
                                                style="color:  #ff0060 ;font-weight: 400 !important;"><i
                                                    class="fa-solid fa-location-dot"></i>
                                                &nbsp;Chennai</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                                <a href="{{ url('/products') }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">LAST CHANCE</span>
                                            <img src="{{ asset('assets/images/home/spa_two.webp') }}"
                                                class="img-fluid card-img-top1" alt="card_image" />
                                        </div>
                                        <div class="card-body card_section">
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title px-3">Beauty Spa</h5>
                                                <span class="badge p-0 mx-3 trending-wishlist-badge">
                                                    <i class="fa-regular fa-bookmark wishlist-icon" onclick="toggleBookmark(this, event)"></i>
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal">
                                                DealsMachi, deals that matter in Chennai! Get the best of
                                                Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                            </p>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color:  #ff0060 "><span>₹150 </span><span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI25</span></p>
                                            <div class="card-divider"></div>
                                            <div class="px-3">
                                                <p>Regular Price</p>
                                                <p><s>₹200 </s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium"
                                                style="color:  #ff0060 ;font-weight: 400 !important;"><i
                                                    class="fa-solid fa-location-dot"></i>
                                                &nbsp;Chennai</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                                <a href="{{ url('/products') }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">EARLY BIRD</span>
                                            <img src="{{ asset('assets/images/home/card_image_1.webp') }}"
                                                class="img-fluid card-img-top1" alt="card_image" />
                                        </div>
                                        <div class="card-body card_section">
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title px-3">Kids Wear</h5>
                                                <span class="badge p-0 mx-3 trending-wishlist-badge">
                                                    <i class="fa-regular fa-bookmark wishlist-icon" onclick="toggleBookmark(this, event)"></i>
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal">
                                                DealsMachi, deals that matter in Chennai! Get the best of
                                                Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                            </p>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color:  #ff0060 "><span>₹150 </span><span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI25</span></p>
                                            <div class="card-divider"></div>
                                            <div class="px-3">
                                                <p>Regular Price</p>
                                                <p><s>₹200 </s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium"
                                                style="color:  #ff0060 ;font-weight: 400 !important;"><i
                                                    class="fa-solid fa-location-dot"></i>
                                                &nbsp;Chennai</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                                <a href="{{ url('/products') }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">TRENDING</span>
                                            <img src="{{ asset('assets/images/home/card_image_3.webp') }}"
                                                class="img-fluid card-img-top1" alt="card_image" />
                                        </div>
                                        <div class="card-body card_section">
                                            <h5 class="card-title mt-3 px-3"></h5>
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title px-3">Beauty Spa</h5>
                                                <span class="badge p-0 mx-3 trending-wishlist-badge">
                                                    <i class="fa-regular fa-bookmark wishlist-icon" onclick="toggleBookmark(this, event)"></i>
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal">
                                                DealsMachi, deals that matter in Chennai! Get the best of
                                                Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                            </p>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color:  #ff0060 "><span>₹150 </span><span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI25</span></p>
                                            <div class="card-divider"></div>
                                            <div class="px-3">
                                                <p>Regular Price</p>
                                                <p><s>₹200 </s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium"
                                                style="color:  #ff0060 ;font-weight: 400 !important;"><i
                                                    class="fa-solid fa-location-dot"></i>
                                                &nbsp;Chennai</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                                <a href="{{ url('/products') }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">POPULAR</span>
                                            <img src="{{ asset('assets/images/home/card_image_2.webp') }}"
                                                class="img-fluid card-img-top1" alt="card_image" />
                                        </div>
                                        <div class="card-body card_section">
                                            <h5 class="card-title mt-3 px-3"></h5>
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title px-3">Men's Wear</h5>
                                                <span class="badge p-0 mx-3 trending-wishlist-badge">
                                                    <i class="fa-regular fa-bookmark wishlist-icon" onclick="toggleBookmark(this, event)"></i>
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal">
                                                DealsMachi, deals that matter in Chennai! Get the best of
                                                Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                            </p>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color:  #ff0060 "><span>₹150 </span><span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI25</span></p>
                                            <div class="card-divider"></div>
                                            <div class="px-3">
                                                <p>Regular Price</p>
                                                <p><s>₹200 </s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium"
                                                style="color:  #ff0060 ;font-weight: 400 !important;"><i
                                                    class="fa-solid fa-location-dot"></i>
                                                &nbsp;Chennai</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                                <a href="{{ url('/products') }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">LIMITED TIME</span>
                                            <img src="{{ asset('assets/images/home/card_image_4.webp') }}"
                                                class="img-fluid card-img-top1" alt="card_image" />
                                        </div>
                                        <div class="card-body card_section">
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title px-3">Beauty Spa</h5>
                                                <span class="badge p-0 mx-3 trending-wishlist-badge">
                                                    <i class="fa-regular fa-bookmark wishlist-icon" onclick="toggleBookmark(this, event)"></i>
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal">
                                                DealsMachi, deals that matter in Chennai! Get the best of
                                                Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                            </p>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color:  #ff0060 "><span>₹150</span><span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI25</span></p>
                                            <div class="card-divider"></div>
                                            <div class="px-3">
                                                <p>Regular Price</p>
                                                <p><s>₹200</s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium"
                                                style="color:  #ff0060 ;font-weight: 400 !important;"><i
                                                    class="fa-solid fa-location-dot"></i>
                                                &nbsp;Chennai</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                                <a href="{{ url('/products') }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">LAST CHANCE</span>
                                            <img src="{{ asset('assets/images/home/kids_wear_2.webp') }}"
                                                class="img-fluid card-img-top1" alt="card_image" />
                                        </div>
                                        <div class="card-body card_section">
                                            <h5 class="card-title mt-3 px-3"></h5>
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title px-3">Kids Wear</h5>
                                                <span class="badge p-0 mx-3 trending-wishlist-badge">
                                                    <i class="fa-regular fa-bookmark wishlist-icon" onclick="toggleBookmark(this, event)"></i>
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal">
                                                DealsMachi, deals that matter in Chennai! Get the best of
                                                Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                            </p>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color:  #ff0060 "><span>₹150</span><span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI25</span></p>
                                            <div class="card-divider"></div>
                                            <div class="px-3">
                                                <p>Regular Price</p>
                                                <p><s>₹200</s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium"
                                                style="color:  #ff0060 ;font-weight: 400 !important;"><i
                                                    class="fa-solid fa-location-dot"></i>
                                                &nbsp;Chennai</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                                <a href="{{ url('/products') }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">EARLY BIRD</span>
                                            <img src="{{ asset('assets/images/home/beauty2.webp') }}"
                                                class="img-fluid card-img-top1" alt="card_image" />
                                        </div>
                                        <div class="card-body card_section">
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title px-3">Beauty Spa</h5>
                                                <span class="badge p-0 mx-3 trending-wishlist-badge">
                                                    <i class="fa-regular fa-bookmark wishlist-icon" onclick="toggleBookmark(this, event)"></i>
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal">
                                                DealsMachi, deals that matter in Chennai! Get the best of
                                                Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                            </p>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color:  #ff0060 "><span>₹150 </span><span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI25</span></p>
                                            <div class="card-divider"></div>
                                            <div class="px-3">
                                                <p>Regular Price</p>
                                                <p><s>₹200 </s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium"
                                                style="color:  #ff0060 ;font-weight: 400 !important;"><i
                                                    class="fa-solid fa-location-dot"></i>
                                                &nbsp;Chennai</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                                <a href="{{ url('/products') }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">TRENDING</span>
                                            <img src="{{ asset('assets/images/home/restaurant.webp') }}"
                                                class="img-fluid card-img-top1" alt="card_image" />
                                        </div>
                                        <div class="card-body card_section">
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title px-3">Restaurants</h5>
                                                <span class="badge p-0 mx-3 trending-wishlist-badge">
                                                    <i class="fa-regular fa-bookmark wishlist-icon" onclick="toggleBookmark(this, event)"></i>
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal">
                                                DealsMachi, deals that matter in Chennai! Get the best of
                                                Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                            </p>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color:  #ff0060 "><span>₹150 </span><span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI25</span></p>
                                            <div class="card-divider"></div>
                                            <div class="px-3">
                                                <p>Regular Price</p>
                                                <p><s>₹200 </s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium"
                                                style="color:  #ff0060 ;font-weight: 400 !important;"><i
                                                    class="fa-solid fa-location-dot"></i>
                                                &nbsp;Chennai</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-center justify-content-center">
                                <a href="{{ url('/products') }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">POPULAR</span>
                                            <img src="{{ asset('assets/images/home/spa_two.webp') }}"
                                                class="img-fluid card-img-top1" alt="card_image" />
                                        </div>
                                        <div class="card-body card_section">
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title px-3">Beauty Spa</h5>
                                                <span class="badge p-0 mx-3 trending-wishlist-badge">
                                                    <i class="fa-regular fa-bookmark wishlist-icon" onclick="toggleBookmark(this, event)"></i>
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal">
                                                DealsMachi, deals that matter in Chennai! Get the best of
                                                Electronics, Food, Travel, Makeup, Spa and other hot deals.
                                            </p>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color:  #ff0060 "><span>₹150 </span><span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI25</span></p>
                                            <div class="card-divider"></div>
                                            <div class="px-3">
                                                <p>Regular Price</p>
                                                <p><s>₹200 </s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="px-3 fw-medium"
                                                style="color:  #ff0060 ;font-weight: 400 !important;"><i
                                                    class="fa-solid fa-location-dot"></i>
                                                &nbsp;Chennai</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
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

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>