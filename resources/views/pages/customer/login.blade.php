@extends('layouts.customer.index')
@section('title', 'Đăng nhập')
@section('content')
    <section class="main-container col1-layout">
        <div class="main container">
            <div class="account-login">
                <div class="page-title">
                    <h2>Đăng nhập hoặc tạo 1 tài khoản</h2>
                </div>
                <fieldset class="col2-set">
                    <legend>Đăng nhập hoặc tạo 1 tài khoản</legend>
                    <div class="col-1 new-users">
                        <strong>Những khách hàng mới</strong>
                        <div class="content" id="intro">
                            <p>
                                Bằng cách tạo tài khoản với cửa hàng của chúng tôi, bạn sẽ có thể đặt hàng
                                nhanh hơn, lưu trữ nhiều địa chỉ giao hàng, xem và theo dõi các đơn đặt hàng trong tài khoản
                                của bạn và
                                hơn thế nữa.
                            </p>
                            <div class="buttons-set">
                                <button class="button create-account" id="btn_register"><span>Tạo 1 tài
                                        khoản</span></button>
                            </div>
                        </div>
                        <div class="content" id="register">
                            <form id="register_form" action="{{route('auth.customer.register')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <ul class="form-list">
                                    <li>
                                        @if (count($errors) > 0)
                                            @foreach ($errors->all() as $error)
                                                <p class="alert alert-danger">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                        @if (session('success'))
                                            <p class="alert-success alert">{{ session('success') }}</p>
                                        @endif
                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {!! session('error') !!}
                                            </div>
                                        @endif
                                    </li>
                                    <li>
                                        <label for="email">Tên<span class="required">*</span></label>
                                        <br>
                                        <input type="text" title="Name" value="{{old('name')}}" class="input-text required-entry" name="name">
                                    </li>
                                    <li>
                                        <label for="email">Địa chỉ email<span class="required">*</span></label>
                                        <br>
                                        <input type="email" title="Email Address" class="input-text required-entry"
                                            name="email" value="{{old('email')}}">
                                    </li>
                                    <li>
                                        <label for="password">Mật mã<span class="required">*</span></label>
                                        <br>
                                        <input type="password" title="Password" value="{{old('password')}}"
                                            class="input-text required-entry validate-password" name="password">
                                    </li>
                                    <li>
                                        <label for="re_password">Nhập lại mật mã<span class="required">*</span></label>
                                        <br>
                                        <input type="password" title="Re Password" value="{{old('re_password')}}"
                                            class="input-text required-entry validate-password" name="re_password">
                                    </li>
                                </ul>
                                <p class="required">* Bắt buộc</p>
                                <div class="buttons-set">
                                    <button type="submit" class="button register"><span>Đăng ký</span></button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="col-2 registered-users"><strong>Các khách hàng đã đăng ký</strong>
                        <form id="login_form" method="POST" enctype='multipart/form-data' action="{{ route('auth.customer.index') }}">
                            @csrf

                            <div class="content">
                                <p>Nếu bạn đã có tài khoản, hãy tiến hành đăng nhập</p>

                                <ul class="form-list">
                                    <li>
                                        @if (count($errors) > 0)
                                            @foreach ($errors->all() as $error)
                                                <p class="alert alert-danger">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                        @if (session('success'))
                                            <p class="alert-success alert">{{ session('success') }}</p>
                                        @endif
                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {!! session('error') !!}
                                            </div>
                                        @endif
                                    </li>
                                    <li>
                                        <label for="email">Địa chỉ email<span class="required">*</span></label>
                                        <br>
                                        <input type="email" title="Email Address" class="input-text required-entry"
                                            name="email" value="{{ old('email') }}">
                                    </li>
                                    <li>
                                        <label for="pass">Mật khẩu<span class="required">*</span></label>
                                        <br>
                                        <input type="password" title="Password" value="{{ old('password') }}"
                                            class="input-text required-entry validate-password" name="password">
                                    </li>
                                </ul>
                                <p class="required">* Bắt buộc</p>
                                <div class="buttons-set">
                                    <button type="submit" class="button login"><span>Đăng nhập</span></button>
                                    {{-- <a class="forgot-word" href="">Forgot
                                        Your Password?</a> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#register').hide();
            $('#btn_register').on('click', function() {
                $('#intro').hide();
                $('#register').show();
            });
        });

    </script>
@endsection
