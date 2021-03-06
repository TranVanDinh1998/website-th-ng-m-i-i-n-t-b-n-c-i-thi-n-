<?php

namespace App\Http\Controllers\Customer\Account;

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

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    // wish list

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

        // wishlist
        $wish_lists = WishList::where('user_id', Auth::user()->id)->get();
        $wish_list_array = array();
        foreach ($wish_lists as $wish) {
            $wish_list_array[] = $wish->product_id;
        }
        // print_r($wish_list_array);
        $wish_list_products = Product::where('is_deleted', 0)->whereIn('id', $wish_list_array)->get();
        // print_r(count($wish_list_product));

        return view('pages.account.wish_list', [
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,

            // wish list
            'wish_lists' => $wish_lists,
            'wish_list_products' => $wish_list_products,

        ]);
    }

    public function add_to_wish_list(Request $request)
    {
        $user = Auth::user();
        $product = Product::find($request->id);
        $wish_lists = WishList::where('user_id', '=', $user->id)->where('product_id', $request->id)->get();
        if (count($wish_lists) > 0) {
            return response()->json([
                'error' => true,
                'message' => 'Product ' . $product->name . ' has already been within your wish list',
            ]);
        } else {
            $wish_list = new WishList();
            $wish_list->user_id =  $user->id;
            $wish_list->product_id = $product->id;
            $wish_list->quantity = 1;
            $result = $wish_list->save();
            if ($result) {
                return response()->json([
                    'error' => false,
                    'message' => 'Product ' . $product->name . ' has been added to your wish list',
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Error occoured!',
                ]);
            }
        }
    }

    public function edit_wish_list(Request $request)
    {
        if ($request->id == null) {
            return back()->with('error', 'ID is invalid!');
        }
        $wish_list = WishList::find($request->id);
        $wish_list->note = $request->note;
        $wish_list->quantity = $request->quantity;

        $result = $wish_list->save();
        if ($result) {
            return back()->with('success', 'Item ' . $wish_list->id . ' was edited.');
        } else {
            return back()->with('error', 'Error occurred!');
        }
    }

    public function remove_wish_list($id)
    {
        $wish_list = WishList::find($id);
        if ($wish_list->forceDelete()) {
            return back()->with('success', 'Item ' . $wish_list->id . ' was deleted from wish list.');
        } else {
            return back()->with('error', 'Error occurred!');
        }
    }

    public function wish_list_to_cart()
    {
        // wishlist
        $wish_lists = WishList::where('user_id', Auth::user()->id)->get();

        foreach ($wish_lists as $wish_list) {
            $product = Product::find($wish_list->product_id);
            // add product to shopping cart
            if ($product->remaining == 0 || $product->is_actived == 0) {
                return back()->with('error', 'The product ' . $product->name . ' is out of stock!');
            } else {
                $cart = session()->get('cart');
                // if cart is empty then this is the first product of the cart
                if (!$cart) {
                    $cart = [
                        $wish_list->product_id => [
                            'product_name' => $product->name,
                            'product_image' => $product->image,
                            'product_quantity' => $wish_list->quantity,
                            'product_price' => $product->price,
                            'product_discount' => $product->discount,
                        ]
                    ];
                    session()->put('cart', $cart);
                }
                // if cart is not empty then check if this product exist before then change the chapter
                if (isset($cart[$wish_list->product_id])) {
                    $cart[$wish_list->product_id]['product_quantity'] = $cart[$wish_list->product_id]['product_quantity'] + $wish_list->quantity;
                    session()->put('cart', $cart);
                }
                //if product not exist in cart then add product into cart
                $cart[$wish_list->product_id] = [
                    'product_name' => $product->name,
                    'product_image' => $product->image,
                    'product_quantity' => $wish_list->quantity,
                    'product_price' => $product->price,
                    'product_discount' => $product->discount,
                ];
                session()->put('cart', $cart);
            }
            $wish_list->forceDelete();
        }
        return back()->with('success', 'All products in wish list were added to the shopping cart.');
    }

}
