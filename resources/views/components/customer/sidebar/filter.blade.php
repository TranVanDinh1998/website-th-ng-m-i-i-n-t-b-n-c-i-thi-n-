{{-- side bar for filter page --}}
<aside class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9 wow">
    <div class="side-nav-categories">
        <div class="block-title"> Categories </div>
        <!--block-title-->
        <!-- BEGIN BOX-CATEGORY -->
        <div class="box-content box-category">
            <ul>
                @foreach ($categories as $category)
                    <li> <a href="{{ URL::to('filter/' . $category->id) }}">{{ $category->name }}</a>
                        <span 
                        @if ($current_category_id == $category->id)
                            class="subDropdown minus"
                        @else
                            class="subDropdown plus"
                        @endif
                ></span>
                <ul class="level1" @if ($current_category_id == $category->id)
                    style="display:block"
                @else
                    style="display:none"
                    @endif
                    >
                    @foreach ($collections as $collection)
                        @if ($collection->category_id == $category->id)
                            <li> <a href="{{ URL::to('filter/' . $category->id . '/' . $collection->id) }}">
                                    {{ $collection->name }} </a> </li>
                        @endif
                    @endforeach
                </ul>
                </li>
                @endforeach
            </ul>
        </div>
        <!--box-content box-category-->
    </div>
    <div class="block block-layered-nav">
        <div class="block-title"><span>Shop By</span></div>
        <div class="block-content">
            <p class="block-subtitle">Shopping Options</p>
            <dl id="narrow-by-list">
                <dt class="odd">Price</dt>
                <dd class="odd">
                    <ol>
                        <li> <a
                                href="{{ route($current_page, ['category_id' => $current_category_id, 'collection_id' => $current_collection_id, 'producer_id' => $producer_id, 'sort' => $sort, 'view' => $view, 'price_to' => 500000]) }}"><span
                                    class="price">0</span> - <span class="price">500000 <small>d</small></span></a>
                            {{-- (6) --}}
                        </li>
                        <li> <a
                                href="{{ route($current_page, ['category_id' => $current_category_id, 'collection_id' => $current_collection_id, 'producer_id' => $producer_id, 'sort' => $sort, 'view' => $view, 'price_from' => 500000, 'price_to' => 1000000]) }}"><span
                                    class="price">500000</span> - <span class="price">1000000
                                    <small>d</small></span></a>
                            {{-- (6) --}}
                        </li>
                        <li> <a
                                href="{{ route($current_page, ['category_id' => $current_category_id, 'collection_id' => $current_collection_id, 'producer_id' => $producer_id, 'sort' => $sort, 'view' => $view, 'price_from' => 1000000, 'price_to' => 2000000]) }}"><span
                                    class="price">1000000</span> - <span class="price">2000000
                                    <small>d</small></span></a>
                            {{-- (6) --}}
                        </li>
                        <li> <a
                                href="{{ route($current_page, ['category_id' => $current_category_id, 'collection_id' => $current_collection_id, 'producer_id' => $producer_id, 'sort' => $sort, 'view' => $view, 'price_from' => 2000000, 'price_to' => 5000000]) }}"><span
                                    class="price">2000000</span> - <span class="price">5000000
                                    <small>d</small></span></a>
                            {{-- (6) --}}
                        </li>
                        <li> <a
                                href="{{ route($current_page, ['category_id' => $current_category_id, 'collection_id' => $current_collection_id, 'producer_id' => $producer_id, 'sort' => $sort, 'view' => $view, 'price_from' => 5000000]) }}"><span
                                    class="price">5000000 <small>d</small></span> and above</a>
                            {{-- (6) --}}
                        </li>
                    </ol>


                </dd>
                <dt class="even">Manufacturer</dt>
                <dd class="even">
                    <ol>
                        @foreach ($producers as $producer)
                            <li> <a
                                    href="{{ route($current_page, ['category_id' => $current_category_id, 'collection_id' => $current_collection_id, 'producer_id' => $producer->id, 'sort' => $sort, 'view' => $view, 'price_from' => $price_from, 'price_to' => $price_to]) }}">{{ $producer->name }}</a>
                                @foreach ($producers_record_count as $producer_id => $count)
                                    @if ($producer_id == $producer->id)
                                        ({{ $count }})
                                    @endif
                                @endforeach
                            </li>
                        @endforeach
                    </ol>
                </dd>
                {{-- <dt class="odd">Color</dt>
                <dd class="odd">
                    <ol>
                        <li> <a href="#">Green</a> (1) </li>
                        <li> <a href="#">White</a> (5) </li>
                        <li> <a href="#">Black</a> (5) </li>
                        <li> <a href="#">Gray</a> (4) </li>
                        <li> <a href="#">Dark Gray</a> (3) </li>
                        <li> <a href="#">Blue</a> (1) </li>
                    </ol>
                </dd>
                <dt class="last even">Size</dt>
                <dd class="last even">
                    <ol>
                        <li> <a href="#">S</a> (6) </li>
                        <li> <a href="#">M</a> (6) </li>
                        <li> <a href="#">L</a> (4) </li>
                        <li> <a href="#">XL</a> (4) </li>
                    </ol>
                </dd> --}}
            </dl>
        </div>
    </div>
    <div class="block block-cart">
        <div class="block-title"><span>My Cart</span></div>
        <div class="block-content">
            <div class="summary">
                <p class="amount">
                    <a href="{{ URL::to('cart') }}">
                        There are
                        @if ($count_cart != 0 && $count_cart != null)
                            {{ $count_cart }}
                        @else
                            0
                        @endif
                        items in your cart.
                    </a>
                </p>
                <p class="subtotal"> <span class="label">Cart Subtotal:</span> <span class="price">
                        @if ($total_cart != 0) {{ $total_cart }}
                        d @else 0 @endif
                    </span> </p>
            </div>
            <div class="ajax-checkout">
                {{-- <button type="submit" title="Submit"
                    class="button button-checkout"><span>Checkout</span></button> --}}
                <a title="Checkout" href="{{ URL::to('/check-out') }}"><span class="hidden-xs">Checkout</span></a>
            </div>
            @if (isset($shopping_carts))
                <p class="block-subtitle">Recently added item(s) </p>
                <ul>
                    @foreach ($shopping_carts as $product_id => $info)
                        <li class="item"> <a class="product-image" title="Fisher-Price Bubble Mower" href="#"><img
                                    width="80" alt="Fisher-Price Bubble Mower"
                                    src="{{ url('uploads/products-images/' . $product_id . '/' . $info['product_image']) }}"></a>
                            <div class="product-details">
                                <div class="access"> <a class="btn-remove1" title="Remove This Item"
                                        onclick="remove_item_from_cart({{ $product_id }})"> <span class="icon"></span>
                                        Remove </a> </div>
                                <p class="product-name"> <a
                                        href="{{ URL::to('product-details/' . $product_id) }}">{{ $info['product_name'] }}</a>
                                </p>
                                <strong>{{ $info['product_quantity'] }}</strong> x <span
                                    class="price">{{ $info['product_price'] - ($info['product_price'] * $info['product_discount']) / 100 }}
                                    d</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    {{-- <div class="block block-subscribe">
        <div class="block-title"><span>Newsletter</span></div>
        <form action="#" method="post" id="newsletter-validate-detail">
            <div class="block-content">
                <div class="form-subscribe-header"> Sign up for our newsletter:</div>
                <input type="text" name="email" id="newsletter" title=""
                    class="input-text required-entry validate-email" placeholder="Enter your email address">
                <div class="actions">
                    <button type="submit" title="Submit" class="subscribe"><span>Subscribe</span></button>
                </div>
            </div>
        </form>
    </div> --}}
    {{-- <div class="block block-compare">
        <div class="block-title "><span>Compare Products (2)</span></div>
        <div class="block-content">
            <ol id="compare-items">
                <li class="item odd">
                    <input type="hidden" class="compare-item-id" value="2173">
                    <a href="#" title="Remove This Item" class="btn-remove1"></a> <a class="product-name" href="#"> Sofa
                        with Box-Edge Polyester Wrapped Cushions</a>
                </li>
                <li class="item last even">
                    <input type="hidden" class="compare-item-id" value="2174">
                    <a href="#" title="Remove This Item" class="btn-remove1"></a> <a class="product-name" href="#"> Sofa
                        with Box-Edge Down-Blend Wrapped Cushions</a>
                </li>
            </ol>
            <div class="ajax-checkout">
                <button class="button button-compare" title="Submit" type="submit"><span>Compare</span></button>
                <button class="button button-clear" title="Submit" type="submit"><span>Clear</span></button>
            </div>
        </div>
    </div> --}}
    <div class="block block-list block-viewed">
        <div class="block-title"><span>Recently Viewed</span> </div>
        <div class="block-content">
            <ol id="recently-viewed-items">
                @if (isset($recent_views))
                    {{-- {{ $recent_views }} --}}
                    @foreach ($recent_views as $product_id => $info)
                        <li class="item odd">
                            <p class="product-name"><a
                                    href="{{ URL::to('product-details/' . $product_id) }}">{{ $info['product_name'] }}</a>
                            </p>
                        </li>
                    @endforeach
                @else
                    <li class="item odd active">
                        <p class="product-name"><a href="#">None</a></p>
                    </li>
                @endif
            </ol>
        </div>
    </div>
    <div class="block block-compare">
        <div class="block-title "><span>Compare Products ({{$count_compare }})</span></div>
        <div class="block-content">
            <ol id="compare-items">
                @if (isset($compare))
                    @foreach ($compare as $product_id => $info)
                        <li class="item odd">
                            <input type="hidden" value="2173" class="compare-item-id">
                            <a class="btn-remove1" title="Remove This Item"
                                onclick="return remove_item_from_compare({{ $product_id }})"></a> <a
                                href="{{ URL::to('product-details/' . $product_id) }}"
                                class="product-name">{{ $info['product_name'] }}</a>
                        </li>
                    @endforeach
                @else
                    <li class="item odd active">
                        <p class="product-name"><a href="#">None</a></p>
                    </li>
                @endif
            </ol>
            <div class="ajax-checkout">
                <a href="{{ route('compare.index') }}" type="submit" title="Submit" onclick=""
                    class="button button-compare"><span>Compare</span></a>
                <button type="submit" onclick="return remove_compare();" title="Submit"
                    class="button button-clear"><span>Clear</span></button>
            </div>
        </div>
    </div>
    {{-- <div class="block block-poll">
        <div class="block-title"><span>Community Poll</span> </div>
        <form onSubmit="return validatePollAnswerIsSelected();" method="post" action="#" id="pollForm">
            <div class="block-content">
                <p class="block-subtitle">What is your favorite Magento feature?</p>
                <ul id="poll-answers">
                    <li class="odd">
                        <input type="radio" value="5" id="vote_5" class="radio poll_vote" name="vote">
                        <span class="label">
                            <label for="vote_5">Layered Navigation</label>
                        </span>
                    </li>
                    <li class="even">
                        <input type="radio" value="6" id="vote_6" class="radio poll_vote" name="vote">
                        <span class="label">
                            <label for="vote_6">Price Rules</label>
                        </span>
                    </li>
                    <li class="odd">
                        <input type="radio" value="7" id="vote_7" class="radio poll_vote" name="vote">
                        <span class="label">
                            <label for="vote_7">Category Management</label>
                        </span>
                    </li>
                    <li class="last even">
                        <input type="radio" value="8" id="vote_8" class="radio poll_vote" name="vote">
                        <span class="label">
                            <label for="vote_8">Compare Products</label>
                        </span>
                    </li>
                </ul>
                <div class="actions">
                    <button class="button button-vote" title="Vote" type="submit"><span>Vote</span></button>
                </div>
            </div>
        </form>
    </div> --}}
    <div class="block block-tags">
        <div class="block-title"><span>Popular Tags</span></div>
        <div class="block-content">
            <ul class="tags-list">
                @if ($tags != null)
                    @foreach ($tags as $tag)
                        <li><a href="{{ route('tag', ['tag_id' => $tag->id]) }}" class="btn btn-continue button">{{ $tag->name }}</a></li>
                    @endforeach
                @endif
            </ul>
            {{-- <div class="actions"> <a class="view-all" href="#">View All
                    Tags</a> </div> --}}
        </div>
    </div>
    {{-- <div class="block block-banner"><a href="#"><img src="{{ url('images/block-banner.png') }}" alt="block-banner"></a>
    </div> --}}
</aside>
{{-- end of side bar for filter --}}
