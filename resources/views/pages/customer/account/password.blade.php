@extends('layouts.customer.index')
@section('title', 'Đổi mật khẩu')
@section('content')
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="my-account">
                        <div class="page-title">
                            <h2>Mật khẩu mới</h2>
                        </div>
                        <div class="col-2 registered-users">
                            <div class="content">
                                <form enctype="multipart/form-data" method="POST"
                                    action="{{ route('account.password.change') }}">
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
                                            <p class="alert-danger alert">{{ session('error') }}</p>
                                        @endif
                                    </div>
                                    <ul class="form-list">
                                        <li>
                                            <label for="">Mật khẩu hiện tại <span class="required">*</span></label>
                                            <br>
                                            <input type="password"
                                                class="input-text required-entry validate-password" value="{{old('old_password')}}"
                                                name="old_password">
                                        </li>
                                        <li>
                                            <label for="">Mật khẩu mới <span class="required">*</span></label>
                                            <br>
                                            <input type="password"
                                                class="input-text required-entry validate-password" value="{{old('new_password')}}"
                                                name="new_password">
                                        </li>
                                        <li>
                                            <label for="">Xác nhận mật khẩu<span class="required">*</span></label>
                                            <br>
                                            <input type="password"
                                                class="input-text required-entry validate-password" value="{{old('re_password')}}"
                                                name="re_password">
                                        </li>
                                    </ul>
                                    <p class="required">* Bắt buộc</p>
                                    <div class="buttons-set">
                                        <button name="send" type="submit"
                                            class="button"><span>Thay đổi</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </section>
                @include('components.customer.sidebar.account')
            </div>
        </div>
    </div>
@endsection
