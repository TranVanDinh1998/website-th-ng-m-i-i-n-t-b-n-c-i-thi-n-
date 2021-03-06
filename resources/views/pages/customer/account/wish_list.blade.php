@extends('layout')
@section('title', 'My wishlist - Electronical Store')
@section('content')
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="my-account">
                        <div class="page-title">
                            <h2>My Wishlist</h2>
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
                                    <table id="wishlist-table" class="clean-table linearize-table data-table">
                                        <thead>
                                            <tr class="first last">
                                                <th class="customer-wishlist-item-image"></th>
                                                <th class="customer-wishlist-item-info"></th>
                                                <th class="customer-wishlist-item-quantity">Quantity</th>
                                                <th class="customer-wishlist-item-price">Price</th>
                                                <th class="customer-wishlist-item-cart"></th>
                                                <th class="customer-wishlist-item-remove"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($wish_lists as $wish_list)
                                                @foreach ($wish_list_products as $product)
                                                    @if ($wish_list->product_id == $product->id)
                                                        <form method="POST" enctype="multipart/form-data"
                                                            action="{{ URL::to('/account/wish-list/edit') }}">
                                                            @csrf
                                                            <tr id="item_31" class="first odd">
                                                                <td class="wishlist-cell0 customer-wishlist-item-image"><a
                                                                        title="{{ $product->name }}"
                                                                        href="{{ URL::to('product-details/' . $product->id) }}"
                                                                        class="product-image">
                                                                        <img width="150" alt="{{ $product->name }}"
                                                                            src="{{ url('uploads/products-images/' . $product->id . '/' . $product->image) }}">
                                                                    </a></td>
                                                                <td class="wishlist-cell1 customer-wishlist-item-info">
                                                                    <h3 class="product-name"><a
                                                                            title="Softwear Women's Designer"
                                                                            href="{{ URL::to('product-details/' . $product->id) }}">{{ $product->name }}</a>
                                                                    </h3>
                                                                    <div class="description std">
                                                                        <div class="inner">{!! $product->description !!}</div>
                                                                    </div>
                                                                    <textarea title="Comment" cols="5" rows="3" name="note"
                                                                        style="height: 120px; width: 96%;">
                                                                    {{ $wish_list->note }}
                                                                    </textarea>
                                                                </td>
                                                                <td data-rwd-label="Quantity"
                                                                    class="wishlist-cell2 customer-wishlist-item-quantity">
                                                                    <div class="cart-cell">
                                                                        <div class="add-to-cart-alt">
                                                                            <input type="hidden" name="id"
                                                                                class="form-control"
                                                                                value="{{ $wish_list->id }}">
                                                                            <input type="text" name="quantity" min="1"
                                                                                class="form-control"
                                                                                value="{{ $wish_list->quantity }}">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td data-rwd-label="Price"
                                                                    class="wishlist-cell3 customer-wishlist-item-price">
                                                                    <div class="cart-cell">
                                                                        <div class="price-box">
                                                                            <span id="product-price-39"
                                                                                class="regular-price">
                                                                                <span class="price">{{ $product->price }}
                                                                                    d</span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="wishlist-cell4 customer-wishlist-item-cart">
                                                                    <div class="cart-cell">
                                                                        <button class="button btn-cart"
                                                                            onclick="add_to_cart({{ $product->id }})"
                                                                            title="Add to Cart"
                                                                            type="button"><span><span>Add to
                                                                                    Cart</span></span></button>
                                                                    </div>
                                                                    {{-- <p><button type="submit"
                                                                            class="btn btn-default">Edit</button></p> --}}
                                                                            <p><button class="button btn-edit" type="submit"><i class="icon-pencil"></i></button></p>
                                                                </td>
                                                                <td
                                                                    class="wishlist-cell5 customer-wishlist-item-remove last">
                                                                    <a class="remove-item" title="Clear Cart"
                                                                        href="{{ URL::to('/account/wish-list/remove/' . $wish_list->id) }}"><span><span></span></span></a>
                                                                </td>
                                                            </tr>
                                                        </form>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <a class="button btn-add" href="{{URL::to('account/wish-list/all-to-cart')}}"
                                            title="Add All to Cart" type="button"><span>Add All to Cart</span></a>
                                    <a class="button btn-update" href="{{URL::to('account/wish-list')}}"><span>Reload Wishlist</span></a>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        {{-- <div class="buttons-set">
                            <p class="back-link"><a href="#/customer/account/"><small>« </small>Back</a></p>
                        </div> --}}
                    </div>
                </section>
                @include('personal_side_bar');
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
