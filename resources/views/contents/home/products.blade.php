@php
    function formatIndianCurrency($num)
    {
        $num = intval($num);
        $lastThree = substr($num, -3);
        $rest = substr($num, 0, -3);
        if ($rest != '') {
            $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest) . ',';
        }
        return '₹' . $rest . $lastThree;
    }

@endphp

<div class="container">
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-stretch justify-content-center">
                <a href="{{ url('/deal/' . $product->id) }}" style="text-decoration: none;"
                    onclick="clickCount('{{ $product->id }}')">
                    <div class="card sub_topCard h-100 d-flex flex-column">
                        <div style="min-height: 50px">
                            @if ($treandingdeals->contains('deal_id', $product->id))
                                <span class="badge trending-badge">TRENDING</span>
                            @elseif($populardeals->contains('deal_id', $product->id))
                                <span class="badge trending-badge">POPULAR</span>
                            @elseif($earlybirddeals->contains('id', $product->id))
                                <span class="badge trending-badge">EARLY BIRD</span>
                            @elseif($lastchancedeals->contains('id', $product->id))
                                <span class="badge trending-badge">LAST CHANCE</span>
                            @elseif($limitedtimedeals->contains('id', $product->id))
                                <span class="badge trending-badge">LIMITED TIME</span>
                            @endif
                            @php
                                $image = isset($product->productMedia)
                                    ? $product->productMedia->where('order', 1)->where('type', 'image')->first()
                                    : null;
                            @endphp
                            <img src="{{ $image ? asset($image->resize_path) : asset('assets/images/home/noImage.webp') }}"
                                class="img-fluid card-img-top1" alt="{{ $product->name }}" />
                        </div>

                        <div class="card-body card_section flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                    <h4 class="card-title ps-3 h3-styling">{{ $product->name }}</h4>
                                    <span class="badge mx-3 p-0 trending-bookmark-badge"
                                        onclick="event.stopPropagation();">
                                        @if ($bookmarkedProducts->contains($product->id))
                                            <button type="button" class="bookmark-button remove-bookmark"
                                                data-deal-id="{{ $product->id }}"
                                                style="border: none; background: none;">
                                                <p style="height:fit-content;cursor:pointer" class="p-1 px-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Favourite">
                                                    <i class="fa-solid fa-heart bookmark-icon"
                                                        style="color: #ff0060;"></i>
                                                </p>
                                            </button>
                                        @else
                                            <button type="button" class="bookmark-button add-bookmark"
                                                data-deal-id="{{ $product->id }}"
                                                style="border: none; background: none;">
                                                <p style="height:fit-content;cursor:pointer" class="p-1 px-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Favourite">
                                                    <i class="fa-regular fa-heart bookmark-icon"
                                                        style="color: #ff0060;"></i>
                                                </p>
                                            </button>
                                        @endif
                                    </span>
                                </div>
                                <span class="px-3">
                                    @php
                                        $fullStars = floor($product->shop->shop_ratings);
                                        $hasHalfStar = $product->shop->shop_ratings - $fullStars >= 0.5;
                                        $remaining = 5 - ($hasHalfStar ? $fullStars + 1 : $fullStars);
                                    @endphp
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fa-solid fa-star" style="color: #ffc200;"></i>
                                    @endfor
                                    @if ($hasHalfStar)
                                        <i class="fa-solid fa-star-half-stroke" style="color: #ffc200;"></i>
                                    @endif
                                    @for ($i = 0; $i < $remaining; $i++)
                                        <i class="fa-regular fa-star" style="color: #ffc200;"></i>
                                    @endfor
                                </span>

                                <p class="px-3 fw-normal truncated-description">{{ $product->description }}</p>
                                <div class="d-flex justify-content-end">
                                    @if (!empty($product->special_price) && $product->special_price)
                                        <div class="px-2">
                                            <button type="button" style="height: fit-content; cursor: pointer;"
                                                class="p-1 text-nowrap special-price">
                                                <span>&nbsp;<i class="fa-solid fa-stopwatch-20"></i>&nbsp;
                                                    &nbsp;Special Price
                                                    &nbsp; &nbsp;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                    style="color: #ff0060">
                                    <span>{{ formatIndianCurrency($product->discounted_price) }}</span>
                                    <span class="me-2">
                                        @if (empty($product->stock) || $product->stock == 0)
                                            <span class="product-out-of-stock">
                                                Out of Stock
                                            </span>
                                        @else
                                            <span class="product-stock-badge">
                                                In Stock
                                            </span>
                                        @endif
                                    </span>
                                    {{-- @if (!empty($product->coupon_code))
                                        <span id="mySpan" class="mx-3 px-2 couponBadge"
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
                                    @endif --}}
                                </p>
                                <div class="card-divider"></div>
                                <div class="ps-3 d-flex justify-content-between align-items-center pe-2">
                                    <div>
                                        <p>Regular Price</p>
                                        @if ($product->deal_type == 2)
                                            <span class="fw-light" style="color: #22cb00ab; !important">Standard
                                                Rates</span>
                                        @else
                                            <span><s>{{ formatIndianCurrency($product->original_price) }}</s></span>
                                        @endif
                                    </div>
                                    <div>
                                        <button class="btn card_cart add-to-cart-btn" data-slug="{{ $product->slug }}"
                                            data-qty="1" onclick="event.stopPropagation();">
                                            Add to Cart
                                        </button>&nbsp;&nbsp;
                                    </div>
                                </div>
                                <div class="card-divider"></div>
                                <p class="ps-3 fw-medium" style="color: #ff0060; font-weight: 400 !important;">
                                    <i class="fa-solid fa-location-dot"></i>&nbsp;{{ $product->shop->city }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
