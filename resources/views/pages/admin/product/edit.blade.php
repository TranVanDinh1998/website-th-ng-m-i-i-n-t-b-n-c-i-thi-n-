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
                <li><a href="{{route('admin.product.index')}}">Sản phẩm</a></li>
                <li class="active">{{ $product->name }}</li>
            </ol>
            <section class="panel">
                <div class="panel-heading">
                    {{ $product->name }}
                </div>
                <div class="panel-body">
                    <div class="position-center">
                        <form method="POST" action="{{ route('admin.product.update',['id'=>$product->id]) }}"
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
                                <input type="hidden" class="form-control" name="id" placeholder="name"
                                    value="{{ $product->id }}">
                                <input type="text" class="form-control" name="name" placeholder="name"
                                    value="{{ $product->name }}">
                            </div>
                            <div class="form-group">
                                <label for="">Mô tả</label>
                                <textarea type="text" class="form-control" id="descript" name="description"
                                    placeholder="Description">{{ $product->description }}</textarea>
                                <script>
                                    CKEDITOR.replace('descript');
                                </script>
                            </div>
                            <div class="form-group">
                                <label for="image">Hình ảnh:</label>
                                <input type="file" class="form-control" id="image_selected" name="image"
                                    placeholder="Select image">
                                    <p class="help-block">Only accept file .jpg, .png, .gif and < 5MB</p>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-sm-1" for="current_image">Current:</label>
                                                <div class="col-sm-5">
                                                    @if ($product->image)
                                                        <img src="{{ asset('storage/images/products/'.$product->image) }}"
                                                            style="width: 250px;height:auto;">
                                                    @endif
                                                </div>
                                                <label class="control-label col-sm-1" for="current_image">New:</label>
                                                <div class="col-sm-5">
                                                    <img id="image_tag" width="250px;" height="auto;" alt="new image"
                                                        class="img-responsive" src="">
                                                </div>
                                            </div>
                                        </div>
                            </div>
                            <div class="form-group">
                                <label for="price">Đơn giá</label>
                                <input type="number" class="form-control" value="{{ $product->price }}" name="price"
                                    placeholder="price">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Số lượng tổng</label>
                                <input type="number" class="form-control" min="0" name="quantity" value="{{ $product->quantity }}" placeholder="quantity">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Còn tồn</label>
                                <input type="number" class="form-control" value="{{ $product->remaining }}" name="remaining"
                                    placeholder="quantity">
                            </div>
                            <div class="form-group">
                                <label for="category_id">Thể loại:</label>
                                <select class="form-control" name="category_id" required>
                                    <option>Lựa chọn thể loại</option>
                                    @foreach ($categories as $category)
                                        @if ($product->category_id != $category->id)
                                            <option value='{{ $category->id }}'>{{ $category->id }} -
                                                {{ $category->name }}
                                            </option>
                                        @else
                                            <option value='{{ $category->id }}' selected>{{ $category->id }} -
                                                {{ $category->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="producer_id">Hãng:</label>
                                <select class="form-control" name="producer_id" required>
                                    <option>Lựa chọn hãng</option>
                                    @foreach ($producers as $producer)
                                        @if ($product->producer_id != $producer->id)
                                            <option value='{{ $producer->id }}'>{{ $producer->id }} -
                                                {{ $producer->name }}
                                            </option>
                                        @else
                                            <option value='{{ $producer->id }}' selected>{{ $producer->id }} -
                                                {{ $producer->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="discount">Giảm giá</label>
                                <input type="number" class="form-control" min="0" max="100" name="discount"
                                    placeholder="discount" value="{{ $product->discount }}">
                            </div>
                            <button type="submit" class="btn btn-info">Submit</button>
                        </form>
                    </div>
                </div>
            </section>
        </section>

        <!-- Form add category and form add producer -->
        {{-- @include('admin.optional_add') --}}
        <!-- / Form add category and form add producer -->

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
