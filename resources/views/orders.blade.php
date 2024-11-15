@extends('layouts.master')

@section('content')
    <div class="container categoryIcons p-3">
        <h3 class="mb-3" style="color: #ff0060">My Orders</h3>
        <a class="text-decoration-none " href="{{ url('orderView') }}">
            <div class="card p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <p>Order Id : <span>DEALSMACHI_03</span>&nbsp;
                        <span class="badge_payment">order status</span>&nbsp;
                        <span class="badge_warning">Coupon code</span>
                    </p>
                    <p>Date : <span>15/11/2024</span></p>
                </div>
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex">
                        <img src="{{ asset('images/products/cloflix-solid-men-round-neck-yellow-t-shirt.jpg') }}" />
                        <div>
                            <p class="mb-1">Product Name : <span>CLOFLIX Solid Men Round Neck Yellow T-Shirt</span></p>
                            <p class="mb-1">Description : <span>CLOFLIX Solid Men Round Neck Yellow T-Shirt CLOFLIX Solid
                                    Men
                                    Round Neck Yellow T-Shirt CLOFLIX Solid Men Round Neck Yellow T-Shirt</span></p>
                            <p>
                                <del>₹499</del> &nbsp;
                                <span style="color: #ff0060; font-size:24px">₹249</span> &nbsp;
                                <span class="badge_payment">29% saved</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <span class="badge_warning">Payment Status</span>
                </div>
            </div>
        </a>
        <a class="text-decoration-none " href="{{ url('orderView') }}">
            <div class="card p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <p>Order Id : <span>DEALSMACHI_03</span>&nbsp;
                        <span class="badge_payment">order status</span>&nbsp;
                        <span class="badge_warning">Coupon code</span>
                    </p>
                    <p>Date : <span>15/11/2024</span></p>
                </div>
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex">
                        <img src="{{ asset('images/products/cloflix-solid-men-round-neck-yellow-t-shirt.jpg') }}" />
                        <div>
                            <p class="mb-1">Product Name : <span>CLOFLIX Solid Men Round Neck Yellow T-Shirt</span></p>
                            <p class="mb-1">Description : <span>CLOFLIX Solid Men Round Neck Yellow T-Shirt CLOFLIX Solid
                                    Men
                                    Round Neck Yellow T-Shirt CLOFLIX Solid Men Round Neck Yellow T-Shirt</span></p>
                            <p>
                                <del>₹499</del> &nbsp;
                                <span style="color: #ff0060; font-size:24px">₹249</span> &nbsp;
                                <span class="badge_payment">29% saved</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <span class="badge_warning">Payment Status</span>
                </div>
            </div>
        </a>


    </div>
@endsection
