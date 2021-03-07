@extends('layouts.admin.index')
@section('title', 'Đơn hàng')
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.order.cancel') }}">Đơn hàng</a></li>
                <li class="active">Đơn hàng bị hủy</li>
            </ol>
            <div class="table-agile-info">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Đơn hàng - đơn hàng đã hủy
                    </div>
                    <div class="row w3-res-tb">
                        <div class="col-sm-5 m-b-xs">
                            <span class="btn-group">
                                <a href="{{ route('admin.order.cancel') }}" class="btn btn-sm btn-default"><i
                                        class="fa fa-refresh"></i> Tải lại trang</a>
                                <a href="{{ route('admin.order.history') }}" class="btn btn-sm btn-default"><i
                                        class="fa fa-film"></i> Lịch sử giao dịch</a>
                                <a href="{{ route('admin.order.create') }}" class="btn btn-sm btn-success"><i
                                        class="fa fa-plus"></i> Tạo mới</a>
                                <a href="{{ route('admin.order.recycle') }}" class="btn btn-sm btn-danger"><i
                                        class="fa fa-trash"></i> Thùng rác</a>
                            </span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                        </div>
                    </div>
                    <form method="GET" action="{{ route('admin.order.bulk_action') }}" enctype="multipart/form-data">
                        <div class="row w3-res-tb">
                            <div class="col-sm-5 m-b-xs">
                                <select id="bulk_action" name="bulk_action"
                                    class="input-sm form-control w-sm inline v-middle">
                                    <option>Thao tác đa mục tiêu</option>
                                    <option value="1">Hoạt động</option>
                                    <option value="6">Loại bỏ</option>
                                </select>
                                <button class="btn btn-sm btn-default">Áp dụng</button>
                            </div>
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-3">
                            </div>
                        </div>
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
                        <div class="table-responsive">
                            <table class="table table-striped b-t b-light">
                                <thead>
                                    <tr>
                                        <th style="width:20px;">
                                            <label class="i-checks m-b-none">
                                                <input type="checkbox"><i></i>
                                            </label>
                                        </th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">ID
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li @if ($sort_id == 0) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => 0, 'status' => $status, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">Inc</a>
                                                    </li>
                                                    <li @if ($sort_id == 1) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => 1, 'status' => $status, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">Desc</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th>Người nhận</th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Tạo
                                                    lúc
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li @if ($sort_date == 0) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => 0, 'status' => $status, 'sort_total' => $sort_total, 'sort_date' => 0, 'view' => $view]) }}">Inc</a>
                                                    </li>
                                                    <li @if ($sort_date == 1) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => 1, 'status' => $status, 'sort_total' => $sort_total, 'sort_date' => 1, 'view' => $view]) }}">Desc</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th>Ship to</th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button"
                                                    data-toggle="dropdown">Thành tiền
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li @if ($sort_total == null) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => $sort_id, 'sort_date' => $sort_date, 'status' => $status, 'view' => $view]) }}">All</a>
                                                    </li>
                                                    <li @if ($sort_total == 0 && $sort_total != null) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => 0, 'status' => $status, 'sort_total' => 0, 'sort_date' => $sort_date, 'view' => $view]) }}">Inc</a>
                                                    </li>
                                                    <li @if ($sort_total == 1 && $sort_total != null) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => 1, 'status' => $status, 'sort_total' => 1, 'sort_date' => $sort_date, 'view' => $view]) }}">Desc</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button"
                                                    data-toggle="dropdown">Trạng thái
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li @if ($status == null) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => $sort_id, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">All</a>
                                                    </li>
                                                    <li @if ($status == 0 && $status != null) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => $sort_id, 'status' => '0', 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">Pending</a>
                                                    </li>
                                                    <li @if ($status == 1 && $status != null) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => $sort_id, 'status' => '1', 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">Waiting
                                                            for goods</a>
                                                    </li>
                                                    <li @if ($status == 2 && $status != null) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => $sort_id, 'status' => '2', 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">On
                                                            Delivery</a>
                                                    </li>
                                                    <li @if ($status == 3 && $status != null) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => $sort_id, 'status' => '3', 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">Delivered</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button"
                                                    data-toggle="dropdown">Thanh toán
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li @if ($sort_paid == null) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_id' => $sort_id, 'sort_date' => $sort_date, 'status' => $status, 'view' => $view]) }}">All</a>
                                                    </li>
                                                    <li @if ($sort_paid == 0 && $sort_paid != null) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_paid' => 0, 'sort_id' => $sort_id, 'status' => $status, 'sort_total' => 0, 'sort_date' => $sort_date, 'view' => $view]) }}">No</a>
                                                    </li>
                                                    <li @if ($sort_paid == 1 && $sort_paid != null) class="active" @endif><a
                                                            href="{{ route('admin.order.cancel', ['sort_paid' => 1, 'sort_id' => $sort_id, 'status' => $status, 'sort_total' => 1, 'sort_date' => $sort_date, 'view' => $view]) }}">Yes</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th colspan="3">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                <label class="i-checks m-b-none">
                                                    <input type="checkbox" value="{{ $order->id }}"
                                                        name="order_id_list[]"><i></i>
                                                </label>
                                            </td>
                                            <td>
                                                {{ $order->id }}
                                            </td>
                                            <td>
                                                {{ $order->shippingAddress->name }}
                                            </td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>
                                                <span class="text-ellipsis">
                                                    {{ $order->shippingAddress->address }} ,
                                                    {{ $order->shippingAddress->ward }} ,
                                                    {{ $order->shippingAddress->district }} ,
                                                    {{ $order->shippingAddress->province }}
                                                </span>
                                            </td>
                                            <td>{{ $order->total }}</td>
                                            <td>
                                                @switch($order->status)
                                                    @case(0)
                                                    Đang chờ xử lý
                                                    @break
                                                    @case(1)
                                                    Chờ hàng
                                                    @break
                                                    @case(2)
                                                    Đang giao
                                                    @break
                                                    @case(3)
                                                    Đã giao
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @if ($order->paid == 1)
                                                    Có
                                                @else
                                                    Không
                                                @endif
                                            </td>
                                            <td>
                                                <a onclick="return confirm('Are you sure?')"
                                                    href="{{ route('admin.order.verify', ['id' => $order->id, 'verified' => 1]) }}"
                                                    class="btn btn-default" title="Activate">
                                                    <span class="glyphicon glyphicon-check"></span>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-info"
                                                    href="{{ route('admin.order.edit', ['id' => $order->id]) }}">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                            </td>
                                            <td>
                                                <a onclick="return confirm('Are you sure?')"
                                                    href="{{ route('admin.order.delete', ['id' => $order->id]) }}"
                                                    class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Hiển thị :
                                            {{ $view }} của {{ $orders_count }} đơn hàng
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li @if ($view == 10) class="active" @endif><a
                                                    href="{{ route('admin.order.cancel', ['sort_id' => $sort_id, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'status' => $status, 'view' => 10]) }}">10</a>
                                            </li>
                                            <li @if ($view == 15) class="active" @endif><a
                                                    href="{{ route('admin.order.cancel', ['sort_id' => $sort_id, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'status' => $status, 'view' => 15]) }}">15</a>
                                            </li>
                                            <li @if ($view == 20) class="active" @endif><a
                                                    href="{{ route('admin.order.cancel', ['sort_id' => $sort_id, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'status' => $status, 'view' => 20]) }}">20</a>
                                            </li>
                                            <li @if ($view == 30) class="active" @endif><a
                                                    href="{{ route('admin.order.cancel', ['sort_id' => $sort_id, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'status' => $status, 'view' => 30]) }}">30</a>
                                            </li>
                                            <li @if ($view == 40) class="active" @endif><a
                                                    href="{{ route('admin.order.cancel', ['sort_id' => $sort_id, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'status' => $status, 'view' => 40]) }}">40</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-7 text-right text-center-xs">
                                    <ul class="pagination pagination-sm m-t-none m-b-none">
                                        {!! $orders->withQueryString()->links() !!}
                                    </ul>
                                </div>
                            </div>
                        </footer>
                </div>
            </div>
        </section>
        <!-- footer -->
        @include('components.admin.footer')
        <!-- / footer -->
    </section>

    <!--main content end-->
    <script>
        $(document).ready(function() {
            $("#success_msg").fadeOut(10000);
            $("#error_msg").fadeOut(10000);
        });

    </script>
@endsection
