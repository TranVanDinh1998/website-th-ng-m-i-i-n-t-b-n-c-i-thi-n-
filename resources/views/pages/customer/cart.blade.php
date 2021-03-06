@extends('layouts.customer.index')
@section('title', 'Giỏ hàng')
@section('content')
    <section class="main-container col1-layout">
        <div class="main container">
            <div class="col-main">
                <div class="cart wow">
                    <div class="page-title">
                        <h2>Giỏ hàng</h2>
                    </div>
                    <div class="table-responsive">
                        <fieldset>
                            @if ($shopping_carts != null)
                                <form method="post" enctype="multipart/form-data" action="" id="update_cart_form">
                                    @csrf
                                    <table class="data-table cart-table" id="shopping-cart-table">
                                        <thead>
                                            <tr class="first last">
                                                <th>&nbsp;</th>
                                                <th><span class="nobr">Tên sản phẩm</span></th>
                                                <th><span class="nobr">Đơn giá</span></th>
                                                <th>Số lượng</th>
                                                <th>Thành tiền</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="first last">
                                                <td class="a-right last" colspan="50">
                                                    <a href="{{ route('home') }}" class="button btn-default btn-continue"
                                                        title="Continue Shopping" type="button"><span><span>Tiếp tục mua hàng</span></span>
                                                    </a>
                                                    <button class="button btn-update" name="update_cart_action"
                                                        type="submit"><span><span>Cập nhật giỏ hàng</span></span>
                                                    </button>
                                                    <button onclick="remove_cart();" class="button btn-empty"
                                                        title="Clear Cart"><span><span>Xóa bỏ giỏ hàng</span></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($shopping_carts as $product_id => $info)
                                                <tr class="first odd">
                                                    <td class="image">
                                                        <a class="product-image" title="{{ $info['product_name'] }}"
                                                            href="{{ route('product_details', ['id' => $product_id]) }}">
                                                            <img width="75" alt="{{ $info['product_name'] }}"
                                                                src="{{ asset('storage/images/products/' . $info['product_image']) }}"></a>
                                                    </td>
                                                    <td>
                                                        <h2 class="product-name"> <a
                                                                href="{{ route('product_details', ['id' => $product_id]) }}">{{ $info['product_name'] }}</a>
                                                        </h2>
                                                    </td>
                                                    <td>
                                                        @if ($info['product_discount'] != null)
                                                            <span class="cart-price">
                                                                <p class="special-price"> <span class="price">
                                                                        {{ $info['product_price'] - ($info['product_price'] * $info['product_discount']) / 100 }}
                                                                    </span>
                                                                </p>
                                                                <p class="old-price"> <span class="price-sep">-</span> <span
                                                                        class="price"> {{ $info['product_price'] }}
                                                                    </span> </p>
                                                            </span>
                                                        @else
                                                            <span class="cart-price">
                                                                <p class="price"> <span class="price">
                                                                        {{ $info['product_price'] }} </span>
                                                                </p>
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" class="form-control"
                                                            value="{{ $info['product_quantity'] }}"
                                                            name="quantity_{{ $product_id }}">
                                                    </td>
                                                    <td>
                                                        <span class="cart-price">
                                                            @if ($info['product_discount'] != null)
                                                                <span
                                                                    class="price">{{ ($info['product_price'] - ($info['product_price'] * $info['product_discount']) / 100) * $info['product_quantity'] }}
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="price">{{ $info['product_price'] * $info['product_quantity'] }}
                                                                </span>
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a onclick="remove_item_from_cart({{ $product_id }})"
                                                            class="button remove-item" title="Remove item">
                                                            <span><span>Loại bỏ sản phẩm</span></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                            @else
                                <a href="{{ route('home') }}" class="btn btn-default button btn-continue"
                                    title="Tiếp tục mua hàng"><span><span>Tiếp tục mua hàng</span></span></a>
                            @endif
                        </fieldset>
                    </div>
                    <!-- BEGIN CART COLLATERALS -->
                    <div class="cart-collaterals row">
                        <div class="col-sm-4">
                            <div class="discount">
                                <h3>Mã giảm giá</h3>
                                <form method="post" action="" id="apply_coupon_form">
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
                                    <label for="coupon_code">Hãy nhập mã giảm giá tại đây nếu bạn có.</label>
                                    <input type="text" value="" name="code" id="coupon_code" class="input-text fullwidth">
                                    <button value="Apply Coupon" class="button coupon " title="Apply Coupon"
                                        type="submit"><span>Áp dụng mã giảm giá</span></button>
                                    <button onclick="return remove_coupon();" title="Clear"
                                        class="button button-clear"><span>Xóa</span></button>
                                </form>
                            </div>
                        </div>
                        <div class="totals col-sm-4">
                            <h3>Tổng giá trị đơn hàng</h3>
                            <div class="inner">
                                <table class="table shopping-cart-table-total" id="shopping-cart-totals-table">
                                    <colgroup>
                                        <col>
                                        <col width="1">
                                    </colgroup>
                                    <tfoot>
                                        <tr>
                                            <td colspan="1" class="a-left" style=""><strong>Thành tiền</strong></td>
                                            <td class="a-right" style="">
                                                <strong>
                                                    <span class="price">
                                                        @if ($discount_cart == null)
                                                            {{ $total_cart }}
                                                        @else
                                                            {{ $total_cart - $discount_cart['coupon_discount'] }}
                                                        @endif
                                                    </span>
                                                </strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td colspan="1" class="a-left" style=""> Tổng </td>
                                            <td class="a-right" style=""><span class="price">{{ $total_cart }} </span>
                                            </td>
                                        </tr>
                                        @if (isset($discount_cart))
                                            <tr>
                                                <td colspan="1" class="a-left" style=""> Giảm giá </td>
                                                <td class="a-right" style=""><span class="">-
                                                        {{ $discount_cart['coupon_discount'] }}</span>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <ul class="checkout">
                                    <li>
                                        <button id="btn_check_out" class="button btn-proceed-checkout"
                                            title="Proceed to Checkout" type="button"><span>Đặt hàng</span></button>
                                    </li>
                                    <br>
                                </ul>
                            </div>
                            <!--inner-->

                        </div>
                    </div>
                    <!--cart-collaterals-->
                </div>
            </div>
        </div>
    </section>
    <script>
        function remove_cart() {
            if (confirm("Bạn có thực sự muốn loại bỏ toàn bộ giỏ hàng?")) {
                $.ajax({
                    url: "{{ route('cart.delete') }}",
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

        function remove_coupon() {
            if (confirm("Bạn có muốn hủy mã giảm giá?")) {
                $.ajax({
                    url: "{{ route('cart.remove_coupon') }}",
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
            // window.location.href="{{ route('cart.remove_coupon') }}";
        }

        $(document).ready(function() {
            $('#btn_check_out').on('click', function() {
                $.ajax({
                    url: "{{ route('cart.check') }}",
                    type: 'GET',
                    data: {},
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    beforeSend: function() {},
                    success: function(response) {
                        console.log(response);
                        alert(response.message);
                        if (response.error == false) {
                            window.location.href = "{{ url('/check-out') }}";
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }

                });
            });
            $('#update_cart_form').on('submit', (function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('cart.update') }}",
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    beforeSend: function() {},
                    success: function(response) {
                        console.log(response);
                        alert(response.message);
                        if (response.error == false) {
                            window.location.reload();
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }

                });
            }));
            $('#apply_coupon_form').on('submit', (function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('cart.apply_coupon') }}",
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    beforeSend: function() {},
                    success: function(response) {
                        console.log(response);
                        alert(response.message);
                        if (response.error == false) {
                            window.location.reload();
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }

                });
            }));
        });

    </script>
@endsection
