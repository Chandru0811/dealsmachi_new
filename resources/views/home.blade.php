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
    <!-- Permission Denied Modal -->
    <div class="modal fade" id="permissionDeniedModal" tabindex="-1" aria-labelledby="permissionDeniedModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionDeniedModalLabel">Enable Location Services for Nearby Deals</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color: #ff0060">Don't miss out on amazing deals near you! <br>
                        Please enable location services to uncover them.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            window.onload = getLocation;

            let lastChild = $('#hotpicks').children().last().find('a');
            if (lastChild.length) {
                lastChild.attr('id', 'nearest_deals');

            } else {
                console.log("No child element found.");
            }

            function updateDropdownToggle() {
                if ($(window).width() < 992) {
                    $(".dropdown-toggle").attr("data-bs-toggle", "dropdown");
                    $('.dropdown-toggle').on('click', function(event) {
                        event.preventDefault();

                        const $menu = $(this).next('.dropdown-menu');
                        const isExpanded = $(this).attr('aria-expanded') === 'true';

                        $(this).toggleClass('show', !isExpanded);
                        $menu.toggleClass('show', !isExpanded);
                        $(this).attr('aria-expanded', !isExpanded);
                    });
                } else {
                    $(".dropdown-toggle").removeAttr("data-bs-toggle");
                }
            }

            updateDropdownToggle();

            $(window).resize(function() {
                updateDropdownToggle();
            });

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition, showError);
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            }

            function showPosition(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                console.log('Latitude:', latitude);
                console.log('Longitude:', longitude);

                const nearestDealsLink = $('#nearest_deals');
                const baseUrl = nearestDealsLink.attr('href');
                const newUrl = `${baseUrl}?latitude=${latitude}&longitude=${longitude}`;
                nearestDealsLink.attr('href', newUrl);
            }

            function showError(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        var permissionDeniedModal = new bootstrap.Modal(document.getElementById(
                            'permissionDeniedModal'));
                        permissionDeniedModal.show();
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        alert("The request to get user location timed out.");
                        break;
                    case error.UNKNOWN_ERROR:
                        alert("An unknown error occurred.");
                        break;
                }
            }

            $('#nearest_deals').on('click', function() {
                event.preventDefault();
                navigator.permissions.query({
                    name: 'geolocation'
                }).then(function(result) {
                    if (result.state === 'granted') {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(showlocation, showError);
                        } else {
                            alert("Geolocation is not supported by this browser.");
                        }
                    } else if (result.state === 'prompt') {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(showlocation, showError);
                        } else {
                            alert("Geolocation is not supported by this browser.");
                        }
                    } else if (result.state === 'denied') {
                        // Notify the user to enable location permissions manually
                        alert(
                            "Location access is denied. Please enable it in your browser settings."
                            );
                    }
                });
            });

            function showlocation(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                console.log('Latitude:', latitude);
                console.log('Longitude:', longitude);

                const nearestDealsLink = $('#nearest_deals');
                const baseUrl = nearestDealsLink.attr('href');

                // Check if the URL already has latitude and longitude to avoid appending them again
                if (!baseUrl.includes("latitude") && !baseUrl.includes("longitude")) {
                    const newUrl = `${baseUrl}?latitude=${latitude}&longitude=${longitude}`;
                    nearestDealsLink.attr('href', newUrl);

                    // Redirect to the updated URL
                    window.location.href = newUrl;
                } else {
                    // If the URL already contains latitude and longitude, just navigate to it
                    window.location.href = baseUrl;
                }
            }
        });
    </script>
@endsection
