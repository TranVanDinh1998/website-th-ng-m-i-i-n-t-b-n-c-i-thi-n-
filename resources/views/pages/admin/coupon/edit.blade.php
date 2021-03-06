@extends('layouts.admin.index')
@section('title', 'Mã giảm giá')
@section('head')
    <script src="{{ url('admin/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
                <li><a href="{{route('admin.coupon.index')}}">Mã giảm giá</a></li>
                <li class="active">{{ $coupon->name }}</li>
            </ol>
            <section class="panel">
                <div class="panel-heading">
                    {{ $coupon->name }}
                </div>
                <div class="panel-body">
                    <div class="position-center">
                        <form  enctype="multipart/form-data"
                            action="{{ route('admin.coupon.update',['id'=>$coupon->id]) }}" method="POST">
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
                                <input type="text" class="form-control" id="name" name="name" value="{{$coupon->name}}" placeholder="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Mã để nhập </label>
                                <input type="text" class="form-control" name="code" placeholder="code" value="{{$coupon->code}}">
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
                                                    @if ($coupon->image)
                                                        <img src="{{ asset('/storage/images/coupons/'.$coupon->image) }}"
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
                                <label for="name">Hết hạn lúc</label>
                                <input type="datetime" class="form-control" name="expired_at" placeholder="expire date" value="{{$coupon->expired_at}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Số lượng</label>
                                <input type="number" class="form-control" name="quantity" placeholder="quantity" value="{{$coupon->quantity}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Số lượng tồn</label>
                                <input type="number" class="form-control" name="remaining" placeholder="quantity" value="{{$coupon->remaining}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Yêu cầu giá trị đơn hàng tối thiểu</label>
                                <input type="number" class="form-control" name="minimum_order_value" placeholder="" value="{{$coupon->minimum_order_value}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Loại giảm giá</label>
                                <select id="discount_type" name="type" class="form-control">
                                    <option value="0" @if ($coupon->type == 0)
                                        selected
                                        @endif>Tiền mặt</option>
                                    <option value="1" @if ($coupon->type == 1)
                                        selected
                                        @endif>Phần trăm</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Giảm giá </label>
                                <input type="number" class="form-control" name="discount" min="0"
                                    placeholder="discount value" value="{{ $coupon->discount }}">
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
