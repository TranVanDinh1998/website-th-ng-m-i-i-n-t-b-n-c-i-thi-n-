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
use App\Tag;
use App\User;
use App\Producer;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AdvancedSearchController extends Controller
{

    public function index(Request $request)
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
        $user = null;
        $user = Auth::user();

        // searching
        $search = $request->search;
        $price_from = $request->price_from;
        $price_to = $request->price_to;
        $category_id_list = null;
        $category_id_list = $request->category_id_list;
        $producer_id_list = null;
        $producer_id_list = $request->producer_id_list;

        return view('pages.information.advanced_search.index', [
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // user
            'user' => $user,
            //
            // filter
            'search' => $search,
            'price_from' => $price_from,
            'price_to' => $price_to,
            'category_id_list' => $category_id_list,
            'producer_id_list' => $producer_id_list,
        ]);
    }

    public function result(Request $request)
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
        //collections
        $collections = Collection::notDelete()->active()->get();
        // view
        $recent_views = session()->get('recent_views');

        // products
        // $products = Product::notDelete()->active()
        // ->search($request)->sort($request)
        // ->price($request)
        // ->producer($request)
        // ->category($request);



        // if ($request->has('producer_id_list') && $request->producer_id_list != null) {
        //     $products = $products->whereIn('producer_id',$request->producer_id_list);
        // }
        // 

        $products = Product::notDelete()->active()->search($request)->sort($request)
        ->massCategory($request)
        ->massProducer($request)
        ->price($request);

        // print_r($request->all());
        $count_product = null;
        $count_product = $products->get()->count();
        // producer
        $producers = Producer::notDelete()->active()->get();
        $producers_record_count = array();
        foreach ($producers as $producer) {
            $producers_record_count[$producer->id] = 0;
        }
        $search_products = $products->get();
        $search_producers_record_count = array();
        foreach ($search_products as $product) {
            if (isset($search_producers_record_count[$product->producer_id])) {
                $search_producers_record_count[$product->producer_id] += 1;
            } else {
                $search_producers_record_count[$product->producer_id] = 1;
            }
        }
        foreach ($producers_record_count as $producer_id => $count) {
            foreach ($search_producers_record_count as $search_producer_id => $search_count) {
                if ($producer_id == $search_producer_id) {
                    $producers_record_count[$producer_id] = $search_count;
                }
            }
        }

        // paginate
        if ($request->has('view')) {
            $products = $products->paginate($request->view);
        } else {
            $products = $products->paginate(15);
        }

        // foreach ($products as $product) {
        //     echo $product->id.'-' . $product->name.'<br>';
        // }



        // filter
        $search = null;
        $sort = null;
        $view = null;
        $price_from = null;
        $price_to = null;
        $search = $request->search;
        $sort = $request->sort;
        $view = $request->view;
        $price_from = $request->price_from;
        $price_to = $request->price_to;
        $category_id_list = null;
        $category_id_list = $request->category_id_list;
        $producer_id_list = null;
        $producer_id_list = $request->producer_id_list;
        // echo 'search - '.$search.'<br>';
        // echo 'sort -'.$sort.'<br>';
        // echo 'view -'.$view.'<br>';
        // echo 'producer_id -'.$producer_id.'<br>';
        // echo 'price_from -'.$price_from.'<br>';
        // echo 'price_to -'.$price_to.'<br>';
        // echo 'category id list <br>';
        // foreach ($category_id_list as $category_id) {
        //     echo 'category_id_list -'.$category_id .'<br>';
        // }
        // foreach ($producer_id_list as $producer_id) {
        //     echo 'producer_id_list -'.$producer_id. '<br>';
        // }
        // compare
        $compare = session()->get('compare');
        $count_compare = null;
        if (isset($compare)) {
            foreach ($compare as $product_id => $info) {
                $count_compare += 1;
            }
        }
        return view('pages.information.advanced_search.result', [
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // collections
            'search_collections' => $collections,
            // product
            'products' => $products,
            'count_product' => $count_product,
            //producer
            'producers_record_count' => $producers_record_count,
            // filter
            'search' => $search,
            'sort' => $sort,
            'view' => $view,
            'price_from' => $price_from,
            'price_to' => $price_to,
            'category_id_list' => $category_id_list,
            'producer_id_list' => $producer_id_list,
            // view
            'recent_views' => $recent_views,
            // action
            'current_page' => 'search',

            // compare
            'compare' => $compare,
            'count_compare' => $count_compare,
        ]);
    }
}
