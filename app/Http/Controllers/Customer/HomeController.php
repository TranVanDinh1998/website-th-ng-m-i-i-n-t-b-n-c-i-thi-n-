<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Advertise;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Coupon;
use App\Models\Producer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function __construct(Advertise $advertise, Category $category, Producer $producer, Product $product, Coupon $coupon, Collection $collection)
    {
        $this->advertise = $advertise;
        $this->category = $category;
        $this->producer = $producer;
        $this->product = $product;
        $this->coupon = $coupon;
        $this->collection = $collection;
    }
    public function index()
    {

        // advertise
        $advertises = $this->advertise->active()->latest()->limit(10)->get();

        // all products
        $products = $this->product->active()->lastest()->get();
        // best sell products
        $best_seller_products = $this->product->active()
            ->select('id', 'name', 'price', 'description', 'image', DB::raw('quantity-remaining as leftover'))
            ->orderByDesc('leftover')
            ->limit(10)
            ->get();

        // new products
        $newest_products = $this->product->active()->lastest()->limit(10)->get();
        // feature products
        $feature_products = $this->product->active()->orderByDesc('rating')->limit(10)->get();
        // sale products
        $sale_products = $this->product->active()->whereNotNull('discount')->limit(10)->get();

        // most imfortant collections
        $three_most_priority_collections = $this->collection->active()->orderByDesc('priority')->limit(3)->get();
        // second best collections
        $three_second_priority_collections = $this->collection->active()->orderByDesc('priority')->skip(3)->limit(3)->get();

        // newest collections and products respectively 
        $two_newest_collections = $this->collection->active()->limit(2)->get();

        // discount 
        $coupons = Coupon::active()->lastest()->limit(3)->get();


        // cart
        $shopping_carts = session()->get('cart');
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
        return view('pages.customer.home', [
            // advertise
            'advertises' => $advertises,
            // product
            // all product
            'products' => $products,
            // best sell products
            'best_seller_products' => $best_seller_products,
            // newest products
            'newest_products' => $newest_products,
            // feature products
            'feature_products' => $feature_products,

            // sale products
            'sale_products' => $sale_products,

            // collection
            // newest collections
            'two_newest_collections' => $two_newest_collections,
            // 'two_newest_collections_products' => $two_newest_collection_products,
            // 
            'three_most_priority_collections' => $three_most_priority_collections,
            'three_second_priority_collections' => $three_second_priority_collections,
            // coupon
            'coupons' => $coupons,

            // shopping cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
        ]);
    }
}
