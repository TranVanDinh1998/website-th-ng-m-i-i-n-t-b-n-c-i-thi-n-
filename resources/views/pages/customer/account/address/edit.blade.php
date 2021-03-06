@extends('layouts.customer.index')
@section('title', 'Địa chỉ cá nhân')
@section('content')
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="my-account">
                        <div class="page-title">
                            <h2>Địa chỉ #{{$address->id}}</h2>
                        </div>
                        <div class="my-wishlist">
                            <fieldset>
                                <form action="{{ route('account.address.update', ['id'=>$address->id]) }}" id="edit_address_form" method="POST" enctype="multipart/form-data">
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Thông tin liên hệ</h4>
                                            <div class="form-group">
                                                <label for=""> Tên người nhận <span class="required">*</span>
                                                </label>
                                                <input name="id" value="{{$address->id}}" type="hidden">
                                                <input type="text" class="form-control" value="{{ $address->name }}"
                                                    name="name">
                                            </div>
                                            <div class="form-group">
                                                <label for="shipping:telephone">Số điện thoại <span
                                                        class="required">*</span></label>
                                                <input type="text" name="number" value="{{ $address->number }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>Địa chỉ</h4>
                                            <div class="form-group">
                                                <label for="">Tỉnh/ thành phố<span class="required">*</span></label>
                                                <select class="form-control" name="province_id">
                                                    <option value="">
                                                        Lựa chọn tỉnh/ thành phố
                                                    </option>
                                                    @foreach ($provinces as $province)
                                                        @if ($address->province_id == $province->id)
                                                            <option value="{{ $province->id }}" selected>
                                                                {{ $province->name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $province->id }}">
                                                                {{ $province->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Quận/ huyện<span class="required">*</span></label>
                                                <select class="form-control" name="district_id">
                                                    <option value="">
                                                        Lựa chọn quận/ huyện
                                                    </option>
                                                    @foreach ($districts as $district)
                                                        @if ($address->district_id == $district->id)
                                                            <option value="{{ $district->id }}" selected>
                                                                {{ $district->name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $district->id }}">
                                                                {{ $district->name }}
                                                            </option>
                                                        @endif

                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Xã/ phường<span class="required">*</span></label>
                                                <select class="form-control" name="ward_id">
                                                    <option value="">
                                                        Lựa chọn xã/ phường
                                                    </option>
                                                    @foreach ($wards as $ward)
                                                        @if ($address->ward_id == $ward->id)
                                                            <option value="{{ $ward->id }}" selected>
                                                                {{ $ward->name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $ward->id }}">
                                                                {{ $ward->name }}
                                                            </option>
                                                        @endif

                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="shipping:street1">Địa chỉ chi tiết <span
                                                        class="required">*</span></label>
                                                <input type="text" title="Street Address" value="{{$address->address}}" name="address" value=""
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="1" name="shipping">Thiết lập địa chỉ này là địa
                                            chỉ giao hàng mặc định</label>
                                    </div>
                                    <div class="form-group">
                                        <p class="require"><em class="required">* </em>Bắt buộc</p>
                                        <button id="btn_shipping_checkout" type="submit" class="button continue"><span>Save</span></button>
                                    </div>
                                </form>
                            </fieldset>
                        </div>
                    </div>
                </section>
                @include('components.customer.sidebar.account')
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#success_msg").fadeOut(10000);
            $("#error_msg").fadeOut(10000);
        });

    </script>
@endsection
