<div class="container slider-content">
    <div class="owl-carousel carousel_slider owl-theme">
        @foreach ($sliders as $slider)
            <div class="item">
                <img src="{{ asset($slider->image_path) }}" alt="slider_image" class="img-fluid p-2 rounded-5 banner_image" />
            </div>
        @endforeach
    </div>
</div>
