@extends('layouts.admin.index')
@section('title', 'Đánh giá')
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="table-agile-info">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Đánh giá
                    </div>
                    <div class="row w3-res-tb">
                        <div class="col-sm-5 m-b-xs">
                            <span class="btn-group">
                                <a href="{{ route('admin.review.index') }}" class="btn btn-sm btn-default"><i
                                        class="fa fa-refresh"></i> Làm mới</a>
                                <a href="{{ route('admin.review.recycle') }}" class="btn btn-sm btn-danger"><i
                                        class="fa fa-trash"></i> Thùng rác</a>
                            </span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                        </div>
                    </div>
                    <form method="GET" action="{{ route('admin.review.bulk_action') }}" enctype="multipart/form-data">
                        <div class="row w3-res-tb">
                            <div class="col-sm-5 m-b-xs">
                                <select id="bulk_action" name="bulk_action"
                                    class="input-sm form-control w-sm inline v-middle">
                                    <option>Thao tác đa mục tiêu</option>
                                    <option value="0">Tắt</option>
                                    <option value="1">Bật</option>
                                    <option value="2">Loại bỏ</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-default">Áp dụng</button>
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
                                                            href="{{ route('admin.review.index', ['sort_id' => 0, 'status' => $status, 'view' => $view]) }}">Inc</a>
                                                    </li>

                                                    <li @if ($sort_id == 1) class="active" @endif><a
                                                            href="{{ route('admin.review.index', ['sort_id' => 1, 'status' => $status, 'view' => $view]) }}">Desc</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </th>
                                        <th>Minh họa</th>
                                        <th>Sản phẩm</th>
                                        <th>Người dùng</th>
                                        <th>Tóm tắt</th>
                                        <th>Tạo lúc</th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button"
                                                    data-toggle="dropdown">Trạng thái
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li @if ($status == null) class="active" @endif><a
                                                            href="{{ route('admin.review.index', ['view' => $view]) }}">All</a>
                                                    </li>
                                                    <li @if ($status == 1) class="active" @endif><a
                                                            href="{{ route('admin.review.index', ['sort_id' => $sort_id, 'status' => '1', 'view' => $view]) }}">Active</a>
                                                    </li>
                                                    <li @if ($status == 0 && $status != null) class="active" @endif><a
                                                            href="{{ route('admin.review.index', ['sort_id' => $sort_id, 'status' => '0', 'view' => $view]) }}">Inactive</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </th>
                                        <th colspan="2">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reviews as $review)
                                        <tr>
                                            <td>
                                                <label class="i-checks m-b-none">
                                                    <input type="checkbox" value="{{ $review->id }}"
                                                        name="review_id_list[]"><i></i>
                                                </label>
                                            </td>
                                            <td>
                                                {{ $review->id }}
                                            </td>
                                            <td>
                                                <img style="width: 70px; height : auto"
                                                    src="{{ asset('storage/images/products/' . $review->product->image) }}"
                                                    alt="{{ $review->product->name }}">
                                            </td>
                                            <td><span class="text-ellipsis">{{ $review->product->name }}</span></td>
                                            <td>
                                                {{ $review->user->email }}
                                            </td>
                                            <td>
                                                <span class="text-ellipsis">
                                                    {{ $review->summary }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-ellipsis">
                                                    {{ $review->created_at }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($review->verified == 1)
                                                    <div class="alert alert-success" role="alert">
                                                        <strong>Hoạt động</strong>
                                                    </div>
                                                @else
                                                    <div class="alert alert-danger" role="alert">
                                                        <strong>Ngừng hoạt động</strong>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($review->verified == 0)
                                                    <a onclick="return confirm('Are you sure?')"
                                                        href="{{ route('admin.review.verify', ['id' => $review->id, 'verified' => 1]) }}"
                                                        class="btn btn-success" title="Activate">
                                                        <span class="glyphicon glyphicon-check"></span>
                                                    </a>
                                                @else
                                                    <a onclick="return confirm('Are you sure?')"
                                                        href="{{ route('admin.review.verify', ['id' => $review->id, 'verified' => 0]) }}"
                                                        class="btn btn-warning" title="Deactivate">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-info"
                                                    href="{{ route('admin.review.show', ['id' => $review->id]) }}">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                            </td>
                                            <td>
                                                <a onclick="return confirm('Are you sure?')"
                                                    href="{{ route('admin.review.delete', ['id' => $review->id]) }}"
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
                                            {{ $view }} của {{ $reviews_count }} đánh giá
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li @if ($view == 10) class="active" @endif><a
                                                    href="{{ route('admin.review.index', ['sort_id' => $sort_id, 'status' => $status, 'view' => 10]) }}">10</a>
                                            </li>
                                            <li @if ($view == 15) class="active" @endif><a
                                                    href="{{ route('admin.review.index', ['sort_id' => $sort_id, 'status' => $status, 'view' => 15]) }}">15</a>
                                            </li>
                                            <li @if ($view == 20) class="active" @endif><a
                                                    href="{{ route('admin.review.index', ['sort_id' => $sort_id, 'status' => $status, 'view' => 20]) }}">20</a>
                                            </li>
                                            <li @if ($view == 30) class="active" @endif><a
                                                    href="{{ route('admin.review.index', ['sort_id' => $sort_id, 'status' => $status, 'view' => 30]) }}">30</a>
                                            </li>
                                            <li @if ($view == 40) class="active" @endif><a
                                                    href="{{ route('admin.review.index', ['sort_id' => $sort_id, 'status' => $status, 'view' => 40]) }}">40</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-7 text-right text-center-xs">
                                    <ul class="pagination pagination-sm m-t-none m-b-none">
                                        {!! $reviews->withQueryString()->links() !!}
                                    </ul>
                                </div>
                            </div>
                        </footer>
                    </form>

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
