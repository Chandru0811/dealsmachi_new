@extends('layouts.master')

@section('content')
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
                    <i class="fa-solid fa-check-circle" style="color: #EF4444"></i>
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
                    <i class="fa-solid fa-check-circle" style="color: #EF4444"></i>
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
    <!-- Category & Banner Start  -->
    <!-- hero section -->
    <section class="categoryIcons">
        @include('contents.home.categoryGroup')
        @include('contents.home.slider')
    </section>



    <!--  Category & Banner End  -->

    <div class="products-container">
        <div id="products-wrapper">
            <section>
                @include('contents.home.hotpicks')
                <div class="container">
                    <h5 class="pt-0 pb-2">Products</h5>
                </div>
                @include('contents.home.products')
            </section>
        </div>

        <!-- Loading spinner -->
        <div class="loading-spinner loading-text d-none text-center" style="width: fit-content">
            <span style="color: #ff0060">Loading...</span>
        </div>
    </div>
    <!-- Product Card End -->

    <!-- App & PlayStore Start  -->
    @include('contents.home.playstoreContent')
    <!-- App & PlayStore End  -->

    <!-- Lead Magnet Model -->
    <div class="modal fade" id="indexLeadMagnetModal" tabindex="-1" role="dialog"
        aria-labelledby="indexLeadMagnetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content modalContent" style="background-color: #1e1e1e">
                <div class="modal-body p-0 text-center position-relative">
                    <div type="button" class="position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                        aria-label="Close"><i class="fa-solid fa-circle-xmark" style="color: #000; font-size: 20px"></i>
                    </div>
                    <img src="{{ asset('assets/images/Republic_Campaign.webp') }}" alt="Republic_Campaign" width="500"
                        height="500" class="img-fluid">
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let loading = false;
            let currentPage = 1;
            let hasMoreProducts = true;
            const loadingSpinner = document.querySelector('.loading-spinner');

            function loadMoreProducts() {
                if (loading || !hasMoreProducts) return;

                loading = true;
                currentPage++;
                loadingSpinner.classList.remove('d-none');

                setTimeout(() => {
                    fetch(`/?page=${currentPage}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            if (html.trim().length > 0) {
                                document.getElementById('products-wrapper').insertAdjacentHTML(
                                    'beforeend', html);
                            } else {
                                hasMoreProducts = false;
                                // alert('All products have been loaded.');
                            }
                            loadingSpinner.classList.add('d-none');
                            loading = false;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            loadingSpinner.classList.add('d-none');
                            loading = false;
                        });
                }, 400);
            }


            function handleScroll() {
                const scrollPosition = window.innerHeight + window.scrollY;
                const bodyHeight = document.documentElement.scrollHeight;

                if (scrollPosition >= bodyHeight - 500) {
                    loadMoreProducts();
                }
            }

            let timeout;
            window.addEventListener('scroll', function() {
                if (timeout) {
                    window.cancelAnimationFrame(timeout);
                }
                timeout = window.requestAnimationFrame(function() {
                    handleScroll();
                });
            });
        });



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
                // const geocoder = new google.maps.Geocoder();
                // const latlng = {
                //     lat: latitude,
                //     lng: longitude
                // };

                // geocoder.geocode({
                //     location: latlng
                // }, function(results, status) {
                //     if (status === 'OK') {
                //         if (results[0]) {
                //             const address = results[0].formatted_address;
                //             console.log('User Address:', address);
                //             $('.user_address').text(address);
                //         } else {
                //             console.log('No address found');
                //         }
                //     } else {
                //         console.log('Geocoder failed due to:', status);
                //     }
                // });
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
