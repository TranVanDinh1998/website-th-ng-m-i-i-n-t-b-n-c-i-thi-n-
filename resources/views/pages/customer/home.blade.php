@extends('layouts.customer.index')
@section('title', 'Home')
@section('content')

    <!-- Slider -->
    @include('components.customer.slider')
    <!-- end Slider -->
    <!-- header service -->
    <div class="header-service">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>
    <!-- end header service -->

    <!-- offer banner section -->
    <div class="offer-banner-section">
        <div class="container">
            <div class="row">
                @foreach ($three_most_priority_collections as $collection)
                    <div class="col-md-4"><a title="{{ $collection->name }}"
                            href="{{ route('filter', ['category_id' => $collection->category_id]) }}"><img
                                class="img-responsive" alt="{{ $collection->name }}"
                                src="{{ asset('/storage/images/collections/' . $collection->image) }}"></a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- end offer banner section -->

    <!-- main container -->
    <section class="main-container col1-layout home-content-container">
        <div class="container">
            <div class="row">
                <div class="std">
                    <div class="col-lg-8 col-xs-12 col-sm-8 best-seller-pro wow">
                        <div class="slider-items-products">
                            <div class="new_title center">
                                <h2>Bán chạy nhất</h2>
                            </div>
                            <div id="best-seller-slider" class="product-flexslider hidden-buttons">
                                <div class="slider-items slider-width-col4">
                                    @foreach ($best_seller_products as $product)
                                        <!-- Item -->
                                        @include('components.customer.display.product')
                                        <!-- End Item -->
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-12 col-sm-4 wow latest-pro small-pr-slider">
                        <div class="slider-items-products">
                            <div class="new_title center">
                                <h2>Sản phẩm mới nhất</h2>
                            </div>
                            <div id="latest-deals-slider" class="product-flexslider hidden-buttons latest-item">
                                <div class="slider-items slider-width-col4">

                                    @foreach ($newest_products as $product)
                                        <!-- Item -->
                                        <div class="item">
                                            <div class="col-item">
                                                <div class="images-container">
                                                    <a class="product-image" title="{{ $product->name }}"
                                                        href="{{ route('product_details', ['id' => $product->id]) }}">
                                                        <img src="{{ asset('storage/images/products/' . $product->image) }}"
                                                            class="img-responsive" alt="a" />
                                                    </a>
                                                    <div class="actions">
                                                        <div class="actions-inner">
                                                            <ul class="add-to-links">
                                                                <li>
                                                                    @if (Auth::user())
                                                                        <a onclick="add_to_wish_list({{ $product->id }});"
                                                                            title="Ưu thích" class="link-wishlist">
                                                                            <span>Ưu thích</span>
                                                                        </a>
                                                                    @else
                                                                        <a onclick="alert('You need to login to add this product to the wish list!');"
                                                                            title="Ưu thích" class="link-wishlist">
                                                                            <span>Ưu thích</span></a>
                                                                    @endif
                                                                </li>
                                                                <li><a onclick="add_to_compare({{ $product->id }})"
                                                                        title="Thêm vào so sánh" class="link-compare ">
                                                                        <span>Thêm vào so sánh</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="qv-button-container">
                                                        <a class="qv-e-button btn-quickview-1"
                                                            onclick="return quick_view({{ $product->id }});">
                                                            <span><span>Xem nhanh</span></span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="info">
                                                    <div class="info-inner">
                                                        <div class="item-title">
                                                            <a title="{{ $product->name }}"
                                                                href="{{ route('product_details', ['id' => $product->id]) }}">
                                                                {{ $product->name }}
                                                            </a>
                                                        </div>
                                                        <!--item-title-->
                                                        <div class="item-content">
                                                            <div class="ratings">
                                                                <div class="rating-box">
                                                                    <div style="width:{{ $product->rating * 20 }}%"
                                                                        class="rating">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="price-box">
                                                                @if ($product->discount != null)
                                                                    <p class="special-price">
                                                                        <span class="price">
                                                                            {{ $product->price - ($product->price * $product->discount) / 100 }}
                                                                            <small> đ</small>
                                                                        </span>
                                                                    </p>
                                                                    <p class="old-price">
                                                                        <span class="price-sep">-</span>
                                                                        <span class="price">{{ $product->price }}
                                                                            <small> đ</small>
                                                                        </span>
                                                                    </p>
                                                                @else
                                                                    <p class="regular-price">
                                                                        <span class="price">
                                                                            {{ $product->price }}<small> đ</small>
                                                                        </span>
                                                                    </p>
                                                                @endif

                                                            </div>
                                                        </div>
                                                        <!--item-content-->
                                                    </div>
                                                    <!--info-inner-->
                                                    <div class="actions">
                                                        <button class="button btn-cart"
                                                            onclick="return add_to_cart({{ $product->id }});"
                                                            title="Thêm vào giỏ hàng" type="button"><span>Thêm vào giỏ
                                                                hàng</span></button>
                                                    </div>
                                                    <!--actions-->
                                                    <div class="clearfix"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Item -->
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End main container -->
    <!-- recommend slider -->
    <section class="recommend container">
        <div class="new-pro-slider small-pr-slider" style="overflow:visible">
            <div class="slider-items-products">
                <div class="new_title center">
                    <h2>Sản phẩm đề cử</h2>
                </div>
                <div id="recommend-slider" class="product-flexslider hidden-buttons">
                    <div class="slider-items slider-width-col3">
                        @foreach ($feature_products as $product)
                            <!-- Item -->
                            @include('components.customer.display.product2')
                            <!-- End Item -->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Recommend slider -->
    <!-- banner section -->

    <!-- End banner section -->
    <!-- middle slider -->
    <section class="middle-slider container">
        <div class="row">
            <div class="col-sm-4 custom-slider">
                <div>
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            @for ($i = 0; $i < 2; $i++)
                                <div class="item 
                                        @if ($i==0) active @endif "> <img
                                            src="
                                    {{ asset('/storage/images/collections/' . $two_newest_collections[$i]->image) }}"
                                    alt="{{ $two_newest_collections[$i]->name }}">
                                    <div class="carousel-caption">
                                        <h3><a href=""
                                                title="{{ $two_newest_collections[1]->name }}">{{ $two_newest_collections[$i]->name }}</a>
                                        </h3>
                                        <p>{!! $two_newest_collections[$i]->description !!}</p>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span
                                class="sr-only">Previous</span> </a> <a class="right carousel-control"
                            href="#carousel-example-generic" role="button" data-slide="next"> <span
                                class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span
                                class="sr-only">Next</span> </a>
                    </div>
                </div>
            </div>
            @foreach ($two_newest_collections as $collection)
                <div class="col-sm-4 pro-block">
                    <div class="inner-div">
                        <h2 class="category-pro-title"><span>{{ $collection->name }} Collection</span></h2>
                        <div class="category-products">
                            <div class="products small-list">
                                @for ($i = 0; $i < $collection->collectionProducts()->count(); $i++)
                                    <div class="item">
                                        <div class="item-area">
                                            <div class="product-image-area"> <a
                                                    href="{{ route('product_details', ['id' => $collection->collectionProducts[$i]->product->id]) }}"
                                                    class="product-image"> <img
                                                        src="{{ asset('storage/images/products/' . $collection->collectionProducts[$i]->product->image) }}"
                                                        alt="products images"> </a> </div>
                                            <div class="details-area">
                                                <h2 class="product-name"><a
                                                        href="{{ route('product_details', ['id' => $collection->collectionProducts[$i]->product->id]) }}">{{ $collection->collectionProducts[$i]->product->name }}</a>
                                                </h2>
                                                <div class="ratings">
                                                    <div class="rating-box">
                                                        <div style="width:{{ $collection->collectionProducts[$i]->product->rating * 20 }}%"
                                                            class="rating"></div>
                                                    </div>
                                                </div>
                                                <div class="price-box">
                                                    @if ($collection->collectionProducts[$i]->product->discount != null)
                                                        <p class="special-price"> <span class="price">
                                                                {{ $collection->collectionProducts[$i]->product->price - ($collection->collectionProducts[$i]->product->price * $collection->collectionProducts[$i]->product->discount) / 100 }}
                                                                <small> đ</small>
                                                            </span>
                                                        </p>
                                                        <p class="old-price"> <span class="price-sep">-</span> <span
                                                                class="price">
                                                                {{ $collection->collectionProducts[$i]->product->price }}
                                                                <small> đ</small>
                                                            </span> </p>
                                                    @else
                                                        <p class="regular-price"> <span class="price">
                                                                {{ $collection->collectionProducts[$i]->product->price }}
                                                                <small> đ</small>
                                                            </span>
                                                        </p>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @break($i == 2)
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <!-- End middle slider -->
    <!-- promo banner section -->
    <div class="promo-banner-section container wow">
        <div class="container">
            <div class="row"> <img alt="promo-banner3" src="{{ url('images/bottom-banner.jpg') }}"></div>
        </div>
    </div>
    <!-- End promo banner section -->

    <!-- Latest Blog -->
    <section class="latest-blog container wow">
        <div class="blog-title">
            <h2><span>Latest Coupon</span></h2>
        </div>
        <div class="row">
            @foreach ($coupons as $coupon)
                <div class="col-xs-12 col-sm-4">
                    <div class="blog-img">
                        <img style="height: 250px; width:100%;object-fit:cover;" class="img-responsive"
                            src="{{ asset('/storage/images/coupons/' . $coupon->image) }}" alt="{{ $coupon->name }}">
                    </div>
                    <h4 class="item-title">{{ $coupon->name }}</h4>
                    <p class="text-primary">Code : {{ $coupon->code }}
                    <p>
                    <div class="post-date"><i class="icon-calendar"></i> {{ $coupon->created_at }}</div>
                </div>
            @endforeach
        </div>
    </section>
    <!-- End Latest Blog -->

    <!-- Featured Slider -->
    <section class="featured-pro wow animated parallax parallax-2">
        <div class="container">
            <div class="std">
                <div class="slider-items-products">
                    <div class="featured_title center">
                        <h2>Sản phẩm hạ giá</h2>
                    </div>
                    <div id="featured-slider" class="product-flexslider hidden-buttons">
                        <div class="slider-items slider-width-col4">
                            @foreach ($sale_products as $product)
                                <!-- Item -->
                                @include('components.customer.display.product')
                                <!-- End Item -->
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Featured Slider -->
    <script type='text/javascript'>
        jQuery(document).ready(function() {
            jQuery('#rev_slider_4').show().revolution({
                dottedOverlay: 'none',
                delay: 5000,
                startwidth: 1170,
                startheight: 580,

                hideThumbs: 200,
                thumbWidth: 200,
                thumbHeight: 50,
                thumbAmount: 2,

                navigationType: 'thumb',
                navigationArrows: 'solo',
                navigationStyle: 'round',

                touchenabled: 'on',
                onHoverStop: 'on',

                swipe_velocity: 0.7,
                swipe_min_touches: 1,
                swipe_max_touches: 1,
                drag_block_vertical: false,

                spinner: 'spinner0',
                keyboardNavigation: 'off',

                navigationHAlign: 'center',
                navigationVAlign: 'bottom',
                navigationHOffset: 0,
                navigationVOffset: 20,

                soloArrowLeftHalign: 'left',
                soloArrowLeftValign: 'center',
                soloArrowLeftHOffset: 20,
                soloArrowLeftVOffset: 0,

                soloArrowRightHalign: 'right',
                soloArrowRightValign: 'center',
                soloArrowRightHOffset: 20,
                soloArrowRightVOffset: 0,

                shadow: 0,
                fullWidth: 'on',
                fullScreen: 'off',

                stopLoop: 'off',
                stopAfterLoops: -1,
                stopAtSlide: -1,

                shuffle: 'off',

                autoHeight: 'off',
                forceFullWidth: 'on',
                fullScreenAlignForce: 'off',
                minFullScreenHeight: 0,
                hideNavDelayOnMobile: 1500,

                hideThumbsOnMobile: 'off',
                hideBulletsOnMobile: 'off',
                hideArrowsOnMobile: 'off',
                hideThumbsUnderResolution: 0,

                hideSliderAtLimit: 0,
                hideCaptionAtLimit: 0,
                hideAllCaptionAtLilmit: 0,
                startWithSlide: 0,
                fullScreenOffsetContainer: ''
            });
        });

    </script>
@endsection
