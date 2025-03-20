<div class="container">
    <h3 class="pt-0 pb-2 h3-styling">Sub Categories</h3>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 pb-3" id="hotpicks">
        @foreach ($subCategories as $subCategory)
            <div class="col mb-3">
                <a href="{{ url('hotpick/' . $subCategory->slug) }}" style="text-decoration: none;">
                    <div class=" topCard card-img-top1 h-100">
                        <div class="card-body p-0" style="min-height: 50px; position: relative;">

                            <img src="{{ asset($subCategory->image_path) }}" class="img-fluid card-img-top"
                                alt="{{ $subCategory->name }}" />
                        </div>

                    </div>
                    <h2 class="h2-styling">{{ $subCategory->name }}</h2>

                </a>
            </div>
        @endforeach
    </div>
</div>
