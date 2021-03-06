@extends('layouts.customer.index')
@section('title', 'Danh sách địa chỉ')
@section('content')
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="my-account">
                        <div class="page-title">
                            <h2>Danh sách địa chỉ của bạn</h2>
                        </div>
                        <div class="my-wishlist">
                            <div class="table-responsive">
                                <fieldset>
                                    @if (session('success'))
                                        <div id="success_msg" class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div id="error_msg" class="alert alert-danger">
                                            {!! session('error') !!}
                                        </div>
                                    @endif
                                    <a style="float:right" class="button" href="{{ route('account.address.create') }}">Tạo
                                        mới</a>
                                    <table id="wishlist-table" class="clean-table linearize-table data-table">
                                        <thead>
                                            <tr class="first last">
                                                <th class="customer-wishlist-item-info">ID</th>
                                                <th class="customer-wishlist-item-image">Tên người nhận</th>
                                                <th class="customer-wishlist-item-info">Số điện thoại</th>
                                                <th class="customer-wishlist-item-info">Địa chỉ</th>
                                                <th class="customer-wishlist-item-info">Xã, phường</th>
                                                <th class="customer-wishlist-item-info">Quận/ huyện</th>
                                                <th class="customer-wishlist-item-info">Tỉnh/ thành phố</th>
                                                <th class="customer-wishlist-item-action" colspan="4"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user->addresses as $address)
                                                <tr>
                                                    <td>{{ $address->id }}
                                                    </td>
                                                    <td>{{ $address->name }}</td>
                                                    <td>{{ $address->number }}</td>
                                                    <td>{{ $address->address }}</td>
                                                    <td>
                                                        {{ $address->ward->name }}
                                                    </td>
                                                    <td>
                                                        {{ $address->district->name }}
                                                    </td>
                                                    <td>
                                                        {{ $address->province->name }}
                                                    <td>
                                                        <a @if (Auth::user()->shipping_address_id == $address->id) class="active btn btn-success"
                                                        @else
                                                                class="btn btn-default" @endif
                                                            title="Set this address as the primary shipping address"
                                                            href="{{ route('account.address.shipping_address', ['id' => $address->id]) }}">Ship</a>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-default"
                                                            href="{{ route('account.address.edit', ['id' => $address->id]) }}">
                                                            Edit
                                                        </a>
                                                    </td>
                                                    <td class="wishlist-cell5 customer-wishlist-item-remove last"><a
                                                            class="remove-item" title="Clear Address"
                                                            onclick="return confirm('Are you sure?')"
                                                            href="{{ route('account.address.destroy', ['id' => $address->id]) }}"><span><span></span></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                        </div>
                        <div class="box-account">
                            <div class="col2-set">
                                <h4>Thiết lập mặc định</h4>
                                <div class="manage_add"></div>
                                <div class="col-1">
                                    <h5>Địa chỉ giao hàng mặc định</h5>
                                    @if ($user->address)
                                    <address>
                                        {{ $user->address->name }}<br>
                                        {{ $user->address->address }} ,
                                        {{ $user->address->ward->name }} ,
                                        {{ $user->address->district->name }} ,
                                        {{ $user->address->province->name }}
                                        T: {{ $user->address->number }}<br>
                                        <a
                                            href="{{ route('account.address.edit', ['id' => $user->shipping_address_id]) }}">Chỉnh
                                            sửa địa chỉ</a>
                                    </address>   
                                    @else
                                        <p>Trống</p>
                                    @endif
                                </div>
                            </div>
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
