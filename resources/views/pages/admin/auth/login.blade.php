@extends('layouts.admin.login')
@section('title', 'Admin login')
@section('content')
    <!--main content start-->
    <div class="log-w3">
        <div class="w3layouts-main">
            <h2>Sign In Now</h2>
            <form action="{{ route('auth.admin.login') }}" id="login_form" method="post">
                @csrf
                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <p class="alert alert-danger">{{ $error }}</p>
                    @endforeach
                @endif
                @if (session('error'))
                    <div id="error_msg" class="alert alert-danger">
                        {!! session('error') !!}
                    </div>
                @endif
                <input type="email" class="ggg" name="email" placeholder="E-MAIL">
                <input type="password" class="ggg" name="password" placeholder="PASSWORD">
                <div class="clearfix"></div>
                <input type="submit" value="Sign In" name="login">
            </form>
        </div>
    </div>
    <!--main content end-->
@endsection
