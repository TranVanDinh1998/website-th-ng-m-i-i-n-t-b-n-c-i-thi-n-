@extends('layouts.admin.index')
@section('title', 'Thay đổi mật khẩu')
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <section class="panel">
                <div class="panel-heading">
                    Thay đổi mật khẩu
                </div>
                <div class="panel-body">
                    <div class="position-center">
                        <form enctype="multipart/form-data" method="POST"
                            action="{{ route('admin.profile.password.update') }}">
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
                                <label for="name">Mật khẩu cũ</label>
                                <input type="password" class="form-control" name="old_password" placeholder="old password">
                            </div>
                            <div class="form-group">
                                <label for="name">Mật khẩu mới</label>
                                <input type="password" class="form-control" value="{{old('new_password')}}" name="new_password" placeholder="new password">
                            </div>
                            <div class="form-group">
                                <label for="name">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" value="{{old('re_password')}}" name="re_password" placeholder="re enter new password">
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

@endsection
