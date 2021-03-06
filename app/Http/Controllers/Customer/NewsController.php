<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Producer;
use App\Models\Category;
use App\Models\Tag;

class NewsController extends Controller
{
    public function __construct(Category $category, Product $product, Collection $collection, Producer $producer, Tag $tag, Coupon $coupon)
    {
        $this->coupon = $coupon;
        $this->category = $category;
        $this->product = $product;
        $this->collection = $collection;
        $this->producer = $producer;
        $this->tag = $tag;
    }
    public function index()
    {

        // tags
        $tags = $this->tag->orderByDesc('view')->limit(10)->get();
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
        // coupon
        $coupons = $this->coupon->active()->paginate(12);
        // most popular coupon
        $most_view_coupons = $this->coupon->active()->latest()->limit(4)->get();
        return view('pages.customer.news', [

            'tags' => $tags,
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            // coupon
            'coupons' => $coupons,
            // most view coupon
            'most_view_coupons' => $most_view_coupons
        ]);
    }
}
