<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from htmldemo.magikcommerce.com/ecommerce/inspire-html-template/digital/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 13 Aug 2015 08:00:59 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <!-- Favicons Icon -->
    <link rel="icon" href="http://demo.magikthemes.com/skin/frontend/base/default/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="http://demo.magikthemes.com/skin/frontend/base/default/favicon.ico"
        type="image/x-icon" />
    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- CSS Style -->

    <link rel="stylesheet" href="{{ url('css/blogmate.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('css/fancybox.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('css/font-awesome.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('css/owl.carousel.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('css/owl.theme.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('css/revslider copy.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('css/revslider.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('css/style.css') }}" type="text/css">

    <!-- Google Fonts, Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>
    {{-- <link rel="stylesheet" href="{{ asset('public/css/font-awesome.min.css') }}"> --}}
    <!-- Google jQuery -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body class="cms-index-index">
    <div class="page">

        <!-- Header -->
        @include('components.customer.header')
        <!-- end header -->

        <div class="panel">
            @yield('content')
        </div>

        <!-- Footer -->
        @include('components.customer.footer')
        <!-- End Footer -->
        <div class="social">
            <ul>
                <li class="fb"><a href="#"></a></li>
                <li class="tw"><a href="#"></a></li>
                <li class="googleplus"><a href="#"></a></li>
                <li class="rss"><a href="#"></a></li>
                <li class="pintrest"><a href="#"></a></li>
                <li class="linkedin"><a href="#"></a></li>
                <li class="youtube"><a href="#"></a></li>
            </ul>
        </div>

        {{-- @endif --}}

        <!-- Quick view -->
        @include('components.customer.display.quick_view')
        <!--End Quick view-->

        <script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/common.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/cloudzoom.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/jquery.jcarousel.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/revslider.js') }}"></script>
        <script type="text/javascript" src="{{ url('js/owl.carousel.min.js') }}"></script>
        <script type="text/javascript">
            function add_to_wish_list(id) {
                $.ajax({
                    url: "{{ url('account/wish-list/add') }}",
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.error != undefined) {
                            alert(response.message);
                        }
                    },
                    error: function(e) {
                        alert('You need to login first');
                    }

                });
                return false;
            }

            function add_to_cart(id) {
                $.ajax({
                    url: "{{ route('cart.create') }}",
                    type: 'GET',
                    data: {
                        id: id,
                        quantity: 1,
                    },
                    success: function(response) {
                        console.log(response)
                        alert(response.message);
                        if (response.error == false) {
                            window.location.reload();
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }

                });
                return false;
            }

            function add_to_compare(id) {
                $.ajax({
                    url: "{{ url('/compare/add') }}",
                    type: 'GET',
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        console.log(response)
                        alert(response.message);
                    },
                    error: function(e) {
                        console.log(e);
                    }

                });
                return false;
            }

            function remove_compare() {
                if (confirm("Are you sure want to remove entire comparition?")) {
                    $.ajax({
                        url: "{{ url('/compare/delete') }}",
                        type: 'GET',
                        data: {},
                        success: function(response) {
                            console.log(response)
                            alert(response.message);
                            if (response.error == false) {
                                window.location.reload();
                            }
                        },
                        error: function(e) {
                            console.log(e);
                        }

                    });
                    return false;
                }
            }

            function remove_item_from_cart(id) {
                if (confirm("Are you sure want to remove this product from the shopping cart?")) {
                    $.ajax({
                        url: "{{ url('/cart/remove') }}",
                        type: 'GET',
                        data: {
                            id: id,
                        },
                        success: function(response) {
                            console.log(response)
                            alert(response.message);
                            if (response.error == false) {
                                window.location.reload();
                            }
                        },
                        error: function(e) {
                            console.log(e);
                        }

                    });
                    return false;
                }
            }

            function remove_item_from_compare(id) {
                if (confirm("Are you sure want to remove this product from the comparation?")) {
                    $.ajax({
                        url: "{{ url('/compare/remove') }}",
                        type: 'GET',
                        data: {
                            id: id,
                        },
                        success: function(response) {
                            console.log(response)
                            alert(response.message);
                            if (response.error == false) {
                                window.location.reload();
                            }
                        },
                        error: function(e) {
                            console.log(e);
                        }

                    });
                    return false;
                }
            }

            function quick_view(id) {
                var get_data = '';
                $.ajax({
                    url: "{{ url('quick-view') }}",
                    type: 'GET',
                    data: {
                        product_id: id,
                    },
                    success: function(response) {
                        console.log(response)
                        get_data = response;
                        $('#quick-view-content').html(response);
                        $('#quick-view').modal('show');
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
                return false;
            }

            $(document).ready(function() {
                $('#btn_increase').click(function() {
                    var quantity = $('#qty').val();
                    quantity++;
                    $('#qty').val(quantity);
                });
                $('#btn_decrease').click(function() {
                    var quantity = $('#qty').val();
                    quantity--;
                    if (quantity <= 0) {
                        quantity++;
                    }
                    $('#qty').val(quantity);
                });
                $('#add_to_cart_form').on('submit', function(e) {
                    var id = $('#product_id').val();
                    var quantity = $('#qty').val();
                    add_to_cart_form(id, quantity);
                });
            });

        </script>
    </div>
</body>

</html>
