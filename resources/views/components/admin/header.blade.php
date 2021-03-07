<!--header start-->
<header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">
        <a href="{{ route('admin.index') }}" class="logo">
            Quản lý
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
                        <p class="">Bạn có {{ $task_orders_count }} đơn hàng đang chờ xử lý</p>
                    </li>
                    @foreach ($task_orders as $task_order)
                        <li>
                            <a href="#">
                                <div class="task-info clearfix">
                                    <div class="desc pull-left">
                                        <h5>Đơn hàng #{{ $task_order->id }}</h5>
                                        <p>{{ $task_order->total }} đ, tạo lúc {{ $task_order->created_at }}</p>
                                        <p>
                                            {{ $task_order->shippingAddress->address }} ,
                                            {{ $task_order->shippingAddress->ward }} ,
                                            {{ $task_order->shippingAddress->district }} ,
                                            {{ $task_order->shippingAddress->province }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                    <li class="external">
                        <a href="{{ route('admin.order.index') }}">Xem tất cả đơn hàng</a>
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
                        <p class="red">Bạn có {{ $task_contacts_count }} tin nhắn</p>
                    </li>
                    @foreach ($task_contacts as $contact)
                        <li>
                            <a href="#">
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
                        <a href="{{ route('admin.contact.index') }}">Xem hết mọi tin nhắn</a>
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
                        <p class="red">Bạn có {{ $task_reviews_count }} đánh giá</p>
                    </li>
                    @foreach ($task_reviews as $review)
                        <li>
                            <a href="#">
                                @foreach ($users as $item)
                                    @if ($item->id == $review->user_id)
                                        <span class="photo"><img alt="avatar"
                                                src="{{ asset('/storage/images/users/' . $item->image) }}"></span>
                                        <span class="subject">
                                            <span class="from">{{ $item->name }}</span>
                                            <span class="time">Tạo lúc {{ $item->create_date }}</span>
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
                        <a href="{{ route('admin.review.index') }}">Xem hết tất cả bình luận</a>
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
                    <img alt="" 
                    src="{{ asset('storage/images/users/' . $current_user->image) }}"
                    >
                    <span class="username">{{ $current_user->name }}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="{{ route('admin.profile.index') }}"><i class=" fa fa-suitcase"></i>Thông tin cá nhân</a></li>
                    <li><a href="{{ route('admin.profile.password.index') }}"><i class="fa fa-cog"></i>Thay đổi mật khẩu</a>
                    </li>
                    <li><a href="{{route('auth.admin.logout')}}"><i class="fa fa-key"></i>Đăng xuất</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->

        </ul>
        <!--search & user info end-->
    </div>
</header>
<!--header end-->
