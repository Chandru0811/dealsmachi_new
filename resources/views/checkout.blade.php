@extends('layouts.master')

@section('content')
<section>
    <div class="container" style="margin-top: 100px;">
        <h2 class="text-center">Checkout</h2>
        <div class="row my-5">
            <div class="col-md-7 col-12">
                <div class="card p-3">
                    <div>
                        <h5 style="color: #ff0060;">Customer Info</h5>
                        <div class="row mt-4">
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" />
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label"></label>City
                                <input type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" />
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label">Zip Code</label>
                                <input type="text" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h5 style="color: #ff0060;">Payment Methods</h5>
                        <div class="row py-3">
                            <div class="col-5">
                                <div class="card payment-option" onclick="selectPaymentOption('cash_on_delivery')">
                                    <div class="d-flex align-items-center p-3 w-100">
                                        <input type="radio" name="payment_method" id="cash_on_delivery" value="cash_on_delivery" class="form-check-input">
                                        <label for="cash_on_delivery" class="d-flex align-items-center m-0">
                                            <img src="{{ asset('assets/images/home/cash_payment.png') }}" alt="Cash on Delivery" class="mx-3" style="width: 24px; height: auto;">
                                            <span>Cash on Delivery</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="offset-1 col-5">
                                <div class="card payment-option" onclick="selectPaymentOption('online_payment')">
                                    <div class="d-flex align-items-center p-3 w-100">
                                        <input type="radio" name="payment_method" id="online_payment" value="online_payment" class="form-check-input">
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
            <div class="col-md-5 col-12">
                <div class="card p-3">
                    <h5 style="color: #ff0060;">Product Info</h5>
                    <div>
                        <img src="{{ asset('assets/images/home/beauty2.webp') }}" alt="Product Name" class="img-fluid px-5 py-3">
                        <h5 class="text-center">Beauty Spa</h5>
                        <div class="d-flex justify-content-center align-items-center">
                            <p style="text-decoration: line-through; color: gray;">₹99.00</p>&nbsp;&nbsp;
                            <p style="color: #ff0060; font-size: 24px;">₹89.00</p>
                        </div>
                        <hr />
                        <div class="d-flex justify-content-between">
                            <div>
                                <p>Subtotal</p>
                                <p>Discount</p>
                                <p>Delivery</p>
                            </div>
                            <div>
                                <p>₹89.00</p>
                                <p>₹0.00</p>
                                <p>₹0.00</p>
                            </div>
                        </div>
                        <hr class="mt-1" />
                        <div class="d-flex justify-content-between">
                            <p class="mb-0">Total</p>
                            <p class="mb-0" style="color: #ff0060; font-size: 24px;">₹89.00</p>
                        </div>
                        <p style="color: #b12704">Your Savings : ₹10.00 (10%)</p>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Enter a coupon code" >
                            <button class="btn applyBtn" type="button" id="button-addon2">Apply</button>
                        </div>
                        <button type="submit" class="btn applyBtn w-100">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection