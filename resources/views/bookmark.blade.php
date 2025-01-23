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
    <section>
        <div class="container" style="margin-top: 100px">
            @if (isset($bookmarks) && $bookmarks->isNotEmpty())
                <!-- Display "Your Bookmark" heading only if there are bookmarks -->
                @if ($bookmarks->total() > 0)
                    <span class="d-flex">
                        <h5 class="pt-0 pb-2">Your Favourites</h5>
                        &nbsp;&nbsp;
                        <p class="d-flex" style="color: #ff0060;" id="bookmarkCountDisplay">
                            (<span class="totalItemsCount">{{ $bookmarks->total() }}</span>)
                        </p>
                    </span>
                @endif

                <div class="row pb-4">
                    @foreach ($bookmarks as $bookmark)
                        @php
                            $deal = $bookmark->deal;
                        @endphp
                        <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-stretch justify-content-center">
                            <!-- Click event on this wrapper div instead of <a> tag -->
                            <div class="clickable-card" data-deal-id="{{ $deal->id }}">
                                <a href="{{ url('/deal/' . $deal->id) }}" style="text-decoration: none;">
                                    <div class="card sub_topCard h-100 d-flex flex-column">
                                        <div style="min-height: 50px">
                                            <span class="badge trending-badge">TRENDING</span>
                                            @php
                                                $image = isset($deal->productMedia)
                                                    ? $deal->productMedia
                                                        ->where('order', 1)
                                                        ->where('type', 'image')
                                                        ->first()
                                                    : null;
                                            @endphp
                                            <img src="{{ $image ? asset($image->path) : asset('assets/images/home/noImage.webp') }}"
                                                class="img-fluid card-img-top1" alt="{{ $deal->name }}" />
                                        </div>
                                        <div
                                            class="card-body card_section flex-grow-1 d-flex flex-column justify-content-between">
                                            <div>
                                                <div class="mt-3 d-flex align-items-center justify-content-between">
                                                    <h5 class="card-title ps-3">{{ $deal->name }}</h5>
                                                    <span class="badge mx-3 p-0 trending-bookmark-badge"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Favourite">
                                                        <button type="button" data-deal-id="{{ $deal->id }}"
                                                            class="bookmark-button" style="border: none; background: none;">
                                                            @if (count($deal->bookmark) === 0)
                                                                <i class="fa-regular fa-heart" style="color: #ff0060;"></i>
                                                            @else
                                                                <i class="fa-solid fa-heart" style="color: #ff0060;"></i>
                                                            @endif
                                                        </button>
                                                    </span>
                                                </div>
                                                <span class="px-3">
                                                    @php
                                                        $fullStars = floor($deal->shop->shop_ratings);
                                                        $hasHalfStar = $deal->shop->shop_ratings - $fullStars >= 0.5;
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
                                                <p class="px-3 fw-normal truncated-description">{{ $deal->description }}</p>
                                            </div>
                                            <div>
                                                <div class="card-divider"></div>
                                                <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                                    style="color: #ff0060">
                                                    <span>₹{{ number_format($deal->discounted_price, 0) }}</span>
                                                    @if (!empty($deal->coupon_code))
                                                        <span id="mySpan" class="mx-3 px-2 couponBadge"
                                                            onclick="copySpanText(this, event)" data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" title="Click to Copy"
                                                            style="position:relative;">

                                                            {{ $deal->coupon_code }}

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
                                                <div class="ps-3 d-flex justify-content-between align-items-center pe-2">
                                                    <div>
                                                        <p>Regular Price</p>
                                                        @if ($deal->deal_type == 2)
                                                            <p style="color: #22cb00">Standard Rates</p>
                                                        @else
                                                            <p><s>₹{{ number_format($deal->original_price, 0) }}</s></p>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <button class="btn card_cart add-to-cart-btn"
                                                            data-slug="{{ $deal->slug }}">
                                                            Add to Cart
                                                        </button>&nbsp;&nbsp;
                                                    </div>
                                                </div>
                                                <div class="card-divider"></div>
                                                <p class="ps-3 fw-medium"
                                                    style="color: #ff0060; font-weight: 400 !important;">
                                                    <i class="fa-solid fa-location-dot"></i>&nbsp;{{ $deal->shop->city }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty bookmark section -->
                <div class="col-12 text-center d-flex flex-column align-items-center justify-content-center"
                    style="min-height: 60vh">
                    <img src="{{ asset('assets/images/home/empty_bookmark.webp') }}" alt="Empty Favourite"
                        class="img-fluid">
                    <h2 class="mt-5 mb-3" style="color: #ff0060">Your bookmark is waiting to be filled with treasures!</h2>
                </div>
            @endif
            <div class="pagination justify-content-center">
                {{ $bookmarks->links() }}
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function updateBookmarkCount(count) {
                const countDisplay = $(".totalItemsCount");
                if (count > 0) {
                    countDisplay.text(count);
                    $("#bookmarkCountDisplay").css("display", "inline");
                } else {
                    countDisplay.text("");
                    $("#bookmarkCountDisplay").css("display", "none");
                }
            }

            $(document).on('click', '.bookmark-button', function(e) {
                e.preventDefault();
                e.stopPropagation(); // Prevents click from bubbling up

                let button = $(this);
                let dealId = button.data('deal-id');
                let isBookmarked = button.find('i').hasClass('fa-solid');

                if (isBookmarked) {
                    $.ajax({
                        url: `/bookmark/${dealId}/remove`,
                        method: 'DELETE',
                        success: function(response) {
                            updateBookmarkCount(response.total_items);

                            button.closest('.col-md-4').remove();

                            if (response.total_items == 0) {
                                let emptyBookmarkHtml = `
                                <div class="col-12 text-center d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh">
                                    <img src="{{ asset('assets/images/home/empty_bookmark.webp') }}" alt="Empty Favourite" class="img-fluid">
                                    <h2 class="mt-5" style="color: #ff0060">Your bookmark is waiting to be filled with treasures!</h2>
                                </div>
                            `;
                                $('.row.pb-4').html(emptyBookmarkHtml);
                                $("#bookmarkCountDisplay").remove();
                                $("h5:contains('Your Favourite')").parent()
                                    .remove(); // Remove heading if no bookmarks
                            }
                        },
                        error: function(xhr) {
                            console.error('Error occurred while removing bookmark:', xhr);
                        }
                    });
                }
            });

            $(document).on('click', '.clickable-card', function(e) {
                if (!$(e.target).closest('.bookmark-button').length) {
                    let dealId = $(this).data('deal-id');
                    clickCount(dealId); // Trigger click count only if not clicking the bookmark
                }
            });

            function loadBookmarkCount() {
                $.ajax({
                    url: '/totalbookmark',
                    method: 'GET',
                    success: function(response) {
                        updateBookmarkCount(response.total_items);
                    },
                    error: function(xhr) {
                        console.error('Failed to load bookmark count.');
                    }
                });
            }

            loadBookmarkCount();
            $('.bookmark-button [data-bs-toggle="tooltip"]').removeAttr("data-bs-toggle");
        });
    </script>
@endsection
