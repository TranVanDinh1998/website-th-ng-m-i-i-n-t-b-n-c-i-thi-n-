@extends('layouts.admin.index')
@section('title', 'Quảng cáo')
@section('head')
    <script src="{{ url('admin/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
                <li><a href="{{route('admin.advertise.index')}}">Quảng cáo</a></li>
                <li class="active">{{ $advertise->name }}</li>
            </ol>
            <section class="panel">
                <div class="panel-heading">
                    {{ $advertise->name }}
                </div>
                <div class="panel-body">
                    <div class="position-center">
                        <form  enctype="multipart/form-data"
                            action="{{ route('admin.advertise.update',['id'=>$advertise->id]) }}" method="POST">
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
                                <input type="text" class="form-control" name="name" id="name" placeholder="name"
                                    value="{{ $advertise->name }}">
                            </div>
                            <div class="form-group">
                                <label for="name">Tóm tắt</label>
                                <input type="text" class="form-control" name="summary" id="name" placeholder="name"
                                    value="{{ $advertise->summary }}">
                            </div>
                            <div class="form-group">
                                <label for="">Mô tả</label>
                                <textarea id="descript" class="form-control" name="description"
                                    placeholder="Password">{{$advertise->description}}</textarea>
                                <script>
                                    CKEDITOR.replace('descript');
                                </script>
                            </div>
                            <div class="form-group">
                                <label for="image">Hình ảnh:</label>
                                <input type="file" class="form-control" id="image_selected" name="image"
                                    placeholder="Select image">
                                <p class="help-block">Chỉ chấp nhận hình ảnh với đuôi .jpg, .png, .gif và < 5MB</p>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-sm-1" for="current_image">Hiện tại:</label>
                                                <div class="col-sm-5">
                                                    @if ($advertise->image)
                                                        <img src="{{ asset('/storage/images/advertises/'.$advertise->image) }}"
                                                            style="width: 250px;height:auto;">
                                                    @endif
                                                </div>
                                                <label class="control-label col-sm-1" for="current_image">Mới:</label>
                                                <div class="col-sm-5">
                                                    <img id="image_tag" width="250px;" height="auto;" alt="new image"
                                                        class="img-responsive" src="">
                                                </div>
                                            </div>
                                        </div>
                            </div>
                            <div class="form-group">
                                <label for="advertise_id">Sản phẩm:</label>
                                <select class="form-control" name="product_id">
                                    @foreach ($products as $product)
                                        @if ($advertise->product_id != $product->id)
                                            <option value='{{ $product->id }}'>{{ $product->id }} -
                                                {{ $product->name }}
                                            </option>
                                        @else
                                            <option value='{{ $product->id }}' selected>{{ $product->id }} -
                                                {{ $product->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-hidden"></div>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
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
