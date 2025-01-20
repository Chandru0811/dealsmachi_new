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
        use Carbon\Carbon;
    @endphp
    <section>
        <div class="container" style="margin-top: 100px">
            @php
                $subtotal = 0;
                $total_discount = 0;
            @endphp
            <!-- Check if carts or cart->items are empty -->
            @if ($carts->isEmpty() || $carts->every(fn($cart) => $cart->items->isEmpty()))
                <div class="col-12 text-center d-flex flex-column align-items-center justify-content-center mt-0">
                    <img src="{{ asset('assets/images/home/empty_cart.webp') }}" alt="Empty Cart"
                        class="img-fluid empty_cart_img">
                    <h2 style="color: #ff0060">Your Cart is empty</h2>
                    <h5 class="mt-2" style="color: #808080">Looks like you have not added anything to your cart. Go ahead
                        & explore top categories.</h5>
                    <a href="/" class="btn showmoreBtn mt-2">Shop More</a>
                </div>
            @else
                @foreach ($carts as $cart)
                    <div class="d-flex justify-content-between mb-3">
                        <h5>Your Cart <span style="color: #ff0060"> ({{ $cart->item_count }})</span></h5>
                        <a href="/" class="text-decoration-none">
                            <button type="button" class="btn showmoreBtn">
                                Shop more
                            </button>
                        </a>
                    </div>
                    @foreach ($cart->items as $item)
                        @php
                            $product = $item->product;
                            $subtotal += $product->original_price * $item->quantity;
                            $total_discount +=
                                ($product->original_price - $product->discounted_price) * $item->quantity;
                        @endphp
                        @php
                            $currentDate = Carbon::now();

                            $deliveryDays = is_numeric($product->delivery_days) ? (int) $product->delivery_days : 0;

                            $deliveryDate =
                                $deliveryDays > 0 ? $currentDate->addDays($deliveryDays)->format('d-m-y') : null;
                        @endphp
                        <div class="row p-4">
                            <div class="col-md-4 mb-3">
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
                            <div class="col-md-8">
                                <h5>{{ $product->name }}</h5>
                                <h6 class="truncated-description">{{ $product->description }}</h6>
                                @if ($product->deal_type == 1)
                                    <div class="rating my-2">
                                        <span>Delivery Date :</span><span class="stars">
                                            <span>
                                                {{ $deliveryDays > 0 ? $deliveryDate : 'No delivery date available' }}
                                            </span>
                                        </span>
                                    </div>
                                @endif
                                <p>Seller : {{ $product->shop->email ?? '' }}</p>
                                <div>
                                    <span style="text-decoration: line-through; color:#c7c7c7">
                                        ₹{{ $product->original_price }}
                                    </span>
                                    <span class="ms-1" style="font-size:22px;color:#ff0060">
                                    ₹{{ $product->discounted_price }}
                                    </span>
                                    <span class="ms-1" style="font-size:12px; color:#00DD21">
                                        {{ round($product->discount_percentage) }}% off
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center">
                            <div class="col-md-6">
                                @if ($product->deal_type === 2)
                                    <div class="d-flex align-items-start my-3">
                                        <div class="d-flex flex-column me-3" style="width: 30%;">
                                            <label for="service_date" class="form-label">Service Date</label>
                                            <input type="date" id="service_date" name="service_date"
                                                class="form-control form-control-sm service-date"
                                                value="{{ $item->service_date }}" data-cart-id="{{ $cart->id }}"
                                                data-product-id="{{ $product->id }}" min="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="d-flex flex-column" style="width: 30%;">
                                            <label for="service_time" class="form-label">Service Time</label>
                                            <input type="time" id="service_time" name="service_time"
                                                class="form-control form-control-sm service-time"
                                                value="{{ $item->service_time }}" data-cart-id="{{ $cart->id }}"
                                                data-product-id="{{ $product->id }}">
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center my-3">
                                        <span class="me-2">Qty</span>
                                        <button class="btn rounded btn-sm decrease-btn" style="background: #c7c7c75b"
                                            data-cart-id="{{ $cart->id }}"
                                            data-product-id="{{ $product->id }}">-</button>
                                        <input type="text"
                                            class="form-control form-control-sm mx-2 text-center quantity-input"
                                            style="width: 50px;" value="{{ $item->quantity }}" readonly>
                                        <button class="btn rounded btn-sm increase-btn" style="background: #c7c7c75b"
                                            data-cart-id="{{ $cart->id }}"
                                            data-product-id="{{ $product->id }}">+</button>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form action="{{ route('savelater.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn border btn-outline-secondary"
                                            style="padding: 14px 20px; border-top-right-radius: 0px; border-bottom-right-radius: 0px;">
                                            Buy Later
                                        </button>
                                    </form>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn border btn-outline-secondary"
                                            style="padding: 14px 20px; border-top-left-radius: 0px; border-bottom-left-radius: 0px;">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="card mb-4">
                        <div class="card-header m-0 p-2">
                            <p class="mb-0">Order Summary</p>
                        </div>
                        <div class="card-body m-0 p-4 order-summary">
                            <div class="d-flex justify-content-between align-items-center">
                                <p>Subtotal (x<span class="quantity-value">{{ $cart->quantity }})</span></p>
                                <p class="subtotal">₹{{ $subtotal }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p>Discount (x<span class="quantity-value">{{ $cart->quantity }})</span></p>
                                <p class="discount">₹{{ $total_discount }}</p>
                            </div>
                            <hr />
                            <div class="d-flex justify-content-between pb-3">
                                <span>Total (x<span class="quantity-value">{{ $cart->quantity }})</span></span>
                                <span class="total">₹{{ $subtotal - $total_discount }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-3 mt-4"
                        style="position: sticky; bottom: 0px; background: #fff;border-top: 1px solid #dcdcdc">
                        <div class="d-flex justify-content-end align-items-center">
                            <h4>Total Amount (x<span class="quantity-value">{{ $cart->quantity }})&nbsp;&nbsp;
                                    <span style="text-decoration: line-through; color:#c7c7c7">
                                        ${{ number_format($cart->items->sum(fn($item) => $item->product->original_price * $item->quantity), 2) }}
                                    </span>
                                    &nbsp;&nbsp;
                                    <span class="ms-1" style="color:#000">
                                        ${{ number_format($cart->items->sum(fn($item) => $item->product->discounted_price * $item->quantity), 2) }}
                                    </span>
                                    &nbsp;&nbsp;
                                    <span class="ms-1" style="font-size:12px; color:#00DD21">
                                        Dealslah Discount
                                        &nbsp;<span>${{ number_format($cart->items->sum(fn($item) => ($item->product->original_price - $item->product->discounted_price) * $item->quantity), 2) }}</span>
                                    </span>
                            </h4>
                        </div>
                        <div class="d-flex justify-content-end align-items-center p-3"
                            style="position: sticky; bottom: 0px; background: #fff">
                            <a href="{{ url('/cartSummary/' . $cart->id) }}" class="btn  order-button">
                                Checkout
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="container mt-5">
            <hr>
            <h2 class="my-4">Saved Wishlist</h2>
            @if ($savedItems->isEmpty())
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/images/home/empty_savedItems.png') }}" alt="Empty Cart"
                        class="img-fluid mb-2" style="width: 300px;" />
                    <h4 style="color: #ff0060;">Your Saved Wishlists are awaiting your selection!</h4>
                </div>
            @else
                <hr>

                @foreach ($savedItems as $savedItem)
                    @php
                        $currentDate = Carbon::now();

                        $deliveryDays = is_numeric($savedItem->deal->delivery_days)
                            ? (int) $savedItem->deal->delivery_days
                            : 0;

                        $deliveryDate =
                            $deliveryDays > 0 ? $currentDate->addDays($deliveryDays)->format('d-m-y') : null;
                    @endphp
                    <div class="row p-4">
                        <div class="col-md-3 d-flex flex-column justify-content-center align-items-center">
                            <div class="d-flex justify-content-center align-items-center">
                                @php
                                    $image = $savedItem->deal->productMedia
                                        ->where('order', 1)
                                        ->where('type', 'image')
                                        ->first();
                                @endphp
                                <img src="{{ $image ? asset($image->path) : asset('assets/images/home/noImage.webp') }}"
                                    style="max-width: 100%; max-height: 100%;" alt="{{ $savedItem->deal->name }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>{{ $savedItem->deal->name }}</h5>
                            <h6 class="truncated-description">{{ $savedItem->deal->description }}</h6>
                            @if ($savedItem->deal->deal_type == 1)
                                <div class="rating my-2">
                                    <span>Delivery Date :</span><span class="stars">
                                        <span>
                                            {{ $deliveryDays > 0 ? $deliveryDate : 'No delivery date available' }}
                                        </span>
                                    </span>
                                </div>
                            @endif
                            <p>Seller : {{ $savedItem->deal->shop->email }}</p>
                            <div>
                                <span style="text-decoration: line-through; color:#c7c7c7">
                                ₹{{ $savedItem->deal->original_price }}
                                </span>
                                <span class="ms-1" style="font-size:22px;color:#ff0060">
                                ₹{{ $savedItem->deal->discounted_price }}
                                </span>
                                <span class="ms-1" style="font-size:12px; color:#00DD21">
                                    {{ round($savedItem->deal->discount_percentage) }}% off
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex flex-column justify-content-end align-items-end mb-3">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <form action="{{ route('movetocart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $savedItem->deal_id }}">
                                    <button type="submit" class="btn border btn-outline-secondary"
                                        style="padding: 14px 20px; border-top-right-radius: 0px; border-bottom-right-radius: 0px;">
                                        Move to Cart
                                    </button>
                                </form>
                                <form action="{{ route('savelater.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $savedItem->deal_id }}">
                                    <button type="submit" class="btn border btn-outline-secondary"
                                        style="padding: 14px 20px; border-top-left-radius: 0px; border-bottom-left-radius: 0px;">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                        <hr class="mt-3">
                    </div>
                @endforeach
            @endif
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const orderNowButton = document.querySelector('.btn[href*="/cartSummary"]');

            orderNowButton.addEventListener('click', (event) => {
                let valid = true;
                let firstInvalidField = null;
                const currentDate = new Date();
                const currentHours = currentDate.getHours();
                const currentMinutes = currentDate.getMinutes();

                const serviceDateField = document.querySelector('.service-date');
                const serviceTimeField = document.querySelector('.service-time');

                document.querySelectorAll('.error-message').forEach(error => error.remove());

                if (!serviceDateField.value) {
                    valid = false;
                    displayError(serviceDateField, 'Service Date is required');
                    if (!firstInvalidField) firstInvalidField = serviceDateField;
                }

                if (!serviceTimeField.value) {
                    valid = false;
                    displayError(serviceTimeField, 'Service Time is required');
                    if (!firstInvalidField) firstInvalidField = serviceTimeField;
                } else if (serviceDateField.value) {
                    const selectedDate = new Date(serviceDateField.value);
                    if (selectedDate.toDateString() === currentDate.toDateString()) {
                        const [inputHours, inputMinutes] = serviceTimeField.value.split(':').map(Number);
                        if (inputHours < currentHours || (inputHours === currentHours && inputMinutes <
                                currentMinutes)) {
                            valid = false;
                            displayError(serviceTimeField, 'Time must be in the future');
                            if (!firstInvalidField) firstInvalidField = serviceTimeField;
                        }
                    }
                }

                if (!valid) {
                    event.preventDefault();
                    if (firstInvalidField) firstInvalidField.focus();
                } else {
                    const cartId = serviceDateField.getAttribute('data-cart-id');
                    const productId = serviceDateField.getAttribute('data-product-id');
                    const serviceDate = serviceDateField.value;
                    const serviceTime = serviceTimeField.value;

                    updateCart(cartId, productId, null, serviceDate, serviceTime);
                }
            });

            function removeErrorMessage(event) {
                const field = event.target;
                const error = field.nextElementSibling;
                if (error && error.classList.contains('error-message')) {
                    error.remove();
                }
            }

            const serviceDateField = document.querySelector('.service-date');
            const serviceTimeField = document.querySelector('.service-time');

            serviceDateField.addEventListener('input', removeErrorMessage);
            serviceTimeField.addEventListener('input', removeErrorMessage);

            function displayError(field, message) {
                const fieldContainer = field.closest('.d-flex');
                const errorMessage = document.createElement('span');
                errorMessage.textContent = message;
                errorMessage.style.color = 'red';
                errorMessage.style.fontSize = '12px';
                errorMessage.classList.add('error-message');
                fieldContainer.appendChild(errorMessage);
            }
        });

        document.querySelectorAll('.decrease-btn, .increase-btn').forEach((btn) => {
            btn.addEventListener('click', function() {
                const cartId = this.getAttribute('data-cart-id');
                const productId = this.getAttribute('data-product-id');
                const quantityInput = this.parentElement.querySelector('.quantity-input');
                let quantity = parseInt(quantityInput.value);
                if (this.classList.contains('decrease-btn') && quantity > 1) quantity -= 1;
                else if (this.classList.contains('increase-btn')) quantity += 1;
                quantityInput.value = quantity;
                updateCart(cartId, productId, quantity);
            });
        });
        document.querySelectorAll('.service-date, .service-time').forEach((input) => {
            input.addEventListener('change', function() {
                const cartId = this.getAttribute('data-cart-id');
                const productId = this.getAttribute('data-product-id');
                const serviceDate = document.querySelector(`.service-date[data-product-id="${productId}"]`)
                    .value;
                const serviceTime = document.querySelector(`.service-time[data-product-id="${productId}"]`)
                    .value;
                updateCart(cartId, productId, null, serviceDate, serviceTime);
            });
        });

        function updateCart(cartId, productId, quantity, serviceDate = null, serviceTime = null) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const data = {
                cart_id: cartId,
                product_id: productId,
                quantity: quantity,
                service_date: serviceDate,
                service_time: serviceTime,
                _token: csrfToken,
            };
            fetch("{{ route('cart.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'success') {
                        document.querySelectorAll('.quantity-value').forEach((element) => {
                            element.textContent = data.updatedCart.quantity;
                        });
                        document.querySelector('.subtotal').textContent = `$${data.updatedCart.subtotal.toFixed(2)}`;
                        document.querySelector('.discount').textContent = `$${data.updatedCart.discount.toFixed(2)}`;
                        document.querySelector('.total').textContent = `$${data.updatedCart.grand_total.toFixed(2)}`;
                    } else {
                        alert(data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error updating cart:', error);
                });
        }
    </script>
@endsection
