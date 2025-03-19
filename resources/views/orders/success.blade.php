@extends('layouts.master')

@section('content')
    <section class="mb-4" style="margin-top: 100px">
        <div class="container mt-4" >
            <div class="row justify-content-center">
                <div class="col-md-6 text-center p-3" style="border: 1px solid #ddd; border-radius: 10px; background: #fff;">
                    <div class="mb-1">
                        <img src="{{ asset('assets/images/home/check.webp') }}" class="img-fluid" />
                    </div>
                    <div class="mb-1">
                        <p style="font-size: 20px; font-weight: bold;">Order Placed Successfully !</p>
                    </div>
                    <div class="mb-1">
                        <p style="font-size: 20px;">Delivery to</p>
                    </div>
                    <div class="text-center">
                        <p style="font-size: 18px; color: rgb(179, 184, 184)">
                          {{ $address }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
