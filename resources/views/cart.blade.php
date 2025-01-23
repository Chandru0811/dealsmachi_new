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
                    <img src="{{ asset('assets/images/home/cart_empty.webp') }}" alt="Empty Cart"
                        class="img-fluid empty_cart_img">
                    <p class="pt-5" style="color: #ff0060;font-size: 22px">Your Cart is Currently Empty</p>
                    <p class="" style="color: #6C6C6C;font-size: 16px">Looks Like You Have Not Added Anything To </br>
                        Your Cart. Go Ahead & Explore Top Categories.</p>
                    <a href="/" class="btn showmoreBtn mt-2">Shop More</a>
                </div>
            @else
                @foreach ($carts as $cart)
                    <div class="d-flex justify-content-between mb-3">
                        <h5>Your Cart <span style="color: #ff0060"> ({{ $cart->items->count() }})</span></h5>
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
                                        $image = isset($product->productMedia)
                                            ? $product->productMedia->where('order', 1)->where('type', 'image')->first()
                                            : null;
                                    @endphp
                                    <img src="{{ $image ? asset($image->path) : asset('assets/images/home/noImage.webp') }}"
                                        style="max-width: 100%; max-height: 100%;" alt="{{ $product->name }}" />
                                </div>
                            </div>
                            <div class="col-md-8">
                                <a href="{{ url(path: '/deal/' . $product->id) }}" style="color: #000;"
                                    onclick="clickCount('{{ $product->id }}')">
                                    <p style="font-size: 18px;">
                                        {{ $product->name }}
                                    </p>
                                </a>
                                <p class="truncated-description" style="font-size: 16px">
                                    {{ $product->description }}</p>
                                {{-- @if ($product->deal_type == 1)
                                    <div class="rating my-2">
                                        <span>Delivery Date :</span><span class="stars">
                                            <span>
                                                {{ $deliveryDays > 0 ? $deliveryDate : 'No delivery date available' }}
                                            </span>
                                        </span>
                                    </div>
                                @endif --}}
                                <p style="color: #AAAAAA;font-size:14px;">Seller :
                                    {{ $product->shop->legal_name ?? '' }}</p>
                                <div class="d-flex">
                                    <div class="my-4">
                                        <img src="{{ asset('assets/images/home/delivery_icon.webp') }}" alt="icon"
                                            class="img-fluid" />
                                    </div> &nbsp;&nbsp;
                                    <div class="my-4">
                                        <p style="font-size: 16px;">
                                            Delivery Date :
                                            @if ($product->deal_type == 0)
                                                {{ $deliveryDays > 0 ? $deliveryDate : 'No delivery date available' }}
                                            @else
                                                No delivery date available
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <span style="font-size:15px;text-decoration: line-through; color:#c7c7c7">
                                        ₹{{ number_format($product->original_price, 0) }}
                                    </span>
                                    <span class="ms-1" style="font-size:18px;font-weight:500;color:#ff0060">
                                        ₹{{ number_format($product->discounted_price, 0) }}
                                    </span>
                                    <span class="ms-1" style="font-size:18px;font-weight:500; color:#28A745">
                                        {{ round($product->discount_percentage) }}% Off
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center">
                            <div class="col-md-6">
                                @if ($product->deal_type === 2)
                                    <div class="d-flex align-items-start my-3">
                                        {{-- <div class="d-flex flex-column me-3" style="width: 30%;">
                        <label for="service_date" class="form-label">Service Date</label>
                        <input type="date" id="service_date" name="service_date"
                            class="form-control form-control-sm service-date"
                            value="{{ $item->service_date }}" data-cart-id="{{ $cart->id }}"
                            data-product-id="{{ $product->id }}" min="{{ date('Y-m-d') }}">
                    </div> --}}
                                        <div class="d-flex flex-column me-3" style="width: 30%;">
                                            <label for="service_date" class="form-label">Service Date</label>
                                            <input type="date" id="service_date" name="service_date"
                                                class="form-control form-control-sm service-date"
                                                data-cart-id="{{ $cart->id }}" data-product-id="{{ $product->id }}">
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
                                        <button class="btn rounded btn-sm decrease-btn" data-cart-id="{{ $cart->id }}"
                                            data-product-id="{{ $product->id }}">-</button>
                                        <input type="text"
                                            class="form-control form-control-sm mx-2 text-center quantity-input"
                                            style="width: 50px;background-color:#F9F9F9;border-radius:2px"
                                            value="{{ $item->quantity }}" readonly>
                                        <button class="btn rounded btn-sm increase-btn"
                                            data-cart-id="{{ $cart->id }}"
                                            data-product-id="{{ $product->id }}">+</button>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 d-flex justify-content-md-end">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form action="{{ route('savelater.add') }}" method="POST"
                                        onsubmit="showLoader(this)">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <img src="{{ asset('assets/images/home/solar_pin-list.webp') }}"
                                                    alt="icon" class="img-fluid" />
                                            </div>
                                            <div>
                                                <button type="submit" class="btn save-for-later-btn"
                                                    style="color: #ff0060;border: none">
                                                    <span class="loader spinner-border spinner-border-sm"
                                                        style="display: none;"></span>
                                                    Save For Later
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    &nbsp;&nbsp;
                                    <form action="{{ route('cart.remove') }}" method="POST"
                                        onsubmit="showLoader(this)">
                                        @csrf
                                        <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="d-flex align-items-center cancel-btn">
                                            <div>
                                                <img src="{{ asset('assets/images/home/trash_Icons.webp') }}"
                                                    alt="icon" class="img-fluid" />
                                            </div>
                                            <div>
                                                <button type="submit" class="btn"
                                                    style="color: #ff0060;border: none">
                                                    <span class="loader spinner-border spinner-border-sm me-2"
                                                        style="display: none"></span>
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="card mb-4 order_summary_card p-3">
                        <div class="card-header m-0 py-3" style="background: #fff">
                            <p class="mb-0" style="font-size:20px;font-weight:400">Order Summary</p>
                        </div>
                        <div class="card-body m-0 p-4 order-summary">
                            <div class="d-flex justify-content-between align-items-center">
                                <p style="color: #AAAAAA;font-size:16px">Subtotal (x<span
                                        class="quantity-value">{{ $cart->quantity }}</span>)</p>
                                <p class="subtotal">₹{{ number_format($subtotal, 0) }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center" style="color: #28A745;">
                                <p style="font-size:16px">Discount (x<span
                                        class="quantity-value">{{ $cart->quantity }}</span>)</p>
                                <p class="discount">₹{{ number_format($total_discount, 0) }}</p>
                            </div>
                            <!-- <hr />
                            <div class="d-flex justify-content-between pb-3">
                                <span>Total (x<span class="quantity-value">{{ $cart->quantity }}</span>)</span>
                                <span class="total">${{ number_format($subtotal - $total_discount, 0) }}</span>
                            </div> -->
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-3 mt-4"
                        style="position: sticky; bottom: 0px; background: #fff;border-top: 1px solid #dcdcdc">
                        <div class="d-flex justify-content-end align-items-center">
                            <h4>
                                Total Amount (x<span class="quantity-value">{{ $cart->quantity }}</span>)&nbsp;&nbsp;
                                <span style="text-decoration: line-through; color:#c7c7c7" class="subtotal">
                                    ₹{{ number_format($subtotal, 0) }}
                                </span>
                                &nbsp;&nbsp;
                                <span class="total ms-1" style="color:#000">
                                    ₹{{ number_format($subtotal - $total_discount, 0) }}
                                </span>
                                &nbsp;&nbsp;
                                <span class="ms-1" style="font-size:12px; color:#28A745; white-space: nowrap;">
                                    Dealsmachi Discount
                                    &nbsp;<span class="discount">₹{{ number_format($total_discount, 0) }}</span>
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
            <div class="d-flex">
                <div class="my-4"> <img src="{{ asset('assets/images/home/solar_pin-list.webp') }}" alt="icon"
                        class="img-fluid" />
                </div> &nbsp;&nbsp;
                <div class="my-4">
                    <p style="font-size:20px;font-weight:400">Saved For Later</p>
                </div>
            </div>
            @if ($savedItems->isEmpty())
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/images/home/empty_savedItems.png') }}" alt="Empty Cart"
                        class="img-fluid mb-2" style="width: 300px;" />
                    <h4 style="color: #ff0060;">Your Saved Wishlists are awaiting your selection!</h4>
                </div>
            @else
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
                                    $image = isset($savedItem->deal->productMedia)
                                        ? $savedItem->deal->productMedia
                                            ->where('order', 1)
                                            ->where('type', 'image')
                                            ->first()
                                        : null;
                                @endphp
                                <img src="{{ $image ? asset($image->path) : asset('assets/images/home/noImage.webp') }}"
                                    style="max-width: 100%; max-height: 100%;" alt="{{ $savedItem->deal->name }}" />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <a href="{{ url(path: '/deal/' . $savedItem->deal->id ) }}" style="color: #000;"
                                onclick="clickCount('{{ $savedItem->deal->id }}')">
                                <p style="font-size: 18px;font-weight:500">
                                    {{ $savedItem->deal->name }}
                                </p>
                            </a>
                            <p class="truncated-description" style="font-size: 16px">
                                {{ $savedItem->deal->description }}</p>
                            @if ($savedItem->deal->deal_type == 1)
                                <div class="rating my-2">
                                    <span>Delivery Date :</span><span class="stars">
                                        <span>
                                            {{ $deliveryDays > 0 ? $deliveryDate : 'No delivery date available' }}
                                        </span>
                                    </span>
                                </div>
                            @endif
                            <p style="color: #AAAAAA;font-size:14px;">Seller :
                                {{ $savedItem->deal->shop->legal_name }}</p>

                            <div></div>
                            <div>
                                <span style="font-size:15px;text-decoration: line-through; color:#c7c7c7">
                                    ₹{{ number_format($savedItem->deal->original_price, 0) }}
                                </span>
                                <span class="ms-1" style="font-size:18px;font-weight:500;color:#ff0060">
                                    ₹{{ number_format($savedItem->deal->discounted_price, 0) }}
                                </span>
                                <span class="ms-1" style="font-size:18px;font-weight:500; color:#28A745">
                                    {{ round($savedItem->deal->discount_percentage) }}% Off
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex flex-column justify-content-end align-items-end mb-3">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <form action="{{ route('savelater.remove') }}" method="POST"
                                    onsubmit="showLoader(this)">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $savedItem->deal_id }}">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <img src="{{ asset('assets/images/home/trash_Icons.webp') }}" alt="icon"
                                                class="img-fluid" width="20" height="20" />
                                        </div>
                                        <div>
                                            <button type="submit" class="btn remove-cart-btn"
                                                style="color: #ff0060;border: none">
                                                <span class="loader spinner-border spinner-border-sm"
                                                    style="display: none"></span>
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <form action="{{ route('movetocart') }}" method="POST" onsubmit="showLoader(this)">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $savedItem->deal_id }}">
                                    <div class="d-flex align-items-center cancel-btn">
                                        <div>
                                            <img src="{{ asset('assets/images/home/delivery_icon.webp') }}"
                                                alt="icon" class="img-fluid" />
                                        </div>
                                        <div>
                                            <button type="submit" class="btn" style="color: #ff0060;border: none">
                                                <span class="loader spinner-border spinner-border-sm me-2"
                                                    style="display: none"></span>
                                                Move to Cart
                                            </button>
                                        </div>
                                    </div>
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

                // Clear existing error messages
                document.querySelectorAll('.error-message').forEach(error => error.remove());

                // Loop through all products with deal_type = 2
                document.querySelectorAll('.service-date').forEach((serviceDateField) => {
                    const productId = serviceDateField.getAttribute('data-product-id');
                    const serviceTimeField = document.querySelector(
                        `.service-time[data-product-id="${productId}"]`);

                    // Validate service date
                    if (!serviceDateField.value) {
                        valid = false;
                        displayError(serviceDateField, 'Service Date is required');
                        if (!firstInvalidField) firstInvalidField = serviceDateField;
                    }

                    // Validate service time
                    if (!serviceTimeField.value) {
                        valid = false;
                        displayError(serviceTimeField, 'Service Time is required');
                        if (!firstInvalidField) firstInvalidField = serviceTimeField;
                    } else if (serviceDateField.value) {
                        const selectedDate = new Date(serviceDateField.value);
                        if (selectedDate.toDateString() === currentDate.toDateString()) {
                            const [inputHours, inputMinutes] = serviceTimeField.value.split(':')
                                .map(Number);
                            if (inputHours < currentHours || (inputHours === currentHours &&
                                    inputMinutes < currentMinutes)) {
                                valid = false;
                                displayError(serviceTimeField,
                                    'Service Time must be in the future');
                                if (!firstInvalidField) firstInvalidField = serviceTimeField;
                            }
                        }
                    }
                });

                if (!valid) {
                    event.preventDefault();
                    if (firstInvalidField) firstInvalidField.focus();
                } else {
                    // Update cart for all valid service dates and times
                    document.querySelectorAll('.service-date').forEach((serviceDateField) => {
                        const cartId = serviceDateField.getAttribute('data-cart-id');
                        const productId = serviceDateField.getAttribute('data-product-id');
                        const serviceDate = serviceDateField.value;
                        const serviceTime = document.querySelector(
                            `.service-time[data-product-id="${productId}"]`).value;

                        updateCart(cartId, productId, null, serviceDate, serviceTime);
                    });
                }
            });

            // Function to remove error messages when input changes
            document.querySelectorAll('.service-date, .service-time').forEach((input) => {
                input.addEventListener('input', function() {
                    const error = this.closest('.d-flex').querySelector('.error-message');
                    if (error) error.remove();
                });
            });

            // Function to display error messages
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
                        document.querySelectorAll('.subtotal').forEach((element) => {
                            element.textContent = `₹${data.updatedCart.subtotal.toFixed(0)}`;
                        });
                        document.querySelectorAll('.discount').forEach((element) => {
                            element.textContent = `₹${data.updatedCart.discount.toFixed(0)}`;
                        });
                        document.querySelectorAll('.total').forEach((element) => {
                            element.textContent = `₹${data.updatedCart.grand_total.toFixed(0)}`;
                        });
                    } else {
                        alert(data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error updating cart:', error);
                });
        }

        function showLoader(form) {
            const button = form.querySelector('button[type="submit"]');
            button.disabled = true;
        }
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
