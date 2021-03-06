<footer class="footer">
    <div class="brand-logo ">
        <div class="container">
            <div class="slider-items-products">
                <div id="brand-logo-slider" class="product-flexslider hidden-buttons">
                    <div class="slider-items slider-width-col6">
                        @foreach ($producers as $producer)
                            <!-- Item -->
                            <div class="item">
                                <a
                                    href="{{ route('info.advanced_search.result', ['producer_id_list' => [$producer->id]]) }}"><img
                                        style="width: 40%;height:auto;"
                                        src="{{ asset('/storage/images/producers/' . $producer->image) }}" alt="Image"></a>
                            </div>
                            <!-- End Item -->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-middle container">
        <div class="col-md-3 col-sm-4">
            <div class="footer-logo"><a href="{{ URL::to('/') }}" title="Logo"><img
                        src="{{ url('images/footer-logo.png') }}" alt="logo"></a></div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus diam arcu. </p>
            <div class="payment-accept">
                <div><img src="{{ url('images/payment-1.png') }}" alt="payment"> <img
                        src="{{ url('images/payment-2.png') }}" alt="payment"> <img
                        src="{{ url('images/payment-3.png') }}" alt="payment"> <img
                        src="{{ url('images/payment-4.png') }}" alt="payment"></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <h4>Style Advisor</h4>
            <ul class="links">
                <li class="first"><a title="Your Account" href="{{ route('account.dashboard') }}">Your Account</a></li>
                <li><a title="Information" href="{{ route('account.info.index') }}">Information</a></li>
                <li><a title="Addresses" href="{{ route('account.address.index') }}">Addresses</a></li>
                <li><a title="Addresses" href="{{ route('coupon') }}">Discount</a></li>
                <li><a title="Orders History" href="{{ route('account.order.index') }}">Orders History</a></li>
            </ul>
        </div>
        <div class="col-md-3 col-sm-4">
            <h4>Information</h4>
            <ul class="links">
                <li class="first"><a href="{{ route('info.site_map.category') }}" title="Site Map">Site Map</a></li>
                <li><a href="{{ route('info.search_terms') }}" title="Search Terms">Search Terms</a></li>
                <li><a href="{{ route('info.advanced_search.index') }}" title="Advanced Search">Advanced Search</a>
                </li>
                <li><a href="{{ route('info.contact_us') }}" title="Contact Us">Contact Us</a></li>
                <li><a href="{{ route('info.about_us') }}" title="About Us">About Us</a></li>
            </ul>
        </div>
        <div class="col-md-3 col-sm-4">
            <h4>Contact us</h4>
            <div class="contacts-info">
                <address>
                    <i class="add-icon">&nbsp;</i>72 Tran Dai Nghia street, Hai Ba Trung District <br>
                    &nbsp;Ha Noi, VietNam
                </address>
                <div class="phone-footer"><i class="phone-icon">&nbsp;</i> +1 800 000 000</div>
                <div class="email-footer"><i class="email-icon">&nbsp;</i> <a href="#">stevenuniverse03@gmail.com</a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom container">
    </div>
</footer>
