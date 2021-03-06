@extends('layouts.admin.index')
@section('title', 'Bộ sưu tập')
@section('head')
    <script src="{{ url('admin/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
                <li><a href="{{route('admin.collection.index')}}">Bộ sưu tập</a></li>
                <li class="active">{{ $collection->name }}</li>
            </ol>
            <section class="panel">
                <div class="panel-heading">
                    {{ $collection->name }}
                </div>
                <div class="panel-body">
                    <div class="position-center">
                        <form  enctype="multipart/form-data"
                            action="{{ route('admin.collection.update',['id'=>$collection->id]) }}" method="POST">
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
                                    value="{{ $collection->name }}">
                            </div>
                            <div class="form-group">
                                <label for="">Mô tả</label>
                                <textarea id="descript" class="form-control" name="description"
                                    placeholder="Password">{{$collection->description}}</textarea>
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
                                                    @if ($collection->image)
                                                        <img src="{{ asset('/storage/images/collections/'.$collection->image) }}"
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
                                <label for="collection_id">Thể loại liên quan:</label>
                                <select class="form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        @if ($category->category_id != $category->id)
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
                                <label for="name">Ưu tiên</label>
                                <input type="number" min="0" class="form-control" name="priority" value="{{$category->priority ?? 0}}" placeholder="name">
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
