<!--header start-->
<header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">
        <a href="{{ route('admin.index') }}" class="logo">
            MANAGEMENT
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->
    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            <!-- settings start -->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="badge bg-success">{{ $task_orders_count }}</span>
                </a>
                <ul class="dropdown-menu extended tasks-bar">
                    <li>
                        <p class="">You have {{ $task_orders_count }} pending order(s)</p>
                    </li>
                    @foreach ($task_orders as $task_order)
                        <li>
                            <a href="#">
                                <div class="task-info clearfix">
                                    <div class="desc pull-left">
                                        <h5>Order #{{ $task_order->id }}</h5>
                                        <p>{{ $task_order->total }} d, Create at {{ $task_order->create_date }}</p>
                                        <p>
                                            @foreach ($addresses as $address)
                                                @if ($address->id == $task_order->shipping_address_id)
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
                                        </p>
                                    </div>
                                    {{-- <span class="notification-pie-chart pull-right"
                                        data-percent="45">
                                        <span class="percent"></span>
                                    </span> --}}
                                </div>
                            </a>
                        </li>
                    @endforeach
                    <li class="external">
                        <a href="{{ route('admin.order.index') }}">See All Orders</a>
                    </li>
                </ul>
            </li>
            <!-- settings end -->
            <!-- inbox dropdown start-->
            <li id="header_inbox_bar" class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-important">{{ $task_contacts_count }}</span>
                </a>
                <ul class="dropdown-menu extended inbox">
                    <li>
                        <p class="red">You have {{ $task_contacts_count }} Mails</p>
                    </li>
                    @foreach ($task_contacts as $contact)
                        <li>
                            <a href="#">
                                {{-- <span class="photo"><img alt="avatar"
                                        src="{{ url('uploads/users-image/' . $user->image) }}"></span>
                                --}}
                                <span class="subject">
                                    <span class="from">{{ $contact->name }}</span>
                                    <span class="time">{{ $contact->create_date }}</span>
                                </span>
                                <span class="message">
                                    {{ $contact->email }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('admin.contact.index') }}">See all messages</a>
                    </li>
                </ul>
            </li>
            <!-- inbox dropdown end -->
            <!-- notification dropdown start-->
            <li id="header_notification_bar" class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-bell-o"></i>
                    <span class="badge bg-warning">{{ $task_reviews_count }}</span>
                </a>
                <ul class="dropdown-menu extended inbox">
                    <li>
                        <p class="red">You have {{ $task_reviews_count }} Reviews</p>
                    </li>
                    @foreach ($task_reviews as $review)
                        <li>
                            <a href="#">
                                @foreach ($users as $item)
                                    @if ($item->id == $review->user_id)
                                        <span class="photo"><img alt="avatar" 
                                                src="{{ url('uploads/users-images/' . $item->image) }}"></span>
                                        <span class="subject">
                                            <span class="from">{{ $item->name }}</span>
                                            <span class="time">Create at {{ $item->create_date }}</span>
                                        </span>
                                        <span class="message">
                                            {{ $review->summary }}
                                        </span>
                                    @endif
                                @endforeach
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{route('admin.review.index')}}">See all messages</a>
                    </li>
                </ul>
            </li>
            <!-- notification dropdown end -->
        </ul>
        <!--  notification end -->
    </div>
    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <li>
                <input type="text" class="form-control search" placeholder=" Search">
            </li>
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="{{ url('uploads/users-images/' . $current_user->image) }}">
                    <span class="username">{{ $current_user->name }}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="{{ route('admin.auth.profile') }}"><i class=" fa fa-suitcase"></i>Profile</a></li>
                    <li><a href="{{ route('admin.auth.password') }}"><i class="fa fa-cog"></i>Change password</a></li>
                    <li><a href="{{ route('admin.auth.doLogout') }}"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->

        </ul>
        <!--search & user info end-->
    </div>
</header>
<!--header end-->
