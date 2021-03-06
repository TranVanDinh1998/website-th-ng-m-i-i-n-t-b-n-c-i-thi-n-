<!-- Slider -->
<div id="magik-slideshow" class="magik-slideshow">
    <div class="wow">
        <div id='rev_slider_4_wrapper' class='rev_slider_wrapper fullwidthbanner-container'>
            <div id='rev_slider_4' class='rev_slider fullwidthabanner'>
                <ul>
                    @foreach ($advertises as $advertise)
                        <li data-transition='random' data-slotamount='7' data-masterspeed='1000' data-thumb=''><img
                                src="{{ asset('/storage/images/advertises/' . $advertise->image) }}"
                                data-bgposition='left top' data-bgfit='cover' data-bgrepeat='no-repeat' alt="banner" />
                            <div class='tp-caption ExtraLargeTitle sft  tp-resizeme ' data-x='15' data-y='80'
                                data-endspeed='500' data-speed='500' data-start='1100' data-easing='Linear.easeNone'
                                data-splitin='none' data-splitout='none' data-elementdelay='0.1'
                                data-endelementdelay='0.1' style='z-index:2; white-space:nowrap;'>
                                {{ $advertise->summary }}
                            </div>
                            <div class='tp-caption LargeTitle sfl  tp-resizeme ' data-x='15' data-y='135'
                                data-endspeed='500' data-speed='500' data-start='1300' data-easing='Linear.easeNone'
                                data-splitin='none' data-splitout='none' data-elementdelay='0.1'
                                data-endelementdelay='0.1' style='z-index:3; white-space:nowrap;'>
                                {{ $advertise->name }}
                            </div>
                            <div class='tp-caption sfb  tp-resizeme ' data-x='15' data-y='360' data-endspeed='500'
                                data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none'
                                data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1'
                                style='z-index:4; white-space:nowrap;'><a
                                    href="{{ route('product_details', ['id' => $advertise->product_id]) }}"
                                    class="view-more">Tìm hiểu thêm</a>
                                <button onclick="add_to_cart({{ $advertise->product_id }});" class="buy-btn">Mua ngay</button>
                            </div>
                            <div class='tp-caption Title sft  tp-resizeme ' data-x='15' data-y='230' data-endspeed='500'
                                data-speed='500' data-start='1500' data-easing='Power2.easeInOut' data-splitin='none'
                                data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1'
                                style='z-index:4; white-space:nowrap;'>{!! $advertise->description !!}</div>
                            <div class='tp-caption Title sft  tp-resizeme ' data-x='15' data-y='400' data-endspeed='500'
                                data-speed='500' data-start='1500' data-easing='Power2.easeInOut' data-splitin='none'
                                data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1'
                                style='z-index:4; white-space:nowrap;font-size:11px'></div>
                        </li>
                    @endforeach
                </ul>
                <div class="tp-bannertimer"></div>
            </div>
        </div>
    </div>
</div>
<!-- end Slider -->
