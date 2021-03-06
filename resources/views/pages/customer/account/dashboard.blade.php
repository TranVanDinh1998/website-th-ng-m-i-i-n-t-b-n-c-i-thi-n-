@extends('layouts.customer.index')
@section('title', 'Tổng quan')
@section('content')
    <!-- main-container -->
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="my-account">
                        <div class="page-title">
                            <h2>Tổng quan tài khoản</h2>
                        </div>
                        <div class="dashboard">
                            <div class="welcome-msg"> <strong>Hello, {{ Auth::user()->name }}!</strong>
                                <p>
                                    Từ Trang tổng quan tài khoản, bạn có thể xem nhanh về các hoạt động của mình
                                    hoạt động tài khoản và cập nhật thông tin tài khoản của bạn. Chọn một liên kết bên dưới
                                    để xem hoặc
                                    chỉnh sửa thông tin.
                                </p>
                            </div>
                            <div class="recent-orders">
                                <div class="title-buttons"><strong>Các đơn hàng gần đây</strong> <a
                                        href="{{ route('account.order.index') }}">Tất cả</a> </div>
                                <div class="table-responsive">
                                    <table class="data-table" id="my-orders-table">
                                        <col>
                                        <col>
                                        <col>
                                        <col width="1">
                                        <col width="1">
                                        <col width="1">
                                        <thead>
                                            <tr class="first last">
                                                <th>Đơn hàng #</th>
                                                <th>Ngày tạo</th>
                                                <th>Đưa tới</th>
                                                <th><span class="nobr">Tổng giá trị</span></th>
                                                <th>Trạng thái</th>
                                                <th>Hoạt động</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recent_orders as $order)
                                                <tr class="first odd">
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->created_at }} </td>
                                                    <td>
                                                        {{ $order->shippingAddress->address . ', ' . $order->shippingAddress->ward . ', ' . $order->shippingAddress->district . ', ' . $order->shippingAddress->province }}
                                                    </td>
                                                    <td><span class="price">{{ $order->total }} đ</span></td>
                                                    <td>
                                                        <em>
                                                            @switch($order->status)
                                                                @case(0)
                                                                Đang chờ xử lý
                                                                @break
                                                                @case(1)
                                                                Đang chờ hàng hóa
                                                                @break
                                                                @case(2)
                                                                Đang giao
                                                                @break
                                                                @case(3)
                                                                Đã giao
                                                                @break
                                                            @endswitch
                                                        </em>
                                                    </td>
                                                    <td>
                                                        @if ($order->verified == 0)
                                                            Không
                                                        @else
                                                            Có
                                                        @endif
                                                    </td>
                                                    <td class="a-center last">
                                                        <span class="nobr">
                                                            <a
                                                                href="{{ route('account.order.detail', ['id' => $order->id]) }}">Chi
                                                                tiết</a>
                                                            @if ($order->verified == 1)
                                                                <span class="separator">|</span> <a
                                                                    href="{{ route('account.order.cancel', ['id' => $order->id]) }}">Hủy</a>
                                                            @endif
                                                            <span class="separator">|</span> <a
                                                                href="{{ route('account.order.re_order', ['id' => $order->id]) }}">Đặt
                                                                lại</a>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box-account">
                                <div class="page-title">
                                    <h2>Thông tin tài khoản</h2>
                                </div>
                                <div class="col2-set">
                                    <div class="col-1">
                                        <h5>Thông tin liên hệ</h5>
                                        <a href="{{ route('account.info.index') }}">Chỉnh sửa</a>
                                        <p>{{ $user->name }}<br>
                                            {{ $user->email }}<br>
                                            <a href="{{ route('account.password.index') }}">Thay đổi mật khẩu</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col2-set">
                                    <h4>Danh sách địa chỉ</h4>
                                    <div class="manage_add"><a href="{{ route('account.address.index') }}">Quản lý địa
                                            chỉ</a> </div>
                                    <div class="col-1">
                                        <h5>Địa chỉ giao hàng mặc định</h5>
                                        @if ($user->address)
                                        <address>
                                            {{ $user->address->name }}<br>
                                            {{ $user->address->address }} ,
                                            {{ $user->address->ward->name }} ,
                                            {{ $user->address->district->name }} ,
                                            {{ $user->address->province->name }}
                                            T: {{ $user->address->number }}<br>
                                            <a
                                                href="{{ route('account.address.edit', ['id' => $user->shipping_address_id]) }}">Chỉnh
                                                sửa địa chỉ</a>
                                        </address>   
                                        @else
                                            <p>Trống</p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @include('components.customer.sidebar.account')
            </div>
        </div>
    </div>
    <!--End main-container -->
@endsection
