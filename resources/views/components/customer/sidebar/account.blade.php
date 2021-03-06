{{-- Account side bar --}}
<aside class="col-right sidebar col-sm-3 wow">
    <div class="block block-account">
        <div class="block-title">Tài khoản của tôi</div>
        <div class="block-content">
            <ul>
                <li class="current"><a href="{{ route('account.dashboard') }}">Tổng quan</a></li>
                <li><a href="{{ route('account.info.index') }}">Thông tin tài khoản</a></li>
                <li><a href="{{ route('account.address.index') }}">Danh sách địa chỉ</a>
                </li>
                <li><a href="{{ route('account.order.index') }}">Đơn hàng</a>
                </li>
                <li><a href="{{ route('account.review.index') }}">Các đánh giá sản phẩm</a></li>
                <li><a href="{{ route('account.wishlist.index') }}">Danh sách ưu thích</a></li>
                <li><a href="{{ route('account.password.index') }}">Mật khẩu</a></li>
            </ul>
        </div>
    </div>
</aside>
{{-- end of account side bar --}}
