@extends('layouts.customer.index')
@section('title', 'Thông tin tài khoản')
@section('content')
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="my-account">
                        <div class="page-title">
                            <h2>Thông tin tài khoản cá nhân</h2>
                        </div>
                        <div class="col-2 registered-users">
                            <div class="content">
                                <form enctype="multipart/form-data" id="edit_info_form" method="POST"
                                    action="{{ route('account.info.update', ['id' => $user->id]) }}">
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
                                        <label for="name">Tên tài khoản</label>
                                        <input type="text" class="form-control" name="name" placeholder="name"
                                            value="{{ $user->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="email"
                                            value="{{ $user->email }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Hình ảnh:</label>
                                        <input type="file" class="form-control" id="image_selected" name="image"
                                            placeholder="Select image">
                                        <p class="help-block">Chỉ chấp nhận hình ảnh với đuôi .jpg, .png, .gif và < 5MB</p>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-1" for="current_image">Hiện
                                                            tại:</label>
                                                        <div class="col-sm-5">
                                                            <input type='hidden' class="form-control" name='current_image'
                                                                value='{{ $user->image }}'>
                                                            @if ($user->image)
                                                                <img src="{{ asset('storage/images/users/' . $user->image) }}"
                                                                    style="width: 250px;height:auto;">
                                                            @endif
                                                        </div>
                                                        <label class="control-label col-sm-1"
                                                            for="current_image">Mới:</label>
                                                        <div class="col-sm-5">
                                                            <img id="image_tag" width="250px;" height="auto;"
                                                                alt="new image" class="img-responsive" src="">
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
                @include('components.customer.sidebar.account')
            </div>
        </div>
    </div>
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
        });

    </script>
@endsection
