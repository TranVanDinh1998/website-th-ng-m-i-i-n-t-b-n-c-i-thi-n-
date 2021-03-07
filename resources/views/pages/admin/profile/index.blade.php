@extends('layouts.admin.index')
@section('title', 'Hồ sơ cá nhân')
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <section class="panel">
                <div class="panel-heading">
                    Hồ sơ cá nhân của bạn
                </div>
                <div class="panel-body">
                    <div class="position-center">
                        <form enctype="multipart/form-data" method="POST"
                            action="{{ route('admin.profile.update') }}">
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
                                @if (session('error'))
                                <p class="alert-success alert">{{ session('error') }}</p>
                            @endif
                            </div>
                            <div class="form-group">
                                <label for="name">Tên</label>
                                <input type="text" class="form-control" name="name" placeholder="name"
                                    value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="email"
                                    value="{{ $user->email }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="name">Tạo ra lúc</label>
                                <input type="date" class="form-control" name="email" placeholder="email"
                                    value="{{ $user->create_date }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="name">Lần cập nhật cuối</label>
                                <input type="date" class="form-control" name="email" placeholder="email"
                                    value="{{ $user->update_date }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="image">Hình ảnh:</label>
                                <input type="file" class="form-control" id="image_selected" name="image"
                                    placeholder="Select image">
                                <p class="help-block">Only accept file .jpg, .png, .gif and < 5MB</p>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="control-label col-sm-1" for="current_image">Hiện tại:</label>
                                                <div class="col-sm-5">
                                                    <input type='hidden' class="form-control" name='current_image'
                                                        value='{{ $user->image }}'>
                                                    @if ($user->image)
                                                        <img src="{{ asset('storage/images/admins/' . $user->image) }}"
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
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function() {
            $("#image_selected").change(function() {
                readURL(this);
            });
        })

    </script>
@endsection
