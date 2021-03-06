@extends('layout')
@section('title', 'Register - Electronical Store')
@section('content')
    <section class="main-container col1-layout">
        <div class="main container">
            <div class="account-login">
                <div class="page-title">
                    <h2>Create an Account</h2>
                </div>
                <div class="col-2">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-6">
                                <form method='POST' id="register_form" action="{{ URL::to('/register') }}"
                                    enctype='multipart/form-data'>
                                    @csrf
                                    <div id="errorMessage"></div>
                                    <div class="form-group">
                                        <label for="name">Name </label>
                                        <input type="text" class="form-control" name="name" placeholder="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email </label>
                                        <input type="email" class="form-control" name="email" placeholder="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Password </label>
                                        <input type="password" class="form-control" name="password" placeholder="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Confirm Password </label>
                                        <input type="password" class="form-control" name="re_password"
                                            placeholder="confirm password">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image </label>
                                        <input type="file" class="form-control" id="image_selected" name="image"
                                            placeholder="Select image">
                                        <p class="help-block">Only accept file .jpg, .png, .gif and < 5MB</p>
                                                <img id="image_tag" width="300px" height="auto;" class="img-responsive"
                                                    src="">
                                    </div>
                                    <div class="buttons-set">
                                        <button type="submit" class="button login"><span>Register</span></button>
                                        <a class="forgot-word" href="{{ URL::to('/login') }}">Have an account? Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
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
            $('#register_form').on('submit', (function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/register') }}",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    beforeSend: function() {},
                    success: function(response) {
                        console.log(response);
                        if (response.error == true) {
                            if (response.message.name != undefined) {
                                $("#errorMessage").fadeIn(1000, function() {
                                    $("#errorMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.name[0] +
                                        "</div>"
                                    );
                                    $("#errorMessage").fadeOut(10000);
                                });
                            }
                            if (response.message.email != undefined) {
                                $("#errorMessage").fadeIn(1000, function() {
                                    $("#errorMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.email[0] +
                                        "</div>"
                                    );
                                    $("#errorMessage").fadeOut(10000);
                                });
                            }
                            if (response.message.password != undefined) {
                                $("#errorMessage").fadeIn(1000, function() {
                                    $("#errorMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.password[0] + "</div>");
                                    $("#errorMessage").fadeOut(10000);

                                });
                            }
                            if (response.message.re_password != undefined) {
                                $("#errorMessage").fadeIn(1000, function() {
                                    $("#errorMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.re_password[0] +
                                        "</div>");
                                    $("#errorMessage").fadeOut(10000);

                                });
                            }
                            if (response.message.image != undefined) {
                                $("#errorMessage").fadeIn(1000, function() {
                                    $("#errorMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.image[0] +
                                        "</div>"
                                    );
                                    $("#errorMessage").fadeOut(10000);
                                });
                            }
                            if (response.message.errorImage != undefined) {
                                $("#errorMessage").fadeIn(1000, function() {
                                    $("#errorMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.errorImage[0] +
                                        "</div>"
                                    );
                                    $("#errorMessage").fadeOut(10000);
                                });
                            }
                            if (response.message.errorRegister != undefined) {
                                $("#errorMessage").fadeIn(1000, function() {
                                    $("#errorMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.errorRegister[0] +
                                        "</div>"
                                    );
                                    $("#errorMessage").fadeOut(10000);
                                });
                            }
                        } else {
                            alert("A new user has been registered.");
                            window.location.href = "{{ url('/login') }}";
                        }
                    },
                    // error: function(e) {
                    //     console.log(e);
                    // }
                })
            }));
        });

    </script>
@endsection
