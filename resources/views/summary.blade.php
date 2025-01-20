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
            style="position: fixed; top: 70px; right: 40px; z-index: 1050; background:#ef4444; color:#fff">
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
            style="position: fixed; top: 70px; right: 40px; z-index: 1050; background:#ef4444; color:#fff">
            {{ session('error') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @php
        $selectedAddressId = session('selectedId');
        $default_address =
            $addresses->firstWhere('id', $selectedAddressId) ?? ($addresses->firstWhere('default', true) ?? null); // Add fallback to null
    @endphp
    <section>
        <div class="container" style="margin-top: 100px">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-12">
                    <p class="text-center mb-0" style="visibility: hidden">p</p>

                    <div class="card p-3 mb-3">
                        <div class="d-flex align-items-center">
                            <h5 class="fw-bold mb-0">Delivery Addresses</h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            @if ($default_address)
                                <span class="badge badge_infos py-1" data-bs-toggle="modal"
                                    data-bs-target="#myAddressModal">Change</span>
                            @else
                                <button type="button" class="btn primary_new_btn" style="font-size: 12px"
                                    data-bs-toggle="modal" data-bs-target="#newAddressModal">
                                    <i class="fa-light fa-plus"></i> Add New Address
                                </button>
                            @endif
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                @if ($default_address)
                                    <p>
                                        <strong>{{ $default_address->first_name ?? '' }}
                                            {{ $default_address->last_name ?? '' }} (+65)
                                            {{ $default_address->phone ?? '' }}</strong>&nbsp;&nbsp;<br>
                                        {{ $default_address->address ?? '' }} -
                                        {{ $default_address->postalcode ?? '' }}
                                        <span>
                                            @if ($default_address->default)
                                                <span class="badge badge_danger py-1">Default</span>&nbsp;&nbsp;
                                            @endif
                                        </span>
                                    </p>
                                @else
                                    <p class="font-weight-bold">Uh-oh! It looks like you don't have a default
                                        address set yet. Add one now to speed up your checkout process!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card p-3 mb-3" id="product_list">
                        @foreach ($products as $product)
                            <div class="row px-4 pt-2" id="product_{{ $product->id }}">
                                <div class="col-md-4 col-12 d-flex flex-column justify-content-center align-items-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        @php
                                            $image = $product->productMedia
                                                ->where('order', 1)
                                                ->where('type', 'image')
                                                ->first();
                                        @endphp
                                        <img src="{{ $image ? asset($image->path) : asset('assets/images/home/noImage.webp') }}"
                                            style="max-width: 100%; max-height: 100%;" alt="{{ $product->name }}" />
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <h5>{{ $product->name }}</h5>
                                    <h6 class="truncated-description">{{ $product->description }}</h6>
                                    <div>
                                        <span style="text-decoration: line-through; color:#c7c7c7">
                                            ₹{{ $product->original_price }}
                                        </span>
                                        <span class="ms-1" style="font-size:22px;color:#ef4444">
                                            ₹{{ $product->discounted_price }}
                                        </span>
                                        <span class="ms-1" style="font-size:12px; color:#00DD21">
                                            {{ round($product->discount_percentage) }}% off
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-wrap align-items-center mt-2">
                                    @if ($product->deal_type === 2)
                                        <div class="d-flex align-items-center">
                                            <div class="form-group">
                                                <label for="service_date_{{ $product->id }}" class="form-label">Service
                                                    Date</label>
                                                <input type="date" id="service_date_{{ $product->id }}"
                                                    name="service_date" class="form-control form-control-sm service-date"
                                                    value="" min="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div class="form-group ms-2">
                                                <label for="service_time_{{ $product->id }}" class="form-label">Service
                                                    Time</label>
                                                <input type="time" id="service_time_{{ $product->id }}"
                                                    name="service_time" class="form-control form-control-sm service-time"
                                                    value="" required>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center my-3">
                                            <span class="me-2">Qty</span>
                                            <button class="btn rounded btn-sm decrease-btn" style="background: #c7c7c75b"
                                                data-product-id="{{ $product->id }}">-</button>
                                            <input type="text" id="quantityInput_{{ $product->id }}" value="1"
                                                class="form-control form-control-sm mx-2 text-center quantity-input"
                                                style="width: 50px;" readonly>
                                            <button class="btn rounded btn-sm increase-btn" style="background: #c7c7c75b"
                                                data-product-id="{{ $product->id }}">+</button>
                                        </div>
                                    @endif
                                    @if (count($products) > 1)
                                        <span class="px-2">
                                            <button class="btn btn-sm btn-danger rounded remove-btn"
                                                style="background: #ef4444; color:#fff;
                                     margin-top: {{ $product->deal_type === 2 ? '30px;' : '3px;' }}">Remove</button>
                                        </span>
                                    @endif
                                </div>
                                <hr class="mt-3">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <p class="text-center mb-0">You have these items in your cart </p>
                    <div class="container mb-4">
                        <div class="card p-3">
                            <!-- Card 1 -->
                            <!-- cart items -->
                            <div id="cart_items">
                                @if ($carts->items->count() > 0)
                                    @foreach ($carts->items as $cart)
                                        <div class="row d-flex align-items-center mb-3"
                                            id="cart_item_{{ $cart->product->id }}">
                                            <div class="col-1">
                                                <input type="checkbox" class="cartItem_check"
                                                    value="{{ $cart->product->id }}" class="me-1" />
                                            </div>
                                            <div class="col-3">
                                                @php
                                                    $image = $cart->product->productMedia
                                                        ->where('order', 1)
                                                        ->where('type', 'image')
                                                        ->first();
                                                @endphp
                                                <img src="{{ $image ? asset($image->path) : asset('assets/images/home/noImage.webp') }}"
                                                    class="img-fluid card_img_cont" alt="{{ $cart->product->name }}" />
                                            </div>
                                            <div class="col-8">
                                                <div class="d-flex flex-column justify-content-start">
                                                    <h5 class="mb-1 fs_common text-truncate" style="max-width: 100%;">
                                                        {{ $cart->product->name }}
                                                    </h5>
                                                    <p class="mb-0 text-muted fs_common text-truncate"
                                                        style="max-width: 100%;">
                                                        {{ $cart->product->description }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center" id="no_items">
                                        <p class="text-muted">No items found in the cart.</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Add Button -->
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-orange fs_common my-2" id="get_cartItems">Add Item</button>
                            </div>
                            <!-- saved items -->
                            <p>Saved Items</p>
                            @if ($savedItem->count() > 0)
                                @foreach ($savedItem as $list)
                                    <div class="row d-flex align-items-center mb-3">
                                        <div class="col-1">
                                            {{-- <input type="checkbox" value="{{ $list->deal->id }}" class="me-1" /> --}}
                                        </div>
                                        <div class="col-3">
                                            @php
                                                $image = $list->deal->productMedia
                                                    ->where('order', 1)
                                                    ->where('type', 'image')
                                                    ->first();
                                            @endphp
                                            <img src="{{ $image ? asset($image->path) : asset('assets/images/home/noImage.webp') }}"
                                                class="img-fluid card_img_cont" alt="{{ $list->deal->name }}" />
                                        </div>
                                        <div class="col-8">
                                            <div class="d-flex flex-column justify-content-start">
                                                <h5 class="mb-1 fs_common text-truncate" style="max-width: 100%;">
                                                    {{ $list->deal->name }}
                                                </h5>
                                                <p class="mb-0 text-muted fs_common text-truncate"
                                                    style="max-width: 100%;">
                                                    {{ $list->deal->description }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <form action="{{ route('movetocart') }}" class="d-flex justify-content-end"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $list->deal->id }}">
                                                <button type="submit" style="width: 150px;font-size: 14px;"
                                                    class="btn py-0">
                                                    <u>Move to Cart</u>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center">
                                    <p class="text-muted">No items found in the Saved list.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center py-3"
                style="position: sticky; bottom: 0px; background: #fff;border-top: 1px solid #dcdcdc">
                <div class="d-flex justify-content-end align-items-center">
                    <h4>Total Amount &nbsp;&nbsp;
                        <span id="original-price-strike" style="text-decoration: line-through; color:#c7c7c7">
                            ${{ $product->original_price }}
                        </span>
                        &nbsp;&nbsp;
                        <span id="discounted-price" style="color:#000">
                            ${{ $product->discounted_price }}
                        </span>
                        &nbsp;&nbsp;
                        <span class="ms-1" style="font-size:12px; color:#00DD21" id="deal-discount">
                            Dealslah Discount
                            &nbsp;<span>${{ number_format($product->original_price - $product->discounted_price, 2) }}</span>
                        </span>
                    </h4>
                </div>
                @if ($default_address)
                    <form action="{{ route('checkout.direct') }}" method="POST" id="checkoutForm">
                        @csrf
                        <input type="hidden" id="all_products_to_buy" name="all_products_to_buy"
                            value="{{ json_encode($products->pluck('id')) }}">
                        <input type="hidden" name="address_id" value="{{ $default_address->id }}">
                        <input type="hidden" name="cart_id" value="{{ $carts->id }}">
                        <button type="submit" class="btn check_out_btn" id="submitBtn">
                            Checkout
                        </button>
                    </form>
                @else
                    <a href="#" class="btn check_out_btn" data-bs-toggle="modal"
                        data-bs-target="#newAddressModal">
                        Checkout
                    </a>
                @endif
            </div>

        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#get_cartItems').on('click', function() {
                let product_ids = [];
                $('.cartItem_check:checked').each(function() {
                    product_ids.push($(this).val());
                });
                $.ajax({
                    url: "{{ route('cartitems.get') }}",
                    type: 'GET',
                    data: {
                        product_ids: product_ids
                    },
                    success: function(response) {
                        console.log(response.data);
                        response.data.forEach(function(product) {
                            // Check if the product is already in the DOM
                            if ($(`#product_${product.id}`).length === 0) {
                                // If not, append the product
                                $('#product_list').append(`
                                    <div class="row px-4 pt-2" id="product_${product.id}">
                                        <div class="col-md-4 col-12 d-flex flex-column justify-content-center align-items-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <img
                                                    src="${product.image}"
                                                    style="max-width: 100%; max-height: 100%;"
                                                    alt="${product.name}" />
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-12">
                                            <h5>${product.name}</h5>
                                            <h6 class="truncated-description">${product.description}</h6>
                                            <div>
                                                <span style="text-decoration: line-through; color:#c7c7c7">
                                                    $${product.original_price}
                                                </span>
                                                <span class="ms-1" style="font-size:22px;color:#ef4444">
                                                    $${product.discounted_price}
                                                </span>
                                                <span class="ms-1" style="font-size:12px; color:#00DD21">
                                                    ${Math.round(product.discount_percentage)}% off
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex flex-wrap align-items-center mt-2">
                                            ${product.deal_type === 2 ? `
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="form-group">
                                                                                <label for="service_date_${product.id}" class="form-label">Service Date</label>
                                                                                <input type="date" id="service_date_${product.id}" name="service_date"
                                                                                    class="form-control form-control-sm service-date"
                                                                                    value="" min="${new Date().toISOString().split('T')[0]}" required>
                                                                            </div>
                                                                            <div class="form-group ms-2">
                                                                                <label for="service_time_${product.id}" class="form-label">Service Time</label>
                                                                                <input type="time" id="service_time_${product.id}" name="service_time"
                                                                                    class="form-control form-control-sm service-time"
                                                                                    value="" required>
                                                                            </div>
                                                                        </div>
                                                                    ` : `
                                                                        <div class="d-flex align-items-center my-3">
                                                                            <span class="me-2">Qty</span>
                                                                            <button class="btn rounded btn-sm decrease-btn"
                                                                                style="background: #c7c7c75b" data-product-id="${product.id}">-</button>
                                                                            <input type="text" id="quantityInput_${product.id}" value="1"
                                                                                class="form-control form-control-sm mx-2 text-center quantity-input"
                                                                                style="width: 50px;" readonly>
                                                                            <button class="btn rounded btn-sm increase-btn"
                                                                                style="background: #c7c7c75b" data-product-id="${product.id}">+</button>
                                                                        </div>
                                                                    `}
                                            ${response.data.length > 1 ? `
                                                                                            <span class="px-2">
                                                                                                <button class="btn btn-sm btn-danger rounded remove-btn"
                                                                                                    style="background: #ef4444; color:#fff;
                                                                                                    margin-top: ${product.deal_type === 2 ? '30px;' : '3px;'}">Remove</button>
                                                                                            </span>
                                                                                        ` : ''}
                                        </div>
                                        <hr class="mt-3">
                                    </div>
                                `);

                                $('#cart_item_' + product.id).remove();
                                if ($('#cart_items').children().length === 0) {
                                    $('#cart_items').append(`<div class="text-center" id="no_items">
                                        <p class="text-muted">No items found in the cart.</p>
                                    </div>`);
                                    $('#get_cartItems').hide();
                                }

                                let allProducts = JSON.parse($('#all_products_to_buy')
                                    .val());
                                allProducts.push(product.id);
                                $('#all_products_to_buy').val(JSON.stringify(
                                    allProducts));
                            }
                        });
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $(document).on('change', '.service-date', function() {
                let productId = $(this).closest('.row').attr('id').split('_')[1];
                let cartId = $('input[name="cart_id"]').val();
                let serviceDate = $(this).val();

                $.ajax({
                    url: "{{ route('cart.update') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        service_date: serviceDate,
                        cart_id: cartId
                    },
                    success: function(response) {
                        // Optionally handle success response
                    },
                    error: function(error) {
                        console.log(error);
                        // Optionally handle error response
                    }
                });
            });

            $(document).on('change', '.service-time', function() {
                let productId = $(this).closest('.row').attr('id').split('_')[1];
                let cartId = $('input[name="cart_id"]').val();
                let serviceTime = $(this).val();

                $.ajax({
                    url: "{{ route('cart.update') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        service_time: serviceTime,
                        cart_id: cartId
                    },
                    success: function(response) {
                        // Optionally handle success response
                    },
                    error: function(error) {
                        console.log(error);
                        // Optionally handle error response
                    }
                });
            });

            function attachQuantityListeners() {
                $(document).on('click', '.increase-btn', function() {
                    let productId = $(this).data('product-id');
                    let quantityInput = $(`#quantityInput_${productId}`);
                    let currentQuantity = parseInt(quantityInput.val());
                    let newQuantity = currentQuantity + 1;
                    updateCart(productId, newQuantity, quantityInput);
                });

                $(document).on('click', '.decrease-btn', function() {
                    let productId = $(this).data('product-id');
                    let quantityInput = $(`#quantityInput_${productId}`);
                    let currentQuantity = parseInt(quantityInput.val());
                    if (currentQuantity > 1) {
                        let newQuantity = currentQuantity - 1;
                        updateCart(productId, newQuantity, quantityInput);
                    }
                });
            }

            function updateCart(productId, newQuantity, quantityInput) {
                $.ajax({
                    url: "{{ route('cart.update') }}", // Update this route to your actual update route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        quantity: newQuantity,
                        cart_id: $('input[name="cart_id"]').val()
                    },
                    success: function(response) {
                        quantityInput.val(newQuantity);
                        // Optionally update other parts of the cart UI, like total price
                    },
                    error: function(error) {
                        console.log(error);
                        // Optionally show an error message to the user
                    }
                });
            }

            // Initial call to attach event listeners
            attachQuantityListeners();

            $(document).on('click', '.remove-btn', function() {
                let product = $(this).closest('.row');
                let productId = product.attr('id').split('_')[1];
                let product_name = product.find('h5').text();
                let product_description = product.find('h6').text();
                let product_image = product.find('img').attr('src');
                product.remove();

                $('#cart_items').append(`
                    <div class="row d-flex align-items-center mb-3" id="cart_item_${productId}">
                        <div class="col-1">
                            <input type="checkbox" class="cartItem_check" value="${productId}" class="me-1" />
                        </div>
                        <div class="col-3">
                            <img src="${product_image ? product_image : '{{ asset('assets/images/home/noImage.webp') }}'}"
                                class="img-fluid card_img_cont" alt="${product_name}" />
                        </div>
                        <div class="col-8">
                            <div class="d-flex flex-column justify-content-start">
                                <h5 class="mb-1 fs_common text-truncate" style="max-width: 100%;">${product_name}</h5>
                                <p class="mb-0 text-muted fs_common text-truncate" style="max-width: 100%;">${product_description}</p>
                            </div>
                        </div>
                    </div>
                `);

                attachQuantityListeners();

                if ($('#cart_items').children().length === 0) {
                    $('#cart_items').append(`<div class="text-center" id="no_items">
                                        <p class="text-muted">No items found in the cart.</p>
                                    </div>`);
                    $('#get_cartItems').hide();
                }

                $('#get_cartItems').show();

            });
        });
    </script>
@endsection
