@extends('layouts.customer.index')
@section('title', 'Chi tiết đơn hàng')
@section('content')
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <ul>
                    <li class="home"> <a href="{{ route('account.order.index') }}" title="Go to Order Page">Đơn
                            hàng</a><span>&mdash;›</span></li>
                    <li class=""><strong> Đơn hàng # {{ $order->id }} </strong></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end breadcrumbs -->
    <!-- main-container -->
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="my-account">
                        <div class="page-title">
                            <h2>Đơn hàng #{{ $order->id }} -
                                @if ($order->verified == 1)
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
                                @else
                                    Đã hủy
                                @endif
                            </h2>
                        </div>
                        <div class="dashboard">
                            <dl class="order-info panel">
                                <dt>Chi tiết đơn hàng:</dt>
                                <dd>
                                    <ul id="order-info-tabs">
                                        <li class="current first last">Thông tin đơn hàng</li>
                                    </ul>
                                </dd>
                                <div style="float:right;">
                                    <a href="{{ route('account.order.re_order', ['id' => $order->id]) }}"
                                        id="btn_check_out" class="link-reorder button" title="Order again" type="button">
                                        <span>Đặt hàng lại</span>
                                    </a>
                                </div>
                            </dl>
                            <p class="order-date">Ngày đặt hàng: {{ $order->created_at }}</p>
                            <div class="col2-set">
                                <div class="col-1">
                                    <div class="box">
                                        <div class="box-title">
                                            <h4>Địa chỉ giao hàng</h4>
                                        </div>
                                        <div class="box-content">
                                            <address>
                                                {{ $order->shippingAddress->name }}<br>
                                                {{ $order->shippingAddress->address . ', ' . $order->shippingAddress->ward . ', ' . $order->shippingAddress->district . ', ' . $order->shippingAddress->province }}
                                                <br>
                                                T: {{ $order->shippingAddress->number }}<br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="box box-payment">
                                        <div class="box-title">
                                            <h4>Phương pháp thanh toá<noscript></noscript></h4>
                                        </div>
                                        <div class="box-content">
                                            @if ($order->payment != null)
                                                <p>Thẻ tín dụng</p>
                                                <p>Chủ sở hữu: {{ $order->payment->name }} </p>
                                                @switch($order->payment->type)
                                                    @case(1)
                                                    <p>Loại thẻ: American Express </p>
                                                    @break
                                                    @case(2)
                                                    <p>Loại thẻ: Visa </p>
                                                    @break
                                                    @case(3)
                                                    <p>Loại thẻ: MasterCard</p>
                                                    @break
                                                    @case(4)
                                                    <p>Loại thẻ: Discover</p>
                                                    @break
                                                @endswitch
                                                <p>Thời gian hết hạn: {{ $order->payment->expire_month }} /
                                                    {{ $order->payment->expire_year }}
                                                </p>
                                            @else
                                                <p>Thanh toán khi nhận hàng</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-items order-details">
                                <h2 class="table-caption">Các sản phẩm trong đơn hàng</h2>
                                <fieldset>
                                    <table class="data-table cart-table" id="shopping-cart-table">
                                        <thead>
                                            <tr class="first last">
                                                <th>&nbsp;</th>
                                                <th><span class="nobr">Sản phẩm</span></th>
                                                <th><span class="nobr">Đơn giá</span></th>
                                                <th>Số lượng</th>
                                                <th>Thành tiền</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order_details as $detail)
                                                <tr class="first odd">
                                                    <td class="image">
                                                        <a class="product-image" title="{{ $detail->product->name }}"
                                                            href="{{ route('product_details', ['id' => $detail->product->id]) }}"><img
                                                                width="100" height="auto" alt="{{$detail->product->name}}"
                                                                src="{{ asset('storage/images/products/' . $detail->product->image) }}"></a>
                                                    </td>
                                                    <td>
                                                        <p class="product-name">
                                                            <a
                                                                href="{{ route('product_details', ['id' => $detail->product->id]) }}">{{ $detail->product->name }}</a>
                                                        </p>
                                                    </td>
                                                    <td>
                                                        @if ($detail->product_discount != null)
                                                            <span class="cart-price">
                                                                <p class="special-price"> <span class="price">
                                                                        {{ $detail->price - ($detail->price * $detail->product_discount) / 100 }}
                                                                    </span>
                                                                </p>
                                                                <p class="old-price"> <span class="price-sep">-</span> <span
                                                                        class="price"> {{ $detail->price }}
                                                                    </span> </p>
                                                            </span>
                                                        @else
                                                            <span class="cart-price">
                                                                <p class="price"> <span class="price">
                                                                        {{ $detail->price }}</span>
                                                                </p>
                                                            </span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        {{ $detail->quantity }}
                                                    </td>
                                                    <td>
                                                        <span class="cart-price">
                                                            @if ($detail->product_discount != null)
                                                                <span
                                                                    class="price">{{ ($detail->price - ($detail->price * $detail->product_discount) / 100) * $detail->quantity }}
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="price">{{ $detail->price * $detail->quantity }}
                                                                </span>
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="cart-collaterals row">
                                        <div class="col-sm-8">
                                        </div>
                                        <div class="totals col-sm-4">
                                            <h3>Tổng giá trị đơn hàng</h3>
                                            <div class="inner">
                                                <table class="table shopping-cart-table-total"
                                                    id="shopping-cart-totals-table">
                                                    <colgroup>
                                                        <col>
                                                        <col width="1">
                                                    </colgroup>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="1" class="a-left" style=""><strong>Thành tiền</strong>
                                                            </td>
                                                            <td class="a-right" style=""><strong><span
                                                                        class="price">{{ $order->total }}
                                                                    </span></strong>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="1" class="a-left" style="">Tổng cộng </td>
                                                            <td class="a-right" style=""><span
                                                                    class="price">{{ $order->sub_total }}
                                                                </span></td>
                                                        </tr>
                                                        @if ($order->discount))
                                                            <tr>
                                                                <td colspan="1" class="a-left" style=""> Giảm giá </td>
                                                                <td class="a-right" style=""><span class="">-
                                                                        {{ $order->discount }} d</span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--inner-->

                                        </div>
                                    </div>
                                </fieldset>
                                <div class="buttons-set">
                                    <p class="back-link"><a href="{{ route('account.order.index') }}"><small>«
                                            </small>Quay trở về danh sách đơn hàng</a></p>
                                </div>
                            </div>
                        </div>
                        <!--dashboard-->
                    </div>
                </section>
                @include('components.customer.sidebar.account')
            </div>
        </div>
    </div>
    <script>


    </script>
    <!--End main-container -->
@endsection
