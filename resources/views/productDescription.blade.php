@extends('layouts.master')

@section('content')
<section class="categoryIcons">
    <div class="container my-5">
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-8 col-12 mb-3">
                <div class="card productViewCard mb-4 px-md-4 px-3 py-3">
                    <div class="row">
                        <div class="col-lg-7 col-12 mb-3 d-flex flex-column justify-content-center">
                            <h4>{{ $product->name }}</h4>
                            <div>
                                <div class="d-flex">
                                    @php
                                    $currentDay = strtolower(\Carbon\Carbon::now()->format('l'));
                                    @endphp

                                    <p class="info pe-3">
                                        <i class="fa-solid fa-circle" style="color: #fdbf46; font-size: 8px;"></i>
                                        @if (
                                        !empty($product->shop->hour['daily_timing'][$currentDay]['closing']))
                                        Open until {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing'][$currentDay]['closing'])->format('h:i A') }}
                                        @else
                                        Closed Today
                                        @endif
                                    </p>
                                    <p class="info"><i class="fa-solid fa-circle"
                                            style="color: #fdbf46; font-size: 8px;"></i>&nbsp;&nbsp;6 Years in Business
                                    </p>
                                </div>
                                <div class="d-flex">
                                    <p>602 <span style="font-size: 11px; color: #5C5C5C;">people</span></p>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <p>{{ $product->shop->shop_ratings }} <span>&nbsp;<i class="fa-solid fa-star fa-xs"
                                                style="color: #fdbf46; cursor: pointer"></i></span></p>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-2 pe-0">
                                                <i class="fa-solid fa-location-dot fa-lg" style="color: #ff0060;"></i>
                                            </div>
                                            <div class="col-10 ps-2" style="font-size: 12px; color: #5C5C5C;">
                                                {{ $product->shop->street }}, {{ $product->shop->street2 }},
                                                {{ $product->shop->city }}-{{ $product->shop->zip_code }},
                                                {{ $product->shop->state }}, {{ $product->shop->country }}.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-2 pe-0">
                                                <i class="fa-solid fa-user-group fa-lg" style="color: #ff0060;"></i>
                                            </div>
                                            <div class="col-10 ps-4" style="font-size: 12px; color: #5C5C5C;">
                                                24 people recently enquired
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3 gap-2">
                                <button class="btn mb-2 showNumBtn"
                                    onclick="window.location.href='tel:{{ $product->shop->mobile }}'">
                                    <i class="fa-solid fa-phone fa-xs"></i>&nbsp;&nbsp;Show Number
                                </button>
                                <button class="btn mb-2 sendEnqBtn" data-bs-toggle="modal"
                                    data-bs-target="#enquiryModal">
                                    Send Enquiry
                                </button>
                                <button class="btn mb-2 sendEnqBtn"
                                    onclick="window.open('https://wa.me/{{ $product->shop->mobile }}?text=Hello! I visited your website.', '_blank')">
                                    <i class="fa-brands fa-whatsapp"></i>&nbsp;&nbsp;Chat
                                </button>
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
                                    @if (count($product->bookmark) === 0)
                                    <form action="{{ route('bookmarks.add', $product->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="bookmark-icon"
                                            style="border: none; background: none;">
                                            <p style="height:fit-content;cursor:pointer" class="p-1 px-2"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Bookmark">
                                                <i class="fa-regular fa-bookmark bookmark-icon"
                                                    style="color: #ff0060;"></i>
                                            </p>
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('bookmarks.remove', $product->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bookmark-icon"
                                            style="border: none; background: none;">
                                            <p style="height:fit-content;cursor:pointer" class="p-1 px-2"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Bookmark">
                                                <i class="fa-solid fa-bookmark bookmark-icon"
                                                    style="color: #ff0060;"></i>
                                            </p>
                                        </button>
                                    </form>
                                    @endif

                                    &nbsp;&nbsp;&nbsp;
                                    <p id="shareButton" style="height: fit-content; cursor:pointer" class="p-1 px-2"
                                        onclick="copyLinkToClipboard()" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Share">
                                        <i class="fa-solid fa-share-nodes" style="color: #ff0060;"></i>
                                    </p>

                                </div>
                            </div>
                            <img src="{{ asset($product->image_url1) }}" alt="Adverstiment" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="productViewTabs">
                    <!-- Tabs navigation -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active mb-1" id="overview-tab" data-bs-toggle="tab"
                                data-bs-target="#overview" type="button" role="tab" aria-controls="overview"
                                aria-selected="true">Overview</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link  mb-1" id="quickinfo-tab" data-bs-toggle="tab"
                                data-bs-target="#quickinfo" type="button" role="tab" aria-controls="quickinfo"
                                aria-selected="false">Quick Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link  mb-1" id="reviews-tab" data-bs-toggle="tab"
                                data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews"
                                aria-selected="false">Reviews</button>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content rounded" id="myTabContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane sub-tabs fade show active" id="overview" role="tabpanel"
                            aria-labelledby="overview-tab">
                            <p class="quickInfo">{{ $product->description }}</p>

                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img src="{{ asset($product->image_url2) }}" alt="Product View Image 1"
                                        class="img-fluid pb-3">
                                </div>
                                <div class="col-md-4 text-center">
                                    <img src="{{ asset($product->image_url3) }}" alt="Product View Image 2"
                                        class="img-fluid pb-3">
                                </div>
                                <div class="col-md-4 text-center">
                                    <img src="{{ asset($product->image_url4) }}" alt="Product View Image 3"
                                        class="img-fluid pb-3">
                                </div>
                            </div>
                        </div>

                        <!-- Quick Info Tab -->
                        <div class="tab-pane sub-tabs fade" id="quickinfo" role="tabpanel"
                            aria-labelledby="quickinfo-tab">
                            <div class="row">
                                <div class="col-12 col-md-4 pe-5">
                                    <p class="fw-medium info-head">Business Summary</p>
                                    <p class="quickInfo">{{ $product->shop->description }}</p>
                                </div>
                                <div class="col-12 col-md-4">
                                    <p class="fw-medium info-head">Year of Establishment</p>
                                    <p class="quickInfo">2018</p>
                                </div>
                                <div class="col-12 col-md-4">
                                    <p class="fw-medium info-head">Timings</p>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="quickInfo">Monday</p>
                                        </div>
                                        <div class="col-8">
                                            <p class="quickInfo">
                                                @if (
                                                !empty($product->shop->hour['daily_timing']['monday']['opening']) &&
                                                !empty($product->shop->hour['daily_timing']['monday']['closing']))
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['monday']['opening'])->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['monday']['closing'])->format('h:i A') }}
                                                @else
                                                Holiday
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="quickInfo">Tuesday</p>
                                        </div>
                                        <div class="col-8">
                                            <p class="quickInfo">
                                                @if (
                                                !empty($product->shop->hour['daily_timing']['tuesday']['opening']) &&
                                                !empty($product->shop->hour['daily_timing']['tuesday']['closing']))
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['tuesday']['opening'])->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['tuesday']['closing'])->format('h:i A') }}
                                                @else
                                                Holiday
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="quickInfo">Wednesday</p>
                                        </div>
                                        <div class="col-8">
                                            <p class="quickInfo">
                                                @if (
                                                !empty($product->shop->hour['daily_timing']['wednesday']['opening']) &&
                                                !empty($product->shop->hour['daily_timing']['wednesday']['closing']))
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['wednesday']['opening'])->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['wednesday']['closing'])->format('h:i A') }}
                                                @else
                                                Holiday
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="quickInfo">Thursday</p>
                                        </div>
                                        <div class="col-8">
                                            <p class="quickInfo">
                                                @if (
                                                !empty($product->shop->hour['daily_timing']['thursday']['opening']) &&
                                                !empty($product->shop->hour['daily_timing']['thursday']['closing']))
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['thursday']['opening'])->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['thursday']['closing'])->format('h:i A') }}
                                                @else
                                                Holiday
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="quickInfo">Friday</p>
                                        </div>
                                        <div class="col-8">
                                            <p class="quickInfo">
                                                @if (
                                                !empty($product->shop->hour['daily_timing']['friday']['opening']) &&
                                                !empty($product->shop->hour['daily_timing']['friday']['closing']))
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['friday']['opening'])->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['friday']['closing'])->format('h:i A') }}
                                                @else
                                                Holiday
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="quickInfo">Saturday</p>
                                        </div>
                                        <div class="col-8">
                                            <p class="quickInfo">
                                                @if (
                                                !empty($product->shop->hour['daily_timing']['saturday']['opening']) &&
                                                !empty($product->shop->hour['daily_timing']['saturday']['closing']))
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['saturday']['opening'])->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['saturday']['closing'])->format('h:i A') }}
                                                @else
                                                Holiday
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p class="quickInfo">Sunday</p>
                                        </div>
                                        <div class="col-8">
                                            <p class="quickInfo">
                                                @if (
                                                !empty($product->shop->hour['daily_timing']['sunday']['opening']) &&
                                                !empty($product->shop->hour['daily_timing']['sunday']['closing']))
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['sunday']['opening'])->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing']['sunday']['closing'])->format('h:i A') }}
                                                @else
                                                Holiday
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane sub-tabs fade" id="reviews" role="tabpanel"
                            aria-labelledby="reviews-tab">
                            <div class="d-flex align-items-center mb-4" style="border-bottom: 1.5px solid #ff0060;">
                                <h2 class="ratingNum">4.6</h2>
                                <p class="px-1 mb-0"><i class="fa-solid fa-star fa-lg" style="color: #fdbf46;"></i>
                                </p>
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
                                                <p class="fw-medium mb-0">Alex</p>
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
                                                <p class="fw-medium mb-0">Daniel</p>
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
                                                <p class="fw-medium mb-0">Ivan</p>
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
                                                <p class="fw-medium mb-0">Kenneth</p>
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
                            <a href="javascript:void(0);" id="read-more-btn" style="color: #ff0060;">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Column -->
            <div class="col-md-4 col-12 mb-3">
                <div class="mx-2">
                    <div class="row productViewCard mb-3">
                        <div class="card p-3" style="border-radius: 5px; border-color: #ff0060;">
                            <div class="container">
                                <div class="d-flex">
                                    <p class="fw-medium">Contact:</p>&nbsp;&nbsp;
                                    <p class="fw-light">
                                        <a href="tel:{{ $product->shop->mobile }}"
                                            class="text-decoration-none text-black">
                                            {{ $product->shop->mobile }}
                                        </a>
                                    </p>
                                </div>
                                <hr>
                                <div class="d-flex">
                                    <p class="fw-medium">Address:</p>&nbsp;&nbsp;
                                    <p class="fw-light">
                                        {{ $product->shop->street }}, {{ $product->shop->street2 }},
                                        {{ $product->shop->city }}-{{ $product->shop->zip_code }},
                                        {{ $product->shop->state }}, {{ $product->shop->country }}.
                                    </p>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 col-lg-6 col-12">
                                        <a href="{{ $product->shop->map_url }}" class="contactCard" target="_blank">
                                            <i class="fa fa-location" style="color: #000;"></i>&nbsp;&nbsp;
                                            Get Directions
                                        </a>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-12">
                                        <a href="mailto:{{ $product->shop->email }}" class="contactCard">
                                            <i class="fa-regular fa-envelope" style="color: #000;"></i>&nbsp;&nbsp;
                                            Send Enquiry by mail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="position: sticky; top: 110px;">
                        <div class="row mb-4">
                            <div class="card p-4" style="border-color:#ff0060;">
                                <h6 class="fw-medium mb-3">Get the list of best <span
                                        style="color:#ff0060;">”{{ $product->name }}”</span></h6>
                                <form id="enquiryFormMain">
                                    <div>
                                        <label class="form-label">Name*</label>
                                        <input type="text" class="form-control" name="name" id="name" />
                                    </div>
                                    <div>
                                        <label class="form-label mt-3">Phone Number*</label>
                                        <input type="text" class="form-control" name="phone" id="phone" />
                                    </div>
                                    <div>
                                        <label class="form-label mt-3">Email(Optional)</label>
                                        <input type="email" class="form-control" name="email" id="email" />
                                    </div>
                                    <button type="submit" class="btn btn-danger mt-3 enquiryBtn">Send
                                        Enquiry</button>
                                </form>
                            </div>
                        </div>
                        <div class="text-center">
                            <img src="{{ asset('assets/images/product_view/adverstiment.webp') }}"
                                alt="Advertisement" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Send Enquiry Modal -->
    <div class="modal fade" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enquiryModalLabel">Get the list of best <span
                            style="color:#ff0060;">”{{ $product->name }}”</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="enquiryFormModal">
                        <div>
                            <label class="form-label">Name*</label>
                            <input type="text" class="form-control" name="name" id="name" />
                        </div>
                        <div>
                            <label class="form-label mt-3">Phone Number*</label>
                            <input type="text" class="form-control" name="phone" id="phone" />
                        </div>
                        <div>
                            <label class="form-label mt-3">Email(Optional)</label>
                            <input type="email" class="form-control" name="email" id="email" />
                        </div>
                        <button type="submit" class="btn btn-danger mt-3 enquiryBtn">Send Enquiry</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modalContent">
                <div class="modal-header d-flex align-items-center justify-content-between errorHeading shadow-none mb-2"
                    style="background: green; color: white;">
                    <h5 class="modal-title" id="errorModalLabel" style="font-size: 28px;">
                        There was an error
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pt-0">
                    <!-- Error Icon -->
                    <i class="fa-solid fa-circle-exclamation my-4"
                        style="color: rgb(255, 80, 80); font-size: 70px;"></i>
                    <p class="mb-0 errorMagnetSubHeading fw-bold pb-4">
                        We are sorry!
                    </p>
                    <p class="mb-0 errorMagnetSubHeading text-muted fw-bold pb-2">
                        You can reach us on
                    </p>
                    <p class="mb-0 errorMobile pb-4">+65 8894 1306</p>

                    <!-- Contact Us Button -->
                    <a href="/" class="btn successMagnetButton">
                        <i class="fas fa-arrow m-0-left"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade text-center" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modalContent">
                <div class="modal-header d-flex align-content-center justify-content-between"
                    style="background: green; color: white;">
                    <h5 class="modal-title" id="successModalLabel" style="font-size: 28px;">
                        That's all required!
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: white;"></button>
                </div>
                <div class="modal-body pt-0">
                    <!-- Success Icon -->
                    <i class="fa-solid fa-circle-check my-5" style="color: #28a745; font-size: 80px;"></i>
                    <p class="mb-0 SuccessMagnetSubHeading pb-4">
                        We will get back to you soon!
                    </p>

                    <!-- Back to Home Button -->
                    <a href="/">
                        <button class="btn successMagnetButton">Back to Home</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection