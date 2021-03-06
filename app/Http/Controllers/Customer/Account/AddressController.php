<?php

namespace App\Http\Controllers\Customer\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Producer;
use App\Models\Category;
use App\Models\Collection;
use App\Models\CollectionProduct;
use App\Models\Order;
use App\Models\ProductImage;
use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use App\Models\Review;
use App\Models\WishList;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function __construct(User $user,Address $address, Province $province, District $district, Ward $ward, Product $product, Order $order)
    {
        $this->product = $product;
        $this->order = $order;
        $this->address = $address;
        $this->province = $province;
        $this->district = $district;
        $this->ward = $ward;
        $this->middleware('auth');
        $this->user = $user;
    }
    // address
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
        // recent order
        $user = Auth::user();

        return view('pages.customer.account.address.index', [
            // user
            'user' => $user,
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // order
        ]);
    }

    public function create()
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
        // recent order
        $user = Auth::user();

        $wards = $this->ward->get();
        $districts = $this->district->get();
        $provinces = $this->province->get();
        return view('pages.customer.account.address.create', [
            // user
            'user' => $user,

            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // address
            'provinces' => $provinces,
            'districts' => $districts,
            'wards' => $wards,
        ]);
    }

    public function store(AddressRequest $request)
    {
        $result = $this->address->create([
            'name' => $request->name,
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'number' => $request->number,
            'ward_id' => $request->ward_id,
            'district_id' => $request->district_id,
            'province_id' => $request->province_id,
        ]);
        if ($request->shipping == 1) {
            $user = $this->user->find(Auth::user()->id);
            $result2 = $user->update(['shipping_address_id' => $result->id]);
            return $result2 ? back()->with('success','The address has been added and be set as primary shipping address')
            : back()->withError('Lỗi xảy ra trong quá trình khởi tạo địa chỉ mới.');
        }
        return $result ? back()->with('success', 'Địa chỉ mới được khởi tạo thành công.')
            : back()->withError('Lỗi xảy ra trong quá trình khởi tạo địa chỉ mới.');
    }

    public function edit($id)
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
        // recent order
        $user = Auth::user();

        // current address
        $address = Address::find($id);
        $wards = $this->ward->get();
        $districts = $this->district->get();
        $provinces = $this->province->get();
        // current address
        return view('pages.customer.account.address.edit', [
            // user
            'user' => $user,

            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,

            // current address
            'address' => $address,
            'provinces' => $provinces,
            'districts' => $districts,
            'wards' => $wards,
        ]);
    }
    public function update(AddressRequest $request,$id)
    {
        $address = $this->address->find($id);
        $result = $address->update([
            'name' => $request->name,
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'number' => $request->number,
            'ward_id' => $request->ward_id,
            'district_id' => $request->district_id,
            'province_id' => $request->province_id,
        ]);
        if ($request->shipping == 1) {
            $user = $this->user->find(Auth::user()->id);
            $result2 = $user->update(['shipping_address_id' => $id]);
            return $result2 ? back()->with('success','Địa chỉ mới được khởi tạo thành công và được thiết lập là địa chỉ giao hàng mặc định')
            : back()->withError('Lỗi xảy ra trong quá trình khởi tạo địa chỉ mới.');
        }
        return $result ? back()->with('success', 'Địa chỉ #' . $id . ' được cập nhật thành công.')
            : back()->withError('Lỗi xảy ra trong quá trình cập nhật địa chỉ #' . $id);
    }


    public function set_primary_shipping_address($id)
    {
        $user = $this->user->find(Auth::user()->id);
        $result = $user->update(['shipping_address_id' => $id]);
        if ($result)
            return back()->with('success', 'Địa chỉ #' . $id . ' đã được thiết lập như địa chỉ giao hàng mặc định.');
        else
            return back()->with('error', 'Lỗi xảy ra');
    }

    public function destroy($id)
    {
        $address = $this->address->find($id);
        $user = $this->user->find(Auth::user()->id);
        if ($user->shipping_address_id == $id) {
            $user = $user->update(['shipping_address_id'=>null]);
        }
        if ($address->forceDelete()) {
            return back()->with('success', 'Địa chỉ #' . $address->id . ' đã được xóa.');
        } else {
            return back()->with('error', 'Lỗi xảy ra');
        }
    }
}
