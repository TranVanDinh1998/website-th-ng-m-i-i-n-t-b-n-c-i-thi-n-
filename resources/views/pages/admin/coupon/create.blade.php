@extends('layouts.admin.index')
@section('title', 'Thêm Mã giảm giá mới')
@section('head')
    <script src="{{ url('admin/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
            <li><a href="{{route('admin.coupon.index')}}">Mã giảm giá</a></li>
                <li class="active">Thêm mới</li>
            </ol>
            <section class="panel">
                <div class="panel-heading">
                    Thêm Mã giảm giá mới
                </div>
                <div class="panel-body">
                    <div class="position-center">
                        <form enctype="multipart/form-data" method="POST"
                            action="{{ route('admin.coupon.store') }}">
                            @csrf
                            <div class="panel">
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <p class="alert alert-danger">{{ $error }}</p>
                                    @endforeach
                                @endif
                                @if (session('success'))
                                    <p class="alert-success alert">{{ session('success') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="name">Tên</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" placeholder="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Mã để nhập </label>
                                <input type="text" class="form-control" name="code" placeholder="code">
                            </div>
                            <div class="form-group">
                                <label for="image">Hình ảnh:</label>
                                <input type="file" class="form-control" id="image_selected" name="image"
                                    placeholder="Select image" required>
                                <p class="help-block">Chỉ chấp nhận hình ảnh với đuôi .jpg, .png, .gif và < 5MB</p>
                                        <img id="image_tag" width="200px" height="auto;" class="img-responsive" src="">
                            </div>
                            <div class="form-group">
                                <label for="name">Hết hạn lúc</label>
                                <input type="date" class="form-control" name="expired_at" placeholder="expire date">
                            </div>
                            <div class="form-group">
                                <label for="name">Số lượng</label>
                                <input type="number" class="form-control" name="quantity" placeholder="quantity">
                            </div>
                            <div class="form-group">
                                <label for="name">Yêu cầu giá trị đơn hàng tối thiểu</label>
                                <input type="number" class="form-control" name="minimum_order_value" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="name">Loại giảm giá</label>
                                <select id="discount_type" name="type" class="form-control">
                                    <option value="0">Tiền mặt</option>
                                    <option value="1">Phần trăm</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Giảm giá </label>
                                <input type="number" class="form-control" name="discount" min="0"
                                    placeholder="discount value">
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-hidden"></div>
                                <div class="col-sm-10">
                                    <button type="submit" id="btnRegister" name="btn_add"
                                        class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
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
    <script>
        $(document).ready(function() {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#image_tag').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#image_selected").change(function() {
                readURL(this);
            });

        });

    </script>
@endsection
