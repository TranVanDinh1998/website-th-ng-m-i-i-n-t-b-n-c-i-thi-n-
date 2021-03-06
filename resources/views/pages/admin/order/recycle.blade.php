@extends('admin.layout')
@section('title', 'Trash can')
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.order.index') }}">Order management</a></li>
                <li class="active">Recycle</li>
            </ol>
            <div class="table-agile-info">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Orders - Trash can
                    </div>
                    <div class="row w3-res-tb">
                        <div class="col-sm-5 m-b-xs">
                            <span class="btn-group">
                                <a href="{{ route('admin.order.recycle') }}" class="btn btn-sm btn-default"><i
                                        class="fa fa-refresh"></i> Refresh</a>
                                <a href="{{ route('admin.order.history') }}" class="btn btn-sm btn-default"><i
                                        class="fa fa-film"></i> History</a>
                                <a href="{{ route('admin.order.cancel') }}" class="btn btn-sm btn-default"><i
                                        class="fa fa-remove"></i>Cancel</a>
                                <a href="{{ route('admin.order.add') }}" class="btn btn-sm btn-success"><i
                                        class="fa fa-plus"></i> Add</a>
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
                                    <option>Bulk action</option>
                                    <option value="7">Activate</option>
                                    <option value="8">Remove</option>
                                </select>
                                <button class="btn btn-sm btn-default">Apply</button>
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
                                                    <li @if ($sort_id == 0)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => 0, 'status' => $status, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">Inc</a>
                                                    </li>
                                                    <li @if ($sort_id == 1)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => 1, 'status' => $status, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">Desc</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th>Receiver</th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button"
                                                    data-toggle="dropdown">Create at
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li @if ($sort_date == 0)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => 0, 'status' => $status, 'sort_total' => $sort_total, 'sort_date' => 0, 'view' => $view]) }}">Inc</a>
                                                    </li>
                                                    <li @if ($sort_date == 1)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => 1, 'status' => $status, 'sort_total' => $sort_total, 'sort_date' => 1, 'view' => $view]) }}">Desc</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th>Ship to</th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button"
                                                    data-toggle="dropdown">Total
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li @if ($sort_total == null)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => $sort_id, 'sort_date' => $sort_date, 'status' => $status, 'view' => $view]) }}">All</a>
                                                    </li>
                                                    <li @if ($sort_total == 0 && $sort_total != null)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => 0, 'status' => $status, 'sort_total' => 0, 'sort_date' => $sort_date, 'view' => $view]) }}">Inc</a>
                                                    </li>
                                                    <li @if ($sort_total == 1 && $sort_total != null)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => 1, 'status' => $status, 'sort_total' => 1, 'sort_date' => $sort_date, 'view' => $view]) }}">Desc</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button"
                                                    data-toggle="dropdown">Status
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li @if ($status == null)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => $sort_id, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">All</a>
                                                    </li>
                                                    <li @if ($status == 0 && $status != null)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => $sort_id, 'status' => '0', 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">Pending</a>
                                                    </li>
                                                    <li @if ($status == 1 && $status != null)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => $sort_id, 'status' => '1', 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">Waiting
                                                            for goods</a>
                                                    </li>
                                                    <li @if ($status == 2 && $status != null)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => $sort_id, 'status' => '2', 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">On
                                                            Delivery</a>
                                                    </li>
                                                    <li @if ($status == 3 && $status != null)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => $sort_id, 'status' => '3', 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'view' => $view]) }}">Delivered</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button"
                                                    data-toggle="dropdown">Payment
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li @if ($sort_paid == null)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_id' => $sort_id, 'sort_date' => $sort_date, 'status' => $status, 'view' => $view]) }}">All</a>
                                                    </li>
                                                    <li @if ($sort_paid == 0 && $sort_paid != null)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_paid' => 0, 'sort_id' => $sort_id, 'status' => $status, 'sort_total' => 0, 'sort_date' => $sort_date, 'view' => $view]) }}">No</a>
                                                    </li>
                                                    <li @if ($sort_paid == 1 && $sort_paid != null)
                                                        class="active"
                                                        @endif><a
                                                            href="{{ route('admin.order.index', ['sort_paid' => 1, 'sort_id' => $sort_id, 'status' => $status, 'sort_total' => 1, 'sort_date' => $sort_date, 'view' => $view]) }}">Yes</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th colspan="3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                <label class="i-checks m-b-none">
                                                    <input type="checkbox" name="order_id_list[]"><i></i>
                                                </label>
                                            </td>
                                            <td>
                                                {{ $order->id }}
                                            </td>
                                            <td>
                                                @foreach ($addresses as $address)
                                                    @if ($address->id == $order->shipping_address_id)
                                                        {{ $address->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $order->create_date }}</td>
                                            <td>
                                                <span class="text-ellipsis">
                                                    @foreach ($addresses as $address)
                                                        @if ($address->id == $order->shipping_address_id)
                                                            {{ $address->address }} ,
                                                            @foreach ($wards as $ward)
                                                                @if ($ward->id == $address->ward_id)
                                                                    {{ $ward->name }} ,
                                                                @endif
                                                            @endforeach
                                                            @foreach ($districts as $district)
                                                                @if ($district->id == $address->district_id)
                                                                    {{ $district->name }} ,
                                                                @endif
                                                            @endforeach
                                                            @foreach ($provinces as $province)
                                                                @if ($province->id == $address->province_id)
                                                                    {{ $province->name }}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </span>
                                            </td>
                                            <td>{{ $order->total }}</td>
                                            <td>
                                                @switch($order->status)
                                                    @case(0)
                                                    Pending
                                                    @break
                                                    @case(1)
                                                    Waiting for goods
                                                    @break
                                                    @case(2)
                                                    On Delivery
                                                    @break
                                                    @case(3)
                                                    Delivered
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @if ($order->is_paid == 0)
                                                    No
                                                @else
                                                    Yes
                                                @endif
                                            </td>
                                            <td>
                                                <a onclick="return confirm('Are you sure?')"
                                                    href="{{ route('admin.producer.restore', ['id' => $producer->id]) }}"
                                                    class="btn btn-success"><span class="glyphicon glyphicon-check"></span>
                                                </a>
                                            </td>
                                            <td>
                                                <a onclick="return confirm('Are you sure?')"
                                                    href="{{ route('admin.producer.delete', ['id' => $producer->id]) }}"
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
                                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">View :
                                            {{ $view }} of {{ $count_order }} item(s)
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li @if ($view == 10)
                                                class="active"
                                                @endif><a
                                                    href="{{ route('admin.order.index', ['sort_id' => $sort_id, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'status' => $status, 'view' => 10]) }}">10</a>
                                            </li>
                                            <li @if ($view == 15)
                                                class="active"
                                                @endif><a
                                                    href="{{ route('admin.order.index', ['sort_id' => $sort_id, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'status' => $status, 'view' => 15]) }}">15</a>
                                            </li>
                                            <li @if ($view == 20)
                                                class="active"
                                                @endif><a
                                                    href="{{ route('admin.order.index', ['sort_id' => $sort_id, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'status' => $status, 'view' => 20]) }}">20</a>
                                            </li>
                                            <li @if ($view == 30)
                                                class="active"
                                                @endif><a
                                                    href="{{ route('admin.order.index', ['sort_id' => $sort_id, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'status' => $status, 'view' => 30]) }}">30</a>
                                            </li>
                                            <li @if ($view == 40)
                                                class="active"
                                                @endif><a
                                                    href="{{ route('admin.order.index', ['sort_id' => $sort_id, 'sort_total' => $sort_total, 'sort_date' => $sort_date, 'status' => $status, 'view' => 40]) }}">40</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-7 text-right text-center-xs">
                                    <ul class="pagination pagination-sm m-t-none m-b-none">
                                        {!! $orders->links() !!}
                                    </ul>
                                </div>
                            </div>
                        </footer>
                </div>
            </div>
        </section>
        <!-- footer -->
        @include('admin.footer')
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
