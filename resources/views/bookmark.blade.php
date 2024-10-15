@extends('layouts.master')

@section('content')
<section>
    <div class="container" style="margin-top: 100px">
        <span class="d-flex">
            <h5 class="pt-0 pb-2">Your Bookmark</h5> &nbsp;&nbsp;
            <p style="color: #ff0060">(<span class="totalItemsCount">{{ $bookmarks->total() }}</span>)</p>
        </span>
        <div class="row pb-4">
            @if ($bookmarks->isNotEmpty())
                @foreach ($bookmarks as $bookmark)
                    @php
                        $deal = $bookmark->deal;
                    @endphp
                    <div class="col-md-4 col-lg-3 col-12 mb-3 d-flex align-items-stretch justify-content-center">
                        <a href="{{ url('/deal/' . $deal->id) }}" style="text-decoration: none; width: 100%;">
                            <div class="card sub_topCard h-100 d-flex flex-column">
                                <div style="min-height: 50px">
                                    <span class="badge trending-badge">TRENDING</span>
                                    <img src="{{ asset($deal->image_url1) }}" class="img-fluid card-img-top1"
                                        alt="{{ $deal->name }}" />
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
                                        <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                            style="color: #ff0060">
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
            @else
                <div class="col-12 text-center d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh">
                    <img src="{{ asset('assets/images/home/empty_bookmark.webp') }}" alt="Empty Bookmark" class="img-fluid">
                    <h2 class="mt-5" style="color: #ff0060">Your bookmark is waiting to be filled with treasures!</h2>
                </div>
            @endif
        </div>
        <div class="pagination justify-content-center">
            {{ $bookmarks->links() }}
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Setup CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Remove Bookmark
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
                        // Update the total bookmark count displayed
                        $('.totalItemsCount').text(response.total_items);

                        // Remove the product card from the DOM
                        button.closest('.col-md-4').remove();

                        // If the total bookmark count becomes zero, show the empty bookmark section
                        if (response.total_items == 0) {
                            let emptyBookmarkHtml = `
                                <div class="col-12 text-center d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh">
                                    <img src="{{ asset('assets/images/home/empty_bookmark.webp') }}" alt="Empty Bookmark" class="img-fluid">
                                    <h2 class="mt-5" style="color: #ff0060">Your bookmark is waiting to be filled with treasures!</h2>
                                </div>
                            `;
                            // Append the empty bookmark section
                            $('.row.pb-4').html(emptyBookmarkHtml);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error occurred while removing bookmark:', xhr);
                    }
                });
            }
        });

        // Initial Load of Bookmark Count
        function loadBookmarkCount() {
            $.ajax({
                url: '/totalbookmark',
                method: 'GET',
                success: function(response) {
                    $('.totalItemsCount').text(response.total_items);
                },
                error: function(xhr) {
                    console.error('Failed to load bookmark count.');
                }
            });
        }

        loadBookmarkCount();
    });
</script>
@endsection
