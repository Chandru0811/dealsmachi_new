<div class="container">
    <h5 class="pt-0 pb-2">Products</h5>
    <div class="row pb-4">
        @foreach ($products as $product)
        <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-stretch">
            <a href="{{ url('/deal/' . $product->id) }}" style="text-decoration: none; width: 100%;">
                <div class="card sub_topCard h-100 d-flex flex-column">
                    <div style="min-height: 50px">
                        @if ($product->label !== '')
                        <span class="badge trending-badge">{{ $product->label }}</span>
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
                                    {{-- Bookmarked: show solid icon --}}
                                    <form action="{{ route('bookmarks.remove', $product->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE') <!-- Use DELETE method for removal -->
                                        <button type="submit" class="bookmark-icon"
                                            style="border: none; background: none;">
                                            <i class="fa-solid fa-bookmark" style="color: #ff0060;"></i>
                                        </button>
                                    </form>
                                    @else
                                    {{-- Not bookmarked: show regular icon --}}
                                    <form action="{{ route('bookmarks.add', $product->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="bookmark-icon"
                                            style="border: none; background: none;">
                                            <i class="fa-regular fa-bookmark" style="color: #ff0060;"></i>
                                        </button>
                                    </form>
                                    @endif
                                </span>
                            </div>
                            <span class="px-3">
                                @php
                                $fullStars = floor($product->shop_ratings); // Get integer part for full stars
                                $hasHalfStar = ($product->shop_ratings - $fullStars) >= 0.5; // Check for half star
                                $remaining = 5 - ($hasHalfStar ? $fullStars + 1 : $fullStars); // Calculate remaining stars
                                @endphp
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fa-solid fa-star" style="color: #ffc200;"></i> <!-- Filled stars -->
                                    @endfor
                                    @if ($hasHalfStar)
                                    <i class="fa-solid fa-star-half-stroke" style="color: #ffc200;"></i> <!-- Half star -->
                                    @endif
                                    @for ($i = 0; $i < $remaining; $i++)
                                        <i class="fa-regular fa-star" style="color: #ffc200;"></i> <!-- Empty stars -->
                                        @endfor
                            </span>

                            <p class="px-3 fw-normal truncated-description">{{ $product->description }}</p>
                        </div>
                        <div>
                            <div class="card-divider"></div>
                            <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                style="color: #ff0060">
                                <span>₹{{ $product->discounted_price }}</span>
                                <span id="mySpan" class="mx-3 px-2 couponBadge"
                                    onclick="copySpanText(this, event)" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="Copy to Clipboard" style="position:relative;">
                                    DEALSMACHI{{ round($product->discount_percentage) }}
                                    <!-- Tooltip container -->
                                    <span class="tooltip-text"
                                        style="visibility: hidden; background-color: black; color: #fff; text-align: center; border-radius: 6px; padding: 5px; position: absolute; z-index: 1; bottom: 125%; left: 50%; margin-left: -60px;">
                                        Copied!
                                    </span>
                                </span>
                            </p>
                            <div class="card-divider"></div>
                            <div class="ps-3">
                                <p>Regular Price</p>
                                <p><s>₹{{ $product->original_price }}</s></p>
                            </div>
                            <div class="card-divider"></div>
                            <p class="ps-3 fw-medium" style="color: #ff0060; font-weight: 400 !important;">
                                <i class="fa-solid fa-location-dot"></i>&nbsp;{{ $product->city }}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>