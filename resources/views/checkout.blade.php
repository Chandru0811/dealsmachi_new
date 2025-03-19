@extends('layouts.master')
@php
use Carbon\Carbon;
function formatIndianCurrency($num) {
    $num = intval($num);
    $lastThree = substr($num, -3);
    $rest = substr($num, 0, -3);
    if ($rest != '') {
        $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest) . ',';
    }
    return "₹" . $rest . $lastThree;
}
@endphp

@section('content')
    @if ($orderoption == 'buynow')
        <section>
            @if (session('status'))
                <div class="alert alert-dismissible fade show toast-success" role="alert"
                    style="position: fixed; top: 70px; right: 40px; z-index: 1050;">
                    <div class="toast-content">
                        <div class="toast-icon">
                            <i class="fa-solid fa-check-circle" style="color: #16A34A"></i>
                        </div>
                        <span class="toast-text"> {!! nl2br(e(session('status'))) !!}</span>&nbsp;&nbsp;
                        <button class="toast-close-btn"data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa-thin fa-xmark" style="color: #16A34A"></i>
                        </button>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert  alert-dismissible fade show toast-danger" role="alert"
                    style="position: fixed; top: 70px; right: 40px; z-index: 1050;">
                    <div class="toast-content">
                        <div class="toast-icon">
                            <i class="fa-solid fa-triangle-exclamation" style="color: #EF4444"></i>
                        </div>
                        <span class="toast-text">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </span>&nbsp;&nbsp;
                        <button class="toast-close-btn"data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa-solid fa-xmark" style="color: #EF4444"></i>
                        </button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="alert  alert-dismissible fade show toast-danger" role="alert"
                    style="position: fixed; top: 70px; right: 40px; z-index: 1050;">
                    <div class="toast-content">
                        <div class="toast-icon">
                            <i class="fa-solid fa-triangle-exclamation" style="color: #EF4444"></i>
                        </div>
                        <span class="toast-text">
                            {{ session('error') }}
                        </span>&nbsp;&nbsp;
                        <button class="toast-close-btn"data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa-solid fa-xmark" style="color: #EF4444"></i>
                        </button>
                    </div>
                </div>
            @endif
            <div class="container" style="margin-top: 100px;">
                <!-- <h2 class="text-center">Checkout</h2> -->
               
                    <div class="row my-5">
                        <div class="col-12">

                            {{-- Saved Address --}}
                            <div class="card p-3 mb-3">
                                <h5 class="mb-4 p-0">Delivery Addresses</h5>

                                <div class="row">
                                    <div class="col-md-12">
                                        {{-- @php
                                            $orderAddress = $order ? json_decode($order->delivery_address, true) : [];
                                        @endphp --}}
                                        <p style="color: #6C6C6C">
                                            {{ $address->first_name ?? '' }}
                                            {{ $address->last_name ?? '' }} (+91)
                                            {{ $address->phone ?? '' }}&nbsp;&nbsp;
                                            {{ $address->address ?? '' }},
                                            {{ $address->city ?? '' }},
                                            {{ $address->state ?? '' }}
                                            - {{ $address->postalcode ?? '' }}
                                            {{-- <span>
                                                <span class="badge badge_infos py-1" data-bs-toggle="modal"
                                                    data-bs-target="#myAddressModal">Change</span>
                                            </span> --}}
                                        </p>
                                    </div>
                                </div>
                            </div>


                            <!-- Order Summary -->
                            <div class="card p-3 mb-3">
                                <div class="row">
                                    <h5 class="mb-4" style="color:#ff0060;">Order Summary</h5>
                                    @foreach ($cart->items as $item)
                                        <div class="col-md-6 col-12">
                                            @if ($item->deal_type == 1)
                                                <p>{{ $item->product->name }}<span class="text-muted">
                                                        (x{{ $item->quantity }})
                                                    </span></p>
                                            @else
                                                <p>{{ $item->product->name }}<span class="text-muted"> (Service) </span>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-12 checkoutsummary-card2 text-end">
                                            <span style="text-decoration: line-through; color:#c7c7c7">
                                                {{-- ₹{{ number_format($item->product->original_price * $item->quantity, 0) }} --}}
                                                {{ formatIndianCurrency($item->product->original_price * $item->quantity) }}
                                            </span>
                                            <span class="ms-1" style="font-size:22px;color:#ff0060">
                                                {{-- ₹{{ number_format($item->product->discounted_price * $item->quantity, 0) }} --}}
                                                {{ formatIndianCurrency($item->product->discounted_price * $item->quantity) }}
                                            </span>
                                            <span class="ms-1" style="font-size:12px; color:#00DD21">
                                                {{-- ({{ number_format($item->product->discount_percentage, 0) }}%) --}}
                                                {{ formatIndianCurrency($item->product->discount_percentage) }}%
                                                off
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Payment Methods -->
                            <div class="card p-3 mb-3">
                                <div>
                                    <h5 style="color:#ff0060;">Payment Methods</h5>
                                    <div class="row justify-content-center mt-3">
                                        <div class="col-lg-5 col-10 mb-3">
                                            <div class="card payment-option">
                                                <div class="d-flex align-items-center  w-100">
                                                    <input type="radio" name="payment_type" id="cash_on_delivery"
                                                        value="cash_on_delivery" class="form-check-input m-3"
                                                        {{ old('payment_type') == 'cash_on_delivery' ? 'checked' : '' }}>
                                                    <label for="cash_on_delivery" class="d-flex align-items-center m-0 py-3" style="width: 100%;">
                                                        <img src="{{ asset('assets/images/home/cash_payment.png') }}"
                                                            alt="Cash on Delivery" class="mx-3"
                                                            style="width: 24px; height: auto;">
                                                        <span>Cash on Delivery</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-10">
                                             <div class="card payment-option">
                                                                                        <div class="d-flex align-items-center w-100">
                                                                                            <input type="radio" name="payment_type" id="online_payment"
                                                                                                value="online_payment" class="form-check-input m-3"
                                                                                                {{ old('payment_type') == 'online_payment' ? 'checked' : '' }}>
                                                                                            <label for="online_payment" class="d-flex align-items-center m-0 py-3" style="width: 100%;>
                                                                                                <img src="{{ asset('assets/images/home/online_banking.png') }}"
                                                                                                    alt="Online Payment" class="mx-3"
                                                                                                    style="width: 24px; height: auto;">
                                                                                                <span>Online Payment</span>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div> 
                                        </div>
                                        @error('payment_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-3 mt-4"
                                style="position: sticky; bottom: 0px; background: #fff;border-top: 1px solid #dcdcdc">
                                <div class="d-flex justify-content-end align-items-center">
                                    <h4>Total Amount &nbsp;&nbsp;
                                    <input type="hidden" name="total_amount" id="total_amount" value="{{ number_format($cart->items->sum(fn($item) => $item->product->original_price * $item->quantity), 0) }}">
                                        <span style="text-decoration: line-through; color:#c7c7c7" class="subtotal">
                                            {{-- ₹{{ number_format($cart->items->sum(fn($item) => $item->product->original_price * $item->quantity), 0) }} --}}
                                            {{ formatIndianCurrency($cart->items->sum(fn($item) => $item->product->original_price * $item->quantity)) }}
                                        </span>
                                        &nbsp;&nbsp;
                                        <span class="mx-1" style="color:#000">
                                            {{-- ₹{{ number_format($cart->items->sum(fn($item) => $item->product->discounted_price * $item->quantity), 0) }} --}}
                                            {{ formatIndianCurrency($cart->items->sum(fn($item) => $item->product->discounted_price * $item->quantity)) }}
                                        </span>
                                        <span class="total" style="font-size:12px; color:#00DD21;white-space: nowrap;">
                                            DealsMachi Discount
                                            &nbsp;<span
                                                class="discount">
                                                {{-- -₹{{ number_format($cart->items->sum(fn($item) => ($item->product->original_price - $item->product->discounted_price) * $item->quantity), 0) }} --}}
                                               - {{ formatIndianCurrency($cart->items->sum(fn($item) => ($item->product->original_price - $item->product->discounted_price) * $item->quantity)) }}
                                            </span>
                                        </span>
                                    </h4>
                                </div>
                                <input type="hidden" name="cart_id" id="cart_id" value="{{ $cart->id }}">
                                <input type="hidden" name="address_id" class="address_id" value="{{$address->id}}">
                                <input type="hidden" name="grandtotal" class="grandtotal" value="{{$cart->items->sum(fn($item) => $item->product->discounted_price * $item->quantity)}}">
                                <div class="d-flex justify-content-end align-items-center ">
                                    <button type="submit" class="btn check_out_btn text-nowrap">
                                        Place Order
                                    </button>
                                </div>
                            </div>
                        </div>
                

            </div>
        </section>
    @else
        <section>
        @if (session('status'))
                <div class="alert alert-dismissible fade show toast-success" role="alert"
                    style="position: fixed; top: 70px; right: 40px; z-index: 1050;">
                    <div class="toast-content">
                        <div class="toast-icon">
                            <i class="fa-solid fa-check-circle" style="color: #16A34A"></i>
                        </div>
                        <span class="toast-text"> {!! nl2br(e(session('status'))) !!}</span>&nbsp;&nbsp;
                        <button class="toast-close-btn"data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa-thin fa-xmark" style="color: #16A34A"></i>
                        </button>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert  alert-dismissible fade show toast-danger" role="alert"
                    style="position: fixed; top: 70px; right: 40px; z-index: 1050;">
                    <div class="toast-content">
                        <div class="toast-icon">
                            <i class="fa-solid fa-triangle-exclamation" style="color: #EF4444"></i>
                        </div>
                        <span class="toast-text">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </span>&nbsp;&nbsp;
                        <button class="toast-close-btn"data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa-solid fa-xmark" style="color: #EF4444"></i>
                        </button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="alert  alert-dismissible fade show toast-danger" role="alert"
                    style="position: fixed; top: 70px; right: 40px; z-index: 1050;">
                    <div class="toast-content">
                        <div class="toast-icon">
                            <i class="fa-solid fa-triangle-exclamation" style="color: #EF4444"></i>
                        </div>
                        <span class="toast-text">
                            {{ session('error') }}
                        </span>&nbsp;&nbsp;
                        <button class="toast-close-btn"data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa-solid fa-xmark" style="color: #EF4444"></i>
                        </button>
                    </div>
                </div>
            @endif
            <div class="container" style="margin-top: 100px;">
                {{-- <h2 class="text-center">Checkout</h2> --}}
                    <div class="row my-5">
                        <div class="col-12">
                            <!-- Customer Info Section -->
                            <div class="card p-3 mb-3">
                                <div class="row">
                                    <h5 class="mb-4" style="color:#ff0060;"> Delivery Address</h5>
                                    <p>
                                        <strong>{{ $address->first_name ?? '' }}
                                            {{ $address->last_name ?? '' }} (+91)
                                            {{ $address->phone ?? '' }}</strong>&nbsp;&nbsp;
                                        {{ $address->address ?? '' }} - {{ $address->postalcode ?? '' }}
                                        <span>
                                            @if ($address->default)
                                                <span class="badge badge_danger py-1">Default</span>&nbsp;&nbsp;
                                            @endif
                                            {{-- <span class="badge badge_infos py-1" data-bs-toggle="modal"
                                                    data-bs-target="#myAddressModal">Change</span> --}}
                                        </span>
                                    </p>

                                </div>
                            </div>
                            <!-- Order summary -->
                            <div class="card p-3 mb-3">
                                <div class="row">
                                    <h5 class="mb-4" style="color:#ff0060;">Order Summary</h5>
                                    @foreach ($cart->items as $item)
                                        <div class="col-md-6 col-12">
                                            @if ($item->deal_type == 1)
                                                <p>{{ $item->product->name }} <span
                                                        class="text-muted">(x{{ $item->quantity }})</span></p>
                                            @else
                                                <p>{{ $item->product->name }} <span class="text-muted">(Service) </span>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-12 checkoutsummary-card2 text-end">
                                            <span style="text-decoration: line-through; color:#c7c7c7">
                                                {{-- ₹{{ number_format($item->product->original_price * $item->quantity, 0) }} --}}
                                                {{ formatIndianCurrency($item->product->original_price * $item->quantity) }}
                                            </span>
                                            <span class="ms-1" style="font-size:22px;color:#ff0060">
                                                {{-- ₹{{ number_format($item->product->discounted_price * $item->quantity, 0) }} --}}
                                                {{ formatIndianCurrency($item->product->discounted_price * $item->quantity) }}
                                            </span>
                                            <span class="ms-1" style="font-size:12px; color:#00DD21">
                                                {{-- ({{ number_format($item->product->discount_percentage, 0) }}%) --}}
                                                {{ formatIndianCurrency($item->product->discount_percentage) }}
                                                off
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Payment Methods -->
                            <div class="card p-3 mb-3">
                                <div>
                                    <h5 style="color:#ff0060;">Payment Methods</h5>
                                    <div class="row justify-content-center mt-3">
                                        <div class="col-lg-5 col-10 mb-3">
                                            <div class="card payment-option">
                                                <div class="d-flex align-items-center w-100">
                                                    <input type="radio" name="payment_type" id="cash_on_delivery"
                                                        value="cash_on_delivery" class="form-check-input m-3"
                                                        {{ old('payment_type') == 'cash_on_delivery' ? 'checked' : '' }}>
                                                    <label for="cash_on_delivery" class="d-flex align-items-center m-0 py-3"  style="width: 100%;>
                                                        <img src="{{ asset('assets/images/home/cash_payment.png') }}"
                                                            alt="Cash on Delivery" class="mx-3"
                                                            style="width: 24px; height: auto;">
                                                        <span>Cash on Delivery</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-10">
                                             <div class="card payment-option">
                                                                                        <div class="d-flex align-items-center w-100">
                                                                                            <input type="radio" name="payment_type" id="online_payment"
                                                                                                value="online_payment" class="form-check-input m-3"
                                                                                                {{ old('payment_type') == 'online_payment' ? 'checked' : '' }}>
                                                                                            <label for="online_payment" class="d-flex align-items-center m-0 py-3"  style="width: 100%;>
                                                                                                <img src="{{ asset('assets/images/home/online_banking.png') }}"
                                                                                                    alt="Online Payment" class="mx-3"
                                                                                                    style="width: 24px; height: auto;">
                                                                                                <span>Online Payment</span>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div> 
                                        </div>
                                        @error('payment_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center py-3 mt-4"
                                style="position: sticky; bottom: 0px; background: #fff;border-top: 1px solid #dcdcdc">
                                <div class="d-flex justify-content-end align-items-center ">
                                    <h4>Total Amount &nbsp;&nbsp; <span
                                            style="text-decoration: line-through; color:#c7c7c7" class="subtotal">
                                            {{-- ₹{{ number_format($cart->total, 0) }} --}}
                                            {{ formatIndianCurrency($cart->total) }}
                                        </span> &nbsp;&nbsp; <span class="total ms-1" style="color:#000">
                                            {{-- ₹{{ number_format($cart->grand_total, 0) }} --}}
                                            {{ formatIndianCurrency($cart->grand_total) }}
                                        </span> <span class="ms-1"
                                            style="font-size:12px; color:#00DD21;white-space: nowrap;">
                                            DealsMachi Discount
                                            &nbsp;<span
                                                class="discount">
                                                {{-- -₹{{ number_format($cart->discount, 0) }} --}}
                                                -{{ formatIndianCurrency($cart->discount) }}
                                            </span></span>
                                    </h4>
                                </div>
                                {{-- <div class="d-flex justify-content-end align-items-center py-3"
                                    style="position:sticky; bottom:10px; background:#fff"> --}}
                                <!--<button type="submit" class="btn check_out_btn text-nowrap" data-bs-toggle="modal"-->
                                <!--    data-bs-target="#orderSuccessModal">-->
                                <!--    Place Order-->
                                <!--</button>-->
                                <input type="hidden" name="grandtotal" class="grandtotal" value="{{$cart->items->sum(fn($item) => $item->product->discounted_price * $item->quantity)}}">
                                <input type="hidden" name="cart_id" id="cart_id" value="{{$cart->id}}">
                                <input type="hidden" name="address_id" class="address_id" value="{{$address->id}}">
                                
                                <button type="submit" class="btn check_out_btn text-nowrap">
                                        Place Order
                                    </button>
                                {{-- </div> --}}
                            </div>
                        </div>
       
            </div>
        </section>
    @endif
            <!-- Online Payment Form -->
<form name="sdklaunch" id="sdklaunch" action="{{ route('new.payment') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" id="bdorderid" name="bdorderid" value="">
    <input type="hidden" id="merchantid" name="merchantid" value="">
    <input type="hidden" id="rdata" name="rdata" value="">
</form>

<!-- Cash on Delivery Form -->
<form name="cod_form" id="cod_form" action="{{ route('new.codorder') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="cart_id" value="{{ $cart->id }}" id="cartId">
    <input type="hidden" name="address_id" value="{{ $address->id }}" id="addressId">
</form>
        
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        
        // $('.check_out_btn').prop('disabled', true).css({
        //     'background-color': '#00dd21',
        //     'opacity': '0.5'
        // });
        
        let totalAmount = parseFloat($(".grandtotal").val());

        if (totalAmount === 0) {
            $("#online_payment").closest(".col-lg-5").hide(); // Hide online payment option
        }
    
        $('input[name="payment_type"]').change(function () {
            if ($(this).val() == 'online_payment') {
                var totalamount = $('#total_amount').val();
                
                if (totalamount == '0') {
                    $('.check_out_btn').prop('disabled', true).css({
                        'background-color': '#00dd21',
                        'opacity': '0.5'
                    });
                } else {
                    $('.check_out_btn').prop('disabled', true).css({
                        'background-color': '#00dd21',
                        'opacity': '0.5'
                    });
        
                    // Show spinner inside the button
                    $('.check_out_btn').html(
                        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Place Order`
                    );
        
                    $.ajax({
                        url: "{{ route('new.payment') }}",
                        type: "POST",
                        data: {
                            "cart_id": $('#cart_id').val(),
                            "address_id": $('.address_id').val(),
                            "amount":totalAmount
                        },
                        success: function (response) {
                            $('.check_out_btn').prop('disabled', false).css({
                                'background-color': '#00dd21',
                                'opacity': '1'
                            }).html(`Place Order`); // Restore button text
        
                            $('#bdorderid').val(response.bdorderid);
                            $('#merchantid').val(response.mercid);
                            $('#rdata').val(response.rdata);
                            $('#sdklaunch').attr('action', response.href);
                            // $('#sdklaunch').submit();
                        },
                        error: function () {
                            $('.check_out_btn').prop('disabled', false).css({
                                'background-color': '#00dd21',
                                'opacity': '1'
                            }).html(`Place Order`); // Restore button text
                        }
                    });
                }
            } else {
                $('.check_out_btn').prop('disabled', false).css({
                    'background-color': '#00dd21',
                    'opacity': '1'
                }).html(`Place Order`); // Restore button text
            }
        });


        
       $('.check_out_btn').on('click', function () {
            var paymenttype = $('input[name="payment_type"]:checked').val();
            
            if (!paymenttype) {
                showToast("Please select a payment method before proceeding.");
                return false; // Prevent further execution
            }
        
            if (paymenttype === "online_payment") {
                $('#sdklaunch').submit();
            } else {
                $('#cod_form').submit();
            }
        });
    

    function showToast(message) {
        var toastHtml = `
            <div class="alert alert-dismissible fade show toast-danger" role="alert"
                style="position: fixed; top: 70px; right: 40px; z-index: 1050;">
                <div class="toast-content">
                    <div class="toast-icon">
                        <i class="fa-solid fa-triangle-exclamation" style="color: #EF4444"></i>
                    </div>
                    <span class="toast-text"> ${message} </span>&nbsp;&nbsp;
                    <button class="toast-close-btn" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa-solid fa-xmark" style="color: #EF4444"></i>
                    </button>
                </div>
            </div>`;
    
        // Append the toast to the body and auto-remove after 3 seconds
        $('body').append(toastHtml);
        setTimeout(function () {
            $(".toast-danger").fadeOut(500, function () { $(this).remove(); });
        }, 3000);
    }

    });
</script>
@endsection
