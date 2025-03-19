@extends('layouts.master')

@section('content')
<style>
    .success-note {
        font-size: 14px;
        color: #777;
    }
</style>
<div class="container py-2">
    <div class="row justify-content-center" style="margin-top: 4.5rem">
        <div class="col-12">
            <div class="p-4 text-center">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <img src="{{ asset('assets/images/home/failed.png') }}" class="img-fluid img-responsive success-img" alt="Failed" style="max-height: 6em" />
                </div>
                <span class="badge rounded-pill mt-3" style="background-color: #ffd4d5; color: #FF2B2E; font-weight: 400;">
                    Payment Failed
                </span>
                <p class="mt-3 h5 fw-semibold" style="margin-bottom: 2rem;">
                    The payment process did not succeed for some reason.
                </p>
                <button type="button" class="btn retry-button"  style="margin-bottom: 2rem;">Retry Payment</button>

                <p class="mt-3 mb-0 success-note">Error:</p>
                <p>
                    {{ $orderData['TransactionData'][0]['transactionErrorDesc'] ?? 'Bank Servers did not respond' }}. Please Try Again.<br />
                    Reach out to our support team at <br /> info@dealsmachi.com or +91 91501 50687 for help.
                </p>
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <a href="https://dealsmachi.com/contactus" class="text-muted">
                        Contact Us
                    </a>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('.retry-button').on('click',function(){
            var cartNumber = localStorage.getItem('cartnumber');
             window.location.href = "{{ route('cart.index') }}" + '?dmc=' + cartNumber;
        });
    });
</script>
@endsection

