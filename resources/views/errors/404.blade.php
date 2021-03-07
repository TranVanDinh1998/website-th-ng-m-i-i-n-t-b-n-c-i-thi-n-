@extends('layouts.customer.index')
@section('title', 'Lỗi')
@section('content')
    <!--End main-container -->
    <section class="content-wrapper">
        <div class="container">
            <div class="std">
                <div class="page-not-found">
                    <h2>404</h2>
                    <h3><img src="images/signal.png">Oops! Trang mà bạn yêu cầu hiện không tồn tại.</h3>
                    <div><a href="{{URL::to('/')}}" type="button" class="btn-home"><span>Quay trở về trang chủ</span></a></div>
                </div>
            </div>
        </div>
    </section>
    <!--End main-container -->
@endsection
