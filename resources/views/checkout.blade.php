@extends('layouts.master')

@section('content')
<section>
    <div class="container" style="margin-top: 100px;">
        <h2 class="text-center">Checkout</h2>
        <form id="checkoutForm" action="{{ route('checkout.checkout') }}" method="POST" data-deal-type="{{ $product->deal_type }}">
            @csrf
            <!-- Hidden Fields -->
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="order_type" id="order_type" value="{{ $product->deal_type == 1 ? 'Product' : ($product->deal_type == 2 ? 'Service' : '') }}">
            <input type="hidden" name="total" id="total" value="{{ $product->discounted_price }}">
            <div class="row my-5">
                <div class="col-md-7 col-12">
                    <div class="card p-3">
                        <!-- Customer Info Section -->
                        <div class="row">
                            <h5 class="mb-4" style="color: #ff0060;">Customer Info</h5>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" required />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" required />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" name="mobile" id="mobile" required />
                            </div>
                            @if($product->deal_type == 1)
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Quantity</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary" id="decreaseQuantity">-</button>
                                    <input type="number" class="form-control text-center" name="quantity" id="quantity" value="1" required />
                                    <button type="button" class="btn btn-outline-secondary" id="increaseQuantity">+</button>
                                </div>
                            </div>
                            @elseif($product->deal_type == 2)
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Service Date</label>
                                <input type="date" class="form-control" name="service_date" id="service_date" />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Service Time</label>
                                <input type="time" class="form-control" name="service_time" id="service_time" />
                            </div>
                            @endif
                        </div>
                        <!-- Billing Address Section -->
                        <div class="row" id="billingAddress">
                            <h5 class="py-3" style="color: #ff0060;">Billing Address</h5>
                            <div class="col-12 mb-3">
                                <label class="form-label">Street</label>
                                <input type="text" class="form-control" name="billing_street" id="billing_street" required />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="billing_city" id="billing_city" required />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" class="form-control" name="billing_state" id="billing_state" required />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" name="billing_country" id="billing_country" required />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Zip Code</label>
                                <input type="text" class="form-control" name="billing_zipCode" id="billing_zipCode" required />
                            </div>
                        </div>
                        <!-- "Same as Shipping Address" Checkbox -->
                        <div class="col-12 mb-3 mt-1">
                            <input type="checkbox" class="form-check-input me-2" id="sameAsShipping" value="true" checked>
                            <label class="form-label" for="sameAsShipping">Same as Shipping Address</label>
                        </div>
                        <!-- Shipping Address Section -->
                        <div id="shippingAddress" style="display: none;">
                            <h5 class="mt-1 mb-3" style="color: #ff0060;">Shipping Address</h5>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Street</label>
                                    <input type="text" class="form-control" name="shipping_street" id="shipping_street" required />
                                </div>
                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="shipping_city" id="shipping_city" required />
                                </div>
                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control" name="shipping_state" id="shipping_state" required />
                                </div>
                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label">Country</label>
                                    <input type="text" class="form-control" name="shipping_country" id="shipping_country" required />
                                </div>
                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label">Zip Code</label>
                                    <input type="text" class="form-control" name="shipping_zipCode" id="shipping_zipCode" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3 mt-1">
                            <label class="form-label">Customer Note</label>
                            <textarea rows="4" class="form-control" name="notes" id="notes"></textarea>
                        </div>
                        <div>
                            <h5 style="color: #ff0060;">Payment Methods</h5>
                            <div class="row justify-content-center mt-3">
                                <div class="col-lg-5 col-10 mb-3">
                                    <div class="card payment-option" onclick="selectPaymentOption('cash_on_delivery')">
                                        <div class="d-flex align-items-center p-3 w-100">
                                            <input type="radio" name="payment_type" id="cash_on_delivery" value="cash_on_delivery" class="form-check-input">
                                            <label for="cash_on_delivery" class="d-flex align-items-center m-0">
                                                <img src="{{ asset('assets/images/home/cash_payment.png') }}" alt="Cash on Delivery" class="mx-3" style="width: 24px; height: auto;">
                                                <span>Cash on Delivery</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-10">
                                    <div class="card payment-option" onclick="selectPaymentOption('online_payment')">
                                        <div class="d-flex align-items-center p-3 w-100">
                                            <input type="radio" name="payment_type" id="online_payment" value="online_payment" class="form-check-input">
                                            <label for="online_payment" class="d-flex align-items-center m-0">
                                                <img src="{{ asset('assets/images/home/online_banking.png') }}" alt="Online Payment" class="mx-3" style="width: 24px; height: auto;">
                                                <span>Online Payment</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product Info Section -->
                <div class="col-md-5 col-12">
                    <div class="card p-3">
                        <h5 style="color: #ff0060;">Product Info</h5>
                        <div>
                            <img src="{{ asset($product->image_url1) }}" alt="Product Name" class="img-fluid px-5 py-3">
                            <h5 class="text-center">{{ $product->name }}</h5>
                            <div class="d-flex justify-content-center align-items-center">
                                <p style="text-decoration: line-through; color: gray;">₹{{ $product->original_price }}</p>&nbsp;&nbsp;
                                <p style="color: #ff0060; font-size: 24px;">₹{{ $product->discounted_price }}</p>
                            </div>
                            <hr />
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p>Subtotal</p>
                                    <p>Discount</p>
                                </div>
                                <div>
                                    <p id="subtotal">₹{{ $product->original_price }}</p>
                                    <p id="discount">₹{{ number_format($product->original_price - $product->discounted_price, 2) }}</p>
                                </div>
                            </div>
                            <hr class="mt-1" />
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Total</p>
                                <p class="mb-0" id="total" style="color: #ff0060; font-size: 24px;">₹{{ $product->discounted_price }}</p>
                            </div>
                            <p style="color: #b12704">Your Savings : <span id="savings">₹{{ number_format($product->original_price - $product->discounted_price, 2) }}</span> ({{ number_format($product->discount_percentage, 0) }}%)</p>
                            <div class="input-group mb-4">
                                <input type="text" class="form-control" placeholder="Enter a coupon code" value="{{ $product->coupon_code }}">
                                <button class="btn applyBtn" type="button" id="button-addon2">Apply</button>
                            </div>
                            <button type="submit" class="btn applyBtn w-100">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
    document.getElementById('sameAsShipping').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('shippingAddress').style.display = 'none';
            document.getElementById('billing_street').value = document.getElementById('shipping_street').value;
            document.getElementById('billing_city').value = document.getElementById('shipping_city').value;
            document.getElementById('billing_state').value = document.getElementById('shipping_state').value;
            document.getElementById('billing_country').value = document.getElementById('shipping_country').value;
            document.getElementById('billing_zipCode').value = document.getElementById('shipping_zipCode').value;
        } else {
            document.getElementById('shippingAddress').style.display = 'block';
            document.getElementById('billing_street').value = '';
            document.getElementById('billing_city').value = '';
            document.getElementById('billing_state').value = '';
            document.getElementById('billing_country').value = '';
            document.getElementById('billing_zipCode').value = '';
        }
    });
    document.getElementById('sameAsShipping').dispatchEvent(new Event('change'));

    const productOriginalPrice = @json($product -> original_price);
    const productDiscountedPrice = @json($product -> discounted_price);

    const quantityInput = document.getElementById('quantity');
    const decreaseButton = document.getElementById('decreaseQuantity');
    const increaseButton = document.getElementById('increaseQuantity');

    const subtotalElement = document.querySelector('#subtotal');
    const discountElement = document.querySelector('#discount');
    const totalElement = document.querySelector('#total');
    const savingsElement = document.querySelector('#savings');

    function updateValues() {
        const quantity = parseInt(quantityInput.value);

        const subtotal = quantity * productOriginalPrice;
        const discount = quantity * productOriginalPrice - quantity * productDiscountedPrice;
        const total = subtotal - discount;
        const savings = discount;

        subtotalElement.textContent = `₹${subtotal.toFixed(2)}`;
        discountElement.textContent = `₹${discount.toFixed(2)}`;
        totalElement.textContent = `₹${total.toFixed(2)}`;
        savingsElement.textContent = `₹${savings.toFixed(2)}`;
    }

    updateValues();

    decreaseButton.addEventListener('click', () => {
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity > 1) {
            quantityInput.value = currentQuantity - 1;
            updateValues();
        }
    });

    increaseButton.addEventListener('click', () => {
        let currentQuantity = parseInt(quantityInput.value);
        quantityInput.value = currentQuantity + 1;
        updateValues();
    });

    quantityInput.addEventListener('change', () => {
        let currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity < 1) {
            currentQuantity = 1;
            quantityInput.value = currentQuantity;
        }
        updateValues();
    });
</script>
@endsection