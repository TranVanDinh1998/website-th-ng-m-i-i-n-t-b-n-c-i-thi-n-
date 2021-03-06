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
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SearchTermsController extends Controller
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
        $user = Auth::user();

        // tag
        $tags = Tag::notDelete()->active()->sort($request);
        $count_tags = $tags->count();
        // paginate
        if ($request->has('view')) {
            $tags = $tags->paginate($request->view);
        } else {
            $tags = $tags->paginate(15);
        }

        // sort
        $sort = null;
        $sort = $request->sort;
        $view = null;
        $view = $request->view;


        return view('pages.information.search_term', [
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // user
            'user' => $user,
            //
            'tags' => $tags,
            'count_tags' => $count_tags,

            // filter
            'sort' => $sort,
            'view' => $view,

        ]);
    }



}
