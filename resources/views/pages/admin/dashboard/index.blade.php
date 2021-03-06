@extends('admin.layout')
@section('title', 'Admin dashboard')
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
                            <h4>View</h4>
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
                            <h4>Users</h4>
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
                            <h4>Sales</h4>
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
                            <h4>Orders</h4>
                            <h3>{{ $count_order }}</h3>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
            <!-- //market-->
            {{-- <div class="row">
                <div class="panel-body">
                    <div class="col-md-12 w3ls-graph">
                        <!--agileinfo-grap-->
                        <div class="agileinfo-grap">
                            <div class="agileits-box">
                                <header class="agileits-box-header clearfix">
                                    <h3>Visitor Statistics</h3>
                                    <div class="toolbar">
                                    </div>
                                </header>
                                <div class="agileits-box-body clearfix">
                                    <div id="hero-area"></div>
                                </div>
                            </div>
                        </div>
                        <!--//agileinfo-grap-->

                    </div>
                </div>
            </div> --}}
            <div class="agil-info-calendar">
                <!-- calendar -->
                <div class="col-md-6 agile-calendar">
                    <div class="calendar-widget">
                        <div class="panel-heading ui-sortable-handle">
                            <span class="panel-icon">
                                <i class="fa fa-calendar-o"></i>
                            </span>
                            <span class="panel-title"> Calendar Widget</span>
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
                            {{-- <div class="alert alert-info clearfix">
                                <span class="alert-icon"><i class="fa fa-envelope-o"></i></span>
                                <div class="notification-info">
                                    <ul class="clearfix notification-meta">
                                        <li class="pull-left notification-sender"><span><a href="#">Jonathan
                                                    Smith</a></span> send you a mail </li>
                                        <li class="pull-right notification-time">1 min ago</li>
                                    </ul>
                                    <p>
                                        Urgent meeting for next proposal
                                    </p>
                                </div>
                            </div>
                            <div class="alert alert-danger">
                                <span class="alert-icon"><i class="fa fa-facebook"></i></span>
                                <div class="notification-info">
                                    <ul class="clearfix notification-meta">
                                        <li class="pull-left notification-sender"><span><a href="#">Jonathan
                                                    Smith</a></span> mentioned you in a post </li>
                                        <li class="pull-right notification-time">7 Hours Ago</li>
                                    </ul>
                                    <p>
                                        Very cool photo jack
                                    </p>
                                </div>
                            </div>
                            <div class="alert alert-success ">
                                <span class="alert-icon"><i class="fa fa-comments-o"></i></span>
                                <div class="notification-info">
                                    <ul class="clearfix notification-meta">
                                        <li class="pull-left notification-sender">You have 5 message unread</li>
                                        <li class="pull-right notification-time">1 min ago</li>
                                    </ul>
                                    <p>
                                        <a href="#">Anjelina Mewlo, Jack Flip</a> and <a href="#">3 others</a>
                                    </p>
                                </div>
                            </div>
                            <div class="alert alert-warning ">
                                <span class="alert-icon"><i class="fa fa-bell-o"></i></span>
                                <div class="notification-info">
                                    <ul class="clearfix notification-meta">
                                        <li class="pull-left notification-sender">Domain Renew Deadline 7 days ahead
                                        </li>
                                        <li class="pull-right notification-time">5 Days Ago</li>
                                    </ul>
                                    <p>
                                        Next 5 July Thursday is the last day
                                    </p>
                                </div>
                            </div>
                            <div class="alert alert-info clearfix">
                                <span class="alert-icon"><i class="fa fa-envelope-o"></i></span>
                                <div class="notification-info">
                                    <ul class="clearfix notification-meta">
                                        <li class="pull-left notification-sender"><span><a href="#">Jonathan
                                                    Smith</a></span> send you a mail </li>
                                        <li class="pull-right notification-time">1 min ago</li>
                                    </ul>
                                    <p>
                                        Urgent meeting for next proposal
                                    </p>
                                </div>
                            </div> --}}
                            {{-- <div class="alert alert-danger">
                                <span class="alert-icon"><i class="fa fa-facebook"></i></span>
                                <div class="notification-info">
                                    <ul class="clearfix notification-meta">
                                        <li class="pull-left notification-sender"><span><a href="#">Jonathan
                                                    Smith</a></span> mentioned you in a post </li>
                                        <li class="pull-right notification-time">7 Hours Ago</li>
                                    </ul>
                                    <p>
                                        Very cool photo jack
                                    </p>
                                </div>
                            </div> --}}
                            <div class="alert alert-info">
                                <span class="alert-icon"><i class="fa fa-comments-o"></i></span>
                                <div class="notification-info">
                                    <ul class="clearfix notification-meta">
                                        <li class="pull-left notification-sender">You have {{ $task_contacts_count }}
                                            message unread</li>
                                        {{-- <li class="pull-right notification-time">1 min
                                            ago</li> --}}
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
                                            and <a href="{{ route('admin.contact.index') }}">{{ $task_contacts_count - 3 }}
                                                other(s)</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="alert alert-success">
                                <span class="alert-icon"><i class="fa fa-shopping-cart"></i></span>
                                <div class="notification-info">
                                    <ul class="clearfix notification-meta">
                                        <li class="pull-left notification-sender">You have {{ $task_orders_count }}
                                            undone orders</li>
                                        {{-- <li class="pull-right notification-time">1 min
                                            ago</li> --}}
                                    </ul>
                                    <p>
                                        @for ($i = 0; $i < $task_orders_count; $i++)
                                            <a href="{{route('admin.order.detail',['id'=>$task_orders[$i]->id])}}">
                                                Order #{{ $task_orders[$i]->id }}
                                            </a>
                                            @if ($i < 2 && $i + 1 < $task_orders_count)
                                                ,
                                            @endif
                                            @break($i==2)
                                        @endfor
                                        @if ($task_orders_count - 3 > 0)
                                            and <a href="{{route('admin.order.index')}}">{{ $task_orders_count - 3 }} other(s)</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="alert alert-info">
                                <span class="alert-icon"><i class="fa fa-comments-o"></i></span>
                                <div class="notification-info">
                                    <ul class="clearfix notification-meta">
                                        <li class="pull-left notification-sender">You have {{ $task_reviews_count }}
                                            incomming review(s)</li>
                                        {{-- <li class="pull-right notification-time">1 min
                                            ago</li> --}}
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
                                            and <a href="{{ route('admin.review.index') }}">{{ $task_reviews_count - 3 }}
                                                other(s)</a>
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
                        {{-- <div id="graph7"></div>
                        <script>
                            // This crosses a DST boundary in the UK.
                            Morris.Area({
                                element: 'graph7',
                                data: [{
                                        x: '2013-03-30 22:00:00',
                                        y: 3,
                                        z: 3
                                    },
                                    {
                                        x: '2013-03-31 00:00:00',
                                        y: 2,
                                        z: 0
                                    },
                                    {
                                        x: '2013-03-31 02:00:00',
                                        y: 0,
                                        z: 2
                                    },
                                    {
                                        x: '2013-03-31 04:00:00',
                                        y: 4,
                                        z: 4
                                    }
                                ],
                                xkey: 'x',
                                ykeys: ['y', 'z'],
                                labels: ['Y', 'Z']
                            });

                        </script> --}}
                        {!!$monthly_chart!!}
                    </div>
                </div>
                <div class="col-md-4 agile-last-left agile-last-middle">
                    <div class="agile-last-grid">
                        <div class="area-grids-heading">
                            <h3>Daily</h3>
                        </div>
                        {{-- <div id="graph8"></div>
                        <script>
                            var day_data = [{
                                    "period": "2016-10-01",
                                    "licensed": 3407,
                                    "sorned": 660
                                },
                                {
                                    "period": "2016-09-30",
                                    "licensed": 3351,
                                    "sorned": 629
                                },
                                {
                                    "period": "2016-09-29",
                                    "licensed": 3269,
                                    "sorned": 618
                                },
                                {
                                    "period": "2016-09-20",
                                    "licensed": 3246,
                                    "sorned": 661
                                },
                                {
                                    "period": "2016-09-19",
                                    "licensed": 3257,
                                    "sorned": 667
                                },
                                {
                                    "period": "2016-09-18",
                                    "licensed": 3248,
                                    "sorned": 627
                                },
                                {
                                    "period": "2016-09-17",
                                    "licensed": 3171,
                                    "sorned": 660
                                },
                                {
                                    "period": "2016-09-16",
                                    "licensed": 3171,
                                    "sorned": 676
                                },
                                {
                                    "period": "2016-09-15",
                                    "licensed": 3201,
                                    "sorned": 656
                                },
                                {
                                    "period": "2016-09-10",
                                    "licensed": 3215,
                                    "sorned": 622
                                },
                                
                            ];
                            Morris.Bar({
                                element: 'graph8',
                                data: day_data,
                                xkey: 'period',
                                ykeys: ['licensed', 'sorned'],
                                labels: ['Licensed', 'SORN'],
                                xLabelAngle: 60
                            });

                        </script> --}}
                        {!!$daily_chart!!}
                    </div>
                </div>
                <div class="col-md-4 agile-last-left agile-last-right">
                    <div class="agile-last-grid">
                        <div class="area-grids-heading">
                            <h3>Yearly</h3>
                        </div>
                        {{-- <div id="graph9"></div>
                        <script>
                            var day_data = [{
                                    "elapsed": "I",
                                    "value": 34
                                },
                                {
                                    "elapsed": "II",
                                    "value": 24
                                },
                                {
                                    "elapsed": "III",
                                    "value": 3
                                },
                                {
                                    "elapsed": "IV",
                                    "value": 12
                                },
                                {
                                    "elapsed": "V",
                                    "value": 13
                                },
                                {
                                    "elapsed": "VI",
                                    "value": 22
                                },
                                {
                                    "elapsed": "VII",
                                    "value": 5
                                },
                                {
                                    "elapsed": "VIII",
                                    "value": 26
                                },
                                {
                                    "elapsed": "IX",
                                    "value": 12
                                },
                                {
                                    "elapsed": "X",
                                    "value": 19
                                }
                            ];
                            Morris.Line({
                                element: 'graph9',
                                data: day_data,
                                xkey: 'elapsed',
                                ykeys: ['value'],
                                labels: ['value'],
                                parseTime: false
                            });

                        </script> --}}
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
                                    <th>PRODUCT</th>
                                    <th>SALE</th>
                                    <th>REMAINING</th>
                                    <th>TOTAL</th>
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
                            <h4 class="title">Categories statistics ({{ $categories->count() }})</h4>
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
                            <h4 class="title">Collection statistics ({{ $collections->count() }})</h4>
                        </div>
                        <div class="stats-body">
                            <ul class="list-unstyled">
                                @foreach ($collections as $collection)
                                    <li>{{ $collection->name }} <span class="pull-right"><span
                                                class="badge">{{ $collection->collection_products()->count() }}</span></span>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-4 stats-info widget">
                    <div class="stats-info-agileits">
                        <div class="stats-title">
                            <h4 class="title">Browser Stats</h4>
                        </div>
                        <div class="stats-body">
                            <ul class="list-unstyled">
                                <li>GoogleChrome <span class="pull-right">85%</span>
                                    <div class="progress progress-striped active progress-right">
                                        <div class="bar green" style="width:85%;"></div>
                                    </div>
                                </li>
                                <li>Firefox <span class="pull-right">35%</span>
                                    <div class="progress progress-striped active progress-right">
                                        <div class="bar yellow" style="width:35%;"></div>
                                    </div>
                                </li>
                                <li>Internet Explorer <span class="pull-right">78%</span>
                                    <div class="progress progress-striped active progress-right">
                                        <div class="bar red" style="width:78%;"></div>
                                    </div>
                                </li>
                                <li>Safari <span class="pull-right">50%</span>
                                    <div class="progress progress-striped active progress-right">
                                        <div class="bar blue" style="width:50%;"></div>
                                    </div>
                                </li>
                                <li>Opera <span class="pull-right">80%</span>
                                    <div class="progress progress-striped active progress-right">
                                        <div class="bar light-blue" style="width:80%;"></div>
                                    </div>
                                </li>
                                <li class="last">Others <span class="pull-right">60%</span>
                                    <div class="progress progress-striped active progress-right">
                                        <div class="bar orange" style="width:60%;"></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> --}}

                <div class="clearfix"> </div>
            </div>
        </section>
        <!-- footer -->
        @include('admin.footer')
        <!-- / footer -->
    </section>
@endsection
