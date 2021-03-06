@extends('layouts.customer.index')
@section('title', 'Thủ tục đặt hàng')
@section('content')
    <!-- main-container -->
    <script>
        $(document).ready(function() {
            // check method
            $('#btn_checkout_method_continue').click(function() {
                var choice = $('input:radio[name="checkout_method"]:checked').val();
                if (choice == "register") {
                    window.location.href = "{{ route('auth.customer.index') }}";
                } else {
                    if (choice == "guest") {
                        $("#shipping-old-address").hide();
                        $("#shipping-new-address").show();
                    }
                }
            });

            // Shipping check out
            $("#shipping-address-select").change(function() {
                var val = $("#shipping-address-select option:selected").val();
                if (val == 0) {
                    $("#shipping-new-address").show();
                    $('#shipping_add_address_form').attr('action', "{{ route('checkout.new_address') }}");
                } else {
                    $('#shipping_add_address_form').attr('action',
                        "{{ route('checkout.old_address') }}");
                    $("#shipping-new-address").hide();
                }
            });

            // payment
            $('input:radio[name="payment_method"]').click(function() {
                var choice = $('input:radio[name="payment_method"]:checked').val();
                if (choice == "0") {
                    $("#payment_form_ccsave").hide();
                } else {
                    if (choice == "1") {
                        $("#payment_form_ccsave").show();
                    }
                }
            });

            $('#btn_final_check').click(function() {
                window.location.href = "{{ route('checkout.final_check') }}";
            });

        });

    </script>
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="page-title">
                        <h1>Thủ tục đặt hàng</h1>
                    </div>
                    <ol class="one-page-checkout" id="checkoutSteps">
                        <li id="opc-cart" class="section allow active">
                            <div class="step-title"> <span class="number">1</span>
                                <h3>Giỏ hàng</h3>
                                <!--<a href="#">Edit</a> -->
                            </div>
                            <div id="checkout-step-cart" class="step a-item" style="">
                                @if ($shopping_carts != null)
                                    <div class="table-responsive">
                                        <fieldset>
                                            <table class="data-table cart-table" id="shopping-cart-table">
                                                <thead>
                                                    <tr class="first last">
                                                        <th>&nbsp;</th>
                                                        <th><span class="nobr">Sản phẩm</span></th>
                                                        <th><span class="nobr">Đơn giá</span></th>
                                                        <th>Số lượng</th>
                                                        <th>Thành tiền</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($shopping_carts as $product_id => $info)
                                                        <tr class="first odd">
                                                            <td class="image">
                                                                <a class="product-image"
                                                                    title="{{ $info['product_name'] }}"
                                                                    href="{{ route('product_details', ['id' => $product_id]) }}"><img
                                                                        width="75" alt="{{ $info['product_name'] }}"
                                                                        src="{{ asset('storage/images/products/' . $info['product_image']) }}"></a>
                                                            </td>
                                                            <td>
                                                                <p class="product-name"> <a
                                                                        href="{{ route('product_details', ['id' => $product_id]) }}">{{ $info['product_name'] }}</a>
                                                                </p>
                                                            </td>
                                                            <td>
                                                                @if ($info['product_discount'] != null)
                                                                    <span class="cart-price">
                                                                        <p class="special-price"> <span class="price">
                                                                                {{ $info['product_price'] - ($info['product_price'] * $info['product_discount']) / 100 }}
                                                                            </span>
                                                                        </p>
                                                                        <p class="old-price"> <span
                                                                                class="price-sep">-</span> <span
                                                                                class="price">
                                                                                {{ $info['product_price'] }}
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
                                                                <span>{{ $info['product_quantity'] }}</span>
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
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </fieldset>
                                    </div>
                                    <div class="totals " style="float: right;">
                                        <div class="inner">
                                            <table class="table shopping-cart-table-total" id="shopping-cart-totals-table">
                                                <colgroup>
                                                    <col>
                                                    <col width="1">
                                                </colgroup>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="1" class="a-left" style=""><strong>Thành
                                                                tiền</strong></td>
                                                        <td class="a-right" style="">
                                                            <strong>
                                                                <span class="price">
                                                                    @if ($discount_cart == null)
                                                                        {{ $total_cart }} đ
                                                                    @else
                                                                        {{ $total_cart - $discount_cart['coupon_discount'] }}
                                                                        đ
                                                                    @endif
                                                                </span>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="1" class="a-left" style=""> Tổng </td>
                                                        <td class="a-right" style=""><span
                                                                class="price">{{ $total_cart }} đ </span>
                                                        </td>
                                                    </tr>
                                                    @if (isset($discount_cart))
                                                        <tr>
                                                            <td colspan="1" class="a-left" style=""> Giảm giá </td>
                                                            <td class="a-right" style=""><span class="">-
                                                                    {{ $discount_cart['coupon_discount'] }} đ</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--inner-->
                                    </div>
                                @else
                                    <a href="{{ route('home') }}" class="btn btn-default button btn-continue"
                                        title="Tiếp tục mua hàng"><span><span>Tiếp tục mua hàng</span></span></a>
                                @endif
                            </div>
                        </li>
                        <li id="opc-shipping" class="section allow active">
                            <div class="step-title"> <span class="number">2</span>
                                <h3>Địa chỉ giao hàng</h3>
                            </div>
                            @if (!Auth::user())
                                <div id="checkout-step-login" class="step a-item">
                                    <div class="col2-set">
                                        <div class="col-1">
                                            <h4>Đặt hàng với tư cách là thành viên hay khách vãng lai</h4>
                                            <p>Đăng ký thành viên để thuận tiện hơn trong tương lai:</p>
                                            <ul class="form-list">
                                                <li class="control">
                                                    <input type="radio" class="form-control-sm radio" value="guest"
                                                        name="checkout_method">
                                                    <label for="login:guest">Đặt hàng với tư cách là khách vãng lai</label>
                                                </li>
                                                <li class="control">
                                                    <input type="radio" class="form-control-sm radio" value="register"
                                                        name="checkout_method">
                                                    <label for="login:register">Đăng ký tài khoản</label>
                                                </li>
                                            </ul>
                                            <h4>Đăng ký và tiết kiệm thời gian</h4>
                                            <p>Đăng ký thành viên để thuận tiện hơn trong tương lai:</p>
                                            <ul class="ul">
                                                <li>Đặt hàng nhanh chóng và dễ dàng</li>
                                                <li>Dễ dàng truy cập vào lịch sử giao dịch</li>
                                            </ul>
                                            <div class="buttons-set">
                                                <p class="required">&nbsp;</p>
                                                <button id="btn_checkout_method_continue"
                                                    class="button continue"><span><span>Tiếp tục</span></span></button>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <h4>Đăng nhập</h4>
                                            <form method="post" action="{{ route('auth.customer.index') }}"
                                                id="login_form" enctype="multipart/form-data">
                                                @csrf
                                                <fieldset>
                                                    <h5>Đã đăng ký từ trước rồi?</h5>
                                                    <p>Đăng nhập ngay:</p>
                                                    <ul class="form-list">
                                                        <li>
                                                            @if (count($errors) > 0)
                                                                @foreach ($errors->all() as $error)
                                                                    <p class="alert alert-danger">{{ $error }}</p>
                                                                @endforeach
                                                            @endif
                                                            @if (session('success'))
                                                                <p class="alert-success alert">{{ session('success') }}
                                                                </p>
                                                            @endif
                                                            @if (session('error'))
                                                                <div class="alert alert-danger">
                                                                    {!! session('error') !!}
                                                                </div>
                                                            @endif
                                                        </li>
                                                        <li>
                                                            <label class="required" for="login-email"><em>*</em>Địa chỉ
                                                                email</label>
                                                            <div class="input-box">
                                                                <input type="email" value="" name="email"
                                                                    class="input-text required-entry validate-email">
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <label class="required" for="login-password"><em>*</em>Mật
                                                                khẩu</label>
                                                            <div class="input-box">
                                                                <input type="password" name="password"
                                                                    class="input-text required-entry">
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <input type="hidden" value="checkout" name="context">
                                                </fieldset>
                                                <div class="buttons-set">
                                                    <p class="required">* Bắt buộc</p>
                                                    <button class="button login" type="submit"><span><span>Đăng
                                                                nhập</span></span></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-2" id="shipping-new-address" style="display: none;">
                                        <div class="step-title">
                                            <h4>Địa chỉ mới</h4>
                                        </div>
                                        <form id="shipping_add_address_form" enctype="multipart/form-data" method="POST"
                                            action="{{route('checkout.new_address')}}">
                                            @csrf
                                            <fieldset class="group-select">
                                                <ul>
                                                    <li>
                                                        <ul>
                                                            <li>
                                                                <div class="customer-name">
                                                                    <div class="input-box name-firstname">
                                                                        <label for=""> Tên người nhận <span
                                                                                class="required">*</span>
                                                                        </label>
                                                                        <br>
                                                                        <input type="text" name="name" value=""
                                                                            class="input-text required-entry">
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div id="" class="input-box">
                                                                    <label for="shipping:region">Province <span
                                                                            class="required">*</span></label>
                                                                    <br>
                                                                    <select name="province_id">
                                                                        <option value="">
                                                                            Lựa chọn tỉnh, thành phố
                                                                        </option>
                                                                        @foreach ($provinces as $province)
                                                                            <option value="{{ $province->id }}">
                                                                                {{ $province->name }}

                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div id="" class="input-box">
                                                                    <label for="shipping:region">Quận/ Huyện<span
                                                                            class="required">*</span></label>
                                                                    <br>
                                                                    <select name="district_id">
                                                                        <option value="">
                                                                            Chọn quận/ huyện
                                                                        </option>
                                                                        @foreach ($districts as $district)
                                                                            <option value="{{ $district->id }}">
                                                                                {{ $district->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div id="" class="input-box">
                                                                    <label for="shipping:region">Xã/ phường<span
                                                                            class="required">*</span></label>
                                                                    <br>
                                                                    <select name="ward_id">
                                                                        <option value="">
                                                                            Chọn xã/ phường
                                                                        </option>
                                                                        @foreach ($wards as $ward)
                                                                            <option value="{{ $ward->id }}">
                                                                                {{ $ward->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <label for="shipping:street1">Địa chỉ <span
                                                                        class="required">*</span></label>
                                                                <br>
                                                                <input type="text" title="Street Address" name="address"
                                                                    value="" class="input-text required-entry">
                                                            </li>
                                                            <li>
                                                                <div class="input-box">
                                                                    <label for="shipping:telephone">Số điện thoại <span
                                                                            class="required">*</span></label>
                                                                    <br>
                                                                    <input type="text" name="number"
                                                                        class="input-text required-entry">
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <p id="errorAddressMessage"></p>
                                                        <p class="require"><em class="required">* </em>Bắt buộc</p>
                                                        <button id="btn_shipping_checkout" type="submit"
                                                            class="button continue"><span>Xác nhận</span></button>
                                                    </li>
                                                </ul>

                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div id="checkout-step-shipping" class="step a-item">
                                    <form id="shipping_add_address_form" enctype="multipart/form-data" method="POST"
                                        action="{{ route('checkout.old_address') }}">
                                        @csrf
                                        <fieldset class="group-select">
                                            <ul>
                                                <li>
                                                    @if (count($errors) > 0)
                                                        @foreach ($errors->all() as $error)
                                                            <p class="alert alert-danger">{{ $error }}</p>
                                                        @endforeach
                                                    @endif
                                                    @if (session('success'))
                                                        <p class="alert-success alert">{{ session('success') }}
                                                        </p>
                                                    @endif
                                                    @if (session('error'))
                                                        <div class="alert alert-danger">
                                                            {!! session('error') !!}
                                                        </div>
                                                    @endif
                                                </li>
                                                <li id="shipping-old-address">
                                                    <label for="shipping-address-select">
                                                        Lựa chọn địa chỉ giao hàng
                                                    </label>
                                                    <br>
                                                    <select name="shipping_address_id" id="shipping-address-select"
                                                        class="address-select" title="">
                                                        <option value="" value="">Lựa chọn địa chỉ giao hàng</option>
                                                        @if (Auth::user()->addresses != null)
                                                            @foreach (Auth::user()->addresses as $address)
                                                                <option value="{{ $address->id }}" selected>
                                                                    {{ $address->address }} -
                                                                    {{ $address->ward->name }} -
                                                                    {{ $address->district->id }} -
                                                                    {{ $address->province->name }} -
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                        <option value="0" value="">Địa chỉ mới</option>
                                                    </select>
                                                </li>
                                                <li id="shipping-new-address" style="display: none;">
                                                    <fieldset>
                                                        <legend>Địa chỉ mới</legend>
                                                        <ul>
                                                            <li>
                                                                <div class="customer-name">
                                                                    <div class="input-box name-firstname">
                                                                        <label for=""> Tên người nhận <span
                                                                                class="required">*</span>
                                                                        </label>
                                                                        <br>
                                                                        <input type="text" name="name" value=""
                                                                            class="input-text required-entry">
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div id="" class="input-box">
                                                                    <label for="shipping:region">Province <span
                                                                            class="required">*</span></label>
                                                                    <br>
                                                                    <select name="province_id">
                                                                        <option value="">
                                                                            Chọn tỉnh/ thành phố
                                                                        </option>
                                                                        @foreach ($provinces as $province)
                                                                            <option value="{{ $province->id }}">
                                                                                {{ $province->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div id="" class="input-box">
                                                                    <label for="shipping:region">Quận/ huyện<span
                                                                            class="required">*</span></label>
                                                                    <br>
                                                                    <select name="district_id">
                                                                        <option value="">
                                                                            Chọn quận/ huyện
                                                                        </option>
                                                                        @foreach ($districts as $district)
                                                                            <option value="{{ $district->id }}">
                                                                                {{ $district->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div id="" class="input-box">
                                                                    <label for="shipping:region">Xã/ phường<span
                                                                            class="required">*</span></label>
                                                                    <br>
                                                                    <select name="ward_id">
                                                                        <option value="">
                                                                            Chọn xã/ phường
                                                                        </option>
                                                                        @foreach ($wards as $ward)
                                                                            <option value="{{ $ward->id }}">
                                                                                {{ $ward->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <label for="shipping:street1">Địa chỉ<span
                                                                        class="required">*</span></label>
                                                                <br>
                                                                <input type="text" title="Street Address" name="address"
                                                                    value="" class="input-text required-entry">
                                                            </li>
                                                            <li>
                                                                <div class="input-box">
                                                                    <label for="shipping:telephone">Số điện thoại<span
                                                                            class="required">*</span></label>
                                                                    <br>
                                                                    <input type="text" name="number"
                                                                        class="input-text required-entry">
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <input type="checkbox" name="save_address" value="1"
                                                                    title="Save in address book" class="checkbox">
                                                                <label for="shipping:save_in_address_book">Lưu vào danh sách
                                                                    địa chỉ</label>
                                                            </li>
                                                        </ul>
                                                    </fieldset>
                                                </li>
                                            </ul>
                                            <p class="require"><em class="required">* </em>Bắt buộc</p>
                                            <button id="btn_shipping_checkout" type="submit"
                                                class="button continue"><span>Xác nhận</span></button>
                                        </fieldset>
                                    </form>
                                </div>
                            @endif
                        </li>
                        <li id="opc-payment" class="section allow active">
                            <div class="step-title"> <span class="number">3</span>
                                <h3 class="one_page_heading">Thông tin thanh toán</h3>
                            </div>
                            <div id="checkout-step-payment" class="step a-item">
                                <form action="{{ route('checkout.payment') }}" id="payment_credit_add_form" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @if (session('payment_success'))
                                        <p class="alert-success alert">{{ session('payment_success') }}
                                        </p>
                                    @endif
                                    @if (session('payment_error'))
                                        <div class="alert alert-danger">
                                            {!! session('payment_error') !!}
                                        </div>
                                    @endif
                                    <dl id="checkout-payment-method-load">
                                        <dt>
                                            <input type="radio" value="0" @if ($check_out)  @if (isset($check_out['payment']) &&
                                                $check_out['payment'] !=null)
                                            @if ($check_out['payment']['credit'] == 0)
                                                checked @endif
                                            @endif
                                            @endif
                                            name="payment_method" title="Thanh toán khi nhận hàng"
                                            class="radio">
                                            <label for="p_method_checkmo">Thanh toán khi nhận hàng</label>
                                        </dt>
                                        <dd>
                                            <fieldset class="form-list">
                                            </fieldset>
                                        </dd>
                                        <dt>
                                            <input type="radio" value="1" @if ($check_out)  @if (isset($check_out['payment']) &&
                                                $check_out['payment'] !=null)
                                            @if ($check_out['payment']['credit'] == 1)
                                                checked @endif
                                            @endif
                                            @endif
                                            name="payment_method" title="Thẻ tín dụng"
                                            class="radio">
                                            <label for="p_method_ccsave">Thẻ tín dụng</label>
                                        </dt>
                                        <dd>
                                            <fieldset class="form-list">
                                                <ul id="payment_form_ccsave" style="display: none;">
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="ccsave_cc_owner">Tên trên thẻ <span
                                                                    class="required">*</span></label>
                                                            <br>
                                                            <input type="text" title="Name on Card"
                                                                class="input-text required-entry" name="name" value="">
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="ccsave_cc_type">Loại thẻ <span
                                                                    class="required">*</span></label>
                                                            <br>
                                                            <select name="type"
                                                                class="required-entry validate-cc-type-select">
                                                                <option value="">Lựa chọn loại thẻ</option>
                                                                <option value="1">American Express</option>
                                                                <option value="2">Visa</option>
                                                                <option value="3">MasterCard</option>
                                                                <option value="4">Discover</option>
                                                            </select>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="ccsave_cc_number">Mã thẻ tín dụng <span
                                                                    class="required">*</span></label>
                                                            <br>
                                                            <input type="number" name="card_number"
                                                                title="Credit Card Number"
                                                                class="input-text validate-cc-number validate-cc-type"
                                                                value="">
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="ccsave_expiration">Ngày hết hạn<span
                                                                    class="required">*</span></label>
                                                            <br>
                                                            <div class="v-fix">
                                                                <select id="ccsave_expiration" style="width: 140px;"
                                                                    name="expire_month" class="required-entry">
                                                                    <option value="" selected="selected">Tháng</option>
                                                                    <option value="1">01 - Tháng 1</option>
                                                                    <option value="2">02 - Tháng 2</option>
                                                                    <option value="3">03 - Tháng 3</option>
                                                                    <option value="4">04 - Tháng 4</option>
                                                                    <option value="5">05 - Tháng 5</option>
                                                                    <option value="6">06 - Tháng 6</option>
                                                                    <option value="7">07 - Tháng 7</option>
                                                                    <option value="8">08 - Tháng 8</option>
                                                                    <option value="9">09 - Tháng 9</option>
                                                                    <option value="10">10 - Tháng 10</option>
                                                                    <option value="11">11 - Tháng 11</option>
                                                                    <option value="12">12 - Tháng 12</option>
                                                                </select>
                                                            </div>
                                                            <div class="v-fix">
                                                                <select id="ccsave_expiration_yr" style="width: 103px;"
                                                                    name="expire_year" class="required-entry">
                                                                    <option value="" selected="selected">Year</option>
                                                                    <option value="2011">2020</option>
                                                                    <option value="2012">2021</option>
                                                                    <option value="2013">2022</option>
                                                                    <option value="2014">2023</option>
                                                                    <option value="2015">2024</option>
                                                                    <option value="2016">2025</option>
                                                                    <option value="2017">2026</option>
                                                                    <option value="2018">2027</option>
                                                                    <option value="2019">2028</option>
                                                                    <option value="2020">2029</option>
                                                                    <option value="2021">2030</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="input-box">
                                                            <label for="ccsave_cc_cid">Mã xác nhận <span
                                                                    class="required">*</span></label>
                                                            <br>
                                                            <div class="v-fix">
                                                                <input type="number" title="Card Verification Number"
                                                                    class="input-text required-entry validate-cc-cvn"
                                                                    name="verification_number">
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </fieldset>
                                        </dd>
                                    </dl>
                                    <p class="require"><em class="required">* </em>Bắt buộc</p>
                                    <div class="buttons-set1" id="payment-buttons-container">
                                        <button type="submit" class="button" id="btn_payment_checkout"><span>Xác
                                                nhận</span></button>
                                    </div>
                                </form>
                                <div style="clear: both;"></div>
                            </div>
                        </li>
                    </ol>
                </section>
                <aside class="col-right sidebar col-sm-3 wow">
                    <div class="block block-progress">
                        <div class="block-title ">Thủ tục của bạn</div>
                        <div class="block-content">
                            <dl>
                                <dt class="complete">
                                    Giỏ hàng <span class="separator">|</span>
                                </dt>
                                <dd class="complete" id="cart_check_out_result">
                                    @if ($shopping_carts != null)
                                        @foreach ($shopping_carts as $product_id => $info)
                                            {{ $info['product_name'] . ' x ' . $info['product_quantity'] }} <br>
                                        @endforeach
                                        Total: {{ $total_cart }}<br>
                                    @endif
                                </dd>
                                <dt class="complete">
                                    Địa chỉ giao hàng <span class="separator">|</span>
                                </dt>
                                <dd class="complete" id="shipping_check_out_result">
                                    @if ($check_out)
                                        @if (isset($check_out['shipping_address']) && $check_out['shipping_address'] != null)
                                            <address>
                                                {{ $check_out['shipping_address']['name'] }}<br>
                                                {{ $check_out['shipping_address']['address'] }}<br>
                                                {{ $check_out['shipping_address']['ward'] }},
                                                {{ $check_out['shipping_address']['district'] }},
                                                {{ $check_out['shipping_address']['province'] }}<br>
                                                T: {{ $check_out['shipping_address']['number'] }} <br>
                                            </address>
                                        @endif
                                    @endif
                                </dd>
                                <dt> Phương thức thanh toán <span class="separator">|</span> </dt>
                                <dd class="complete" id="payment_check_out_result">
                                    @if ($check_out)
                                        @if (isset($check_out['payment']) && $check_out['payment'] != null)
                                            @if ($check_out['payment']['credit'] == 0)
                                                Thanh toán khi nhận hàng
                                            @else
                                                Thanh toán bằng thẻ<br>
                                                Chủ sở hữu: {{ $check_out['payment']['name'] }} <br>
                                                @switch($check_out['payment']['type'])
                                                    @case(1)
                                                    Loại: American Express <br>
                                                    @break
                                                    @case(2)
                                                    Loại: Visa <br>
                                                    @break
                                                    @case(3)
                                                    Loại: MasterCard<br>
                                                    @break
                                                    @case(4)
                                                    Loại: Discover<br>
                                                    @break
                                                @endswitch
                                                Số thẻ: {{ $check_out['payment']['card_number'] }} <br>
                                                Hạn cuối: {{ $check_out['payment']['expire_month'] }} /
                                                {{ $check_out['payment']['expire_year'] }}<br>
                                            @endif
                                        @endif
                                    @endif
                                </dd>
                            </dl>
                            <ul class="checkout">
                                <li>
                                    <button onclick="" id="btn_final_check" class="button btn-proceed-checkout"
                                        title="Proceed to Checkout" type="button"><span>Đặt hàng</span></button>
                                </li>
                                <li>
                                    @if (session('error'))
                                        <p class="alert alert-danger">
                                            {{ session('error') }}
                                        </p>
                                    @endif
                                </li>
                                <br>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
    <!--End main-container -->
@endsection
