@extends('layouts.customer.index')
@section('title', 'Cảm ơn bạn đã đặt hàng tại website của chúng tôi')
@section('content')
    <!--//end Delivery -->
    <section class="main-container col1-layout">
        <div class="main container">
            <div class="page-title">
                <h2>Đơn hàng của bạn đã được ghi nhận.</h2>
            </div>
            <!--page-title-->
            <div class="dashboard">
                <h2 class="sub-title">Cảm ơn bạn đã mua hàng!</h2>
                <p>Mã đơn hàng của bạn là:
                    @if (Auth::user())
                        <a href="{{ route('account.order.detail', ['id' => $order->id]) }}">{{ $order->id }}</a>
                    @else
                        <span class="text-primary">{{ $order->id }}</span>
                    @endif
                    .
                </p>
                <p>Nếu bạn có tài khoản cá nhân, bạn có thể theo dõi tiến trình đơn hàng của bạn</p>
                <div class="buttons-set">
                    <button type="button" class="button continue" title="Continue Shopping"
                        onclick="window.location='{{ route('home') }}'"><span>Tiếp tục mua hàng?</span></button>
                </div>
            </div>
            <!--dashboard-->
            <br>
        </div>
    </section>
@endsection
