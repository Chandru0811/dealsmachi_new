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
                                    {{ $default_address->last_name ?? '' }} (+91)
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
                                $image = isset($product->productMedia)
                                ? $product->productMedia
                                ->where('order', 1)
                                ->where('type', 'image')
                                ->first() : null;
                                @endphp
                                <img
                                    src="{{ $image ? asset($image->path) : asset('assets/images/home/noImage.webp') }}"
                                    style="max-width: 100%; max-height: 100%;"
                                    alt="{{ $product->name }}" />
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <h5>{{ $product->name }}</h5>
                            <h6 class="truncated-description">{{ $product->description }}</h6>
                            <div>
                                <span class="original-price" style="text-decoration: line-through; color:#c7c7c7">
                                    ₹{{ number_format($product->original_price, 0, '.', ',') }}
                                </span>
                                <span class="discounted-price ms-1" style="font-size:22px;color:#ff0060">
                                    ₹{{ number_format($product->discounted_price, 0, '.', ',') }}
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
                                    <label for="service_date_{{ $product->id }}" class="form-label">Service Date</label>
                                    <input type="date" id="service_date_{{ $product->id }}" name="service_date"
                                        class="form-control form-control-sm service-date"
                                        value="" min="{{ date('Y-m-d') }}" required>
                                    <span class="error-message" id="error_date_{{ $product->id }}"
                                        style="color:red; font-size: 12px;"></span>
                                </div>
                                <div class="form-group ms-2">
                                    <label for="service_time_{{ $product->id }}" class="form-label">Service Time</label>
                                    <input type="time" id="service_time_{{ $product->id }}" name="service_time"
                                        class="form-control form-control-sm service-time"
                                        value="" required>
                                    <span class="error-message" id="error_time_{{ $product->id }}"
                                        style="color:red; font-size: 12px;"></span>
                                </div>
                            </div>
                            @else
                            <div class="d-flex align-items-center my-3">
                                <span class="me-2">Qty</span>
                                <button class="btn rounded btn-sm decrease-btn"
                                    style="background: #c7c7c75b" data-product-id="{{ $product->id }}">-</button>
                                <input type="text" id="quantityInput_{{ $product->id }}" value="1"
                                    class="form-control form-control-sm mx-2 text-center quantity-input"
                                    style="width: 50px;" readonly>
                                <button class="btn rounded btn-sm increase-btn"
                                    style="background: #c7c7c75b" data-product-id="{{ $product->id }}">+</button>
                            </div>
                            @endif
                            <span class="px-2">
                                <button class="btn btn-sm btn-danger rounded remove-btn"
                                    style="background: #ff0060; color:#fff;
                                     margin-top: {{ $product->deal_type === 2 ? '30px;' : '3px;' }}">Remove</button>
                            </span>
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
                                    $image = isset($cart->product->productMedia)
                                    ? $product->productMedia
                                    ->where('order', 1)
                                    ->where('type', 'image')
                                    ->first() : null;
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
                                $image = isset($list->deal->productMedia)
                                ? $list->deal->productMedia
                                ->where('order', 1)
                                ->where('type', 'image')
                                ->first() : null;
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
                <h4>
                    Total Amount &nbsp;&nbsp;
                    <span id="original-price-strike" style="text-decoration: line-through; color:#c7c7c7">
                        ₹{{ number_format($product->original_price, 0, '.', ',') }}
                    </span>
                    &nbsp;&nbsp;
                    <span id="discounted-price" style="color:#000">
                        ₹{{ number_format($product->discounted_price, 0, '.', ',') }}
                    </span>
                    &nbsp;&nbsp;
                    <span class="ms-1" style="font-size:12px; color:#00DD21" id="deal-discount">
                        Dealsmachi Discount
                        &nbsp;<span>₹{{ number_format($product->original_price - $product->discounted_price, 0, '.', ',') }}</span>
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
        // Function to format numbers in Indian style
        function formatIndianNumber(num) {
            const x = num.toString().split('.');
            const lastThree = x[0].slice(-3);
            const otherNumbers = x[0].slice(0, -3);
            const formatted =
                otherNumbers !== '' ?
                otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ',') + ',' + lastThree :
                lastThree;
            return formatted;
        }

        function updateRemoveButtonVisibility() {
            const productCount = $('#product_list .row').length;
            if (productCount > 1) {
                $('.remove-btn').show(); // Show Remove button for all products
            } else {
                $('.remove-btn').hide(); // Hide Remove button if only one product remains
            }
        }

        // Add products to cart
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
                    response.data.forEach(function(product) {
                        if ($(`#product_${product.id}`).length === 0) {
                            $('#product_list').append(`
                                <div class="row px-4 pt-2" id="product_${product.id}">
                                    <div class="col-md-4 col-12 d-flex flex-column justify-content-center align-items-center">
                                        <img src="${product.image}" style="max-width: 100%; max-height: 100%;" alt="${product.name}" />
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <h5>${product.name}</h5>
                                        <h6 class="truncated-description">${product.description}</h6>
                                        <div>
                                            <span class="original-price" style="text-decoration: line-through; color:#c7c7c7">
                                                ₹${formatIndianNumber(product.original_price)}
                                            </span>
                                            <span class="discounted-price ms-1" style="font-size:22px;color:#ff0060">
                                                ₹${formatIndianNumber(product.discounted_price)}
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
                                                    class="form-control form-control-sm service-date" value="" min="${new Date().toISOString().split('T')[0]}" required>
                                                <span class="error-message" id="error_date_${product.id}" style="color:red; font-size: 12px;"></span>
                                            </div>
                                            <div class="form-group ms-2">
                                                <label for="service_time_${product.id}" class="form-label">Service Time</label>
                                                <input type="time" id="service_time_${product.id}" name="service_time"
                                                    class="form-control form-control-sm service-time" value="" required>
                                                <span class="error-message" id="error_time_${product.id}" style="color:red; font-size: 12px;"></span>
                                            </div>
                                        </div>
                                    ` : `
                                        <div class="d-flex align-items-center my-3">
                                            <span class="me-2">Qty</span>
                                            <button class="btn rounded btn-sm decrease-btn" style="background: #c7c7c75b" data-product-id="${product.id}">-</button>
                                            <input type="text" id="quantityInput_${product.id}" value="1"
                                                class="form-control form-control-sm mx-2 text-center quantity-input" style="width: 50px;" readonly>
                                            <button class="btn rounded btn-sm increase-btn" style="background: #c7c7c75b" data-product-id="${product.id}">+</button>
                                        </div>
                                    `}
                                    <span class="px-2">
                                        <button class="btn btn-sm btn-danger rounded remove-btn"
                                            style="background: #ff0060; color:#fff;
                                            margin-top: ${product.deal_type === 2 ? '30px;' : '3px;'}">Remove</button>
                                    </span>
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

                            updateRemoveButtonVisibility();
                            updateCartTotals();
                            updateProductsToBuy();
                        }
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Function to update cart totals
        function updateCartTotals() {
            let totalOriginalPrice = 0;
            let totalDiscountedPrice = 0;
            let totalDiscount = 0;

            // Loop through each product in the cart and calculate totals
            $('#product_list .row').each(function() {
                const productId = $(this).attr('id').split('_')[1];
                const originalPrice = parseFloat(
                    $(this).find('.original-price').text().replace('₹', '').replace(/,/g, '').trim()
                );
                const discountedPrice = parseFloat(
                    $(this).find('.discounted-price').text().replace('₹', '').replace(/,/g, '').trim()
                );
                const quantity = parseInt($(`#quantityInput_${productId}`).val()) || 1;

                // Add to the totals
                totalOriginalPrice += originalPrice * quantity;
                totalDiscountedPrice += discountedPrice * quantity;
                totalDiscount += (originalPrice - discountedPrice) * quantity;
            });

            // Update the displayed totals with formatted numbers
            $('#original-price-strike').text(`₹ ${formatIndianNumber(totalOriginalPrice)}`);
            $('#discounted-price').text(`₹ ${formatIndianNumber(totalDiscountedPrice)}`);
            $('#deal-discount span').text(`₹ ${formatIndianNumber(totalDiscount)}`);
        }

        // Function to update the products to buy hidden input
        function updateProductsToBuy() {
            let productIds = [];
            $('#product_list .row').each(function() {
                const productId = $(this).attr('id').split('_')[1];
                productIds.push(productId);
            });

            // Update the hidden input with the updated product IDs
            $('#all_products_to_buy').val(JSON.stringify(productIds));
        }

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

        // Validation before checkout
        $('#submitBtn').on('click', function(e) {
            let isValid = true;
            $('.service-date').each(function() {
                const serviceDate = $(this).val();
                const serviceTime = $(this).closest('.row').find('.service-time').val();
                const currentDate = new Date();
                const selectedDate = new Date(serviceDate);

                // Reset error messages before validation
                $(this).next('.error-message').text('');
                $(this).closest('.form-group').find('.error-message').text('');

                // Validate service date
                if (!serviceDate) {
                    isValid = false;
                    $(this).next('.error-message').text('Service Date is required');
                }
            });

            $('.service-time').each(function() {
                const serviceTime = $(this).val();
                const serviceDate = $(this).closest('.row').find('.service-date').val();
                const currentDate = new Date();

                // Reset error messages before validation
                $(this).next('.error-message').text('');
                $(this).closest('.form-group').find('.error-message').text('');

                // Validate service time
                if (!serviceTime) {
                    isValid = false;
                    $(this).next('.error-message').text('Service Time is required');
                }

                // Validate future service time if date is today
                if (serviceDate === currentDate.toISOString().split('T')[0]) {
                    const [hours, minutes] = serviceTime.split(':');
                    const selectedTime = new Date(currentDate);
                    selectedTime.setHours(hours, minutes, 0);
                    if (selectedTime <= currentDate) {
                        isValid = false;
                        $(this).closest('.form-group').find('.error-message').text('Service Time must be in the future');
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });

        // Remove error message when service date is selected
        $(document).on('change', '.service-date', function() {
            const serviceDate = $(this).val();
            if (serviceDate) {
                $(this).next('.error-message').text(''); // Remove error message for service date
            }
        });

        // Remove error message when service time is selected
        $(document).on('change', '.service-time', function() {
            const serviceTime = $(this).val();
            if (serviceTime) {
                $(this).closest('.form-group').find('.error-message').text(''); // Remove error message for service time
            }
        });

        // Event listeners for quantity changes
        function attachQuantityListeners() {
            $(document).on('click', '.increase-btn', function() {
                let productId = $(this).data('product-id');
                let quantityInput = $(`#quantityInput_${productId}`);
                let currentQuantity = parseInt(quantityInput.val());
                let newQuantity = currentQuantity + 1;
                quantityInput.val(newQuantity);
                updateCartTotals();
                updateCart(productId, newQuantity);
            });

            $(document).on('click', '.decrease-btn', function() {
                let productId = $(this).data('product-id');
                let quantityInput = $(`#quantityInput_${productId}`);
                let currentQuantity = parseInt(quantityInput.val());
                if (currentQuantity > 1) {
                    let newQuantity = currentQuantity - 1;
                    quantityInput.val(newQuantity);
                    updateCartTotals();
                    updateCart(productId, newQuantity);
                }
            });
        }

        // Update cart via AJAX
        function updateCart(productId, newQuantity) {
            $.ajax({
                url: "{{ route('cart.update') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: newQuantity,
                    cart_id: $('input[name="cart_id"]').val()
                },
                success: function(response) {
                    updateCartTotals(); // Recalculate totals
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Remove products from cart
        $(document).on('click', '.remove-btn', function() {
            const productId = $(this).closest('.row').attr('id').split('_')[1];
            $(this).closest('.row').remove();
            updateCartTotals();
            updateProductsToBuy();
            updateRemoveButtonVisibility();

            // Get the product details from the server to add back to the cart items
            $.ajax({
                url: "{{ route('cartitems.get') }}",
                type: 'GET',
                data: {
                    product_ids: [productId] // Send the product ID to get its details
                },
                success: function(response) {
                    // Check if the product was returned from the server
                    if (response.data && response.data.length > 0) {
                        const product = response.data[0]; // Assuming one product is returned

                        // Append the product to the cart items
                        $('#cart_items').append(`
                        <div class="row d-flex align-items-center mb-3" id="cart_item_${product.id}">
                            <div class="col-1">
                                <input type="checkbox" class="cartItem_check" value="${product.id}" class="me-1" />
                            </div>
                            <div class="col-3">
                                <img src="${product.image}" class="img-fluid card_img_cont" alt="${product.name}" />
                            </div>
                            <div class="col-8">
                                <div class="d-flex flex-column justify-content-start">
                                    <h5 class="mb-1 fs_common text-truncate" style="max-width: 100%;">${product.name}</h5>
                                    <p class="mb-0 text-muted fs_common text-truncate" style="max-width: 100%;">${product.description}</p>
                                </div>
                            </div>
                        </div>
                    `);

                        // Update the total count if needed
                        if ($('#cart_items').children().length > 0) {
                            $('#get_cartItems').show();
                        }
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Initial function calls
        attachQuantityListeners();
        updateRemoveButtonVisibility();
        updateCartTotals();
        updateProductsToBuy();
    });

    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date();
        const currentDate = today.toISOString().split('T')[0]; // Format 'YYYY-MM-DD'

        // Calculate the next date
        const nextDate = new Date(today);
        nextDate.setDate(today.getDate() + 1);
        const nextDateString = nextDate.toISOString().split('T')[0];

        document.querySelectorAll('.service-date').forEach((serviceDateField) => {
            // Set the minimum date to the day after tomorrow
            const restrictedMinDate = new Date(nextDate);
            restrictedMinDate.setDate(nextDate.getDate() + 1);

            serviceDateField.setAttribute('min', restrictedMinDate.toISOString().split('T')[0]);

            // Handle user-typed values (if they bypass the UI)
            serviceDateField.addEventListener('change', () => {
                const selectedDate = serviceDateField.value;
                if (selectedDate === currentDate || selectedDate === nextDateString) {
                    serviceDateField.value = ''; // Clear invalid date
                }
            });
        });
    });
</script>
@endsection