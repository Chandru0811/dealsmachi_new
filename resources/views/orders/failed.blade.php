@extends('layouts.master')

@section('content')
    <style>
        .success-note {
            font-size: 14px;
            color: #777;
        }
    </style>
    <div class="container py-2">
        <div class="row justify-content-center" style="margin-top: 4.5rem;">
            <div class="col-12">
                <div class="p-4 text-center">
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <img src="{{ asset('assets/images/home/payment_warrning.png') }}"
                            class="img-fluid img-responsive success-img" alt="Success" style="max-height: 5em;" />
                    </div>
                    <span class="badge rounded-pill mt-3"
                        style="background-color: #fff3cd; color: #FFC107; font-weight: 400;">
                        Error, No response!
                    </span>
                    <p class="mt-3 h5 fw-semibold" style="margin-bottom: 6rem;">
                        Your bank failed to respond
                    </p>
                    <p class="mt-3 mb-0 success-note">Error:</p>
                    <p>
                        We couldn't get a response from the bank server. <br />
                        Reach out to our support team at <br />
                        info@dealsmachi.com or +91 91501 50687 for help.
                    </p>
                    <a href="https://dealsmachi.com/contactus" class="text-muted">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
