@extends('layouts.master')

@section('content')
    <section>
        <div class="container" style="margin-top: 100px">
            <span class="d-flex">
                <h5 class="pt-0 pb-2">Your Bookmark</h5> &nbsp;&nbsp;
                <p style="color: #ff0060">({{ $bookmarks->total() }})</p>
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
                                    <div
                                        class="card-body card_section flex-grow-1 d-flex flex-column justify-content-between">
                                        <div>
                                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                                <h5 class="card-title ps-3">{{ $deal->name }}</h5>
                                                <span class="badge mx-3 p-0 trending-bookmark-badge">
                                                    @if (count($deal->bookmark) === 0)
                                                        <form action="{{ route('bookmarks.add', $deal->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="bookmark-icon"
                                                                style="border: none; background: none;">
                                                                <i class="fa-regular fa-bookmark"
                                                                    style="color: #ff0060;"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('bookmarks.remove', $deal->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="bookmark-icon"
                                                                style="border: none; background: none;">
                                                                <i class="fa-solid fa-bookmark" style="color: #ff0060;"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </span>
                                            </div>
                                            <span class="px-3">
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                                <i class="fa-solid fa-star" style="color: #ffc200"></i>
                                            </span>
                                            <p class="px-3 fw-normal truncated-description">{{ $deal->description }}</p>
                                        </div>
                                        <div>
                                            <div class="card-divider"></div>
                                            <p class="ps-3 fw-medium d-flex align-items-center justify-content-between"
                                                style="color: #ff0060">
                                                <span>₹{{ $deal->discounted_price }}</span>
                                                <span
                                                    class="mx-3 px-2 couponBadge">DEALSMACHI{{ round($deal->discount_percentage) }}</span>
                                            </p>
                                            <div class="card-divider"></div>
                                            <div class="ps-3">
                                                <p>Regular Price</p>
                                                <p><s>₹{{ $deal->original_price }}</s></p>
                                            </div>
                                            <div class="card-divider"></div>
                                            <p class="ps-3 fw-medium" style="color: #ff0060; font-weight: 400 !important;">
                                                <i class="fa-solid fa-location-dot"></i>&nbsp;Singapore
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center d-flex flex-column align-items-center justify-content-center"
                        style="min-height: 60vh">
                        <img src="{{ asset('assets/images/home/empty_bookmark.webp') }}" alt="Empty Bookmark"
                            class="img-fluid">
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
