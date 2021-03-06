@extends('layout')
@section('title', 'Compare - Electronical Store')
@section('content')
    <section class="main-container col1-layout">
        <div class="main container">
            <div class="col-main">
                <div class="cart wow">
                    <div class="page-title">
                        <h2>Compare Products</h2>
                    </div>
                    <div class="table-responsive">
                        @if ($compare != null)
                            <table class="table table-striped compare-table">
                                <tr class="product-shop-row first odd">
                                    <th>&nbsp;</th>
                                    @foreach ($compare as $product_id => $info)
                                        <td>
                                            <a onclick="return remove_item_from_compare({{ $product_id }});"
                                                class="btn btn-cancel icon-remove" title="Remove This Item"></a> <a
                                                class="product-image" href="#" title="Azrouel Dress"><img
                                                    src="{{ url('uploads/products-images/' . $product_id . '/' . $info['product_image']) }}"
                                                    alt="{{ $info['product_name'] }}" width="200"></a>
                                            <h2 class="product-name"><a
                                                    href="{{ URL::to('product-details/' . $product_id) }}"
                                                    title="{{ $info['product_name'] }}"> {{ $info['product_name'] }}</a>
                                            </h2>
                                            <div class="price-box">
                                                @if ($info['product_discount'] != null)
                                                    <p class="special-price">
                                                        <span class="price">
                                                            {{ $info['product_price'] - ($info['product_price'] * $info['product_discount']) / 100 }}
                                                            <small>vnd</small>
                                                        </span>
                                                    </p>
                                                    <p class="old-price">
                                                        <span class="price-sep">-</span>
                                                        <span class="price">{{ $info['product_price'] }} <small>vnd</small>
                                                        </span>
                                                    </p>
                                                @else
                                                    <p class="regular-price">
                                                        <span class="price"> {{ $info['product_price'] }}<small>vnd</small>
                                                        </span>
                                                    </p>
                                                @endif
                                            </div>
                                            <button type="button" onclick="add_to_cart({{ $product_id }});"
                                                title="Add to Cart" class="button btn-cart"><span>Add to Cart</span>
                                            </button>
                                            </p>
                                            @if (Auth::user())
                                                <a onclick="add_to_wish_list({{ $product_id }});" title="Add to Wishlist"
                                                    class="link-wishlist">
                                                    <span>Add to Wishlist</span>
                                                </a>
                                            @else
                                                <a onclick="alert('You need to login to add this product to the wish list!');"
                                                    title="Add to Wishlist" class="link-wishlist">
                                                    <span>Add to Wishlist</span></a>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                <tr class="even">
                                    <th>Description</th>
                                    @foreach ($compare as $product_id => $info)
                                        <td>
                                            <div>{!! $info['product_description'] !!} </div>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr class="add-to-row last odd text-center">
                                    <th>&nbsp;</th>
                                    @foreach ($compare as $product_id => $info)
                                        <td>
                                            <div class="price-box">
                                                @if ($info['product_discount'] != null)
                                                    <p class="special-price">
                                                        <span class="price">
                                                            {{ $info['product_price'] - ($info['product_price'] * $info['product_discount']) / 100 }}
                                                            <small>vnd</small>
                                                        </span>
                                                    </p>
                                                    <p class="old-price">
                                                        <span class="price-sep">-</span>
                                                        <span class="price">{{ $info['product_price'] }} <small>vnd</small>
                                                        </span>
                                                    </p>
                                                @else
                                                    <p class="regular-price">
                                                        <span class="price"> {{ $info['product_price'] }}<small>vnd</small>
                                                        </span>
                                                    </p>
                                                @endif
                                            </div>
                                            <p>
                                                <button onclick="add_to_cart({{ $product_id }});" type="button"
                                                    title="Add to Cart" class="button"><span><span>Add to
                                                            Cart</span></span></button>
                                            </p>
                                            @if (Auth::user())
                                                <a onclick="add_to_wish_list({{ $product_id }});" title="Add to Wishlist"
                                                    class="link-wishlist">
                                                    <span>Add to Wishlist</span>
                                                </a>
                                            @else
                                                <a onclick="alert('You need to login to add this product to the wish list!');"
                                                    title="Add to Wishlist" class="link-wishlist">
                                                    <span>Add to Wishlist</span></a>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        @else
                            <a href="{{ URL::to('/') }}" class="btn btn-default button btn-continue"
                                title="Continue Shopping"><span><span>Continue shopping</span></span></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
