<?php

namespace App\Http\Controllers\Customer;

use App\Models\Address;
use App\Models\Ward;
use App\Models\District;
use App\Models\Province;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Producer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function __construct(
        Category $category,
        Product $product,
        Collection $collection,
        Producer $producer
    ) {
        $this->category = $category;
        $this->product = $product;
        $this->collection = $collection;
        $this->producer = $producer;
    }
    public function index($id)
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
        $order = Order::find($id);
        return view('pages.customer.delivery', [

            // shopping car
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // your order
            'order' => $order,
        ]);
    }
}
