<?php

namespace App\Http\Controllers\Pages\Info;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Category;
use App\Collection;
use App\CollectionProduct;
use App\Order;
use App\ProductImage;
use App\Address;
use App\District;
use App\Province;
use App\Ward;
use App\Review;
use App\WishList;
use App\OrderDetail;
use App\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SiteMapController extends Controller
{

    public function category(Request $request)
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

        // user
        $user = Auth::user();

        // category
        $categories = Category::notDelete()->active()->sort($request);
        $count_categories = $categories->count();
        // paginate
        if ($request->has('view')) {
            $categories = $categories->paginate($request->view);
        } else {
            $categories = $categories->paginate(15);
        }

        // sort
        $sort = null;
        $sort = $request->sort;
        $view = null;
        $view = $request->view;


        return view('pages.information.site_map.category', [
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // user
            'user' => $user,
            //
            'categories' => $categories,
            'count_categories' => $count_categories,

            // filter
            'sort' => $sort,
            'view' => $view,

        ]);
    }

    public function product(Request $request)
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

        // user
        $user = Auth::user();

        // category
        $products = Product::notDelete()->active()->sort($request);
        $count_products = $products->count();
        // paginate
        if ($request->has('view')) {
            $products = $products->paginate($request->view);
        } else {
            $products = $products->paginate(15);
        }

        // sort
        $sort = null;
        $sort = $request->sort;
        $view = null;
        $view = $request->view;


        return view('pages.information.site_map.product', [
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // user
            'user' => $user,
            //
            'products' => $products,
            'count_products' => $count_products,

            // filter
            'sort' => $sort,
            'view' => $view,

        ]);
    }


}
