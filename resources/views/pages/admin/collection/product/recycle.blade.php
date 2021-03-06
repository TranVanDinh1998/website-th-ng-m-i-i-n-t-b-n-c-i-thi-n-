@extends('layouts.admin.index')
@section('title', 'Thùng rác')
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.collection.index') }}">Bộ sưu tập</a></li>
                <li class="active">{{ $collection->name }}</li>
                <li><a href="{{ route('admin.collection.product.index',['id'=>$collection->id]) }}">Sản phẩm trong bộ sưu tập</a></li>
                <li class="active">Thùng rác</li>
            </ol>
            <div class="table-agile-info">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Thùng rác - Sản phẩm trong bộ sưu tập
                    </div>
                    <div class="row w3-res-tb">
                        <div class="col-sm-5 m-b-xs">
                            <span class="btn-group">
                                <a href="{{ route('admin.collection.product.recycle',['id'=>$collection->id]) }}" class="btn btn-sm btn-default"><i
                                        class="fa fa-refresh"></i> Làm mới</a>
                            </span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <form enctype="multipart/form-data" method="GET"
                                action="{{ route('admin.collection.product.recycle',['id'=>$collection->id]) }}">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" value="{{ $search }}"
                                        name="search" placeholder="Search">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-default">Tìm kiếm</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('admin.collection.product.bulk_action',['id'=>$collection->id]) }}" enctype="multipart/form-data">
                        <div class="row w3-res-tb">
                            <div class="col-sm-5 m-b-xs">
                                <select name="bulk_action" class="input-sm form-control w-sm inline v-middle">
                                    <option>Thao tác đa mục tiêu</option>
                                    <option value="3">Khôi phục</option>
                                    <option value="4">Xóa vĩnh viễn</option>
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
                        @if (session('errors'))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach (session('errors') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
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
                                                            href="{{ route('admin.collection.product.recycle', ['id'=>$collection->id,'sort_id' => 0, 'status' => $status, 'view' => $view]) }}">Inc</a>
                                                    </li>

                                                    <li @if ($sort_id == 1) class="active" @endif><a
                                                            href="{{ route('admin.collection.product.recycle', ['id'=>$collection->id,'sort_id' => 1, 'status' => $status, 'view' => $view]) }}">Desc</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </th>
                                        <th>Sản phẩm trong bộ sưu tập</th>
                                        <th>Hình ảnh</th>
                                        <th>Ngày xóa</th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button"
                                                    data-toggle="dropdown">Trạng thái
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li @if ($status == null) class="active" @endif><a
                                                            href="{{ route('admin.collection.product.recycle', ['id'=>$collection->id,'sort_id' => $sort_id, 'view' => $view]) }}">Tất cả</a>
                                                    </li>
                                                    <li @if ($status == 1) class="active" @endif><a
                                                            href="{{ route('admin.collection.product.recycle', ['id'=>$collection->id,'sort_id' => $sort_id, 'status' => '1', 'view' => $view]) }}">Hoạt động</a>
                                                    </li>

                                                    <li @if ($status == 0 && $status != null) class="active" @endif><a
                                                            href="{{ route('admin.collection.product.recycle', ['id'=>$collection->id,'sort_id' => $sort_id, 'status' => '0', 'view' => $view]) }}">Ngừng hoạt động</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th colspan="2">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($collectionProducts as $collectionProduct)
                                        <tr>
                                            <td>
                                                <label class="i-checks m-b-none">
                                                    <input type="checkbox" value="{{ $collectionProduct->id }}"
                                                        name="collectionProduct_id_list[]"><i></i>
                                                </label>
                                            </td>
                                            <td>
                                                {{ $collectionProduct->id }}
                                            </td>
                                            <td><span class="text-ellipsis">
                                                {{ $collectionProduct->product->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <img style="width: 70px; height : auto"
                                                src="{{ asset('/storage/images/products/' . $collectionProduct->product->image) }}"
                                                alt="{{ $collectionProduct->product->name }}">
                                        </td>
                                            <td><span class="text-ellipsis">{{ $collectionProduct->deleted_at }}</span></td>
                                            <td>
                                                @if ($collectionProduct->verified == 1)
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
                                                <a onclick="return confirm('Are you sure?')"
                                                    href="{{ route('admin.collection.product.restore', ['id' => $collection->id,'product_id'=>$collectionProduct->id, 'verified' => 1]) }}"
                                                    class="btn btn-success"><span class="glyphicon glyphicon-check"></span>
                                                </a>
                                            </td>
                                            <td>
                                                <a onclick="return confirm('Are you sure?')"
                                                    href="{{ route('admin.collection.product.destroy', ['id' => $collection->id,'product_id'=>$collectionProduct->id, 'verified' => 1]) }}"
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
                                            {{ $view }} của {{ $collectionProducts_count }} Hãng
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li @if ($view == 10) class="active" @endif><a
                                                    href="{{ route('admin.collection.product.recycle', ['id' => $collection->id,'sort_id' => $sort_id, 'status' => $status, 'view' => 10]) }}">10</a>
                                            </li>
                                            <li @if ($view == 15) class="active" @endif><a
                                                    href="{{ route('admin.collection.product.recycle', ['id' => $collection->id,'sort_id' => $sort_id, 'status' => $status, 'view' => 15]) }}">15</a>
                                            </li>
                                            <li @if ($view == 20) class="active" @endif><a
                                                    href="{{ route('admin.collection.product.recycle', ['id' => $collection->id,'sort_id' => $sort_id, 'status' => $status, 'view' => 20]) }}">20</a>
                                            </li>
                                            <li @if ($view == 30) class="active" @endif><a
                                                    href="{{ route('admin.collection.product.recycle', ['id' => $collection->id,'sort_id' => $sort_id, 'status' => $status, 'view' => 30]) }}">30</a>
                                            </li>
                                            <li @if ($view == 40) class="active" @endif><a
                                                    href="{{ route('admin.collection.product.recycle', ['id' => $collection->id,'sort_id' => $sort_id, 'status' => $status, 'view' => 40]) }}">40</a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-7 text-right text-center-xs">
                                    <ul class="pagination pagination-sm m-t-none m-b-none">
                                        {!! $collectionProducts->withQueryString()->links() !!}
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
