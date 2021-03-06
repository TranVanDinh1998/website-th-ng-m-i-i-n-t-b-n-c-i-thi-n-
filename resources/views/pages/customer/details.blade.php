@extends('layouts.customer.index')
@section('title', 'Details - Electronical Store')
@section('content')
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <ul>
                    <li class="home"> <a href="{{ route('home') }}" title="Trở về trang chủ">Trang
                            chủ</a><span>&mdash;›</span>
                    </li>
                    <li class="category13"> <a href="{{ URL::to('filter/' . $relative_category->id) }}"
                            title="Go to Home Page">{{ $relative_category->name }}</a><span>&mdash;›</span></li>
                    <li class=""><strong> {{ $product->name }} </strong></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end breadcrumbs -->
    <!-- main-container -->

    <section class="main-container col1-layout">
        <div class="main container">
            <div class="col-main">
                <div class="row">
                    <div class="product-view wow">
                        <div class="product-essential">
                            <div class="product-img-box col-lg-6 col-sm-6 col-xs-12">
                                <ul class="moreview" id="moreview">
                                    <li class="moreview_thumb thumb_1 moreview_thumb_active">
                                        <img class="moreview_thumb_image"
                                            src="{{ asset('storage/images/products/' . $product->image) }}">
                                        <img class="moreview_source_image"
                                            src="{{ asset('storage/images/products/' . $product->image) }}" alt="">
                                        <span class="roll-over">Cuộn qua hình ảnh để phóng to</span>
                                        <img style="position: absolute;" class="zoomImg"
                                            src="{{ asset('storage/images/products/' . $product->image) }}">
                                    </li>
                                    @for ($i = 0; $i < $count_images; $i++)
                                        <li class="moreview_thumb thumb_{{ $i + 2 }}">
                                            <img class="moreview_thumb_image" {{-- src="{{ url('uploads/products-images/' . $product->id . '/' . $product_images[$i]->image) }}" --}}
                                                src="{{ asset('storage/images/products/' . $product->images[$i]->image) }}">
                                            <img class="moreview_source_image"
                                                src="{{ asset('storage/images/products/' . $product->images[$i]->image) }}"
                                                alt="">
                                            <span class="roll-over">Cuộn qua hình ảnh để phóng to</span>
                                            <img style="position: absolute;" class="zoomImg"
                                                src="{{ asset('storage/images/products/' . $product->images[$i]->image) }}">
                                        </li>
                                    @endfor

                                </ul>
                                <div class="moreview-control"> <a style="right: 42px;" href="javascript:void(0)"
                                        class="moreview-prev"></a> <a style="right: 42px;" href="javascript:void(0)"
                                        class="moreview-next"></a> </div>
                            </div>

                            <!-- end: more-images -->

                            <div class="product-shop col-lg-6 col-sm-6 col-xs-12">
                                <div class="product-name">
                                    <h1>{{ $product->name }}</h1>
                                </div>
                                <div class="ratings">
                                    <div class="rating-box">
                                        <div style="width: {{ $product->rating * 20 }}%" class="rating"></div>
                                    </div>
                                    <p class="rating-links"> <a href="#">{{ count($reviews) }} Đánh giá</a> <span
                                            class="separator">|</span> <a href="#product-detail-tab">Thêm đánh giá của
                                            bạn</a>
                                    </p>
                                </div>
                                <p class="availability in-stock"><span>
                                        @if ($product->remaining != 0)
                                            Còn hàng
                                        @else
                                            Hết hàng
                                        @endif
                                    </span></p>
                                <div class="price-block">
                                    <div class="price-box">
                                        @if ($product->discount != null)
                                            <p class="old-price"> <span class="price-label">Giá thông thường:</span> <span
                                                    class="price"> {{ $product->price }} đ </span> </p>
                                            <p class="special-price"> <span class="price-label">Giá đặc biệt</span> <span
                                                    class="price">
                                                    {{ $product->price - ($product->price * $product->discount) / 100 }}
                                                    đ
                                                </span> </p>
                                        @else
                                            <p class="regular-price"> <span class="price-label">Đơn giá :</span> <span
                                                    class="price"> {{ $product->price }} đ </span> </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="price-block">
                                    <div class="price-box">
                                        <p>Thể loại :
                                            <a href="{{ route('filter', ['category_id' => $product->category->id]) }}">
                                                {{ $product->category->name }} </a>
                                        </p>
                                        <p>Hãng :
                                            {{ $product->producer->name }}
                                        </p>
                                        <p>Đã bán : {{ $product->quantity - $product->remaining }}</p>
                                        <p>Tồn kho : {{ $product->remaining }}</p>
                                    </div>
                                </div>
                                <div class="short-description">
                                    <h2>Tổng quan</h2>
                                </div>
                                <div class="add-to-box">
                                    <div>
                                        <button type="button" onclick="add_to_cart({{ $product->id }});"
                                            title="Thêm vào giỏ hàng" class="button btn-cart"><span>Thêm vào giỏ hàng</span>
                                        </button>
                                    </div>

                                    <div class="email-addto-box">
                                        <ul class="add-to-links">
                                            <li> <a class="link-wishlist"
                                                    onclick="add_to_wish_list({{ $product->id }});"><span>Ưu
                                                        thích</span></a></li>
                                            <li><span class="separator">|</span> <a class="link-compare"
                                                    onclick="return add_to_compare({{ $product->id }});"><span>So
                                                        sánh</span></a></li>
                                        </ul>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-collateral">
                            <div class="col-sm-12 wow">
                                <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                                    <li class="active"> <a href="#product_tabs_description" data-toggle="tab"> Mô tả sản
                                            phẩm </a> </li>
                                    <li><a href="#product_tabs_tags" data-toggle="tab">Thẻ</a></li>
                                    <li> <a href="#reviews_tabs" data-toggle="tab">Đánh giá</a> </li>
                                </ul>
                                <div id="productTabContent" class="tab-content">
                                    <div class="tab-pane fade in active" id="product_tabs_description">
                                        <div class="std">
                                            <p>{!! $product->description !!}</p>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="product_tabs_tags">
                                        <div class="box-collateral box-tags">
                                            <div class="tags">
                                                <p class="note">You can use these tags to search for similar products.
                                                </p>
                                                @if ($product->has('tagProducts'))
                                                    @foreach ($product->tagProducts as $tagProduct)
                                                        <a href="{{ route('tag', ['tag_id' => $tagProduct->tag->id]) }}"
                                                            class="button">{{ $tagProduct->tag->name }}</a>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <!--tags-->
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="reviews_tabs">
                                        <div class="box-collateral box-reviews" id="customer-reviews">
                                            <div class="box-reviews1">
                                                <div class="form-add">
                                                    <form id="review_form" action="{{ URL::to('/account/review') }}"
                                                        method="post">
                                                        @csrf
                                                        <h3>Viết đánh giá của bạn</h3>
                                                        <div id="errorMessage"></div>
                                                        <fieldset>
                                                            <h4>Bạn đánh giá sản phẩm này như thể nào? <em
                                                                    class="required">*</em>
                                                            </h4>
                                                            <span id="input-message-box"></span>
                                                            <table id="product-review-table" class="data-table">
                                                                <colgroup>
                                                                    <col>
                                                                    <col width="1">
                                                                    <col width="1">
                                                                    <col width="1">
                                                                    <col width="1">
                                                                    <col width="1">
                                                                </colgroup>
                                                                <thead>
                                                                    <tr class="first last">
                                                                        <th>&nbsp;</th>
                                                                        <th><span class="nobr">1 *</span></th>
                                                                        <th><span class="nobr">2 *</span></th>
                                                                        <th><span class="nobr">3 *</span></th>
                                                                        <th><span class="nobr">4 *</span></th>
                                                                        <th><span class="nobr">5 *</span></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="first odd">
                                                                        <th>Giá cả</th>
                                                                        <td class="value"><input type="radio" class="radio"
                                                                                value="1" id="Price_1" name="price_rate">
                                                                        </td>
                                                                        <td class="value"><input type="radio" class="radio"
                                                                                value="2" id="Price_2" name="price_rate">
                                                                        </td>
                                                                        <td class="value"><input type="radio" class="radio"
                                                                                value="3" id="Price_3" name="price_rate">
                                                                        </td>
                                                                        <td class="value"><input type="radio" class="radio"
                                                                                value="4" id="Price_4" name="price_rate">
                                                                        </td>
                                                                        <td class="value last"><input type="radio"
                                                                                class="radio" value="5" id="Price_5"
                                                                                name="price_rate"></td>
                                                                    </tr>
                                                                    <tr class="even">
                                                                        <th>Giá trị sử dụng</th>
                                                                        <td class="value"><input type="radio" class="radio"
                                                                                value="1" id="Value_1" name="value_rate">
                                                                        </td>
                                                                        <td class="value"><input type="radio" class="radio"
                                                                                value="2" id="Value_2" name="value_rate">
                                                                        </td>
                                                                        <td class="value"><input type="radio" class="radio"
                                                                                value="3" id="Value_3" name="value_rate">
                                                                        </td>
                                                                        <td class="value"><input type="radio" class="radio"
                                                                                value="4" id="Value_4" name="value_rate">
                                                                        </td>
                                                                        <td class="value last"><input type="radio"
                                                                                class="radio" value="5" id="Value_5"
                                                                                name="value_rate"></td>
                                                                    </tr>
                                                                    <tr class="last odd">
                                                                        <th>Chất lượng</th>
                                                                        <td class="value"><input type="radio" class="radio"
                                                                                value="1" id="Quality_1"
                                                                                name="quality_rate">
                                                                        </td>
                                                                        <td class="value"><input type="radio" class="radio"
                                                                                value="2" id="Quality_2"
                                                                                name="quality_rate">
                                                                        </td>
                                                                        <td class="value"><input type="radio" class="radio"
                                                                                value="3" id="Quality_3"
                                                                                name="quality_rate">
                                                                        </td>
                                                                        <td class="value"><input type="radio" class="radio"
                                                                                value="4" id="Quality_4"
                                                                                name="quality_rate">
                                                                        </td>
                                                                        <td class="value last"><input type="radio"
                                                                                class="radio" value="5" id="Quality_5"
                                                                                name="quality_rate"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <input type="hidden" value="{{ $product->id }}"
                                                                class="validate-rating" name="product_id">
                                                            <div class="review1">
                                                                <ul class="form-list">
                                                                    <li>
                                                                        <label class="required" for="summary_field">Tóm
                                                                            tắt<em>*</em></label>
                                                                        <div class="input-box">
                                                                            <input type="text"
                                                                                class="input-text required-entry"
                                                                                id="summary_field" name="summary">
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="review2">
                                                                <ul>
                                                                    <li>
                                                                        <label class="required label-wide"
                                                                            for="review_field">Đánh giá<em>*</em></label>
                                                                        <div class="input-box">
                                                                            <textarea class="required-entry" rows="3"
                                                                                cols="5" name="description"></textarea>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                                <div class="buttons-set">
                                                                    <button class="button submit" title="Gửi đánh giá"
                                                                        type="submit"><span>Gửi đánh giá</span></button>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="box-reviews2">
                                                <h3>Các đánh giá của khách hàng</h3>
                                                <div class="box visible">
                                                    <ul>
                                                        @foreach ($reviews as $review)
                                                            <li>
                                                                <table class="ratings-table">
                                                                    <colgroup>
                                                                        <col width="1">
                                                                        <col>
                                                                    </colgroup>
                                                                    <tbody>
                                                                        <tr>
                                                                            <th>Giá trị sử dụng</th>
                                                                            <td>
                                                                                <div class="rating-box">
                                                                                    <div class="rating"
                                                                                        style="width:{{ $review->value_rate * 20 }}%;">
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Chất lượng</th>
                                                                            <td>
                                                                                <div class="rating-box">
                                                                                    <div class="rating"
                                                                                        style="width:{{ $review->quality_rate * 20 }}%;">
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Giá cả</th>
                                                                            <td>
                                                                                <div class="rating-box">
                                                                                    <div class="rating"
                                                                                        style="width:{{ $review->price_rate * 20 }}%;">
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <div class="review">
                                                                    <h6><a href="">{{ $review->summary }}</a>
                                                                    </h6>
                                                                    <small>Được đánh giá bởi
                                                                        <span>
                                                                            {{ $review->user->name }}
                                                                        </span>on {{ $review->created_at }}
                                                                    </small>
                                                                    <div class="review-txt"> {{ $review->description }}
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                {{-- <div class="col-sm-7 text-right text-center-xs">
                                                    <ul class="pagination pagination-sm m-t-none m-b-none">
                                                        {!! $reviews->links() !!}
                                                    </ul>
                                                </div> --}}
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="box-additional">
                                    <div class="related-pro wow">
                                        <div class="slider-items-products">
                                            <div class="new_title center">
                                                <h2>Cùng bộ sưu tập</h2>
                                            </div>
                                            <div id="related-products-slider" class="product-flexslider hidden-buttons">
                                                <div class="slider-items slider-width-col4">
                                                    @if ($same_collection_products != null)
                                                        @foreach ($same_collection_products as $product)
                                                            <!-- Item -->
                                                            @include('components.customer.display.product')
                                                            <!-- End Item -->
                                                        @endforeach
                                                    @else
                                                        <div class="inner-text">
                                                            <h3>None<h3>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="upsell-pro wow">
                                        <div class="slider-items-products">
                                            <div class="new_title center">
                                                <h2>Cùng thể loại</h2>
                                            </div>
                                            <div id="upsell-products-slider" class="product-flexslider hidden-buttons">
                                                <div class="slider-items slider-width-col4">
                                                    @foreach ($same_category_products as $product)
                                                        <!-- Item -->
                                                        @include('components.customer.display.product')
                                                        <!-- End Item -->
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End main-container -->
@endsection
