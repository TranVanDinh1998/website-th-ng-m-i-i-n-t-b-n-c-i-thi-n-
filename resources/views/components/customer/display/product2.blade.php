<!-- Item -->
<div class="item">
    <div class="col-item">

        @if ($product->discount != null)
            <div class="sale-label sale-top-right">Sale </div>
        @endif
        <div class="images-container"> <a class="product-image" title="{{ $product->name }}"
                href="{{ route('product_details', ['id' => $product->id]) }}"> <img
                    src="{{ asset('storage/images/products/' . $product->image) }}" class="img-responsive" alt="a" />
            </a>
            <div class="actions">
                <div class="actions-inner">
                    <ul class="add-to-links">
                        <li><a @if (Auth::user()) onclick="add_to_wish_list({{ $product->id }});"
                                        @else
                                                                onclick="alert('You need to login to add this product to the wish list!');" @endif title="Ưu thích" class="link-wishlist"><span>Thêm vào
                                    ưu thích</span></a>
                        </li>
                        <li><a onclick="add_to_compare({{ $product->id }})" title="Thêm vào so sánh"
                                class="link-compare "><span>Thêm vào
                                    so sánh</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="qv-button-container"> <a onclick="return quick_view({{ $product->id }});"
                    class="qv-e-button btn-quickview-1"><span><span>Xem nhanh</span></span></a>
            </div>
        </div>
        <div class="info">
            <div class="info-inner">
                <div class="item-title"> <a title="{{ $product->name }}"
                        href="{{ URL('product-details/' . $product->id) }}">
                        {{ $product->name }} </a> </div>
                <!--item-title-->
                <div class="item-content">
                    <div class="ratings">
                        <div class="rating-box">
                            <div style="width:{{ $product->rating * 20 }}%" class="rating">
                            </div>
                        </div>
                    </div>
                    <div class="price-box">
                        @if ($product->discount != null)
                            <p class="special-price"> <span class="price">
                                    {{ $product->price - ($product->price * $product->discount) / 100 }}
                                    <small> đ</small>
                                </span>
                            </p>
                            <p class="old-price"> <span class="price-sep">-</span> <span class="price">
                                    {{ $product->price }} <small> đ</small>
                                </span> </p>
                        @else
                            <p class="regular-price"> <span class="price">
                                    {{ $product->price }}
                                    <small> đ</small>
                                </span>
                            </p>
                        @endif

                    </div>
                </div>
                <!--item-content-->
            </div>
            <!--info-inner-->
            <div class="actions">
                <button type="button" onclick="add_to_cart({{ $product->id }});" title="Thêm vào giỏ hàng"
                    class="button btn-cart"><span>Thêm vào
                        giỏ hàng</span></button>
            </div>
            <!--actions-->
            <div class="clearfix"> </div>
        </div>
    </div>
</div>
<!-- End Item -->
