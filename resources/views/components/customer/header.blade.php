<header class="header-container">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <!-- Header Language -->
                <div class="col-xs-6">
                    <!-- End Header Currency -->
                    <div class="welcome-msg hidden-xs">
                        Chào mừng
                        @if (Auth::user())
                            {{ Auth::user()->name }}
                        @else
                            đến với cửa hàng
                        @endif
                    </div>
                </div>
                <div class="col-xs-6">
                    <!-- Header Top Links -->
                    <div class="toplinks">
                        <div class="links">
                            <div class="myaccount">
                                @if (Auth::user() && Auth::user()->is_admin == 1)
                                    <a title="My management" href="{{ route('admin.index') }}"><span
                                            class="hidden-xs">Quản lý</span></a>
                                @endif
                            </div>
                            <div class="myaccount"><a title="My Account" href="{{ URL::to('account') }}"><span
                                        class="hidden-xs">Tài khoản cá nhân</span></a></div>
                            <div class="wishlist"><a title="My Wishlist"
                                    href="{{ URL::to('account/wish-list') }}"><span class="hidden-xs">Danh sách ưu
                                        thích</span></a></div>
                            <div class="check"><a title="Checkout" href="{{ URL::to('/check-out') }}"><span
                                        class="hidden-xs">Thủ tục thanh toán</span></a>
                            </div>
                            <div class="phone hidden-xs">1 800 000 000</div>
                        </div>
                    </div>
                    <!-- End Header Top Links -->
                </div>
            </div>
        </div>
    </div>
    <div class="header container">
        <div class="row">
            <div class="col-lg-2 col-sm-3 col-md-2 col-xs-12">
                <!-- Header Logo -->
                <a class="logo" title="Magento Commerce" href="{{ URL::to('/') }}"><img alt="Magento Commerce"
                        src="{{ url('images/logo.png') }}"></a>
                <!-- End Header Logo -->
            </div>
            <div class="col-lg-7 col-sm-4 col-md-6 col-xs-12">
                <!-- Search-col -->
                <div class="search-box" style="border: none !important;">
                    <div class="panel">
                        <form autocomplete="off" class="form-inline navbar-form" action="{{ route('search') }}"
                            method="GET">
                            <select name="category_id" class="cate-dropdown hidden-xs">
                                <option value="">Tất cả thể loại</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">&nbsp;&nbsp;&nbsp;{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" autocomplete="off" placeholder="Search here..." class="form-control"
                                name="search" id="search" required>
                            <button type="submit" class="search-btn-bg"><span>Tìm kiếm</span></button>
                        </form>
                    </div>
                </div>
                <!-- End Search-col -->
            </div>
            <!-- Top Cart -->
            <div class="col-lg-3 col-sm-5 col-md-4 col-xs-12">
                <div class="top-cart-contain">
                    <div class="mini-cart">
                        <div data-toggle="dropdown" data-hover="dropdown" class="basket dropdown-toggle">
                            <a href="{{ route('cart.index') }}"> <i class="icon-cart"></i>
                                <div class="cart-box"><span class="title">Giỏ hàng</span>
                                    @if (isset($count_cart) && $count_cart != null)
                                        <span id="cart-total">
                                            {{ $count_cart }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                        </div>
                        <div>
                            <div class="top-cart-content arrow_box">
                                <div class="block-subtitle">Những sản phẩm đã thêm vào gần đây</div>
                                <ul id="cart-sidebar" class="mini-products-list">
                                    @if (isset($shopping_carts) && $shopping_carts != null)
                                        @foreach ($shopping_carts as $product_id => $info)
                                            <li class="item even"> <a class="product-image"
                                                    href="{{ route('product_details', ['id' => $product_id]) }}"
                                                    title="Downloadable Product "><img
                                                        alt="{{ $info['product_name'] }} "
                                                        src="{{ asset('storage/images/products/' . $info['product_image']) }}"
                                                        width="80"></a>
                                                <div class="detail-item">
                                                    <div class="product-details">
                                                        <a onclick="remove_item_from_cart({{ $product_id }});"
                                                            title="Remove This Item" onClick=""
                                                            class="glyphicon glyphicon-remove">&nbsp;</a>
                                                        <p class="product-name"> <a
                                                                href="{{ URL::to('product-details/' . $product_id) }}"
                                                                title="Downloadable Product">
                                                                {{ $info['product_name'] }} </a> </p>
                                                    </div>
                                                    <div class="product-details-bottom">
                                                        <span class="price">
                                                            Price :
                                                            @if ($info['product_discount'] != null)
                                                                {{ $info['product_price'] - ($info['product_price'] * $info['product_discount']) / 100 }}
                                                                vnd
                                                            @else
                                                                {{ $info['product_price'] }}
                                                                vnd
                                                            @endif
                                                        </span>
                                                        <span class="title-desc">Quantity:</span>
                                                        <strong>{{ $info['product_quantity'] }}</strong>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="top-subtotal">Tổng cộng: <span class="price">
                                        @if (isset($total_cart))
                                            {{ $total_cart }}
                                        @endif
                                    </span>
                                </div>
                                <div class="actions">
                                    <a class="btn-checkout" href="{{ route('checkout.index') }}"><span>Thanh
                                            toán</span></a>
                                    <a href="{{ route('cart.index') }}" class="view-cart" type="button"><span>Xem giỏ
                                            hàng</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="ajaxconfig_info" style="display:none"> <a href="#/"></a>
                        <input value="" type="hidden">
                        <input id="enable_module" value="1" type="hidden">
                        <input class="effect_to_cart" value="1" type="hidden">
                        <input class="title_shopping_cart" value="Go to shopping cart" type="hidden">
                    </div>
                </div>
                @if (!Auth::user())
                    <div class="signup"><a title="Đăng ký" href="{{ route('auth.customer.login') }}"><span>Đăng ký</span></a>
                    </div>
                    <span class="or"> | </span>
                    <div class="login"><a title="Đăng nhập" href="{{ route('auth.customer.login') }}"><span>Đăng nhập</span></a>
                    </div>
            </div>
        @else
            <div class="signup"><a title="Logout" href="{{ route('auth.customer.logout') }}"><span>Đăng xuất</span></a>
            </div>
            @endif
            <!-- End Top Cart -->
        </div>
    </div>
</header>
<!-- Navbar -->
<nav>
    <div class="container">
        <div class="nav-inner">
            <a class="logo-small" title="Magento Commerce" href="{{ route('home') }}"><img alt="Magento Commerce"
                    src="{{ url('images/logo-small.png') }}"></a>
            <ul id="nav" class="hidden-xs">
                <li class="level0 parent drop-menu"><a href="{{ route('home') }}" class="active"><span>Trang
                            chủ</span>
                    </a>
                </li>
                <li class="level0 nav-5 level-top first"> <a class="level-top" href="">
                        <span>Các thiết bị điện tử</span> </a>
                    <div style="display:none;" class="level0-wrapper dropdown-6col">
                        <div class="level0-wrapper2">
                            <div class="nav-block nav-block-center grid12-12 itemgrid itemgrid-4col">
                                <!--mega menu-->
                                <ul class="level3">
                                    @foreach ($categories as $category)
                                        <li class="level3 nav-6-1 parent item"> <a
                                                href="{{ route('filter', ['category_id' => $category->id]) }}"><span>{{ $category->name }}</span></a>
                                            <!--sub sub category-->
                                            <ul class="level1">
                                                @foreach ($category->collections as $collection)
                                                    <li class="level2 nav-6-1-1">
                                                        <a
                                                            href="{{ route('filter', ['category_id' => $category->id, 'collection_id' => $collection->id]) }}">
                                                            <span>{{ $collection->name }}</span></a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <!--level1-->
                                            <!--sub sub category-->
                                            <div class="cat-img"><img
                                                    src="{{ asset('/storage/images/categories/' . $category->image) }}"
                                                    alt="Mobiles">
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <!--level0-->
                            </div>
                        </div>
                    </div>
                </li>

                <li class="level0 parent drop-menu"><a href="{{ route('coupon') }}"><span>Mã giảm giá</span> </a>
                </li>
                <li class="level0 parent drop-menu"><a href="{{ route('compare.index') }}"><span>So sánh</span>
                    </a>
                </li>
                <li class="level0 parent drop-menu"><a href="{{ route('info.contact_us') }}"><span>Liên hệ</span>
                    </a>
                </li>
                <li class="level0 parent drop-menu"><a href="{{ route('info.about_us') }}"><span>Thông tin về cửa
                            hàng</span> </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- end nav -->
