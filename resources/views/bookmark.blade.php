@extends('layouts.master')

@section('content')
<section>
    <div class="container" style="margin-top: 100px">
        @if ($bookmarks->isNotEmpty())
            <span class="d-flex">
                <h5 class="pt-0 pb-2">Your Bookmark</h5> &nbsp;&nbsp;
                <p style="color: #ff0060" class="totalItemsCount">({{ $bookmarks->total() }})</p>
            </span>
            <div class="row pb-4">
                @foreach ($bookmarks as $bookmark)
                    @php
                    $deal = $bookmark->deal;
                    @endphp
                    <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-stretch justify-content-center">
                        <a href="{{ url('/deal/' . $deal->id) }}" style="text-decoration: none; width: 100%;">
                            <div class="card sub_topCard h-100 d-flex flex-column">
                                <div style="min-height: 50px">
                                    <span class="badge trending-badge">TRENDING</span>
                                    <img src="{{ asset($deal->image_url1) }}" class="img-fluid card-img-top1" alt="{{ $deal->name }}" />
                                </div>
                                <div class="card-body card_section flex-grow-1 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="mt-3 d-flex align-items-center justify-content-between">
                                            <h5 class="card-title ps-3">{{ $deal->name }}</h5>
                                            <span class="badge mx-3 p-0 trending-bookmark-badge" data-bs-toggle="tooltip" data-bs-placement="top" title="Bookmark">
                                                <button type="button" data-deal-id="{{ $deal->id }}" class="bookmark-button" style="border: none; background: none;">
                                                    @if (count($deal->bookmark) === 0)
                                                        <i class="fa-regular fa-bookmark" style="color: #ff0060;"></i>
                                                    @else
                                                        <i class="fa-solid fa-bookmark" style="color: #ff0060;"></i>
                                                    @endif
                                                </button>
                                            </span>
                                        </div>
                                        <span class="px-3">
                                            @php
                                            $fullStars = floor($deal->shop->shop_ratings);
                                            $hasHalfStar = ($deal->shop->shop_ratings - $fullStars) >= 0.5;
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
                                        <p class="ps-3 fw-medium d-flex align-items-center justify-content-between" style="color: #ff0060">
                                            <span>${{ $deal->discounted_price }}</span>
                                            <span class="mx-3 px-2 couponBadge">DEALSLAH{{ round($deal->discount_percentage) }}</span>
                                        </p>
                                        <div class="card-divider"></div>
                                        <div class="ps-3">
                                            <p>Regular Price</p>
                                            <p><s>${{ $deal->original_price }}</s></p>
                                        </div>
                                        <div class="card-divider"></div>
                                        <p class="ps-3 fw-medium" style="color: #ff0060; font-weight: 400 !important;">
                                            <i class="fa-solid fa-location-dot"></i>&nbsp;{{ $deal->shop->city }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="col-12 text-center d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh">
                <img src="{{ asset('assets/images/home/empty_bookmark.webp') }}" alt="Empty Bookmark" class="img-fluid">
                <h2 class="mt-5" style="color: #ff0060">Your bookmark is waiting to be filled with treasures!</h2>
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
            $(".totalItemsCount").each(function() {
                if (count > 0) {
                    $(this).text(count).css("visibility", "visible");
                } else {
                    $(this).text("").css("visibility", "hidden");
                }
            });
        }

        $(document).on('click', '.bookmark-button', function(e) {
            e.preventDefault();
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

                        // Check if there are no bookmarks left
                        if (response.total_items == 0) {
                            let emptyBookmarkHtml = `
                                <div class="col-12 text-center d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh">
                                    <img src="{{ asset('assets/images/home/empty_bookmark.webp') }}" alt="Empty Bookmark" class="img-fluid">
                                    <h2 class="mt-5" style="color: #ff0060">Your bookmark is waiting to be filled with treasures!</h2>
                                </div>
                            `;
                            $('.row.pb-4').html(emptyBookmarkHtml);
                            // Hide the heading and item count as well
                            $(".d-flex h5").remove(); // Remove the heading
                            $(".totalItemsCount").remove(); // Remove the count
                        }
                    },
                    error: function(xhr) {
                        console.error('Error occurred while removing bookmark:', xhr);
                    }
                });
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

        // Disable or remove tooltip from bookmark buttons
        $('.bookmark-button [data-bs-toggle="tooltip"]').removeAttr("data-bs-toggle");
    });
</script>
@endsection