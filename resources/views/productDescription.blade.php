@extends('layouts.master')

@section('content')
    @php
        $reviewData = [
            [
                'productId' => '1',
                'reviews' => [
                    [
                        'reviewerName' => 'Tan Wei Ming',
                        'review' =>
                            'Thank you Trucklah for the wonderful job. I am very much happy with your service. I got track updates regularly and everything went well!',
                        'rating' => 4.3,
                        'reviewDate' => '2024-09-10',
                        'advertisement' => 'assets/images/product_view/trucklah_add.png',
                    ],
                    [
                        'reviewerName' => 'Lim Xin Wei',
                        'review' =>
                            'Thank you Trucklah for your prompt service. We were in difficulty with lack of space in our apartment. Thankfully, Trucklah managed it well and were on time and budget friendly.',
                        'rating' => 5,
                        'reviewDate' => '2024-09-12',
                        'advertisement' => 'assets/images/product_view/trucklah_add.png',
                    ],
                ],
            ],
            [
                'productId' => '3',
                'reviews' => [
                    [
                        'reviewerName' => 'Goh Meih Lin',
                        'review' =>
                            'I did an item move last week with Trucklah. The service was excellent. I recommend their service, they are professional in approach.',
                        'rating' => 4,
                        'reviewDate' => '2024-09-15',
                        'advertisement' => 'assets/images/product_view/trucklah_add.png',
                    ],
                    [
                        'reviewerName' => 'Wong Kok Seng',
                        'review' =>
                            'Trucklah helped us to move our office last week. Their service was really appreciable. The best thing I noted is that they were professional in approach and they did really well to relocate our office. I am really thankful for their effort!',
                        'rating' => 5,
                        'reviewDate' => '2024-09-17',
                        'advertisement' => 'assets/images/product_view/trucklah_add.png',
                    ],
                ],
            ],
            [
                'productId' => '4',
                'reviews' => [
                    [
                        'reviewerName' => 'Liu Zhang',
                        'review' =>
                            'We were in a hurry and there was no one we trust. Thanks to Trucklah, for helping us on time like a friend. Their delivery experts handled everything without errors.',
                        'rating' => 5,
                        'reviewDate' => '2024-09-20',
                        'advertisement' => 'assets/images/product_view/trucklah_add.png',
                    ],
                    [
                        'reviewerName' => 'Zhang Wei',
                        'review' =>
                            'As a business, we never rely much on third party services. But Trucklah changed us. We are full partnership with Trucklah now. Complete peace of mind.',
                        'rating' => 5,
                        'reviewDate' => '2024-09-22',
                        'advertisement' => 'assets/images/product_view/trucklah_add.png',
                    ],
                ],
            ],
            [
                'productId' => '6',
                'reviews' => [
                    [
                        'reviewerName' => 'Wang Fang',
                        'review' =>
                            'E-commerce is tricky. But if you have a logistics partner like Trucklah, life is more easy than we expect. Timely delivery, on schedule, all the time.',
                        'rating' => 4,
                        'reviewDate' => '2024-09-25',
                        'advertisement' => 'assets/images/product_view/trucklah_add.png',
                    ],
                    [
                        'reviewerName' => 'Li Na',
                        'review' =>
                            'We never thought moving would be this easy. Not until we had our move scheduled with Trucklah. App booking, online payment, everything went well.',
                        'rating' => 5,
                        'reviewDate' => '2024-09-27',
                        'advertisement' => 'assets/images/product_view/trucklah_add.png',
                    ],
                ],
            ],
            [
                'productId' => '11',
                'reviews' => [
                    [
                        'reviewerName' => 'Chen Ming',
                        'review' =>
                            'Space issues were too much for us. Until Trucklah cleared it for us without any headaches. For any moving work, I recommend Trucklah.',
                        'rating' => 4,
                        'reviewDate' => '2024-09-30',
                        'advertisement' => 'assets/images/product_view/trucklah_add.png',
                    ],
                    [
                        'reviewerName' => 'Xiao Mei',
                        'review' =>
                            'Moving is not easy in Singapore. But with Trucklah by your side, nothing is impossible. Faster, reliable and safe delivery from Trucklah has changed the scene.',
                        'rating' => 5,
                        'reviewDate' => '2024-10-02',
                        'advertisement' => 'assets/images/product_view/trucklah_add.png',
                    ],
                ],
            ],
        ];
    @endphp

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
                                            @if (!empty($product->shop->hour['daily_timing'][$currentDay]['closing']))
                                                Open until
                                                {{ \Carbon\Carbon::createFromFormat('H:i', $product->shop->hour['daily_timing'][$currentDay]['closing'])->format('h:i A') }}
                                            @else
                                                Closed Today
                                            @endif
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
                                                    <a href="{{ $product->shop->map_url }}" class="text-muted"
                                                        target="_blank" style="text-decoration: none;">
                                                        {{ $product->shop->street }}, {{ $product->shop->street2 }},
                                                        {{ $product->shop->city }}-{{ $product->shop->zip_code }},
                                                        {{ $product->shop->country }}.
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-2 pe-0">
                                                    <i class="fa-solid fa-phone fa-lg" style="color: #ff0060;"></i>
                                                </div>
                                                <div class="col-10 ps-2" style="font-size: 18px; color: #5C5C5C;">
                                                    <a href="{{ $product->shop->mobile }}"
                                                        class="text-decoration-none text-black"
                                                        data-full-number="{{ $product->shop->mobile }}"
                                                        data-masked-number="{{ substr($product->shop->mobile, 0, 4) . str_repeat('x', strlen($product->shop->mobile) - 4) }}"
                                                        onclick="toggleNumber(event)">
                                                        {{ substr($product->shop->mobile, 0, 4) . str_repeat('x', strlen($product->shop->mobile) - 4) }}
                                                    </a>
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
                                    <button class="btn mb-2 sendEnqBtn" disabled
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
                                        @if ($bookmarkedProducts->contains($product->id))
                                            <button type="button" class="bookmark-button remove-bookmark"
                                                data-deal-id="{{ $product->id }}" style="border: none; background: none;">
                                                <p style="height:fit-content;cursor:pointer" class="p-1 px-2">
                                                    <i class="fa-solid fa-bookmark bookmark-icon"
                                                        style="color: #ff0060;"></i>
                                                </p>
                                            </button>
                                        @else
                                            <button type="button" class="bookmark-button add-bookmark"
                                                data-deal-id="{{ $product->id }}" style="border: none; background: none;">
                                                <p style="height:fit-content;cursor:pointer" class="p-1 px-2">
                                                    <i class="fa-regular fa-bookmark bookmark-icon"
                                                        style="color: #ff0060;"></i>
                                                </p>
                                            </button>
                                        @endif
                                        &nbsp;&nbsp;&nbsp;
                                        <p id="shareButton"
                                            style="height: fit-content; cursor: pointer; position: relative;"
                                            class="p-1 px-2"
                                            onclick="copyLinkToClipboard(this, event, '{{ $product->id }}')"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Share">
                                            <i class="fa-solid fa-share-nodes" style="color: #ff0060;"></i>

                                            <!-- Tooltip container to show below the share icon -->
                                            <span class="tooltip-text"
                                                style="visibility: hidden; background-color: black; color: #fff;
                                                   text-align: center; border-radius: 6px; padding: 5px;
                                                   position: absolute; z-index: 1; top: 125%; left: 50%;
                                                   transform: translateX(-50%); font-size: 12px; white-space: nowrap;">
                                                Link Copied!
                                            </span>
                                        </p>

                                    </div>
                                </div>
                                <img src="{{ asset($product->image_url1) }}" alt="Adverstiment" class="img-fluid">
                            </div>
                        </div>
                        <div class="d-flex flex-wrap social-link-container">
                            <a href="#" id="" class="me-2" title="" rel="">
                                <i class="fa-regular fa-thumbs-up"></i>
                                <p>Like</p>
                            </a>

                            <div id="social-links">
                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=https://sgitjobs.com/dealslah/deal/46"
                                            class="social-button" id="" title="" rel=""><span
                                                class="fab fa-facebook-square" aria-hidden="true"></span></a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/intent/tweet?text=House+Moving&amp;url=https://sgitjobs.com/dealslah/deal/46"
                                            class="social-button" id="" title="" rel=""><span
                                                class="fab fa-twitter" aria-hidden="true"></span></a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/sharing/share-offsite?mini=true&amp;url=https://sgitjobs.com/dealslah/deal/46&amp;title=House+Moving&amp;summary="
                                            class="social-button" id="" title="" rel=""><span
                                                class="fab fa-linkedin" aria-hidden="true"></span></a>
                                    </li>
                                    <li>
                                        <a target="_blank"
                                            href="https://wa.me/?text=https://sgitjobs.com/dealslah/deal/46"
                                            class="social-button" id="" title="" rel=""><span
                                                class="fab fa-whatsapp" aria-hidden="true"></span></a>
                                    </li>
                                </ul>
                            </div>

                            <a href="#" id="" title="" rel="">
                                <i class="fa-brands fa-instagram"></i>
                                <p>Instagram</p>
                            </a>
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
                                    <div class="col-12 col-md-6 pe-5">
                                        <p class="fw-medium info-head">Business Summary</p>
                                        <p class="quickInfo">{{ $product->shop->description }}</p>
                                    </div>

                                    <div class="col-12 col-md-6">
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
                                @php
                                    $hasReviews = false;
                                    $totalRating = 0;
                                    $totalReviews = 0;
                                @endphp

                                @foreach ($reviewData as $reviewSet)
                                    @if ($reviewSet['productId'] == $product->id)
                                        @foreach ($reviewSet['reviews'] as $review)
                                            @php
                                                $hasReviews = true;
                                                $totalRating += $review['rating'];
                                                $totalReviews++;
                                            @endphp
                                        @endforeach
                                    @endif
                                @endforeach

                                @if ($hasReviews)
                                    @php
                                        $averageRating = $totalReviews ? round($totalRating / $totalReviews, 1) : 0;
                                    @endphp

                                    <div class="d-flex align-items-center mb-4"
                                        style="border-bottom: 1.5px solid #ff0060;">
                                        <h2 class="ratingNum">{{ $averageRating }}</h2>
                                        <p class="px-1 mb-0"><i class="fa-solid fa-star fa-lg"
                                                style="color: #fdbf46;"></i></p>
                                        <div>
                                            <p class="mb-0">{{ $totalReviews }} Ratings</p>
                                            {{-- <p class="quickInfo">Jd rating index based on {{ $totalReviews }} ratings across the web</p> --}}
                                        </div>
                                    </div>

                                    <div class="row">
                                        @foreach ($reviewData as $reviewSet)
                                            @if ($reviewSet['productId'] == $product->id)
                                                @foreach ($reviewSet['reviews'] as $index => $review)
                                                    <div class="col-md-12 col-lg-6 mb-3 review-card"
                                                        data-review-index="{{ $index + 1 }}">
                                                        <div class="card h-100 p-3">
                                                            <div class="row">
                                                                <div class="col-2">
                                                                    <img src="{{ asset('assets/images/product_view/profile.webp') }}"
                                                                        alt="Profile {{ $index + 1 }}"
                                                                        class="img-fluid">
                                                                </div>
                                                                <div class="col-10">
                                                                    <p class="fw-medium mb-0">
                                                                        {{ $review['reviewerName'] }}
                                                                    </p>
                                                                    <div class="d-flex justify-content-between">
                                                                        <p class="mb-0">
                                                                            @php
                                                                                $fullStars = floor($review['rating']); // Calculate full stars
                                                                                $hasHalfStar =
                                                                                    $review['rating'] - $fullStars >=
                                                                                    0.5; // Check if there's a half star
                                                                            @endphp
                                                                            @for ($i = 1; $i <= 6; $i++)
                                                                                @if ($i <= $fullStars)
                                                                                    <i class="fa-solid fa-star fa-2xs"
                                                                                        style="color: #fdbf46;"></i>
                                                                                @elseif ($i == $fullStars + 1 && $hasHalfStar)
                                                                                    <i class="fa-solid fa-star-half-stroke fa-2xs"
                                                                                        style="color: #fdbf46;"></i>
                                                                                @else
                                                                                    <i class="fa-solid fa-star-regular fa-2xs"
                                                                                        style="color: #fdbf46;"></i>
                                                                                @endif
                                                                            @endfor
                                                                        </p>
                                                                        <p class="quickInfo">{{ $review['reviewDate'] }}
                                                                        </p>
                                                                    </div>
                                                                    <p class="quickInfo">{{ $review['review'] }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="d-flex align-items-center justify-content-center"
                                        style="min-height: 50vh">
                                        <p>No reviews available for this product.</p>
                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="col-md-4 col-12 mb-3">
                    <div class="mx-2">
                        <div class="row productViewCard mb-3">
                            <div class="card w-100 social-media-card p-0">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class=" text-center w-100 my-2 py-3 ms-2"
                                            style="cursor: pointer; background-color: #627aad;">
                                            <a href="https://www.facebook.com/profile.php?id=61567112492283"
                                                target="_blank" style="text-decoration:none;"><i
                                                    class="fa-brands social-Icon fa-facebook-f"></i>
                                                <p class="mb-0 count-Text">1k</p>
                                                <p class="mb-0 count-Text2">Fans</p>
                                            </a>
                                        </span>

                                        <span class=" text-center w-100 my-2  py-3 ms-2"
                                            style="cursor: pointer;background-color: #FF0000;">
                                            <a href="https://www.youtube.com/channel/UCAyH2wQ2srJE8WqvII8JNrQ"
                                                target="_blank" style="text-decoration:none;"><i
                                                    class="fa-brands social-Icon fa-youtube"></i>
                                                <p class="mb-0 count-Text">1.2k</p>
                                                <p class="mb-0 count-Text2">Subscribes</p>
                                            </a>
                                        </span>

                                        <span class=" text-center w-100 my-2 py-3 mx-2"
                                            style="cursor: pointer;background: linear-gradient(
                                                                    45deg,
                                                                    #f09433,
                                                                    #e6683c,
                                                                    #dc2743,
                                                                    #cc2366,
                                                                    #bc1888
                                                                );">
                                            <a href="https://www.instagram.com/dealslah/" style="text-decoration:none;">
                                                <i class="fa-brands social-Icon fa-instagram"></i>
                                                <p class="mb-0 count-Text">1.4k</p>
                                                <p class="mb-0 count-Text2">Followers</p>
                                            </a>
                                        </span>

                                    </div>
                                    <a href="#" style="text-decoration:none;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <img src="{{ asset('assets/images/home/Whatsapp-Banner.webp') }}"
                                                alt="Whatsapp Banner" class="img-fluid px-2 pb-2">
                                        </div>
                                    </a>
                                </div>
                            </div>

                        </div>
                        <div style="position: sticky; top: 110px;">
                            <div class="row mb-4">
                                <div class="card p-4" style="border-color:#ff0060;">
                                    <h6 class="fw-medium mb-3">Get the list of best <span
                                            style="color:#ff0060;">”{{ $product->name }}”</span></h6>
                                    <form id="enquiryFormMain" data-deal-id="{{ $product->id }}"
                                        onsubmit="event.preventDefault(); submitEnquiryForm(this);">
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
                            @php
                                $productHasReviews = false;
                            @endphp

                            @foreach ($reviewData as $reviewSet)
                                @if ($reviewSet['productId'] == $product->id)
                                    @php
                                        $productHasReviews = true;
                                        $firstReviewWithAd = collect($reviewSet['reviews'])->first(function ($review) {
                                            return isset($review['advertisement']) && !empty($review['advertisement']);
                                        });
                                    @endphp
                                    @if ($firstReviewWithAd)
                                        <div class="text-center">
                                            <img src="{{ asset($firstReviewWithAd['advertisement']) }}"
                                                alt="Advertisement" class="img-fluid">
                                        </div>
                                        {{-- @else
                                    <div class="text-center">
                                        <img src="{{ asset('assets/images/product_view/advertisement.webp') }}" alt="Default Advertisement" class="img-fluid">
                    </div> --}}
                                    @endif
                                @endif
                            @endforeach

                            @if (!$productHasReviews)
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/product_view/Dealslah poster Ad plain SVG.svg') }}"
                                        alt="Fallback Advertisement" class="img-fluid">
                                </div>
                            @endif

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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="enquiryFormModal" data-deal-id="{{ $product->id }}"
                                onsubmit="event.preventDefault(); submitEnquiryForm(this);">
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
            <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content modalContent">
                        <div class="modal-header d-flex align-items-center justify-content-between errorHeading shadow-none mb-2"
                            style="background: green; color: white;">
                            <h5 class="modal-title" id="errorModalLabel" style="font-size: 28px;">
                                There was an error
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
