@extends('layouts.customer.index')
@section('title', 'Đơn hàng')
@section('content')
    <!-- main-container -->
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="my-account">
                        <div class="page-title">
                            <h2>Đơn hàng của tôi</h2>
                        </div>
                        <div class="col-sm-12 wow">
                            @if (session('success'))
                                <div id="success_msg" class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div id="error_msg" class="alert alert-danger">
                                    {!! session('error') !!}
                                </div>
                            @endif
                            <div class="toolbar">
                                <div class="pager" style="float: left">
                                    <p class="amount"><strong>{{ $orders_count }} đơn hàng<strong></p>
                                    <div id="limiter">
                                        <label>Hiển thị: </label>
                                        <ul>
                                            <li><a href="{{ route('account.order.index', ['view' => 15]) }}">15<span
                                                        class="right-arrow"></span>
                                                </a>
                                                <ul>
                                                    <li><a href="{{ route('account.order.index', ['view' => 20]) }}">20
                                                        </a>
                                                    </li>
                                                    <li><a href="{{ route('account.order.index', ['view' => 30]) }}">30
                                                        </a>
                                                    </li>
                                                    <li><a href="{{ route('account.order.index', ['view' => 35]) }}">35
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="pages">
                                        <ul class="pagination">
                                            {!! $all_orders->links() !!}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <div class="product-tabs-content-inner clearfix">
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
                                                @foreach ($all_orders as $order)
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
                                                                    <span class="separator">|</span> <a onclick="return confirm('Bạn có chắc là muốn hủy đơn hàng này không?')"
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
                            </div>
                        </div>
                    </div>
                </section>
                @include('components.customer.sidebar.account')
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#success_msg").fadeOut(10000);
            $("#error_msg").fadeOut(10000);
        });

    </script>
    <!--End main-container -->
@endsection
