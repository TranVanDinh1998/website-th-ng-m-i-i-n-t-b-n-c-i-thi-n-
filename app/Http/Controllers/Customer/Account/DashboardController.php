<?php

namespace App\Http\Controllers\Customer\Account;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Collection;
use App\Models\CollectionProduct;
use App\Models\Order;
use App\Models\ProductImage;
use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use App\Models\Producer;
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

class DashboardController extends Controller
{
    public function __construct(Address $address, Province $province, District $district, Ward $ward, Product $product, Order $order)
    {
        $this->product = $product;
        $this->order = $order;
        $this->address = $address;
        $this->province = $province;
        $this->district = $district;
        $this->ward = $ward;
        $this->middleware('auth');

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
        // recent order
        $user = Auth::user();
        $recent_orders = $user->orders;

        return view('pages.customer.account.dashboard', [
            // user
            'user' => $user,

            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // order
            'recent_orders' => $recent_orders,
        ]);
    }
}
