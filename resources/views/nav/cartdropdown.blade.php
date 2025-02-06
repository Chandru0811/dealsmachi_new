<div class="child">
    <p class="text_size" style="color: #cbcbcb">Recently Added Products</p>

    @if (!$carts || $carts->items->isEmpty())
    <div class="text-center">
        <img src="{{ asset('assets/images/home/empty_cart.webp') }}" alt="Empty Cart"
            class="img-fluid" width="75">
        <p class="text_size" style="color: #cbcbcb">Your cart is empty</p>
    </div>
    @else
    @php
    $itemsDisplayed = 0;
    @endphp
    @foreach ($carts->items->take(6) as $item)
    <div class="d-flex">
        @php
        $image = isset($item->product->productMedia)
            ? $item->product->productMedia
                ->where('order', 1)
                ->where('type', 'image')
                ->first() : null;
        @endphp
        <img src="{{ $image ? asset($image->resize_path) : asset('assets/images/home/noImage.webp') }}"
            class="img-fluid dropdown_img" alt="{{ $item->product->name }}" />
        <div class="text-start">
            <p class="text-start px-1 text-wrap m-0 p-0" style="font-size: 12px; white-space: normal;">
                {{ \Illuminate\Support\Str::limit($item->product->name, 20) }}
            </p>
            <p class="px-1 text_size" style="color: #ff0060">
                ₹ {{ number_format($item->discount, 0) }}
            </p>
        </div>
    </div>
    @php
    $itemsDisplayed++;
    @endphp
    @endforeach

    @if ($itemsDisplayed < $carts->items->count())
        <div class="text-end mb-2">
            <a style="font-size: 13px" href="{{ route('cart.index') }}">View All</a>
        </div>
    @endif
    @endif

    <div class="dropdown_cart_view d-flex justify-content-end">
        <a href="{{ route('cart.index') }}"
            class="text_size text-decoration-none d-none d-xl-inline" style="text-decoration: none;">
            View My Shopping Cart
        </a>
    </div>
</div>
