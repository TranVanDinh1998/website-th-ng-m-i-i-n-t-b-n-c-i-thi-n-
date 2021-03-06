@extends('layouts.admin.index')
@section('title', 'Nhập hàng')
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.product.index') }}">Sản phẩm</a></li>
                <li class="active">Nhập thêm hàng</li>
            </ol>
            <section class="panel">
                <div class="panel-heading">
                    Nhập hàng
                </div>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="POST" id="import_product_form"
                            action="{{ route('admin.product.import') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="panel">
                                @if (session('successes'))
                                    @foreach (session('successes') as $success)
                                        <div id="error_msg" class="alert alert-success">
                                            {{ $success }}
                                        </div>
                                    @endforeach
                                @endif
                                @if (session('errors'))
                                    @foreach (session('errors') as $error)
                                        <div id="error_msg" class="alert alert-danger">
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <input type="hidden" name="number" value="{{ $count }}">
                            @for ($i = 0; $i < $count; $i++)
                                <div class="row form-group panel">
                                    <div class="col-sm-6">
                                        <label>Product #{{ $products[$i]->id }}</label>
                                        @if ($products[$i]->image)
                                            <img src="{{ asset('storage/images/products/' . $products[$i]->image) }}"
                                                style="width: 100%;height:auto;">
                                        @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="producer_id">Tên sản phẩm : {{ $products[$i]->name }}</label>
                                            <input type="hidden" class="form-control" value="{{ $products[$i]->id }}"
                                                name="import[{{ $i }}][product_id]">
                                        </div>
                                        <div class="form-group">
                                            <label for="quantity">Số lượng</label>
                                            <input type="number" class="form-control" min="0"
                                                name="import[{{ $i }}][quantity]" placeholder="quantity">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                            <button type="submit" class="btn btn-info">Lưu</button>
                        </form>
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
