@extends('layouts.master')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="categoryIcons container d-flex flex-column align-items-start text-start"
         style="color: rgb(128, 128, 128); max-width: 600px;">

        <h4 style=" color: #4e4e4e;">
            Please allow location access to show nearby deals
        </h4>

        <p style="font-size: 1.2em; margin-top: 10px;">
            This is how you can enable it
        </p>

        <div>
            <p>In your browser, do the following:</p>
            <div class="d-flex align-items-center mb-2">
                <img src="{{ asset('assets/images/home/Chrome.webp') }}" alt="Chrome_img"
                     class="img-fluid me-2" style="width: 24px; height: 24px;" />
                <span>Privacy and Security > Site Settings > Location</span>
            </div>
            <div class="d-flex align-items-center mb-2">
                <img src="{{ asset('assets/images/home/Firefox.webp') }}" alt="Firefox_img"
                     class="img-fluid me-2" style="width: 24px; height: 24px;" />
                <span>Settings > Privacy & Security > Permissions > Location</span>
            </div>
            <div class="d-flex align-items-center mb-2">
                <img src="{{ asset('assets/images/home/Safari.webp') }}" alt="Safari_img"
                     class="img-fluid me-2" style="width: 24px; height: 24px;" />
                <span>Preferences > Websites > Location</span>
            </div>
            <p>In the location settings, find the site you’re using and select Allow for location access.</p>
        </div>
    </div>
</div>
@endsection
    @section('scripts')
    <script>

        window.onload = getLocation;

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

                // Initialize the geocoder
                const geocoder = new google.maps.Geocoder();
                const latlng = { lat: latitude, lng: longitude };

                // Call Google Geocode API
                geocoder.geocode({ location: latlng }, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            const address = results[0].formatted_address;
                            console.log('User Address:', address);
                            $('.user_address').text(address);
                            // You can then send this address to your Laravel backend or display it on the page
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
                        alert("User denied the request for Geolocation.");
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


    </script>
@endsection
