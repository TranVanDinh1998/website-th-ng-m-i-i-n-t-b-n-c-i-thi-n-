@extends('layout')
@section('title', 'Contact us - Electronical Store')
@section('content')
    <!-- main-container -->
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="page-title">
                        <h1>Contact Us</h1>
                    </div>
                    <form action="" id="contact_form" method="post">
                        <div class="static-contain">
                            <fieldset class="group-select">
                                <ul>
                                    <li id="billing-new-address-form">
                                        <fieldset>
                                            <ul>
                                                <li>
                                                    <p id="errorContactMessage"></p>
                                                </li>
                                                <li>
                                                    <div class="customer-name">
                                                        <div class="input-box name-firstname">
                                                            <label for="name"><em class="required">*</em>Name</label>
                                                            <br>
                                                            <input name="name" id="name" title="Name" @if ($user != null)
                                                            value="{{ $user->name }}"
                                                            @endif
                                                            class="input-text required-entry" type="text">
                                                        </div>
                                                        <div class="input-box name-firstname">
                                                            <label for="email"><em class="required">*</em>Email</label>
                                                            <br>
                                                            <input name="email" id="email" title="Email" @if ($user != null)
                                                            value="{{ $user->email }}"
                                                            @endif
                                                            class="input-text required-entry validate-email"
                                                            type="text">

                                                        </div>
                                                    </div>
                                                </li>
                                                <li>

                                                    <label for="telephone">Telephone</label>
                                                    <br>
                                                    <input name="number" id="telephone" title="Telephone" value=""
                                                        class="input-text" type="text">

                                                </li>
                                                <li>

                                                    <label for="comment"><em class="required">*</em>Comment</label>
                                                    <br>
                                                    <textarea name="comment" id="comment" title="Comment"
                                                        class="required-entry input-text" cols="5" rows="3"></textarea>

                                                </li>
                                            </ul>
                                        </fieldset>
                                    </li>
                                    <p class="require"><em class="required">* </em>Required Fields</p>
                                    <input type="text" name="hideit" id="hideit" value="" style="display:none !important;">
                                    <div class="buttons-set">
                                        <button type="submit" title="Submit"
                                            class="button submit"><span><span>Submit</span></span></button>
                                    </div>
                                </ul>
                            </fieldset>
                        </div>

                    </form>
                </section>
                @include('information_side_bar');
            </div>
        </div>
    </div>
    <!--End main-container -->
    <script>
        $(document).ready(function() {
            $('#contact_form').on('submit', (function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/information/contact-us') }}",
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
                                $("#errorContactMessage").fadeIn(1000, function() {
                                    $("#errorContactMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.name[0] +
                                        "</div>"
                                    );
                                    $("#errorContactMessage").fadeOut(10000);
                                });
                            }
                            if (response.message.email != undefined) {
                                $("#errorContactMessage").fadeIn(1000, function() {
                                    $("#errorContactMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.email[0] +
                                        "</div>"
                                    );
                                    $("#errorContactMessage").fadeOut(10000);
                                });
                            }
                            if (response.message.number != undefined) {
                                $("#errorContactMessage").fadeIn(1000, function() {
                                    $("#errorContactMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.number[0] +
                                        "</div>"
                                    );
                                    $("#errorContactMessage").fadeOut(10000);
                                });
                            }
                            if (response.message.comment != undefined) {
                                $("#errorContactMessage").fadeIn(1000, function() {
                                    $("#errorContactMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.comment[0] +
                                        "</div>"
                                    );
                                    $("#errorContactMessage").fadeOut(10000);
                                });
                            }

                            if (response.message.errorContact != undefined) {
                                $("#errorContactMessage").fadeIn(1000, function() {
                                    $("#errorContactMessage").html(
                                        "<div class='alert alert-danger' style='width:100%; margin:auto;'>" +
                                        response.message.errorContact[0] +
                                        "</div>"
                                    );
                                    $("#errorContactMessage").fadeOut(10000);
                                });
                            }
                        } else {
                            alert("A new contact has been added.");
                        }
                    },
                })
            }));

        });

    </script>
@endsection
