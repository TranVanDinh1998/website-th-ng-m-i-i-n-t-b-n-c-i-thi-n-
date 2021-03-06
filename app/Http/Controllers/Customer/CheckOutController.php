<?php

namespace App\Http\Controllers\Customer;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Ward;
use App\Models\District;
use App\Models\Province;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Producer;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PaymentRequest;
use App\Models\OrderDetail;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;



class CheckOutController extends Controller
{
    public function __construct(
        Address $address,
        Province $province,
        District $district,
        Ward $ward,
        Category $category,
        Product $product,
        Collection $collection,
        Producer $producer,
        Coupon $coupon,
        Order $order,
        OrderDetail $orderDetail,
        ShippingAddress $shippingAddress,
        User $user,
    ) {
        $this->user = $user;
        $this->address = $address;
        $this->category = $category;
        $this->coupon = $coupon;
        $this->product = $product;
        $this->collection = $collection;
        $this->producer = $producer;
        $this->province = $province;
        $this->district = $district;
        $this->ward = $ward;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->shippingAddress = $shippingAddress;
    }
    public function index()
    {

        // cart
        $shopping_carts = session()->get('cart');
        $discount_cart = session()->get('discount');
        $count_cart = null;
        if (isset($shopping_carts)) {
            foreach ($shopping_carts as $product_id => $info) {
                $count_cart += 1;
            }
        }
        $total_cart = null;
        if (isset($shopping_carts)) {
            foreach ($shopping_carts as $product_id => $info) {
                if ($info['product_discount'] != null) {
                    $total_cart +=  ($info['product_price'] - ($info['product_price'] * $info['product_discount']) / 100) * $info['product_quantity'];
                } else {
                    $total_cart += $info['product_price'] * $info['product_quantity'];
                }
            }
        }

        //address
        $wards = $this->ward->get();
        $districts = $this->district->get();
        $provinces = $this->province->get();

        // check out 
        $check_out = null;
        $check_out = session()->get('check_out');

        // user

        return view('pages.customer.check_out', [

            // shopping cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // address
            'wards' => $wards,
            'districts' => $districts,
            'provinces' => $provinces,
            'check_out' => $check_out,
        ]);
    }

    public function oldAddress(Request $request)
    {
        $check_out = session()->get('check_out');
        $address = $this->address->find($request->shipping_address_id);
        // shipping check out
        $check_out['shipping_address']['name'] = $address->name;
        $check_out['shipping_address']['number'] = $address->number;
        $check_out['shipping_address']['address'] = $address->address;
        $check_out['shipping_address']['ward_id'] = $address->ward->id;
        $check_out['shipping_address']['ward'] = $address->ward->name;
        $check_out['shipping_address']['district_id'] = $address->district->id;
        $check_out['shipping_address']['district'] = $address->district->name;
        $check_out['shipping_address']['province_id'] = $address->province->id;
        $check_out['shipping_address']['province'] = $address->province->name;
        session()->put('check_out', $check_out);
        return back()->withSuccess('Địa chỉ giao hàng đã được lưu.');
    }

    public function newAddress(AddressRequest $request)
    {
        // current user
        $user = null;
        $user = Auth::user();
        $check_out = session()->get('check_out');
        // if shipping address is exist
        $ward = $this->ward->find($request->ward_id);
        $district = $this->district->find($request->district_id);
        $province = $this->province->find($request->province_id);
        $check_out['shipping_address']['name'] = $request->name;
        $check_out['shipping_address']['number'] = $request->number;
        $check_out['shipping_address']['address'] = $request->address;
        $check_out['shipping_address']['ward_id'] = $ward->id;
        $check_out['shipping_address']['ward'] = $ward->name;
        $check_out['shipping_address']['district_id'] = $district->id;
        $check_out['shipping_address']['district'] = $district->name;
        $check_out['shipping_address']['province_id'] = $province->id;
        $check_out['shipping_address']['province'] = $province->name;
        session()->put('check_out', $check_out);
        if ($request->save_address == 1) {
            if ($user == null) {
                return back()->withError('Bạn cần phải có tài khoản mới lưu trữ được địa chỉ giao hàng vào danh sách địa chỉ');
            }
            $result = $this->address->create([
                'name' => $request->name,
                'user_id' => $user->id,
                'address' => $request->address,
                'number' => $request->number,
                'ward_id' => $request->ward_id,
                'district_id' => $request->district_id,
                'province_id' => $request->province_id,
            ]);
            if ($result)
                return back()->withSuccess('Địa chỉ giao hàng mới đã được lưu vào danh sách địa chỉ thành công.');
            else
                return back()->withError('Lỗi xảy ra khi lưu địa chỉ mới.');
        }
        return back()->withSuccess('Địa chỉ giao hàng đã được lưu lại');
    }

    public function payment(Request $request)
    {
        // select payment method
        switch ($request->payment_method) {
            case 0:
                $check_out = session()->get('check_out');
                // payment check out
                $check_out['payment']['credit'] = 0;
                session()->put('check_out', $check_out);
                return back()->with('payment_success', 'Phương thức thanh toán : thanh toán khi nhận hàng, đã được lưu trữ');
                break;
            case 1:
                return back()->with('payment_error', 'Chức năng thanh toán trực tuyến chưa được hoàn thiện.');
                break;
        }
    }

