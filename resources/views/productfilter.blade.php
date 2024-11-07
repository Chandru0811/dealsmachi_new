@extends('layouts.master')

@section('content')
    <div class="categoryIcons">
        <form method="GET"
            action="{{ !empty($category) ? route('subcategorybasedproducts', ['slug' => $category->slug]) : route('search') }}"
            id="filterForm">
            <div class="p-4 topFilter">
                <div class="row d-flex align-items-center">
                    <!-- Beauty Spa and Hair Section -->
                    <div class="col-12 col-md-8 mb-3 mb-md-0">
                        @if (!empty($categorygroup) && !empty($category))
                            <div class="d-flex justify-content-start px-5">
                                <a href="/" class="text-decoration-none">
                                    <p class="topText mb-0">{{ $categorygroup->name ?? '' }}
                                        <i class="arrow-icon me-2 fa-solid fa-angle-right"></i>
                                    </p>
                                </a>
                                <p class="selectText mb-0" style="cursor: default">{{ $category->name ?? '' }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="d-flex justify-content-md-end justify-content-center align-items-center">
                            <div class="d-flex align-items-center me-3">
                                <p class="mb-0 dropdownheading me-2">Per Page:</p>
                                <select class="form-select dropdownproduct" aria-label="Default select example"
                                    name="per_page" onchange="this.form.submit()" style="color: #8A8FB9">
                                    <option value="5" {{ request()->input('per_page') == 5 ? 'selected' : '' }}>5
                                    </option>
                                    <option value="10" {{ request()->input('per_page', 10) == 10 ? 'selected' : '' }}>10
                                    </option>
                                    <option value="15" {{ request()->input('per_page') == 15 ? 'selected' : '' }}>15
                                    </option>
                                    <option value="25" {{ request()->input('per_page') == 25 ? 'selected' : '' }}>25
                                    </option>
                                </select>
                            </div>
                            <div class="d-flex align-items-center">
                                <p class="mb-0 dropdownheading me-2">Sort By:</p>
                                <select class="form-select dropdownproduct" aria-label="Default select example"
                                    name="short_by" onchange="this.form.submit()" style="color: #8A8FB9">
                                    <option value="" class="filterdropdown"></option>
                                    @foreach ($shortby as $dealsoption)
                                        <option value="{{ $dealsoption->slug }}" class="filterdropdown"
                                            {{ request()->input('short_by') == $dealsoption->slug ? 'selected' : '' }}>
                                            {{ $dealsoption->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Filter Button for Mobile -->
            <div class="col-2 d-lg-none filter-button d-flex justify-content-center align-items-center mb-3 mx-3 mt-2"
                style="width: fit-content !important">
                <button class="btn btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas"
                    aria-controls="filterOffcanvas" style="border: none;width: fit-content !important">
                    <i class="fa-solid fa-filter" style="color: #fff"></i> <span class="text-white ms-1">Filters</span>
                </button>
            </div>

            <!-- Filters Section -->
            <div class="row filterindSection m-0 mt-3">
                @if ($deals->isNotEmpty())
                    {{-- Offcanvas for Mobile --}}
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas"
                        aria-labelledby="filterOffcanvasLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filter Results</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body" style="overflow-y: auto">
                            <div class="row">
                                <div class="col-6">
                                    <p class="canvas_topText2">Filter Results</p>
                                </div>
                                <div class="col-6">
                                    <p class="canvas_selectText2">{{ $totaldeals }} deals available</p>
                                </div>
                            </div>

                            <!-- Brand Filter -->
                            <div class="px-5 pb-3">
                                <div class="d-flex flex-column">
                                    <p class="topText3 mb-1" style="border-bottom: 1px solid black; width:fit-content">Brand
                                    </p>
                                </div>
                                @foreach ($brands as $brand)
                                    <div class="form-check pt-3">
                                        <input class="form-check-input" type="checkbox" name="brand[]"
                                            value="{{ $brand }}" id="brand_{{ $loop->index }}"
                                            {{ in_array($brand, request()->input('brand', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label categoryLable" for="brand_{{ $loop->index }}">
                                            {{ str_replace('_', ' ', $brand) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Discount Filter -->
                            <div class="px-5 pb-3">
                                <div class="d-flex flex-column">
                                    <p class="topText3">Discount Offer</p>
                                    <div class="textline2"></div>
                                </div>
                                @foreach ($discounts as $discount)
                                    <div class="form-check pt-3">
                                        <input class="form-check-input" type="checkbox" name="discount[]"
                                            value="{{ $discount }}" id="discount_{{ $loop->index }}"
                                            {{ in_array($discount, request()->input('discount', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label categoryLable" for="discount_{{ $loop->index }}">
                                            {{ number_format($discount, 0) }}%
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Rating Item Filter -->
                            <div class="px-5 pb-3">
                                <div class="d-flex flex-column">
                                    <p class="topText3 mb-1">Rating Item</p>
                                    <div class="textline2"></div>
                                </div>

                                @foreach ($rating_items as $item)
                                    <div class="form-check d-flex align-items-center pt-3">
                                        <input class="form-check-input yellow-checkbox me-2" type="checkbox"
                                            name="rating_item[]" value="{{ $item->shop_ratings }}"
                                            id="rating_{{ $loop->index }}"
                                            {{ in_array($item->shop_ratings, request()->input('rating_item', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label categoryLable" for="rating_{{ $loop->index }}">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= round($item->shop_ratings))
                                                    <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                                @else
                                                    <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                                @endif
                                            @endfor
                                            <span class="topText4">({{ $item->rating_count }})</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Price Filter -->
                            <div class="px-5 pb-4">
                                <div class="d-flex flex-column">
                                    <p class="topText3 mb-1">Price Filter</p>
                                    <div class="textline2"></div>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" name="price_range[]"
                                        value="Rs0-Rs1000" id="price_0_1000"
                                        {{ in_array('Rs0-Rs1000', request()->get('price_range', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label categoryLable" for="price_0_1000">
                                        Under Rs 1000
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" name="price_range[]"
                                        value="Rs1000-Rs2000" id="price_1000_2000"
                                        {{ in_array('Rs1000-Rs2000', request()->get('price_range', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label categoryLable" for="price_1000_2000">
                                        Rs 1000 - Rs 2000
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" name="price_range[]"
                                        value="Rs2000-Rs5000" id="price_2000_5000"
                                        {{ in_array('Rs2000-Rs5000', request()->get('price_range', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label categoryLable" for="price_2000_5000">
                                        Rs 2000 - Rs 5000
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" name="price_range[]"
                                        value="Rs5000-Rs10000" id="price_5000_10000"
                                        {{ in_array('Rs5000-Rs10000', request()->get('price_range', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label categoryLable" for="price_5000_10000">
                                        Rs 5000 - Rs 10000
                                    </label>
                                </div>
                                <div class="form-check pt-3">
                                    <input class="form-check-input" type="checkbox" name="price_range[]"
                                        value="Rs10000-Rs100000" id="price_10000_100000"
                                        {{ in_array('Rs10000-Rs100000', request()->get('price_range', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label categoryLable" for="price_10000_100000">
                                        Above Rs 10000
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="px-5 sticky-bottom d-flex justify-content-center align-items-center mb-3">
                            <!-- Buttons inside your offcanvas -->
                            <button type="button" class="btn btn-button clear-button" id="clearButton">Clear
                                All</button>
                            &nbsp;&nbsp;
                            <button type="submit" class="btn btn-button apply-button" id="applyButton">Apply</button>
                        </div>
                    </div>

                    <!-- Filter Sidebar for Larger Screens -->
                    @if (!$deals->isEmpty())
                        <div class="col-md-3 col-12 d-none d-lg-block">
                            <div class="productFilter filterlarge">
                                <div class="d-flex justify-content-center align-items-center pb-3">
                                    <p class="me-2 topText2">Filter Results</p>
                                    &nbsp;&nbsp;
                                    <p class="selectText2">{{ $totaldeals }} deals available</p>
                                </div>

                                <!-- Brand Filter -->
                                <div class="px-5 pb-3">
                                    <div class="d-flex flex-column">
                                        <p class="topText3 mb-1"
                                            style="border-bottom: 1px solid black; width:fit-content">
                                            Brand</p>
                                    </div>
                                    @foreach ($brands as $brand)
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" name="brand[]"
                                                value="{{ $brand }}" id="brand_large_{{ $loop->index }}"
                                                {{ in_array($brand, request()->input('brand', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label categoryLable"
                                                for="brand_large_{{ $loop->index }}">
                                                {{ str_replace('_', ' ', $brand) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Discount Filter -->
                                <div class="px-5 pb-3">
                                    <div class="d-flex flex-column">
                                        <p class="topText3">Discount Offer</p>
                                        <div class="textline2"></div>
                                    </div>
                                    @foreach ($discounts as $discount)
                                        <div class="form-check pt-3">
                                            <input class="form-check-input" type="checkbox" name="discount[]"
                                                value="{{ $discount }}" id="discount_large_{{ $loop->index }}"
                                                {{ in_array($discount, request()->input('discount', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label categoryLable"
                                                for="discount_large_{{ $loop->index }}">
                                                {{ number_format($discount, 0) }}%
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Rating Item Filter -->
                                <div class="px-5 pb-3">
                                    <div class="d-flex flex-column">
                                        <p class="topText3 mb-1">Rating Item</p>
                                        <div class="textline2"></div>
                                    </div>

                                    @foreach ($rating_items as $item)
                                        <div class="form-check d-flex align-items-center pt-3">
                                            <input class="form-check-input yellow-checkbox me-2" type="checkbox"
                                                name="rating_item[]" value="{{ $item->shop_ratings }}"
                                                id="rating_large_{{ $loop->index }}"
                                                {{ in_array($item->shop_ratings, request()->input('rating_item', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label categoryLable"
                                                for="rating_large_{{ $loop->index }}">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= round($item->shop_ratings))
                                                        <i class="fa-solid fa-star" style="color: #FFC107"></i>
                                                    @else
                                                        <i class="fa-solid fa-star" style="color: #B2B2B2"></i>
                                                    @endif
                                                @endfor
                                                <!-- <span class="topText4">({{ $item->rating_count }})</span> -->
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Price Filter -->
                                <div class="px-5 pb-4">
                                    <div class="d-flex flex-column">
                                        <p class="topText3 mb-1">Price Filter</p>
                                        <div class="textline2"></div>
                                    </div>
                                    <div class="form-check pt-3">
                                        <input class="form-check-input" type="checkbox" name="price_range[]"
                                            value="Rs0-Rs1000" id="price_0_1000"
                                            {{ in_array('Rs0-Rs1000', request()->get('price_range', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label categoryLable" for="price_0_1000">
                                            Under Rs 1000
                                        </label>
                                    </div>
                                    <div class="form-check pt-3">
                                        <input class="form-check-input" type="checkbox" name="price_range[]"
                                            value="Rs1000-Rs2000" id="price_1000_2000"
                                            {{ in_array('Rs1000-Rs2000', request()->get('price_range', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label categoryLable" for="price_1000_2000">
                                            Rs 1000 - Rs 2000
                                        </label>
                                    </div>
                                    <div class="form-check pt-3">
                                        <input class="form-check-input" type="checkbox" name="price_range[]"
                                            value="Rs2000-Rs5000" id="price_2000_5000"
                                            {{ in_array('Rs2000-Rs5000', request()->get('price_range', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label categoryLable" for="price_2000_5000">
                                            Rs 2000 - Rs 5000
                                        </label>
                                    </div>
                                    <div class="form-check pt-3">
                                        <input class="form-check-input" type="checkbox" name="price_range[]"
                                            value="Rs5000-Rs10000" id="price_5000_10000"
                                            {{ in_array('Rs5000-Rs10000', request()->get('price_range', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label categoryLable" for="price_5000_10000">
                                            Rs 5000 - Rs 10000
                                        </label>
                                    </div>
                                    <div class="form-check pt-3">
                                        <input class="form-check-input" type="checkbox" name="price_range[]"
                                            value="Rs10000-Rs100000" id="price_10000_100000"
                                            {{ in_array('Rs10000-Rs100000', request()->get('price_range', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label categoryLable" for="price_10000_100000">
                                            Above Rs 10000
                                        </label>
                                    </div>
                                </div>

                                <div class="px-5 sticky-bottom d-flex justify-content-center align-items-center mb-3">
                                    <!-- Buttons for Large Screen -->
                                    <button type="button" class="btn btn-button clear-button"
                                        id="clearButtonLarge">Clear
                                        All</button>
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-button apply-button"
                                        id="applyButtonLarge">Apply</button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-12 col-lg-7 col-12">
                        <div class="row pb-4">

                            @foreach ($deals as $product)
                                <div
                                    class="col-md-4 col-lg-6 col-xl-4 col-12 mb-3 d-flex justify-content-center align-items-stretch">
                                    <a href="{{ url('/deal/' . $product->id) }}" style="text-decoration: none;"
                                        onclick="clickCount('{{ $product->id }}')">
                                        <div class="card sub_topCard h-100 d-flex flex-column">
                                            <div style="min-height: 50px">
                                                <span class="badge trending-badge">{{ $product->label }}</span>
                                                <img src="{{ asset($product->image_url1) }}"
                                                    class="img-fluid card-img-top1" alt="card_image" />
                                            </div>
                                            <div
                                                class="card-body card_section flex-grow-1 d-flex flex-column justify-content-between">
                                                <div>
                                                    <div class="mt-3 d-flex align-items-center justify-content-between">
                                                        <h5 class="card-title ps-3">{{ $product->name }}</h5>
                                                        <span class="badge mx-3 p-0 trending-bookmark-badge" onclick="event.stopPropagation();">
                                                            @if ($bookmarkedProducts->contains($product->id))
                                                                <button type="button"
                                                                    class="bookmark-button remove-bookmark"
                                                                    data-deal-id="{{ $product->id }}"
                                                                    style="border: none; background: none;">
                                                                    <p style="height:fit-content;cursor:pointer"
                                                                        class="p-1 px-2">
                                                                        <i class="fa-solid fa-bookmark bookmark-icon"
                                                                            style="color: #ff0060;"></i>
                                                                    </p>
                                                                </button>
                                                            @else
                                                                <button type="button"
                                                                    class="bookmark-button add-bookmark"
                                                                    data-deal-id="{{ $product->id }}"
                                                                    style="border: none; background: none;">
                                                                    <p style="height:fit-content;cursor:pointer"
                                                                        class="p-1 px-2">
                                                                        <i class="fa-regular fa-bookmark bookmark-icon"
                                                                            style="color: #ff0060;"></i>
                                                                    </p>
                                                                </button>
                                                            @endif

                                                        </span>
                                                    </div>
                                                    <span class="px-3">
                                                        @php
                                                            $fullStars = floor($product->shop->shop_ratings);
                                                            $hasHalfStar =
                                                                $product->shop->shop_ratings - $fullStars >= 0.5;
                                                            $remaining =
                                                                5 - ($hasHalfStar ? $fullStars + 1 : $fullStars);
                                                        @endphp
                                                        @for ($i = 0; $i < $fullStars; $i++)
                                                            <i class="fa-solid fa-star" style="color: #ffc200;"></i>
                                                        @endfor
                                                        @if ($hasHalfStar)
                                                            <i class="fa-solid fa-star-half-stroke"
                                                                style="color: #ffc200;"></i>
                                                        @endif
                                                        @for ($i = 0; $i < $remaining; $i++)
                                                            <i class="fa-regular fa-star" style="color: #ffc200;"></i>
                                                        @endfor
                                                    </span>
                                                    <p class="px-3 fw-normal truncated-description">
                                                        {{ $product->description }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <div class="card-divider"></div>
                                                    <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                                        style="color: #ff0060">
                                                        <span
                                                            class="discounted-price">{{ $product->discounted_price }}</span>
                                                        @if (!empty($product->coupon_code))
                                                            <span id="mySpan" class="mx-3 px-2 couponBadge"
                                                                onclick="copySpanText(this, event)"
                                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                title="Click to Copy" style="position:relative;">

                                                                {{ $product->coupon_code }}

                                                                <!-- Tooltip container -->
                                                                <span class="tooltip-text"
                                                                    style="visibility: hidden; background-color: black; color: #fff; text-align: center;
                                                    border-radius: 6px; padding: 5px; position: absolute; z-index: 1;
                                                    bottom: 125%; left: 50%; margin-left: -60px;">
                                                                    Copied!
                                                                </span>
                                                            </span>
                                                        @endif
                                                    </p>
                                                    <div class="card-divider"></div>
                                                    <div class="ps-3">
                                                        <p>Regular Price</p>
                                                        <p><s class="original-price">{{ $product->original_price }}</s>
                                                        </p>
                                                    </div>
                                                    <div class="card-divider"></div>
                                                    <p class="ps-3 fw-medium"
                                                        style="color: #ff0060; font-weight: 400 !important;">
                                                        <i
                                                            class="fa-solid fa-location-dot"></i>&nbsp;{{ $product->shop->city }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <div class="col-md-12 col-lg-2 col-12 mb-3">
                        <div class="card p-2 d-flex justify-content-center align-items-center"
                            style="border-radius: 10px;border: none">
                            <div class="row justify-content-center">
                                <div class="col-6 p-1">
                                    <div class="card h-100 prodFilterCard"
                                        style="border-color: #1878f3; border-radius: 10px;">
                                        <a href="https://www.facebook.com/profile.php?id=61566743978973" target="_blank"
                                            style="text-decoration: none;">
                                            <div class="p-2 qr-code">
                                                <img src="{{ asset('assets/images/home/facebook_qr_code.webp') }}"
                                                    alt="Facebook QR" class="img-fluid">
                                            </div>
                                            <div class="icon-facebook icon-text">
                                                <i class="fa-brands fa-facebook-f"
                                                    style="color: #1878f3; padding: 3px 5px;"></i>
                                                <span style="white-space: nowrap;">Follow Us</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-6 p-1">
                                    <div class="card h-100 prodFilterCard"
                                        style="border-color: #cc2366; border-radius: 10px;">
                                        <a href="https://www.instagram.com/dealsmachi/" target="_blank"
                                            style="text-decoration: none;">
                                            <div class="p-2 qr-code">
                                                <img src="{{ asset('assets/images/home/instagram_qr_code.webp') }}"
                                                    alt="Instagram QR" class="img-fluid">
                                            </div>
                                            <div class="icon-instagram icon-text">
                                                <i class="fa-brands fa-instagram"
                                                    style="color: #cc2366; padding: 3px 4px;"></i>
                                                <span style="white-space: nowrap;">Follow Us</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-6 p-1">
                                    <div class="card h-100 prodFilterCard"
                                        style="border-color: #FF0000; border-radius: 10px;">
                                        <a href="https://www.youtube.com/channel/UCAyH2wQ2srJE8WqvII8JNrQ" target="_blank"
                                            style="text-decoration: none;">
                                            <div class="p-2 qr-code">
                                                <img src="{{ asset('assets/images/home/youtube_qr_code.webp') }}"
                                                    alt="YouTube QR" class="img-fluid">
                                            </div>
                                            <div class="icon-youtube icon-text">
                                                <i class="fa-brands fa-youtube" style="color: #FF0000;"></i>
                                                <span>Subscribe</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-6 p-1">
                                    <div class="card h-100 prodFilterCard"
                                        style="border-color: #25D366; border-radius: 10px;">
                                        <a href="https://chat.whatsapp.com/Ef23qGMU1d6EXYpRvomaLx" target="_blank"
                                            style="text-decoration: none;">
                                            <div class="p-2 qr-code">
                                                <img src="{{ asset('assets/images/home/whatsapp_qr_code.webp') }}"
                                                    alt="WhatsApp QR" class="img-fluid">
                                            </div>
                                            <div class="icon-whatsapp icon-text">
                                                <i class="fa-brands fa-whatsapp"
                                                    style="color: #25D366; padding: 3px 4px;"></i>
                                                <span>Join Us</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-6 p-1">
                                    <div class="card h-100 prodFilterCard"
                                        style="border-color: #28a8e9; border-radius: 10px;">
                                        <a href="https://t.me/+UTD7rFen3K4zNDFl" target="_blank"
                                            style="text-decoration: none;">
                                            <div class="p-2 qr-code">
                                                <img src="{{ asset('assets/images/home/telegram_qr_code.webp') }}"
                                                    alt="Telegram QR" class="img-fluid">
                                            </div>
                                            <div class="icon-telegram icon-text">
                                                <i class="fa-brands fa-telegram" style="color: #28a8e9;"></i>
                                                <span>Follow Us</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters Section for Empty Product Show -->
                @else
                    @php
                        $currentUrl = request()->path();
                    @endphp

                    @if ($currentUrl === 'hotpick/nearby')
                        <div class="col-12 d-flex justify-content-center align-items-center text-center"
                            style="min-height: 60vh;">
                            <div class="col-12 col-md-12" style="color: rgb(128, 128, 128);">
                                <h4>Oh no! It looks like there are no nearby deals available at your location right now.
                                </h4>
                                <p style="margin-top: 10px; font-size: 14px;">Don't worry, we're always adding more
                                    exciting offers just for you.<br><br> Why not explore other categories or try searching
                                    in a
                                    different area?</p>
                                <a href="{{ url('/') }}" style="color: #007BFF; text-decoration: underline;">Back to
                                    Home</a>
                            </div>
                        </div>
                    @else
                        <div class="col-12 d-flex justify-content-center align-items-center text-center"
                            style="min-height: 60vh;">
                            <div class="col-12 col-md-12" style="color: rgb(128, 128, 128);">
                                <h2>Something Awesome is Coming Soon!</h2>
                            </div>
                        </div>
                    @endif

                @endif
            </div>
        </form>
    </div>

    <script>
        document.getElementById('clearButton').addEventListener('click', function() {
            document.getElementById('filterForm').reset();
            window.location.href = "{{ route('search') }}";
        });

        document.getElementById('clearButtonLarge').addEventListener('click', function() {
            document.getElementById('filterForm').reset();
            window.location.href =
                "{{ !empty($category) ? route('subcategorybasedproducts', ['slug' => $category->slug]) : route('search') }}";
        });
    </script>

@endsection
