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


                // Initialize the geocoder
                const geocoder = new google.maps.Geocoder();
                const latlng = {
                    lat: latitude,
                    lng: longitude
                };

                geocoder.geocode({
                    location: latlng
                }, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            const address = results[0].formatted_address;
                            console.log('User Address:', address);
                            $('.user_address').text(address);
                        } else {
                            console.log('No address found');
                        }
                    } else {
                        console.log('Geocoder failed due to:', status);
                    }
                });
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
        });
    </script>
@endsection
