@extends('layouts.customer.index')
@section('title', 'News')
@section('content')
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <div class="col-main col-sm-9">
                    <div class="page-title">
                        <h2>Mã giảm giá</h2>
                    </div>
                    <div class="blog-wrapper" id="main">
                        <div class="posts-isotope row">
                            @foreach ($coupons as $coupon)
                                <!-- Blog post -->
                                <div class="col-sm-6 col-md-6">
                                    <article class="container-paper-table">
                                        <div class="title">
                                            <h4 class=".text-primary" style="margin : 10px;">{{ $coupon->name }}</h4>
                                        </div>
                                        <div class="post-container"> <a href=""><img class="img-responsive"
                                            src="{{ asset('/storage/images/coupons/' . $coupon->image) }}" alt=""></a>
                                            <div class="text">
                                                <ul class="list-info">
                                                    <li><span class="icon-user">&nbsp;</span>By admin</li>
                                                    <li><span class="icon-time">&nbsp;</span>Posted on
                                                        {{ $coupon->created_at }}
                                                    </li>
                                                </ul>
                                                <h3>Code : {{ $coupon->code }}</h3>
                                                @if ($coupon->type == 0)
                                                    <p>Discount : {{ $coupon->discount }} d</p>
                                                @else
                                                    <p>Discount : {{ $coupon->discount }}%</p>
                                                @endif
                                                <p>Minimum order's value : {{ $coupon->minimum_order_value }} d</p>
                                                <p>Expire date : {{ $coupon->expired_dat }}</p>
                                                <p>Quantity : {{ $coupon->quantity }}</p>
                                                <p>Remaining : {{ $coupon->remaining }}</p>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <!-- //end Blog post -->
                            @endforeach

                            <!-- Pagination -->
                            <ul class="pagination">
                                {!! $coupons->links() !!}
                            </ul>
                            <!-- //end Pagination -->
                        </div>

                    </div>
                </div>
                <div class="col-right sidebar col-sm-3">
                    <div role="complementary" class="widget_wrapper13" id="secondary">
                        <div class="popular-posts widget widget__sidebar wow" id="recent-posts-4">
                            <h3 class="widget-title"><span>Các mã mới nhất</span></h3>
                            <div class="widget-content">
                                <ul class="posts-list unstyled clearfix">
                                    @foreach ($most_view_coupons as $coupon)
                                        <li>
                                            <figure class="featured-thumb"> <a href="#"> <img width="80" height="53"
                                                        alt="blog image"
                                                        src="{{ asset('/storage/images/coupons/' . $coupon->image) }}"> </a>
                                            </figure>
                                            <!--featured-thumb-->
                                            <h4><a title="Pellentesque habitant morbi" href="">{{ $coupon->name }}</a></h4>
                                            <p class="post-meta"><i class="icon-calendar"></i>
                                                <time datetime="2014-07-10T06:53:43+00:00"
                                                    class="entry-date">{{ $coupon->created_at }}</time>
                                                .
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!--widget-content-->
                        </div>
                        <div class="popular-posts widget widget_categories wow" id="categories-2">
                            <h3 class="widget-title"><span>Categories</span></h3>
                            <ul>
                                @foreach ($categories as $category)
                                    <li class="cat-item cat-item-19599"><a href="">{{ $category->name }}</a></li>
                                    <ul>
                                    </ul>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
