@extends('layouts.admin.index')
@section('title', 'Thêm Quảng cáo mới')
@section('head')
    <script src="{{ url('admin/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
            <li><a href="{{route('admin.advertise.index')}}">Quảng cáo</a></li>
                <li class="active">Thêm mới</li>
            </ol>
            <section class="panel">
                <div class="panel-heading">
                    Thêm Quảng cáo mới
                </div>
                <div class="panel-body">
                    <div class="position-center">
                        <form enctype="multipart/form-data" method="POST"
                            action="{{ route('admin.advertise.store') }}">
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
                                <label for="name">Tóm tắt</label>
                                <input type="text" class="form-control" name="summary" id="name" placeholder="name"
                                    value="{{old('summary')}}">
                            </div>
                            <div class="form-group">
                                <label for="">Mô tả</label>
                                <textarea id="descript" class="form-control" name="description"
                                    placeholder="Password">{{old('description')}}</textarea>
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
                                <label for="product_id">Sản phẩm liên quan:</label>
                                <select class="form-control" name="product_id">
                                    @foreach ($products as $product)
                                        <option value='{{ $product->id }}'>{{ $product->id }} -
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
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
