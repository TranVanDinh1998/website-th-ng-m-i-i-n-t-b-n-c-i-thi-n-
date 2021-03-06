@extends('layouts.customer.index')
@section('title', 'Filter')
@section('content')
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <ul>
                    <li class="home"> <a href="{{ route('home') }}" title="Trở về trang chủ">Trang
                            chủ</a><span>&mdash;›</span>
                    </li>
                    <li class=""> <a href="{{ route('filter', ['category_id' => $category->id]) }}"
                            title="Go to category {{ $category->name }}">{{ $category->name }}</a><span>&mdash;›</span>
                    </li>
                    @if ($collection != null)
                        <li class="category13"><strong>{{ $collection->name }}</strong></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <!-- End breadcrumbs -->

    <!-- Two columns content -->
    <section class="main-container col2-left-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 col-sm-push-3 wow">
                    <div class="category-title">
                        @if ($collection != null)
                            <h1>{{ $category->name }} - <strong>{{ $collection->name }}</strong></h1>
                        @else
                            <h1>{{ $category->name }}</h1>
                        @endif
                    </div>
                    <!-- category banner -->
                    <div class="category-description std">
                        <div class="slider-items-products">
                            <div id="category-desc-slider" class="product-flexslider hidden-buttons">
                                <div class="slider-items slider-width-col1">
                                    @if ($collection != null)
                                        <!-- Item -->
                                        <div class="item"> <a href="#"><img class="img-responsive"
                                                    style="width:100%;height:200px; object-fit:cover;" alt="category-banner"
                                                    src="{{ asset('/storage/images/collections/' . $collection->image) }}"></a>
                                            <div class="cat-img-title cat-bg cat-box">
                                                <p>{!! $collection->description !!}
                                                </p>
                                            </div>
                                        </div>
                                        <!-- End Item -->
                                    @endif

                                    <!-- Item -->
                                    <div class="item"> <a href="#x"><img class="img-responsive"
                                                style="width:100%;height:200px; object-fit:cover;" alt="category-banner"
                                                src="{{ asset('/storage/images/categories/' . $category->image) }}"></a>
                                    </div>
                                    <!-- End Item -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- category banner -->
                    <div class="category-products">
                        <div class="toolbar">
                            <div class="sorter">
                                <div class="view-mode">
                                    <button id="btn_filter_list" title="Dạng lưới" class="button button-list">Dạng
                                        lưới</button>
                                    <button id="btn_filter_grid" title="Dạng danh sách" class="button button-grid">Dạng danh
                                        sách</button>
                                </div>
                            </div>
                            <div id="sort-by">
                                <label class="left">Sắp xếp theo: </label>
                                <ul>
                                    <li>
                                        <a
                                            href="{{ route('filter', ['category_id' => $category_id, 'collection_id' => $collection_id, 'sort' => 0, 'view' => $view, 'producer_id' => $producer_id, 'price_from' => $price_from, 'price_to' => $price_to]) }}">Vị
                                            trí<span class="right-arrow"></span>
                                        </a>
                                        <ul>
                                            <li><a
                                                    href="{{ route('filter', ['category_id' => $category_id, 'collection_id' => $collection_id, 'sort' => 1, 'view' => $view, 'producer_id' => $producer_id, 'price_from' => $price_from, 'price_to' => $price_to]) }}">Tên</a>
                                            </li>
                                            <li><a
                                                    href="{{ route('filter', ['category_id' => $category_id, 'collection_id' => $collection_id, 'sort' => 2, 'view' => $view, 'producer_id' => $producer_id, 'price_from' => $price_from, 'price_to' => $price_to]) }}">Đơn
                                                    giá</a>
                                            </li>
                                            <li><a
                                                    href="{{ route('filter', ['category_id' => $category_id, 'collection_id' => $collection_id, 'sort' => 3, 'view' => $view, 'producer_id' => $producer_id, 'price_from' => $price_from, 'price_to' => $price_to]) }}">Xếp
                                                    hạng</a>
                                            </li>
                                            <li><a
                                                    href="{{ route('filter', ['category_id' => $category_id, 'collection_id' => $collection_id, 'sort' => 4, 'view' => $view, 'producer_id' => $producer_id, 'price_from' => $price_from, 'price_to' => $price_to]) }}">Bán
                                                    chạy</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <a class="button-asc left" href="#" title="Set Descending Direction"><span
                                        style="color:#999;font-size:11px;" class="glyphicon glyphicon-arrow-up"></span></a>
                            </div>
                            <div class="pager">
                                <div id="limiter">
                                    <label>Xem: </label>
                                    <ul>
                                        <li><a
                                                href="{{ route('filter', ['category_id' => $category_id, 'collection_id' => $collection_id, 'sort' => $sort, 'view' => 15, 'producer_id' => $producer_id, 'price_from' => $price_from, 'price_to' => $price_to]) }}">15<span
                                                    class="right-arrow"></span>
                                            </a>
                                            <ul>
                                                <li><a
                                                        href="{{ route('filter', ['category_id' => $category_id, 'collection_id' => $collection_id, 'sort' => $sort, 'view' => 20, 'producer_id' => $producer_id, 'price_from' => $price_from, 'price_to' => $price_to]) }}">20
                                                    </a>
                                                </li>
                                                <li><a
                                                        href="{{ route('filter', ['category_id' => $category_id, 'collection_id' => $collection_id, 'sort' => $sort, 'view' => 30, 'producer_id' => $producer_id, 'price_from' => $price_from, 'price_to' => $price_to]) }}">30
                                                    </a>
                                                </li>
                                                <li><a
                                                        href="{{ route('filter', ['category_id' => $category_id, 'collection_id' => $collection_id, 'sort' => $sort, 'view' => 35, 'producer_id' => $producer_id, 'price_from' => $price_from, 'price_to' => $price_to]) }}">35
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="pages">
                                    <ul class="pagination">
                                        {!! $products->withQueryString()->links() !!}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- display product in grid view --}}
                        <div id="filter_grid">
                            @include('components.customer.display.grid');
                        </div>
                        {{-- end of grid view --}}

                        {{-- display product in list view --}}
                        <div id="filter_list" style="display: none;">
                            @include('components.customer.display.list')
                        </div>
                        {{-- end of list view --}}
                    </div>
                </section>
                {{-- start filter side bar --}}
                {{-- side bar for filter page --}}
                <aside class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9 wow">
                    <div class="side-nav-categories">
                        <div class="block-title"> Các thể loại </div>
                        <!--block-title-->
                        <!-- BEGIN BOX-CATEGORY -->
                        <div class="box-content box-category">
                            <ul>
                                @foreach ($categories as $category)
                                    <li> <a href="{{ route('filter', ['category_id' => $category->id]) }}"
                                            class="active">{{ $category->name }}</a>
                                        <span class="subDropdown plus"></span>
                                        <ul class="level1" style="display:none">
                                            @foreach ($category->collections as $collection)
                                                <li> <a
                                                        href="{{ route('filter', ['category_id' => $category->id, 'collection_id' => $collection->id]) }}">
                                                        <span>{{ $collection->name }}</span></a> </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!--box-content box-category-->
                    </div>
                    <div class="block block-layered-nav">
                        <div class="block-title"><span>Mua hàng theo</span></div>
                        <div class="block-content">
                            <p class="block-subtitle">Các tiêu chí mua hàng</p>
                            <dl id="narrow-by-list">
                                <dt class="odd">Giá cả</dt>
                                <dd class="odd">
                                    <ol>
                                        <li> <a
                                                href="{{ route($page, ['category_id' => $category_id, 'collection_id' => $collection_id, 'producer_id' => $producer_id, 'sort' => $sort, 'view' => $view, 'price_to' => 500000]) }}"><span
                                                    class="price">0</span> - <span class="price">500000
                                                    <small>d</small></span></a>
                                            {{-- (6) --}}
                                        </li>
                                        <li> <a
                                                href="{{ route($page, ['category_id' => $category_id, 'collection_id' => $collection_id, 'producer_id' => $producer_id, 'sort' => $sort, 'view' => $view, 'price_from' => 500000, 'price_to' => 1000000]) }}"><span
                                                    class="price">500000</span> - <span class="price">1000000
                                                    <small>d</small></span></a>
                                            {{-- (6) --}}
                                        </li>
                                        <li> <a
                                                href="{{ route($page, ['category_id' => $category_id, 'collection_id' => $collection_id, 'producer_id' => $producer_id, 'sort' => $sort, 'view' => $view, 'price_from' => 1000000, 'price_to' => 2000000]) }}"><span
                                                    class="price">1000000</span> - <span class="price">2000000
                                                    <small>d</small></span></a>
                                            {{-- (6) --}}
                                        </li>
                                        <li> <a
                                                href="{{ route($page, ['category_id' => $category_id, 'collection_id' => $collection_id, 'producer_id' => $producer_id, 'sort' => $sort, 'view' => $view, 'price_from' => 2000000, 'price_to' => 5000000]) }}"><span
                                                    class="price">2000000</span> - <span class="price">5000000
                                                    <small>d</small></span></a>
                                            {{-- (6) --}}
                                        </li>
                                        <li> <a
                                                href="{{ route($page, ['category_id' => $category_id, 'collection_id' => $collection_id, 'producer_id' => $producer_id, 'sort' => $sort, 'view' => $view, 'price_from' => 5000000]) }}"><span
                                                    class="price">5000000 <small>d</small></span> and above</a>
                                            {{-- (6) --}}
                                        </li>
                                    </ol>
                                </dd>
                                <dt class="even">Hãng</dt>
                                <dd class="even">
                                    <ol>
                                        @foreach ($producers as $producer)
                                            <li> <a
                                                    href="{{ route($page, ['category_id' => $category_id, 'collection_id' => $collection_id, 'producer_id' => $producer->id, 'sort' => $sort, 'view' => $view, 'price_from' => $price_from, 'price_to' => $price_to]) }}">{{ $producer->name }}</a>
                                                @foreach ($producers_record_count as $producer_id => $count)
                                                    @if ($producer_id == $producer->id)
                                                        ({{ $count }})
                                                    @endif
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ol>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="block block-cart">
                        <div class="block-title"><span>Giỏ hàng</span></div>
                        <div class="block-content">
                            <div class="summary">
                                <p class="amount">
                                    <a href="{{ URL::to('cart') }}">
                                        Có
                                        @if ($count_cart != 0 && $count_cart != null)
                                            {{ $count_cart }}
                                        @else
                                            0
                                        @endif
                                        sản phẩm trong giỏ hàng của bạn.
                                    </a>
                                </p>
                                <p class="subtotal"> <span class="label">Tổng giá trị giỏ hàng:</span> <span class="price">
                                        @if ($total_cart != 0) {{ $total_cart }}
                                        d @else 0 @endif
                                    </span> </p>
                            </div>
                            <div class="ajax-checkout">
                                <a title="Checkout" href="{{ URL::to('/check-out') }}"><span class="hidden-xs">Thủ tục
                                        mua hàng</span></a>
                            </div>
                            @if (isset($shopping_carts))
                                <p class="block-subtitle">Những sản phẩm mới thêm gần đây </p>
                                <ul>
                                    @foreach ($shopping_carts as $product_id => $info)
                                        <li class="item"> <a class="product-image" title="Fisher-Price Bubble Mower"
                                                href="#"><img width="80" alt="Fisher-Price Bubble Mower"
                                                    src="{{ asset('storage/images/products/' . $info['product_image']) }}"></a>
                                            <div class="product-details">
                                                <div class="access"> <a class="btn-remove1" title="Remove This Item"
                                                        onclick="remove_item_from_cart({{ $product_id }})"> <span
                                                            class="icon"></span>
                                                        Remove </a> </div>
                                                <p class="product-name"> <a
                                                        href="{{ route('product_details', ['id' => $product_id]) }}">{{ $info['product_name'] }}</a>
                                                </p>
                                                <strong>{{ $info['product_quantity'] }}</strong> x <span
                                                    class="price">{{ $info['product_price'] - ($info['product_price'] * $info['product_discount']) / 100 }}
                                                    d</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="block block-list block-viewed">
                        <div class="block-title"><span>Các sản phẩm đã xem gần đây</span> </div>
                        <div class="block-content">
                            <ol id="recently-viewed-items">
                                @if (isset($recent_views))
                                    @foreach ($recent_views as $product_id => $info)
                                        <li class="item odd">
                                            <p class="product-name"><a
                                                    href="{{ route('product_details', ['id' => $product_id]) }}">{{ $info['product_name'] }}</a>
                                            </p>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="item odd active">
                                        <p class="product-name"><a href="#">None</a></p>
                                    </li>
                                @endif
                            </ol>
                        </div>
                    </div>
                    <div class="block block-compare">
                        <div class="block-title "><span>So sánh các sản phẩm ({{ $count_compare }})</span></div>
                        <div class="block-content">
                            <ol id="compare-items">
                                @if (isset($compare))
                                    @foreach ($compare as $product_id => $info)
                                        <li class="item odd">
                                            <input type="hidden" value="2173" class="compare-item-id">
                                            <a class="btn-remove1" title="Remove This Item"
                                                onclick="return remove_item_from_compare({{ $product_id }})"></a> <a
                                                href="{{ route('product_details', ['id' => $product_id]) }}"
                                                class="product-name">{{ $info['product_name'] }}</a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="item odd active">
                                        <p class="product-name"><a href="#">Trống</a></p>
                                    </li>
                                @endif
                            </ol>
                            <div class="ajax-checkout">
                                <a href="{{ route('compare.index') }}" type="submit" title="Submit" onclick=""
                                    class="button button-compare"><span>So sánh</span></a>
                                <button type="submit" onclick="return remove_compare();" title="Submit"
                                    class="button button-clear"><span>Xóa</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="block block-tags">
                        <div class="block-title"><span>Các thẻ phổ biến</span></div>
                        <div class="block-content">
                            <ul class="tags-list">
                                @if ($tags != null)
                                    @foreach ($tags as $tag)
                                        <li><a href="{{ route('tag', ['tag_id' => $tag->id]) }}"
                                                class="btn btn-continue button">{{ $tag->name }}</a></li>
                                    @endforeach
                                @endif
                            </ul>

                        </div>
                    </div>

                </aside>
                {{-- end of side bar for filter --}}

                {{-- end filter side bar --}}
            </div>
        </div>
    </section>
    <!-- End Two columns content -->
    <script>
        $(document).ready(function() {
            // $('#pages .nav').removeClass('sticky');
            $('#btn_filter_grid').click(function() {
                $('#filter_grid').show();
                $('#filter_list').hide();
                $('#btn_filter_grid').addClass('button-active');
                $('#btn_filter_list').removeClass('button-active');
            });
            $('#btn_filter_list').click(function() {
                $('#filter_list').show();
                $('#filter_grid').hide();
                $('#btn_filter_list').addClass('button-active');
                $('#btn_filter_grid').removeClass('button-active');
            });
        });

    </script>
@endsection
