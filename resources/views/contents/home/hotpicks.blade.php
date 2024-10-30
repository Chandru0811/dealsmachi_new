<div class="container">
    <h5 class="pt-0 pb-2">Hot Picks</h5>
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 pb-2">
        @foreach ($hotpicks as $hotpick)
        <div class="col mb-3">
            <a href="{{ url('hotpick/' . $hotpick->slug) }}" style="text-decoration: none;">
                <div class="card topCard card-img-top1 h-100">
                    <div class="card-body p-0" style="min-height: 50px; position: relative;">
                        <img src="{{ asset($hotpick->image_path) }}" class="img-fluid card-img-top"
                            alt="{{ $hotpick->name }}" />
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
