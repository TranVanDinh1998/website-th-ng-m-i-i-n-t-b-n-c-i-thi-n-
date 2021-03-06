@extends('layout')
@section('title', 'Advanced Search - Electronical Store')
@section('content')
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <ul>
                    <li class="home"> <a href="{{ URL::to('/') }}" title="Go to Home Page">Home</a><span>&mdash;›</span>
                    </li>
                    <li> <a href="{{ route('info.advanced_search.index') }}" title="Advanced search">Advanced
                            search</a><span>&mdash;›</span>
                    </li>
                    <li class="category13"><strong>Result</strong></li>
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
                        <h2>Advanced Searching... </h2>
                    </div>
                    @if ($count_product != null)
                        <p class="advanced-search-amount">
                            <strong>{{ $count_product }} item(s)</strong> were found using the following search criteria
                        </p>
                    @else
                        <p class="error-msg">No items were found using the following search criteria. <a
                                href="{{ route('info.advanced_search.index', ['search' => $search, 'category_id_list' => $category_id_list, 'producer_id_list' => $producer_id_list, 'price_to' => $price_to, 'price_from' => $price_from]) }}">Modify
                                your
                                search</a></p>
                    @endif
                    <div class="advanced-search-summary">
                        <ul>
                            <li><strong>Name:</strong>
                                @if ($search != null)
                                    {{ $search }}
                                @else
                                    Any
                                @endif
                            </li>
                            <li><strong>Category:</strong>
                                @if ($category_id_list != null)
                                    @foreach ($categories as $category)
                                        @foreach ($category_id_list as $id)
                                            @if ($category->id == $id)
                                                {{ $category->name }} ,
                                            @endif
                                        @endforeach
                                    @endforeach
                                @else
                                    Any
                                @endif
                            </li>
                            <li><strong>Manufacturer:</strong>
                                @if ($producer_id_list != null)
                                    @foreach ($producers as $producer)
                                        @foreach ($producer_id_list as $id)
                                            @if ($producer->id == $id)
                                                {{ $producer->name }} ,
                                            @endif
                                        @endforeach
                                    @endforeach
                                @else
                                    Any
                                @endif
                            </li>
                            <li><strong>Price:</strong>
                                @if ($price_from != null && $price_to == null)
                                    from {{ $price_from }} to greater
                                @endif
                                @if ($price_to != null && $price_from == null)
                                    from 0 to {{ $price_to }}
                                @endif
                                @if ($price_from != null && $price_to != null)
                                    {{ $price_from }} to {{ $price_to }}
                                @endif
                                @if ($price_from == null && $price_to == null)
                                    Any
                                @endif
                            </li>
                        </ul>
                        @if ($count_product != null)
                            <p class="error-msg">Not what you're looking for? <a
                                    href="{{ route('info.advanced_search.index', ['search' => $search, 'category_id_list' => $category_id_list, 'producer_id_list' => $producer_id_list, 'price_to' => $price_to, 'price_from' => $price_from]) }}">Modify
                                    your
                                    search</a>
                            </p>
                        @endif
                    </div>
                    <!-- category banner -->
                    <div class="category-description std">
                        <div class="slider-items-products">
                            <div id="category-desc-slider" class="product-flexslider hidden-buttons">
                                <div class="slider-items slider-width-col1">
                                    <!-- Item -->
                                    <div class="item"> <a href="#x"><img class="img-responsive"
                                                style="width:100%;height:200px; object-fit:cover;" alt="category-banner"
                                                src="{{ url('images/search-icon-large.png') }}"></a>
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
                                    <button id="btn_filter_list" title="List" class="button button-list">List</button>
                                    <button id="btn_filter_grid" title="Grid" class="button button-grid">Grid</button>
                                </div>
                            </div>
                            <div id="sort-by">
                                <label class="left">Sort By: </label>
                                <ul>
                                    <li>
                                        <a
                                            href="{{ route('info.advanced_search.result', ['search' => $search, 'sort' => 0, 'view' => $view,'category_id_list'=>$category_id_list,'producer_id_list'=> $producer_id_list, 'price_from' => $price_from, 'price_to' => $price_to]) }}">Position<span
                                                class="right-arrow"></span>
                                        </a>
                                        <ul>
                                            <li><a
                                                    href="{{ route('info.advanced_search.result', ['search' => $search, 'sort' => 1, 'view' => $view,'category_id_list'=>$category_id_list,'producer_id_list'=> $producer_id_list, 'price_from' => $price_from, 'price_to' => $price_to]) }}">Name</a>
                                            </li>
                                            <li><a
                                                    href="{{ route('info.advanced_search.result', ['search' => $search, 'sort' => 2, 'view' => $view,'category_id_list'=>$category_id_list,'producer_id_list'=> $producer_id_list, 'price_from' => $price_from, 'price_to' => $price_to]) }}">Price</a>
                                            </li>
                                            <li><a
                                                    href="{{ route('info.advanced_search.result', ['search' => $search, 'sort' => 3, 'view' => $view,'category_id_list'=>$category_id_list,'producer_id_list'=> $producer_id_list, 'price_from' => $price_from, 'price_to' => $price_to]) }}">Rating</a>
                                            </li>
                                            <li><a
                                                    href="{{ route('info.advanced_search.result', ['search' => $search, 'sort' => 4, 'view' => $view,'category_id_list'=>$category_id_list,'producer_id_list'=> $producer_id_list, 'price_from' => $price_from, 'price_to' => $price_to]) }}">Seller</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <a class="button-asc left" href="#" title="Set Descending Direction"><span
                                        style="color:#999;font-size:11px;" class="glyphicon glyphicon-arrow-up"></span></a>
                            </div>
                            <div class="pager">
                                <div id="limiter">
                                    <label>View: </label>
                                    <ul>
                                        <li><a
                                                href="{{ route('info.advanced_search.result', ['search' => $search, 'sort' => $sort, 'view' => 15,'category_id_list'=>$category_id_list,'producer_id_list'=> $producer_id_list, 'price_from' => $price_from, 'price_to' => $price_to]) }}">15<span
                                                    class="right-arrow"></span>
                                            </a>
                                            <ul>
                                                <li><a
                                                        href="{{ route('info.advanced_search.result', ['search' => $search, 'sort' => $sort, 'view' => 20,'category_id_list'=>$category_id_list,'producer_id_list'=> $producer_id_list, 'price_from' => $price_from, 'price_to' => $price_to]) }}">20
                                                    </a>
                                                </li>
                                                <li><a
                                                        href="{{ route('info.advanced_search.result', ['search' => $search, 'sort' => $sort, 'view' => 30,'category_id_list'=>$category_id_list,'producer_id_list'=> $producer_id_list, 'price_from' => $price_from, 'price_to' => $price_to]) }}">30
                                                    </a>
                                                </li>
                                                <li><a
                                                        href="{{ route('info.advanced_search.result', ['search' => $search, 'sort' => $sort, 'view' => 35,'category_id_list'=>$category_id_list,'producer_id_list'=> $producer_id_list, 'price_from' => $price_from, 'price_to' => $price_to]) }}">35
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
                            @include('filter_grid');
                        </div>
                        {{-- end of grid view --}}

                        {{-- display product in list view --}}
                        <div id="filter_list" style="display: none;">
                            @include('filter_list');
                        </div>
                        {{-- end of list view --}}
                    </div>
                </section>
                {{-- @include('filter_side_bar') --}}
                {{-- start filter side bar --}}
                {{-- side bar for filter page --}}
                <aside class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9 wow">
                    <div class="side-nav-categories">
                        <div class="block-title"> Categories </div>
                        <!--block-title-->
                        <!-- BEGIN BOX-CATEGORY -->
                        <div class="box-content box-category">
                            <ul>
                                @foreach ($categories as $category)
                                    <li> <a href="{{ URL::to('filter/' . $category->id) }}"
                                            class="active">{{ $category->name }}</a>
                                        <span class="subDropdown plus"></span>
                                        <ul class="level1" style="display:none">
                                            @foreach ($collections as $collection)
                                                @if ($collection->category_id == $category->id)
                                                    <li> <a
                                                            href="{{ URL::to('filter/' . $category->id . '/' . $collection->id) }}">
                                                            {{ $collection->name }} </a> </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!--box-content box-category-->
                    </div>
                    <div class="block block-cart">
                        <div class="block-title"><span>My Cart</span></div>
                        <div class="block-content">
                            <div class="summary">
                                <p class="amount">
                                    <a href="{{ URL::to('cart') }}">
                                        There are
                                        @if ($count_cart != 0 && $count_cart != null)
                                            {{ $count_cart }}
                                        @else
                                            0
                                        @endif
                                        items in your cart.
                                    </a>
                                </p>
                                <p class="subtotal"> <span class="label">Cart Subtotal:</span> <span class="price">
                                        @if ($total_cart != 0) {{ $total_cart }}
                                        d @else 0 @endif
                                    </span> </p>
                            </div>
                            <div class="ajax-checkout">
                                <a title="Checkout" href="{{ URL::to('/check-out') }}"><span
                                        class="hidden-xs">Checkout</span></a>
                            </div>
                            @if (isset($shopping_carts))
                                <p class="block-subtitle">Recently added item(s) </p>
                                <ul>
                                    @foreach ($shopping_carts as $product_id => $info)
                                        <li class="item"> <a class="product-image" title="Fisher-Price Bubble Mower"
                                                href="#"><img width="80" alt="Fisher-Price Bubble Mower"
                                                    src="{{ url('uploads/products-images/' . $product_id . '/' . $info['product_image']) }}"></a>
                                            <div class="product-details">
                                                <div class="access"> <a class="btn-remove1" title="Remove This Item"
                                                        onclick="remove_item_from_cart({{ $product_id }})"> <span
                                                            class="icon"></span>
                                                        Remove </a> </div>
                                                <p class="product-name"> <a
                                                        href="{{ URL::to('product-details/' . $product_id) }}">{{ $info['product_name'] }}</a>
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
                    {{-- <div class="block block-subscribe">
                        <div class="block-title"><span>Newsletter</span></div>
                        <form action="#" method="post" id="newsletter-validate-detail">
                            <div class="block-content">
                                <div class="form-subscribe-header"> Sign up for our newsletter:</div>
                                <input type="text" name="email" id="newsletter" title=""
                                    class="input-text required-entry validate-email" placeholder="Enter your email address">
                                <div class="actions">
                                    <button type="submit" title="Submit" class="subscribe"><span>Subscribe</span></button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                    <div class="block block-list block-viewed">
                        <div class="block-title"><span>Recently Viewed</span> </div>
                        <div class="block-content">
                            <ol id="recently-viewed-items">
                                @if (isset($recent_views))
                                    @foreach ($recent_views as $product_id => $info)
                                        <li class="item odd">
                                            <p class="product-name"><a
                                                    href="{{ URL::to('product-details/' . $product_id) }}">{{ $info['product_name'] }}</a>
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
                        <div class="block-title "><span>Compare Products ({{ $count_compare }})</span></div>
                        <div class="block-content">
                            <ol id="compare-items">
                                @if (isset($compare))
                                    @foreach ($compare as $product_id => $info)
                                        <li class="item odd">
                                            <input type="hidden" value="2173" class="compare-item-id">
                                            <a class="btn-remove1" title="Remove This Item"
                                                onclick="return remove_item_from_compare({{ $product_id }})"></a> <a
                                                href="{{ URL::to('product-details/' . $product_id) }}"
                                                class="product-name">{{ $info['product_name'] }}</a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="item odd active">
                                        <p class="product-name"><a href="#">None</a></p>
                                    </li>
                                @endif
                            </ol>
                            <div class="ajax-checkout">
                                <a href="{{ route('compare.index') }}" type="submit" title="Submit" onclick=""
                                    class="button button-compare"><span>Compare</span></a>
                                <button type="submit" onclick="return remove_compare();" title="Submit"
                                    class="button button-clear"><span>Clear</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="block block-tags">
                        <div class="block-title"><span>Popular Tags</span></div>
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
                    {{-- <div class="block block-banner"><a href="#"><img
                                src="{{ url('images/block-banner.png') }}" alt="block-banner"></a>
                    </div> --}}
                </aside>
                {{-- end of side bar for filter --}}

                {{-- end filter side bar --}}
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
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
            // $('#quick-view').modal('show');


        });

    </script>
@endsection
