<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{ route('admin.index') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>Thống kê</span>
                    </a>
                </li>

                <!--Product data -->
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Sản phẩm</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.product.index') }}">Quản lý</a></li>
                        <li><a href="{{ route('admin.product.create') }}">Tạo mới</a></li>
                        <li><a href="{{ route('admin.product.recycle') }}">Thùng rác</a></li>
                    </ul>
                </li>
                <!--Category data -->
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Thể loại</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.category.index') }}">Quản lý</a></li>
                        <li><a href="{{ route('admin.category.create') }}">Tạo mới</a></li>
                        <li><a href="{{ route('admin.category.recycle') }}">Thùng rác</a></li>
                    </ul>
                </li>
                <!--Producer data -->
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Hãng</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.producer.index') }}">Quản lý</a></li>
                        <li><a href="{{ route('admin.producer.create') }}">Tạo mới</a></li>
                        <li><a href="{{ route('admin.producer.recycle') }}">Thùng rác</a></li>
                    </ul>
                </li>
                <!--Contact data -->
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Liên lạc</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.contact.index') }}">Quản lý</a></li>
                        <li><a href="{{ route('admin.contact.recycle') }}">Thùng rác</a></li>
                    </ul>
                </li>
                <!--Coupon data -->
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Mã giảm giá</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.coupon.index') }}">Quản lý</a></li>
                        <li><a href="{{ route('admin.coupon.create') }}">Tạo mới</a></li>
                        <li><a href="{{ route('admin.coupon.recycle') }}">Thùng rác</a></li>
                    </ul>
                </li>
                <!--Collection data -->
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Bộ sưu tập</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.collection.index') }}">Quản lý</a></li>
                        <li><a href="{{ route('admin.collection.create') }}">Tạo mới</a></li>
                        <li><a href="{{ route('admin.collection.recycle') }}">Thùng rác</a></li>
                    </ul>
                </li>
                <!--Review data -->
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Đánh giá</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.review.index') }}">Quản lý</a></li>
                        <li><a href="{{ route('admin.review.recycle') }}">Thùng rác</a></li>
                    </ul>
                </li>
                <!--Order data -->
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Đơn hàng</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.order.index') }}">Quản lý</a></li>
                        <li><a href="{{ route('admin.order.history') }}">Lịch sử giao dịch</a></li>
                        <li><a href="{{ route('admin.order.cancel') }}">Đơn hàng bị hủy</a></li>
                        <li><a href="{{ route('admin.order.recycle') }}">Thùng rác</a></li>
                    </ul>
                </li>
                <!--User data -->
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Người dùng</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.user.index') }}">Quản lý</a></li>
                        <li><a href="{{ route('admin.user.recycle') }}">Thùng rác</a></li>
                    </ul>
                </li>
                <!--End of user -->
                <!--Advertise data -->
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Quảng cáo</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.advertise.index') }}">Quản lý</a></li>
                        <li><a href="{{ route('admin.advertise.create') }}">Tạo mới</a></li>
                        <li><a href="{{ route('admin.advertise.recycle') }}">Thùng rác</a></li>
                    </ul>
                </li>
                <!--Tag data -->
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-th"></i>
                        <span>Thẻ</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.tag.index') }}">Quản lý</a></li>
                        <li><a href="{{ route('admin.tag.create') }}">Tạo mới</a></li>
                        <li><a href="{{ route('admin.tag.recycle') }}">Thùng rác</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
