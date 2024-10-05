@extends('layouts.master')

@section('content')
    <!-- Category & Banner Start  -->
    <!-- hero section -->
    <section class="categoryIcons">
        @include('contents.home.categoryGroup')
        @include('contents.home.slider')
    </section>

    <!--  Category & Banner End  -->

    <!-- Product Card Start -->
    <section>
        @include('contents.home.hotpicks')
        @include('contents.home.products')
    </section>
    <!-- Product Card End -->

    <!-- App & PlayStore Start  -->
    @include('contents.home.playstoreContent')
    <!-- App & PlayStore End  -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            function updateDropdownToggle() {
                if ($(window).width() < 992) {
                    $(".dropdown-toggle").attr("data-bs-toggle", "dropdown");
                } else {
                    $(".dropdown-toggle").removeAttr("data-bs-toggle");
                }
            }

            updateDropdownToggle();

            $(window).resize(function() {
                updateDropdownToggle();
            });

        });
    </script>
@endsection