    public function final_check()
    {
        // current user
        $user = null;
        if (Auth::user()) {
            $user = Auth::user();
        } else {
            $user = $this->user->active()->guest()->firstOrCreate(['name' => 'Guest','email'=>'guest@gmail.com','password'=>'123456','guest'=>1]);;
        }
        $user = null;
        $user = Auth::user() ? Auth::user() : $this->user->whereGuest(1)->first();
        // cart
        $shopping_carts = session()->get('cart');
        $discount = session()->get('discount');
        $check_out = session()->get('check_out');
        $shipping_address = null;
        if (isset($check_out['shipping_address'])) {
            $shipping_address = $check_out['shipping_address'];
        }
        $payment = null;
        if (isset($check_out['payment'])) {
            $payment = $check_out['payment'];
        }
        $total_cart = null;
        if (isset($shopping_carts)) {
            foreach ($shopping_carts as $product_id => $info) {
                if ($info['product_discount'] != null) {
                    $total_cart +=  ($info['product_price'] - ($info['product_price'] * $info['product_discount']) / 100) * $info['product_quantity'];
                } else {
                    $total_cart += $info['product_price'] * $info['product_quantity'];
                }
            }
        }

        if ($shopping_carts == null) {
            return back()->with('error', 'Giỏ hàng của bạn rỗng!');
        } else {
            $shopping_carts = session()->get('cart');
            foreach ($shopping_carts as $product_id => $info) {
                $product = null;
                $product = Product::find($product_id);
                if ($product->remaining < $info['product_quantity']) {
                    return back()->with('error', 'Kho hàng chỉ còn ' . $product->quantity . ' chiếc thuộc về' . $product->name . ' sản phẩm!');
                }
            }
            if ($check_out == null) {
                return back()->with('error', 'Bạn chưa hoàn thành thủ tục đặt hàng');
            } else {
                if ($shipping_address == null) {
                    return back()->with('error', 'Bạn chưa chỉ định địa chỉ giao hàng');
                } else {
                    if ($payment == null) {
                        return back()->with('error', 'Bạn chưa chỉ định phương thức thanh toán');
                    } else {
                        if ($discount != null) {
                            $order = $this->order->create([
                                'user_id' => $user->id,
                                'sub_total' => $total_cart,
                                'discount' => $discount['coupon_discount'],
                                'total' => $total_cart - $discount['coupon_discount'],
                            ]);
                        } else {
                            $order = $this->order->create([
                                'user_id' => $user->id,
                                'sub_total' => $total_cart,
                                'total' => $total_cart,
                            ]);
                        }
                        if ($order) {
                            // coupon
                            if ($discount != null) {
                                $coupon = $this->coupon->find($discount['coupon_id']);
                                if ($coupon) {
                                    if ($coupon->remaing <= 0 && date('Y-m-d') > $coupon->expired_at) {
                                        return back()->with('error', 'Mã giảm giá đã hết hạn sử dụng');
                                    } else {
                                        if ($total_cart < $coupon->minimum_order_value) {
                                            return back()->with('error', 'Mã giảm giá này chỉ áp dụng đối với các đơn hàng tối thiểu ' . $coupon->minimum_order_value . ' đ');
                                        } else {
                                            $coupon->remaining -= 1;
                                            $result = $coupon->update(['remaining' => $coupon->remaining - 1]);
                                            if (!$result) {
                                                return back()->with('error', 'Xảy ra lỗi khi áp dụng mã giảm giá');
                                            }
                                        }
                                    }
                                } else {
                                    return back()->with('error', 'Mã giảm giá không hợp lệ');
                                }
                            }
                            // shipping address
                            $shipping_address = $this->shippingAddress->create([
                                'order_id' => $order->id,
                                'name' => $shipping_address['name'],
                                'number' => $shipping_address['number'],
                                'address' => $shipping_address['address'],
                                'ward' => $shipping_address['ward'],
                                'district' => $shipping_address['district'],
                                'province' => $shipping_address['province'],
                            ]);
                            // payment
                            // order detail
                            foreach ($shopping_carts as $product_id => $info) {
                                $order_detail = null;
                                $order_detail = $this->orderDetail->create([
                                    'order_id' => $order->id,
                                    'product_id' => $product_id,
                                    'product_discount' => $info['product_discount'],
                                    'price' => $info['product_price'],
                                    'quantity' => $info['product_quantity'],
                                ]);
                                $product = null;
                                $product = $this->product->find($product_id);
                                $product = $product->update(['remaining' => $product->remaining - $info['product_quantity']]);
                                if (!$order_detail) {
                                    return back()->with('error', 'Lỗi xảy ra khi hoàn tất quá trình đặt hàng');
                                }
                            }
                            session()->forget('cart');
                            session()->forget('discount');
                            session()->forget('check_out');
                            return redirect()->route('delivery', ['id' => $order->id]);
                        } else {
                            return back()->with('error', 'Lỗi xảy ra khi tạo đơn hàng!');
                        }
                    }
                }
            }
        }
    }
}
