@extends('layouts.admin.index')
@section('title', 'Giao diện quản lý')
@section('content')
    <section id="main-content">
        <section class="wrapper">
            <!-- //market-->
            <div class="market-updates">
                <div class="col-md-3 market-update-gd">
                    <div class="market-update-block clr-block-2">
                        <div class="col-md-4 market-update-right">
                            <i class="fa fa-eye"> </i>
                        </div>
                        <div class="col-md-8 market-update-left">
                            <h4>Lượt xem</h4>
                            <h3>{{ $count_view }}</h3>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="col-md-3 market-update-gd">
                    <div class="market-update-block clr-block-1">
                        <div class="col-md-4 market-update-right">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="col-md-8 market-update-left">
                            <h4>Người dùng</h4>
                            <h3>{{ $count_user }}</h3>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="col-md-3 market-update-gd">
                    <div class="market-update-block clr-block-3">
                        <div class="col-md-4 market-update-right">
                            <i class="fa fa-usd"></i>
                        </div>
                        <div class="col-md-8 market-update-left">
                            <h4>Danh thu</h4>
                            <h3>{{ number_format($count_sale) }}</h3>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="col-md-3 market-update-gd">
                    <div class="market-update-block clr-block-4">
                        <div class="col-md-4 market-update-right">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-8 market-update-left">
                            <h4>Đơn hàng</h4>
                            <h3>{{ $count_order }}</h3>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
            <!-- //market-->
            <div class="agil-info-calendar">
                <!-- calendar -->
                <div class="col-md-6 agile-calendar">
                    <div class="calendar-widget">
                        <div class="panel-heading ui-sortable-handle">
                            <span class="panel-icon">
                                <i class="fa fa-calendar-o"></i>
                            </span>
                            <span class="panel-title"> Thời gian</span>
                        </div>
                        <!-- grids -->
                        <div class="agile-calendar-grid">
                            <div class="page">

                                <div class="w3l-calendar-left">
                                    <div class="calendar-heading">

                                    </div>
                                    <div class="monthly" id="mycalendar"></div>
                                </div>

                                <div class="clearfix"> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- //calendar -->
                <div class="col-md-6 w3agile-notifications">
                    <div class="notifications">
                        <!--notification start-->

                        <header class="panel-heading">
                            Notification
                        </header>
                        <div class="notify-w3ls">
                            <div class="alert alert-info">
                                <span class="alert-icon"><i class="fa fa-comments-o"></i></span>
                                <div class="notification-info">
                                    <ul class="clearfix notification-meta">
                                        <li class="pull-left notification-sender">Bạn có {{ $task_contacts_count }}
                                            tin nhắn chưa đọc</li>
                                    </ul>
                                    <p>
                                        @for ($i = 0; $i < $task_contacts_count; $i++)
                                            <a href="{{ route('admin.contact.detail', ['id' => $task_contacts[$i]->id]) }}">
                                                {{ $task_contacts[$i]->name }}
                                            </a>
                                            @if ($i < 2 && $i + 1 < $task_orders_count)
                                                ,
                                            @endif
                                            @break($i==2)
                                        @endfor
                                        @if ($task_contacts_count - 3 > 0)
                                            và <a href="{{ route('admin.contact.index') }}">{{ $task_contacts_count - 3 }}
                                                đơn hàng nữa</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="alert alert-success">
                                <span class="alert-icon"><i class="fa fa-shopping-cart"></i></span>
                                <div class="notification-info">
                                    <ul class="clearfix notification-meta">
                                        <li class="pull-left notification-sender">Bạn có {{ $task_orders_count }}
                                            đơn hàng chờ duyệt</li>
                                    </ul>
                                    <p>
                                        @for ($i = 0; $i < $task_orders_count; $i++)
                                            <a href="{{route('admin.order.edit',['id'=>$task_orders[$i]->id])}}">
                                                Order #{{ $task_orders[$i]->id }}
                                            </a>
                                            @if ($i < 2 && $i + 1 < $task_orders_count)
                                                ,
                                            @endif
                                            @break($i==2)
                                        @endfor
                                        @if ($task_orders_count - 3 > 0)
                                            và <a href="{{route('admin.order.index')}}">{{ $task_orders_count - 3 }} đơn hàng khác nữa</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="alert alert-info">
                                <span class="alert-icon"><i class="fa fa-comments-o"></i></span>
                                <div class="notification-info">
                                    <ul class="clearfix notification-meta">
                                        <li class="pull-left notification-sender">Bạn có {{ $task_reviews_count }}
                                            đánh giá sản phẩm đang chờ duyệt</li>
                                    </ul>
                                    <p>
                                        @for ($i = 0; $i < $task_reviews_count; $i++)
                                            <a href="{{ route('admin.review.detail', ['id' => $task_reviews[$i]->id]) }}">
                                                @foreach ($users as $user)
                                                    @if ($user->id == $task_reviews[$i]->user_id)
                                                        {{$user->name}}
                                                    @endif
                                                @endforeach
                                            </a>
                                            @if ($i < 2 && $i + 1 < $task_reviews_count)
                                                ,
                                            @endif
                                            @break($i==2)
                                        @endfor
                                        @if ($task_reviews_count - 3 > 0)
                                            và <a href="{{ route('admin.review.index') }}">{{ $task_reviews_count - 3 }}
                                               đánh giá khác nữa </a>
                                        @endif
                                    </p>
                                </div>
                            </div>

                        </div>
                        <!--notification end-->
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
            <!-- tasks -->
            <div class="agile-last-grids">
                <div class="col-md-4 agile-last-left">
                    <div class="agile-last-grid">
                        <div class="area-grids-heading">
                            <h3>Monthly</h3>
                        </div>
                        {!!$monthly_chart!!}
                    </div>
                </div>
                <div class="col-md-4 agile-last-left agile-last-middle">
                    <div class="agile-last-grid">
                        <div class="area-grids-heading">
                            <h3>Daily</h3>
                        </div>
                        {!!$daily_chart!!}
                    </div>
                </div>
                <div class="col-md-4 agile-last-left agile-last-right">
                    <div class="agile-last-grid">
                        <div class="area-grids-heading">
                            <h3>Yearly</h3>
                        </div>
                        {!!$yearly_chart!!}
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
            <!-- //tasks -->

            <div class="agileits-w3layouts-stats">
                <div class="col-md-12 stats-info stats-last widget-shadow">
                    <div class="stats-last-agile">
                        <table class="table stats-table ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng bán</th>
                                    <th>Số lượng tồn</th>
                                    <th>Tổng cộng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <th scope="row">{{ $product->id }}</th>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->leftover }}</td>
                                        <td>{{ $product->remaining }}</td>
                                        <td>{{ $product->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 stats-info widget">
                    <div class="stats-info-agileits">
                        <div class="stats-title">
                            <h4 class="title">Danh sách thể loại ({{ $categories->count() }})</h4>
                        </div>
                        <div class="stats-body">
                            <ul class="list-unstyled">
                                @foreach ($categories as $category)
                                    <li>{{ $category->name }} <span class="pull-right"><span
                                                class="badge">{{ $category->products()->count() }}</span></span>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 stats-info widget">
                    <div class="stats-info-agileits">
                        <div class="stats-title">
                            <h4 class="title">Danh sách bộ sưu tập ({{ $collections->count() }})</h4>
                        </div>
                        <div class="stats-body">
                            <ul class="list-unstyled">
                                @foreach ($collections as $collection)
                                    <li>{{ $collection->name }} <span class="pull-right"><span
                                                class="badge">{{ $collection->collectionProducts()->count() }}</span></span>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </section>
        <!-- footer -->
        @include('components.admin.footer')
        <!-- / footer -->
    </section>
@endsection
