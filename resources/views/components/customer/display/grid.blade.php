<ul class="products-grid">
    @foreach ($products as $product)
        <li class="item col-lg-4 col-md-4 col-sm-6 col-xs-6">
            <div class="col-item">
                @if ($product->discount != null && $product->discount != 0)
                    <div class="sale-label sale-top-right">Sale</div>
                @endif
                <div class="images-container"> <a class="product-image" title="{{ $product->name }}"
                        href="{{ route('product_details', ['id' => $product->id]) }}">
                        <img src="{{ asset('storage/images/products/' . $product->image) }}" class="img-responsive"
                            alt="a" />
                    </a>
                    <div class="actions">
                        <div class="actions-inner">
                            <button type="button" onclick="add_to_cart({{ $product->id }});" title="Thêm vào giỏ hàng"
                                class="button btn-cart"><span>Thêm vào giỏ hàng</span></button>
                            <ul class="add-to-links">
                                <li>
                                    @if (Auth::user())
                                        <a onclick="add_to_wish_list({{ $product->id }});"
                                            title="Thêm vào danh sách ưu thích" class="link-wishlist">
                                            <span>Ưu thích</span>
                                        </a>
                                    @else
                                        <a onclick="alert('You need to login to add this product to the wish list!');"
                                            title="Thêm vào danh sách ưu thích" class="link-wishlist">
                                            <span>Ưu thích</span></a>
                                    @endif
                                </li>
                                <li><a onclick="add_to_compare({{ $product->id }})" title="Thêm vào so sánh"
                                        class="link-compare "><span>So sánh</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="qv-button-container">
                        <a onclick="return quick_view({{ $product->id }});"
                            class="btn-quickview qv-e-button btn-quickview-1">
                            <span><span>Xem nhanh</span></span>
                        </a>
                    </div>
                </div>
                <div class="info">
                    <div class="info-inner">
                        <div class="item-title"> <a title="{{ $product->name }}"
                                href="{{ URL::to('product-details/' . $product->id) }}"> {{ $product->name }}
                            </a>
                        </div>
                        <!--item-title-->
                        <div class="item-content">
                            <div class="ratings">
                                <div class="rating-box">
                                    <div style="width:{{ $product->rating * 20 }}%" class="rating"></div>
                                </div>
                            </div>
                            <div class="price-box">
                                @if ($product->discount != null && $product->discount != 0)
                                    <p class="special-price"> <span class="price">
                                            {{ $product->price - ($product->discount * $product->price) / 100 }} d
                                        </span> </p>
                                    <p class="old-price"> <span class="price-sep">-</span> <span class="price">
                                            {{ $product->price }} d
                                        </span>
                                    </p>
                                @else
                                    <p class="regular-price"> <span class="price-sep">-</span> <span class="price">
                                            {{ $product->price }} d
                                        </span>
                                    </p>
                                @endif
                            </div>
                        </div>
                        <!--item-content-->
                    </div>
                    <!--info-inner-->
                    <div class="clearfix"> </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
