@extends('layouts.master')

@section('content')
    <div class="categoryIcons container d-flex align-items-center justify-content-center text-center"
        style="min-height: 70vh; color: rgb(128, 128, 128);">
        <div>
            <h2 style="font-weight: bold; color: #444;">Discover Amazing Deals Nearby!</h2>
            <p style="font-size: 1.2em; margin-top: 10px;">Let us help you find the best deals around your location. Enable
                location access to unlock exclusive offers near you!</p>
            
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
