@extends('layouts.master')

@section('content')
    @if (session('status'))
        <div class="alert alert-dismissible fade show" role="alert"
            style="position: fixed; top: 70px; right: 40px; z-index: 1050; background:#00e888; color:#fff">
            {!! nl2br(e(session('status'))) !!}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-dismissible fade show" role="alert"
            style="position: fixed; top: 70px; right: 40px; z-index: 1050; background:#ff0060; color:#fff">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-dismissible fade show" role="alert"
            style="position: fixed; top: 70px; right: 40px; z-index: 1050; background:#ff0060; color:#fff">
            {{ session('error') }}
            <button type="button" class="btn-close btn-sm" style="" data-bs-dismiss="alert"
                aria-label="Close"></button>
        </div>
    @endif
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
                'productId' => '7',
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
            [
                'productId' => '50',
                'reviews' => [
                    [
                        'reviewerName' => 'Tan Ah Kow',
                        'review' =>
                            'I recently used Trucklah’s new partnership service for moving items with DHL. The process was seamless, and my belongings arrived on time and in great condition. Highly recommended!',
                        'rating' => 4.5,
                        'reviewDate' => '2024-10-10',
                        'advertisement' => 'assets/images/product_view/trucklah_dhl_moving_ad.png', // Example image path
                    ],
                    [
                        'reviewerName' => 'Lim Siang',
                        'review' =>
                            'Trucklah made my move easy with their new service. They coordinated everything with DHL, ensuring that my items were handled carefully and delivered promptly.',
                        'rating' => 5,
                        'reviewDate' => '2024-10-12',
                        'advertisement' => 'assets/images/product_view/trucklah_dhl_moving_ad.png', // Example image path
                    ],
                ],
            ],
            [
                'productId' => '48',
                'reviews' => [
                    [
                        'reviewerName' => 'Lee Wei Jie',
                        'review' =>
                            'Using Trucklah for air cargo was a great experience. They efficiently handled my shipment anywhere I needed. Everything arrived safely and on schedule!',
                        'rating' => 4.8,
                        'reviewDate' => '2024-10-15',
                        'advertisement' => 'assets/images/product_view/trucklah_air_cargo_ad.png', // Example image path
                    ],
                    [
                        'reviewerName' => 'Chong Lin',
                        'review' =>
                            'I was impressed with the air cargo service provided by Trucklah. The team ensured quick processing and excellent support throughout the shipment.',
                        'rating' => 5,
                        'reviewDate' => '2024-10-17',
                        'advertisement' => 'assets/images/product_view/trucklah_air_cargo_ad.png', // Example image path
                    ],
                ],
            ],
        ];
    @endphp
    <section class="categoryIcons container-fluid p-0">

        <div class="productContainer">

            {{-- social QR links  --}}
            <div class="">
                <button type="button" class="social_links" onclick="toggleDropdown()">Social</button>
                <div id="social_dropdown" class="dropdown_items" style="display: none">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-center m-0">Follow Us On</p>
                        <button type="button" class="btn border-0" onclick="toggleDropdown()"><i
                                class="fa-light fa-xmark"></i>
                        </button>
                    </div>
                    <div class="card p-2 d-flex justify-content-center align-items-start"
                        style="border-radius: 10px;border: none">
                        <div class="row justify-content-center">
                            <div class="col-6 p-1">
                                <div class="card h-100 prodFilterCard"
                                    style="border-color: #1878f3; border-radius: 10px;white-space: nowrap;">
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
                                    style="border-color: #cc2366; border-radius: 10px;white-space: nowrap;">
                                    <a href="https://www.instagram.com/dealsmachi/" target="_blank"
                                        style="text-decoration: none;">
                                        <div class="p-2 qr-code">
                                            <img src="{{ asset('assets/images/home/instagram_qr_code.webp') }}"
                                                alt="Instagram QR" class="img-fluid">
                                        </div>
                                        <div class="icon-instagram icon-text">
                                            <i class="fa-brands fa-instagram" style="color: #cc2366; padding: 3px 4px;"></i>
                                            <span style="white-space: nowrap;">Follow Us</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-6 p-1">
                                <div class="card h-100 prodFilterCard"
                                    style="border-color: #FF0000; border-radius: 10px;  white-space: nowrap;">
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
                                    style="border-color: #25D366; border-radius: 10px;  white-space: nowrap;">
                                    <a href="https://chat.whatsapp.com/Ef23qGMU1d6EXYpRvomaLx" target="_blank"
                                        style="text-decoration: none;">
                                        <div class="p-2 qr-code">
                                            <img src="{{ asset('assets/images/home/whatsapp_qr_code.webp') }}"
                                                alt="WhatsApp QR" class="img-fluid">
                                        </div>
                                        <div class="icon-whatsapp icon-text">
                                            <i class="fa-brands fa-whatsapp" style="color: #25D366; padding: 3px 4px;"></i>
                                            <span>Join Us</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="col-6 p-1">
                                <div class="card h-100 prodFilterCard"
                                    style="border-color: #28a8e9; border-radius: 10px;  white-space: nowrap;">
                                    <a href="https://t.me/+UTD7rFen3K4zNDFl" target="_blank" style="text-decoration: none;">
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
            </div>


            {{-- Breadcrumb navigate  --}}
            <div class="breadcrumb-nav container mt-3 ps-3">
                <ol class="breadcrumb" style="list-style:none; padding: 0; margin:0;">
                    <li class="breadcrumb-item"><a class="breadcrumb_link" href="/"
                            style="list-style:none; text-decoration:none">Home</a></li>
                    &nbsp;
                    <span className="breadcrumb-separator" style="color: #A19F9F"> &gt; </span>&nbsp;&nbsp;
                    <li class="breadcrumb-item"><a class="breadcrumb_link" href="#"
                            style="list-style:none; text-decoration:none">Deal</a>
                    </li>&nbsp;
                    <span className="breadcrumb-separator" style="color: #A19F9F"> &gt; </span>&nbsp;&nbsp;
                    <li class="breadcrumb-item active"><span class="breadcrumb_link"> {{ $product->name }}</span></li>
                </ol>
            </div>

            {{-- main content  --}}
            <div class="container p-0 mt-4">

                <div class="row m-0 p-2">
                    <div class="col-md-6 column">
                        <div class="row m-0" style="position:sticky; top:100px">
                            <div class="col-md-2 col-3 pe-md-0">
                                <div class="text-center arrow-button mb-2">
                                    <button type="button" style="border:none; background-color: #eaeaea"
                                        id="scrollUpBtn" title="Scroll up" aria-label="Scroll up" onclick="scrollUp()">
                                        <i class="fa fa-angle-up"></i>
                                    </button>
                                 </div>
                                 <div class="thumbnail" id="thumbnailContainer">
                                    @foreach ($product->productMedia->sortBy('order') as $media)
                                        @if ($media->type == 'image')
                                            <div>
                                                <img class="thumb-img" data-zoom="{{ asset($media->path) }}"
                                                     src="{{ asset($media->path) }}" alt="Image" />
                                            </div>
                                        @elseif ($media->type == 'video')
                                            @php
                                                // Extract YouTube video ID
                                                $videoId = preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))([\w-]+)/', $media->path, $matches)
                                                    ? $matches[1]
                                                    : $media->path;
                                            @endphp
                                            <div>
                                                <img src="https://img.youtube.com/vi/{{ $videoId }}/0.jpg"
                                                     class="thumbnail img-fluid"
                                                     style="height: 60px; cursor: pointer; object-fit: cover;"
                                                     data-bs-toggle="modal" data-bs-target="#videoModal"
                                                     onclick="updateVideoModal('{{ $videoId }}')">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="text-center arrow-button mt-2">
                                    <button type="button" style="border:none; background-color: #eaeaea"
                                            id="scrollDownBtn" title="Scroll down" aria-label="Scroll down"
                                            onclick="scrollDown()">
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-10 col-9 p-lg-0">
                                <div class="thumbnail-container">
                                    @php
                                        // Get the first image
                                        $firstImage = $product->productMedia->sortBy('order')->firstWhere('type', 'image');
                                    @endphp
                                    <img id="main-image" alt="Product Image" class="drift-demo-trigger image-fluid"
                                         data-zoom="{{ $firstImage ? asset($firstImage->path) : asset('assets/images/home/noImage.webp') }}"
                                         src="{{ $firstImage ? asset($firstImage->path) : asset('assets/images/home/noImage.webp') }}" />
                                </div>
                            </div>
                            <div class="col-md-2 col-3"></div>
                            <div class="col-md-10 col-9">
                                <div class="add_cart_btns">
                                    <form action="{{ route('cart.add', ['slug' => $product->slug]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="cart_btn media_fonts_conent text-nowrap">
                                            <i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;Add to Cart
                                        </button>&nbsp;&nbsp;
                                    </form>

                                    <form action="{{ route('cart.add', ['slug' => $product->slug]) }}" method="POST">
                                        @csrf
                                        @if ($product->deal_type == 1)
                                            <input type="hidden" name="saveoption" id="saveoption" value="buy now">
                                            <button type="submit" class="Buy_btn media_fonts_conent text-nowrap">
                                                <i class="fa-thin fa-bag-shopping"></i>&nbsp;&nbsp;Buy Now
                                            </button>
                                        @elseif ($product->deal_type == 2)
                                            <input type="hidden" name="saveoption" id="saveoption" value="buy now">
                                            <button type="submit" class="Buy_btn media_fonts_conent text-nowrap">
                                                <i class="fa-thin fa-bag-shopping"></i>&nbsp;&nbsp;Book Now
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ps-4 mt-3 space_ctrl column">
                        <span class="details" style="position:fixed; top:180px"></span>
                        <div>
                            <div class="fst_rw d-flex justify-content-between align-items-center">
                                <h2 style="color: #000000" class="media_fonts_headings text-nowrap">
                                    {{ $product->name }}
                                    <span>
                                        @if ($bookmarkedProducts->contains($product->id))
                                            <button type="button" class="bookmark-button remove-bookmark"
                                                data-deal-id="{{ $product->id }}"
                                                style="border: none; background: none; font-size:24px; padding: 20px 0 0 30px">
                                                <p style="height: fit-content; cursor: pointer;" class="p-1 px-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Bookmark">
                                                    <i class="fa-solid fa-bookmark bookmark-icon"
                                                        style="color: #ff0060;"></i>
                                                </p>
                                            </button>
                                        @else
                                            <button type="button" class="bookmark-button add-bookmark"
                                                data-deal-id="{{ $product->id }}"
                                                style="border: none; background: none; font-size:24px; padding: 20px 0 0 30px">
                                                <p style="height: fit-content; cursor: pointer;" class="p-1 px-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Bookmark">
                                                    <i class="fa-regular fa-bookmark bookmark-icon"
                                                        style="color: #ff0060;"></i>
                                                </p>
                                            </button>
                                        @endif
                                    </span>
                                </h2>

                                <div class="share">
                                    <button type="button" id="share_btn" style="height: fit-content; cursor: pointer;"
                                        class="p-1  text-nowrap media_fonts_conent"
                                        onclick="copyLinkToClipboard(this, event, '{{ $product->id }}')"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Share">
                                        <span>&nbsp; &nbsp;Share &nbsp; &nbsp;<i class="fa-regular fa-share"></i></span>

                                        <!-- Tooltip container to show below the share icon -->
                                        <span class="tooltip-text">
                                            Link Copied!
                                        </span>
                                    </button>
                                </div>


                            </div>
                            <div class="rating mt-2">
                                <span>Rating :</span><span class="stars">
                                    <span>
                                        <i class="fa-solid fa-star" style="color: #fdbf46;"></i>
                                        <i class="fa-solid fa-star" style="color: #fdbf46;"></i>
                                        <i class="fa-solid fa-star" style="color: #fdbf46;"></i>
                                        <i class="fa-solid fa-star" style="color: #fdbf46;"></i>
                                        <i class="fa-solid fa-star" style="color: #fdbf46;"></i>
                                    </span>
                                </span>
                            </div>

                            <div class="price-section mt-4">
                                <h3>
                                    <span class="current-price">₹{{ number_format($product->discounted_price, 2) }}</span>
                                    <span class="original-price">₹{{ number_format($product->original_price, 2) }}</span>
                                    <span class="discount-price">₹{{ number_format($product->discount_percentage, 2) }}%
                                        off</span>
                                    @if (!empty($product->coupon_code))
                                        <span id="mySpan" class="deal-badge" style="cursor: pointer"
                                            onclick="copySpanText(this, event)" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Click to Copy" style="position:relative;">

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
                                </h3>
                            </div>


                            {{-- description  --}}
                            <div class="description-section mt-4">
                                @if ($product->deal_type == 1)
                                    <h5>Product Description : </h5>
                                @elseif ($product->deal_type == 2)
                                    <h5 class="media_fonts_headings">Service Description : </h5>
                                @endif
                                <p><span class="text-muted media_fonts_conent">{{ $product->description }}</span></p>
                                <div class="mt-2"
                                    style="border: 1px solid #c1bcbc40;border-radius:5px; width: fit-content">
                                    <div class="row m-0">
                                        <p class="text-center p-1"
                                            style="border-bottom: 1px solid #76737340; font-size:12px;">
                                            Share on Social Media</p>

                                        <div class="d-flex  justify-content-center mt-2 social-link-container"
                                            style="z-index:0" data-product-id="{{ $product->id }}">
                                            {!! $shareButtons !!}

                                            <a href="#" onclick="shareOnInstagram()" id="" title=""
                                                rel="">
                                                <i class="fa-brands fa-instagram"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- seller Info  --}}
                            <div class="seller-information mt-4">
                                <h5 class="media_fonts_headings">Seller Information :</h5>
                                <div class="card_offers">
                                    <div class="d-flex justify-content-end align-items-end text-center my-2">
                                        <a href="#" class="modal_links" data-bs-toggle="modal"
                                            data-bs-target="#aboutModal">
                                            <span>About</span>
                                        </a>&nbsp;&nbsp;
                                        <a href="#" class="modal_links" data-bs-toggle="modal"
                                            data-bs-target="#workingHoursModal">
                                            <span>Working Hours</span>
                                        </a>
                                    </div>
                                    <div class="row m-0 p-3 space_ctrl">
                                        <div class="col-12 space_ctrl">
                                            <div class="row m-0 pb-3">
                                                <div class="col-md-6 col-lg-6 col-12 space_ctrl">
                                                    <div class="row m-0">
                                                        <div class="col-2 pe-0">
                                                            <i class="fa-solid fa-location-dot fa-lg"
                                                                style="color: #ff0060;"></i>
                                                        </div>
                                                        @if ($product->shop->address)
                                                            <div class="col-10 ps-2"
                                                                style="font-size: 12px; color: #5C5C5C;">
                                                                <a href="{{ $product->shop->map_url }}"
                                                                    class="text-muted" target="_blank"
                                                                    style="text-decoration: none;">
                                                                    {{ $product->shop->address }}
                                                                </a>
                                                            </div>
                                                        @else
                                                            No Address Found
                                                        @endif

                                                    </div>
                                                </div>
                                                <div class="md-6 col-lg-6 col-12 space_ctrl">
                                                    @if ($product->shop->mobile)
                                                        <div class="row m-0">
                                                            <div class="col-2 pe-0">
                                                                <i class="fa-solid fa-phone fa-lg"
                                                                    style="color: #ff0060;"></i>
                                                            </div>
                                                            <div class="col-10 ps-2"
                                                                style="font-size: 18px; color: #5C5C5C;">
                                                                <a href="{{ $product->shop->mobile }}"
                                                                    class="text-decoration-none text-black"
                                                                    data-full-number="{{ $product->shop->mobile }}"
                                                                    data-masked-number="{{ substr($product->shop->mobile, 0, 4) . str_repeat('x', strlen($product->shop->mobile) - 4) }}"
                                                                    onclick="toggleNumber(event)">
                                                                    {{ substr($product->shop->mobile, 0, 4) . str_repeat('x', strlen($product->shop->mobile) - 4) }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12"><button type="button"
                                                        class="btn mb-2 sendEnqBtn text-nowrap"
                                                        onclick="window.location.href='tel:{{ $product->shop->mobile }}'">
                                                        <i class="fa-solid fa-phone fa-xs"></i>&nbsp;&nbsp;Call
                                                    </button>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <button type="button" class="btn mb-2 sendEnqBtn text-nowrap"
                                                        data-bs-toggle="modal" data-bs-target="#enquiryModal">
                                                        Send Enquiry
                                                    </button>&nbsp;&nbsp;&nbsp;&nbsp;

                                                    @if ($product->shop->mobile)
                                                        <button type="button" class="btn mb-2 sendEnqBtn text-nowrap"
                                                            onclick="sendEnquiry('{{ $product->id }}', '{{ $product->shop->mobile }}', '{{ $product->name }}', '{{ $product->description }}')">
                                                            <i class="fa-brands fa-whatsapp"></i>&nbsp;&nbsp;Whatsapp
                                                            Enquiry
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn mb-2 sendEnqBtn" disabled
                                                            onclick="window.open('https://wa.me/65{{ $product->shop->mobile }}?text=Hello! I visited your website.', '_blank')">
                                                            <i class="fa-brands fa-whatsapp"></i>&nbsp;&nbsp;Enquiry
                                                        </button>
                                                    @endif
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- specification  --}}
                            <div class="specification-section mt-4">
                                <h5>Specifications :</h5>
                                <div class="card_offers">
                                    <p class="p-2 media_fonts_conent">
                                        {{ $product->description }}<span>{{ $product->description }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-0 mt-3 px-3">
                    <div class="col-12 px-2">

                    </div>
                </div>

                {{-- owl carousel  --}}
                <div class="row m-0 mt-3 px-3">
    <div class="col-12 px-2">
        @php
            // Filter and sort product media for videos only
            $videos = $product->productMedia->where('type', 'video')->sortBy('order');
        @endphp

        @if ($videos->count() > 0)
            <div class="p-3 position-relative" style="border-color: #ff0060;">
                <div class="owl-carousel carousel_content owl-theme image-slider1 d-flex gap-3 overflow-hidden carousel-container"
                    id="carousel_slider"
                    style="scroll-snap-type: x mandatory; overflow-x: auto; white-space: nowrap;">

                    @foreach ($videos as $video)
                        @php
                            // Extract YouTube video ID if it's a YouTube URL
                            $videoId = preg_match(
                                '/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))([\w-]+)/',
                                $video->path,
                                $matches
                            ) ? $matches[1] : $video->path;
                        @endphp

                        <img src="https://img.youtube.com/vi/{{ $videoId }}/0.jpg"
                            alt="Video Thumbnail {{ $video->order }}" class="img-fluid item"
                            data-bs-toggle="modal" data-bs-target="#videoModal"
                            onclick="updateVideoModal('{{ $videoId }}')">
                    @endforeach
                </div>
            </div>
        @else
            <p>No videos available.</p>
        @endif
    </div>
</div>


                {{-- review section   --}}
                <div class="review-section mt-4 px-2">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="media_fonts_headings">Reviews</h5>
                        <button disabled type="button" class="review_btn media_fonts_conent">Add Review</button>
                    </div>
                    <div class="card_offers review_section p-3">
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

                            <!-- Rating Summary -->
                            <div class="rating-summary mb-4">
                                <div class="d-flex align-items-center">
                                    <h5>Total score :</h5> &nbsp;&nbsp;<h2 class="average-rating me-2"
                                        style="color:#40d128">
                                        {{ $averageRating }}
                                        <span><i class="fa-solid fa-star fa-lg"
                                                style="color: #fdbf46; font-size:12px"></i></span>
                                        <span><i class="fa-solid fa-star fa-lg"
                                                style="color: #fdbf46; font-size:12px"></i></span>
                                        <span><i class="fa-solid fa-star fa-lg"
                                                style="color: #fdbf46; font-size:12px"></i></span>
                                        <span><i class="fa-solid fa-star fa-lg"
                                                style="color: #fdbf46; font-size:12px"></i></span>
                                        <span><i class="fa-solid fa-star fa-lg"
                                                style="color: #fdbf46; font-size:12px"></i></span>
                                    </h2>
                                </div>
                                <p class="ms-2">No. of reviews : &nbsp;&nbsp;<span
                                        style="color: #c0b9b9;">{{ $totalReviews }}
                                        Reviews</span></p>
                            </div>

                            <!-- Review Cards -->
                            <div class="review-cards mt-4">
                                @foreach ($reviewData as $reviewSet)
                                    @if ($reviewSet['productId'] == $product->id)
                                        @foreach ($reviewSet['reviews'] as $index => $review)
                                            <div class="review-card mb-4">
                                                <hr>
                                                <div class="p-2">
                                                    <div class="row m-0">
                                                        <!-- Review Content -->
                                                        <div class="col-12">
                                                            <div class="col-md-6">
                                                                <div
                                                                    class="row d-flex justify-content-between text-center">
                                                                    <div class="col-md-6 col-12">
                                                                        <h5 class="text-start">
                                                                            {{ $review['reviewerName'] }}
                                                                        </h5>
                                                                    </div>

                                                                    <div class="col-md-6 col-12 d-flex">
                                                                        <div>Rating : &nbsp; <span
                                                                                style="color:#40d128;font-size:1.4rem; font-weight:400">{{ $review['rating'] }}</span>
                                                                            &nbsp;</div>
                                                                        <div class="rating mt-1">
                                                                            @php
                                                                                $fullStars = floor($review['rating']);
                                                                                $hasHalfStar =
                                                                                    $review['rating'] - $fullStars >=
                                                                                    0.5;
                                                                            @endphp
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($i <= $fullStars)
                                                                                    <i class="fa-solid fa-star"
                                                                                        style="color: #fdbf46; font-size:12px"></i>
                                                                                @elseif ($i == $fullStars + 1 && $hasHalfStar)
                                                                                    <i class="fa-solid fa-star-half-stroke"
                                                                                        style="color: #fdbf46; font-size:12px"></i>
                                                                                @else
                                                                                    <i class="fa-regular fa-star"
                                                                                        style="color: #ccc; font-size:12px"></i>
                                                                                @endif
                                                                            @endfor
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="review-text mt-3"
                                                                style="font-size: small;color:#1d1d1d">
                                                                {{ $review['review'] }}
                                                            </p>
                                                        </div>

                                                        <div class="d-flex gap-5 text-center mt-4">
                                                            <small class="reviewer-name" style="color: #c3c2c2;">
                                                                {{ $review['reviewerName'] }}</small>
                                                            <small class="review-date"
                                                                style="color: #c3c2c2;">{{ $review['reviewDate'] }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="no-reviews d-flex justify-content-center align-items-center"
                                style="min-height: 200px;">
                                <p class="text-muted">No reviews available for this product.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>


            {{-- about and working hours modal  --}}
            <div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="aboutModalLabel">{{ $product->shop->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Add your content here -->
                            <p class="quickInfo">{{ $product->shop->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add the modal for "Working Hours" -->
            <div class="modal fade" id="workingHoursModal" tabindex="-1" aria-labelledby="workingHoursModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="workingHoursModalLabel">Timings</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex justify-content-around text-center">
                            <div class="col-12">
                                <div class="row m-0">
                                    <div class="col-4 pe-3 text-end">
                                        <p class="quickInfo text-nowrap">Monday</p>
                                    </div>
                                    <div class="col-8 ps-5 text-start">
                                        <p class="quickInfo text-nowrap">:&nbsp;&nbsp;&nbsp;
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
                                <div class="row m-0">
                                    <div class="col-4 pe-3 text-end">
                                        <p class="quickInfo text-nowrap">Tuesday</p>
                                    </div>
                                    <div class="col-8 ps-5 text-start">
                                        <p class="quickInfo text-nowrap">:&nbsp;&nbsp;&nbsp;
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
                                <div class="row m-0">
                                    <div class="col-4 pe-3 text-end">
                                        <p class="quickInfo text-nowrap">Wednesday</p>
                                    </div>
                                    <div class="col-8 ps-5 text-start">
                                        <p class="quickInfo text-nowrap">:&nbsp;&nbsp;&nbsp;
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
                                <div class="row m-0">
                                    <div class="col-4 pe-3 text-end">
                                        <p class="quickInfo text-nowrap">Thursday</p>
                                    </div>
                                    <div class="col-8 ps-5 text-start">
                                        <p class="quickInfo text-nowrap">:&nbsp;&nbsp;&nbsp;
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
                                <div class="row m-0">
                                    <div class="col-4 pe-3 text-end">
                                        <p class="quickInfo text-nowrap">Friday</p>
                                    </div>
                                    <div class="col-8 ps-5 text-start">
                                        <p class="quickInfo text-nowrap">:&nbsp;&nbsp;&nbsp;
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
                                <div class="row m-0">
                                    <div class="col-4 pe-3 text-end">
                                        <p class="quickInfo text-nowrap">Saturday</p>
                                    </div>
                                    <div class="col-8 ps-5 text-start">
                                        <p class="quickInfo text-nowrap">:&nbsp;&nbsp;&nbsp;
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
                                <div class="row m-0">
                                    <div class="col-4 pe-3 text-end">
                                        <p class="quickInfo text-nowrap">Sunday</p>
                                    </div>
                                    <div class="col-8 ps-5 text-start">
                                        <p class="quickInfo text-nowrap">:&nbsp;&nbsp;&nbsp;
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
                </div>
            </div>



            <!-- Modal -->
            <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content p-0 border-none">
                        <button type="button"
                            class="btn-close btn-close-sm position-absolute end-0 m-2 text-center d-flex align-items-center"
                            data-bs-dismiss="modal" aria-label="Close"
                            style="z-index: 1050; box-shadow: none; background:#fff !important;">
                            <i class="fa-light fa-xmark" style="font-size: 22px;"></i>
                        </button>
                        <div class="modal-body p-0">
                            <div class="ratio ratio-16x9">
                                <iframe id="videoFrame" src="" title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </section>
    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-0 border-none">
                <button type="button" class="btn-close btn-close-sm position-absolute end-0 m-2" data-bs-dismiss="modal"
                    aria-label="Close" style="z-index: 1050; font-size: 12px; box-shadow: none;">
                </button>
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe id="videoFrame" src="" title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Send Enquiry Modal -->
    <div class="modal fade" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enquiryModalLabel">Get the Best Price for <span
                            style="color:#ff0060;">”{{ $product->name }}”</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <i class="fa-solid fa-circle-exclamation my-4" style="color: rgb(255, 80, 80); font-size: 70px;"></i>
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
                        <button type="button" class="btn successMagnetButton">Back to Home</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const socialDropdown = document.getElementById("social_dropdown");
            socialDropdown.style.display = socialDropdown.style.display === "none" ? "block" : "none";

            if (socialDropdown.style.display === "block") {
                document.addEventListener("click", closeDropdownOnClickOutside);
            } else {
                document.removeEventListener("click", closeDropdownOnClickOutside);
            }
        }

        function closeDropdownOnClickOutside(event) {
            const socialDropdown = document.getElementById("social_dropdown");
            const socialButton = document.querySelector(".social_links");

            if (!socialDropdown.contains(event.target) && !socialButton.contains(event.target)) {
                socialDropdown.style.display = "none";
                document.removeEventListener("click", closeDropdownOnClickOutside);
            }
        }

        function navigateToRoute() {
            window.location.href = '/summary';
        }

        function submitServiceForm(route, method, saveoption = null) {
            const form = document.getElementById('service_form');

            if (saveoption) {
                let hiddenInput = document.getElementById('saveOptionInput');
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'saveoption';
                    hiddenInput.id = 'saveOptionInput';
                    form.appendChild(hiddenInput);
                }
                hiddenInput.value = saveoption;
            }

            if (form.checkValidity()) {
                form.action = route;
                form.method = method;
                form.submit();
            } else {
                form.reportValidity();
            }
        }

        // Zoom functionality
        const mainImage = document.querySelector("#main-image");
        const detailsContainer = document.querySelector(".details");
        const thumbnails = document.querySelectorAll(".thumb-img");
        const thumbnailContainer = document.querySelector("#thumbnailContainer");
        const scrollUpBtn = document.querySelector("#scrollUpBtn");
        const scrollDownBtn = document.querySelector("#scrollDownBtn");

        detailsContainer.style.pointerEvents = "none";

        mainImage.addEventListener("mouseenter", () => {
            detailsContainer.style.pointerEvents = "auto";
        });


        mainImage.addEventListener("mouseleave", () => {
            detailsContainer.style.pointerEvents = "none"; 
        });

        let driftInstance = new Drift(mainImage, {
            paneContainer: detailsContainer,
            inlinePane: 769,
            inlineOffsetY: -85,
            containInline: true,
            hoverBoundingBox: true,
        });

        function checkScrollLimits() {
            scrollUpBtn.disabled = thumbnailContainer.scrollTop === 0;
            scrollDownBtn.disabled =
                thumbnailContainer.scrollTop + thumbnailContainer.clientHeight >=
                thumbnailContainer.scrollHeight;
        }

        function scrollUp() {
            thumbnailContainer.scrollBy({
                top: -80,
                behavior: "smooth",
            });
            setTimeout(checkScrollLimits, 300);
        }

        // Scroll Down Function
        function scrollDown() {
            thumbnailContainer.scrollBy({
                top: 80,
                behavior: "smooth",
            });
            setTimeout(checkScrollLimits, 300);
        }

        checkScrollLimits();

        thumbnails.forEach((thumbnail) => {
            thumbnail.addEventListener("click", (e) => {
                thumbnails.forEach((thumb) => thumb.classList.remove("active"));
                e.target.classList.add("active");

                mainImage.src = e.target.src;
                mainImage.setAttribute("data-zoom", e.target.dataset.zoom);

                driftInstance.destroy();
                driftInstance = new Drift(mainImage, {
                    paneContainer: document.querySelector(".details"),
                    inlinePane: 769,
                    inlineOffsetY: -85,
                    containInline: true,
                    hoverBoundingBox: true,
                });
            });
        });

        function updateVideoModal(videoId) {
            const iframe = document.getElementById('videoFrame');
            iframe.src = `https://www.youtube.com/embed/${videoId}`;
        }

        document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
            const iframe = document.getElementById('videoFrame');
            iframe.src = '';
        });
    </script>

@endsection
