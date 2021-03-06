@extends('layout')
@section('title', 'Review')
@section('content')
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="my-account">
                        <div class="page-title">
                            <h2>My Reviews</h2>
                        </div>
                        <div class="my-wishlist">
                            <div class="table-responsive">
                                <fieldset>
                                    <table id="wishlist-table" class="clean-table linearize-table data-table">
                                        <thead>
                                            <tr class="first last">
                                                <th class="customer-wishlist-item-image">Product</th>
                                                <th class="customer-wishlist-item-info">Name</th>
                                                <th class="customer-wishlist-item-info">Comment</th>
                                                <th class="customer-wishlist-item-info">Price</th>
                                                <th class="customer-wishlist-item-info">Value</th>
                                                <th class="customer-wishlist-item-info">Quality</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reviews as $review)
                                                @foreach ($review_products as $product)
                                                    @if ($review->product_id == $product->id)
                                                        <tr id="item_31" class="first odd">
                                                            <td class="wishlist-cell0 customer-wishlist-item-image"><a
                                                                    title="{{ $product->name }}"
                                                                    href="{{ URL::to('product-details/' . $product->id) }}"
                                                                    class="product-image">
                                                                    <img width="150" alt="{{ $product->name }}"
                                                                        src="{{ url('uploads/products-images/' . $product->id . '/' . $product->image) }}">
                                                                </a>
                                                            </td>
                                                            <td class="wishlist-cell1 customer-wishlist-item-info">
                                                                <h3 class="product-name"><a title="{{ $product->name }}"
                                                                        href="{{ URL::to('product-details/' . $product->id) }}">{{ $product->name }}</a>
                                                                </h3>
                                                            </td>
                                                            <td class="wishlist-cell1 customer-wishlist-item-info">
                                                                {{ $review->description }}
                                                            </td>
                                                            <td class="wishlist-cell1 customer-wishlist-item-info">
                                                                <div class="rating-box">
                                                                    <div style="width: {{ $review->price_rate * 20 }}%"
                                                                        class="rating"></div>
                                                                </div>
                                                            </td>
                                                            <td class="wishlist-cell1 customer-wishlist-item-info">
                                                                <div class="rating-box">
                                                                    <div style="width: {{ $review->value_rate * 20 }}%"
                                                                        class="rating"></div>
                                                                </div>
                                                            </td>
                                                            <td class="wishlist-cell1 customer-wishlist-item-info">
                                                                <div class="rating-box">
                                                                    <div style="width: {{ $review->quality_rate * 20 }}%"
                                                                        class="rating"></div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="col-sm-7 text-right text-center-xs">
                                        <ul class="pagination pagination-sm m-t-none m-b-none">
                                            {!! $reviews->links() !!}
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </section>
                @include('personal_side_bar');
            </div>
        </div>
    </div>
@endsection
