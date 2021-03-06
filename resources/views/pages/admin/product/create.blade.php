@extends('layouts.admin.index')
@section('title', 'Sản phẩm')
@section('head')
    <script src="{{ url('admin/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.product.store') }}">Sản phẩm</a></li>
                <li class="active">Thêm mới</li>
            </ol>
            <section class="panel">
                <div class="panel-heading">
                    Sản phẩm mới
                </div>
                <div class="panel-body">
                    <div class="position-center">
                        <form method='POST' id="add_product_form" action="{{ route('admin.product.store') }}"
                            enctype='multipart/form-data'>
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
                                <input type="text" class="form-control" name="name" placeholder="name">
                            </div>
                            <div class="form-group">
                                <label for="">Mô tả</label>
                                <textarea id="descript" class="form-control" name="description"
                                    placeholder="Password"></textarea>
                                <script>
                                    CKEDITOR.replace('descript');
                                </script>
                            </div>
                            <div class="form-group">
                                <label for="image">Hình ảnh:</label>
                                <input type="file" class="form-control" id="image_selected" name="image"
                                    placeholder="Select image" required>
                                <p class="help-block">Chỉ chấp nhận hình ảnh với đuôi .jpg, .png, .gif và < 5MB</p>
                                        <img id="image_tag" width="200px" height="auto;" class="img-responsive" src="">
                            </div>
                            <div class="form-group">
                                <label for="price">Đơn giá</label>
                                <input type="number" class="form-control" min="0" name="price" placeholder="price">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Số lượng tổng</label>
                                <input type="number" class="form-control" min="0" name="quantity" placeholder="quantity">
                            </div>
                            <div class="form-group">
                                <label for="category_id">Thể loại:</label>
                                <select class="form-control" name="category_id" required>
                                    <option>Lựa chọn thể loại</option>
                                    @foreach ($categories as $category)
                                        <option value='{{ $category->id }}'>{{ $category->id }} -
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="producer_id">Hãng:</label>
                                <select class="form-control" name="producer_id" required>
                                    <option>Lựa chọn hãng</option>
                                    @foreach ($producers as $producer)
                                        <option value='{{ $producer->id }}'>{{ $producer->id }} -
                                            {{ $producer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="discount">Giảm giá theo phần trăm</label>
                                <input type="number" class="form-control" min="0" max="100" name="discount"
                                    placeholder="discount">
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
