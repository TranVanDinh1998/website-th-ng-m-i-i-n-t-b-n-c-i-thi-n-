@extends('layouts.admin.index')
@section('title', 'Đơn hàng')
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.order.index') }}">Đơn hàng</a></li>
                <li class="active">Đơn hàng #{{ $order->id }}</li>
            </ol>
            <section class="panel">
                <div class="panel-heading">
                    Thông tin đơn hàng
                    <span class="tools pull-right">
                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                    </span>
                </div>
                <div class="panel-body">
                    <div class="position-center">
                        <form id="update_order_form" enctype="multipart/form-data"
                            action="{{route('admin.order.update',['id'=>$order->id]) }}" method="POST">
                            @csrf
                            <div class="panel">
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <p class="alert alert-danger">{{ $error }}</p>
                                    @endforeach
                                @endif
                                @if (session('success'))
                                    <p class="alert-success alert">{{ session('success') }}</p>
                                @endif
                                @if (session('error'))
                                <p class="alert-success alert">{{ session('error') }}</p>
                            @endif
                            </div>
                            <div class="form-group">
                                <label for="name">Tạo lúc</label>
                                <input type="date" class="form-control" value="{{ $order->created_at }}" disabled>
                                <input type="hidden" class="form-control" name="id" placeholder="name"
                                    value="{{ $order->id }}">
                            </div>
                            <div class="form-group">
                                <label for="name">Đưa tới</label>
                                <div class="row">
                                    <input type="text" class="form-control"
                                        value="{{ $order->shippingAddress->address . ', ' . $order->shippingAddress->ward . ', ' . $order->shippingAddress->district . ', ' . $order->shippingAddress->province }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Tổng cộng</label>
                                <input type="number" class="form-control" value="{{ $order->sub_total }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="name">Giảm giá</label>
                                <input type="number" class="form-control" value="{{ $order->discount }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="name">Thành tiền</label>
                                <input type="number" class="form-control" value="{{ $order->total }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="name">Trạng thái</label>
                                <select class="form-control" name="status">
                                    <option value="0" @if ($order->status == 0)
                                        selected
                                        @endif>Đang chờ xử lý</option>
                                    <option value="1" @if ($order->status == 1)
                                        selected
                                        @endif>Chờ hàng</option>
                                    <option value="2" @if ($order->status == 2)
                                        selected
                                        @endif>Đang đưa hàng</option>
                                    <option value="3" @if ($order->status == 3)
                                        selected
                                        @endif>Đã giao</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Thanh toán</label>
                                <select class="form-control" name="payment">
                                    <option value="1" @if ($order->is_paid == 1)
                                        selected
                                        @endif>Đã thanh toán</option>
                                    <option value="0" @if ($order->is_paid == 0)
                                        selected
                                        @endif>Chưa thanh toán</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-hidden"></div>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <section class="panel">
                <div class="panel-heading">
                    Order's details
                    <span class="tools pull-right">
                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                    </span>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped b-t b-light">
                            <thead>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderDetails as $detail)
                                    <tr class="first odd">
                                                <td class="image">
                                                    <a class="product-image" title="Sample Product"
                                                        href="{{ route('product_details' ,['id'=> $detail->product->id]) }}"><img
                                                            width="100" height="auto" alt="Sample Product"
                                                            src="{{ asset('storage/images/products/' . $detail->product->image) }}"></a>
                                                </td>
                                                <td>
                                                    <p class="product-name">
                                                        <a
                                                        href="{{ route('product_details' ,['id'=> $detail->product->id]) }}">{{ $detail->product->name }}</a>
                                                    </p>
                                                </td>
                                                <td>
                                                    @if ($detail->product_discount != null)
                                                        <span class="cart-price">
                                                            <p class="special-price text-danger"> <span class="price">
                                                                    {{ $detail->price - ($detail->price * $detail->product_discount) / 100 }}
                                                                </span>
                                                            </p>
                                                            <p class="old-price"> <span class="price-sep">-</span> <span
                                                                    class="price"><del> {{ $detail->price }}</del>
                                                                </span> </p>
                                                        </span>
                                                    @else
                                                        <span class="cart-price">
                                                            <p class="price"> <span class="price">
                                                                    {{ $detail->price }} </span>
                                                            </p>
                                                        </span>
                                                    @endif

                                                </td>
                                                <td>
                                                    <input type="number" min="0" class="form-control"
                                                        value="{{ $detail->quantity }}" name="" disabled>
                                                </td>
                                                <td>
                                                    <span class="cart-price text-danger">
                                                        @if ($detail->product_discount != null)
                                                            <span
                                                                class="price">{{ ($detail->price - ($detail->price * $detail->product_discount) / 100) * $detail->quantity }}
                                                            </span>
                                                        @else
                                                            <span class="price">{{ $detail->price * $detail->quantity }}
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
                                    <table class="table shopping-cart-table-total" id="shopping-cart-totals-table">
                                        <colgroup>
                                            <col>
                                            <col width="1">
                                        </colgroup>
                                        <tfoot>
                                            <tr>
                                                <td colspan="1" class="a-left" style="">
                                                    <strong>Thành tiền</strong>
                                                </td>
                                                <td class="a-right" style="">
                                                    <strong>
                                                        <span class="price">{{ $order->total }}</span>
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                                <td colspan="1" class="a-left" style=""> Tổng cộng </td>
                                                <td class="a-right" style="">
                                                    <span class="price">{{ $order->sub_total }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @if ($order->discount))
                                                <tr>
                                                    <td colspan="1" class="a-left" style=""> Giảm giá </td>
                                                    <td class="a-right" style="">
                                                        <span class="">-{{ $order->discount }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!--inner-->

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        <!-- footer -->
        @include('components.admin.footer')
        <!-- / footer -->
    </section>
    <!--main content end-->

@endsection
