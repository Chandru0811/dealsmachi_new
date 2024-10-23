<div class="container">
    <h5 class="pt-0 pb-2">Products</h5>
    <div class="row pb-4">
        @foreach ($products as $product)
        <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-stretch justify-content-center">
            <a href="{{ url('/deal/' . $product->id) }}" style="text-decoration: none;" onclick="clickCount('{{ $product->id }}')">
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
                        <img src="{{ asset($product->image_url1) }}" class="img-fluid card-img-top1"
                            alt="{{ $product->name }}" />
                    </div>
                    <div class="card-body card_section flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                <h5 class="card-title ps-3">{{ $product->name }}</h5>
                                <span class="badge mx-3 p-0 trending-bookmark-badge">
                                    @if ($bookmarkedProducts->contains($product->id))
                                    <button type="button" class="bookmark-button remove-bookmark" data-deal-id="{{ $product->id }}" style="border: none; background: none;">
                                        <p style="height:fit-content;cursor:pointer" class="p-1 px-2">
                                            <i class="fa-solid fa-bookmark bookmark-icon" style="color: #ff0060;"></i>
                                        </p>
                                    </button>
                                    @else
                                    <button type="button" class="bookmark-button add-bookmark" data-deal-id="{{ $product->id }}" style="border: none; background: none;">
                                        <p style="height:fit-content;cursor:pointer" class="p-1 px-2">
                                            <i class="fa-regular fa-bookmark bookmark-icon" style="color: #ff0060;"></i>
                                        </p>
                                    </button>
                                    @endif
                                </span>
                            </div>
                            <span class="px-3">
                                @php
                                $fullStars = floor($product->shop->shop_ratings);
                                $hasHalfStar = ($product->shop->shop_ratings - $fullStars) >= 0.5;
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
                        </div>
                        <div>
                            <div class="card-divider"></div>
                            <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                style="color: #ff0060">
                                <span>Rs {{ $product->discounted_price }}</span>
                                @if (!empty($product->coupon_code))
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
                                @endif
                            </p>
                            <div class="card-divider"></div>
                            <div class="ps-3">
                                <p>Regular Price</p>
                                <p><s>Rs {{ $product->original_price }}</s></p>
                            </div>
                            <div class="card-divider"></div>
                            <p class="ps-3 fw-medium" style="color: #ff0060; font-weight: 400 !important;">
                                <i class="fa-solid fa-location-dot"></i>&nbsp;{{  $product->shop->city }}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
