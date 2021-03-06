{{-- @extends('layout')
@section('content') --}}
{{-- quick view --}}
<div class="row">
    <div class="product-img-box col-lg-6 col-sm-6 col-xs-12">
        <img class="img-responsive"
            src="{{ url('uploads/products-images/' . $quick_view_product->id . '/' . $quick_view_product->image) }}">
    </div>
    <div class="product-shop col-lg-6 col-sm-6 col-xs-12">
        {{-- <div class="product-next-prev"> <a class="product-next"
                href="#"><span></span></a> <a class="product-prev" href="#"><span></span></a> </div>
        --}}
        <div class="product-name">
            <h3>{{ $quick_view_product->name }}</h3>
        </div>
        <div class="ratings">
            <div class="rating-box">
                <div style="width: {{ $quick_view_product->rating * 20 }}%" class="rating"></div>
            </div>
            <p class="rating-links"> <a href="#">{{ count($reviews) }} Review(s)</a> <span class="separator">|</span> <a
                    href="#product-detail-tab">Add Your Review</a>
            </p>
        </div>
        <p class="availability in-stock"><span>
                @if ($quick_view_product->remaining != 0)
                    In Stock
                @else
                    Out of Stock
                @endif
            </span></p>
        <div class="price-block">
            <div class="price-box">
                @if ($quick_view_product->discount != null)
                    <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price">
                            {{ $quick_view_product->price }} vnd </span> </p>
                    <p class="special-price"> <span class="price-label">Special Price</span> <span class="price">
                            {{ $quick_view_product->price - ($quick_view_product->price * $quick_view_product->discount) / 100 }}
                            vnd
                        </span> </p>
                @else
                    <p class="regular-price"> <span class="price-label">Price</span> <span class="price">
                            {{ $quick_view_product->price }} vnd </span> </p>
                @endif
            </div>
        </div>
        <div class="short-description">
            <h3>Quick Overview</h3>
            <div class="price-box">
                <p>Category :
                    @foreach ($categories as $category)
                        @if ($category->id == $quick_view_product->category_id)
                            {{-- {{ $category->name }}
                            --}}
                            <a href="{{ URL::to('filter/' . $category->id) }}">
                                {{ $category->name }} </a>
                        @endif
                    @endforeach
                </p>
                <p>Producer :
                    @foreach ($producers as $producer)
                        @if ($producer->id == $quick_view_product->producer_id)
                            {{ $producer->name }}
                        @endif
                    @endforeach
                </p>
                <p>Sold : {{ $quick_view_product->quantity - $quick_view_product->remaining }}</p>
                <p>Remaining : {{ $quick_view_product->remaining }}</p>
            </div>
        </div>
        <button type="button" onclick="add_to_cart({{ $quick_view_product->id }});" title="Add to Cart"
            class="button btn-cart"><span>Add to Cart</span>
        </button>
        @if (Auth::user())
            <button onclick="add_to_wish_list({{ $product->id }});" title="Add to Wishlist"
                class="button link-wishlist">
                <span>Add to Wishlist</span>
            </button>
        @else
            <button onclick="alert('You need to login to add this product to the wish list!');" title="Add to Wishlist"
                class="button link-wishlist">
                <span>Add to Wishlist</span></button>
        @endif
    </div>
</div>
<!--End Quick view-->
{{-- @endsection --}}
