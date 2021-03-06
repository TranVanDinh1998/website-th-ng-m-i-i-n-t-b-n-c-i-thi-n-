<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Coupon;
use App\Category;
use App\Collection;
use App\CollectionProduct;
use App\ProductImage;
use App\Tag;
use App\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompareController extends Controller
{
    public function index()
    {
        // cart
        $shopping_carts = session()->get('cart');
        $discount_cart = session()->get('discount');
        // session()->forget('compare');
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

        // compare
        $compare = session()->get('compare');
        // foreach($compare as $product_id => $info) {
        //     echo $product_id. '<br>';
        // }
        return view('pages.compare', [
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,

            // compare
            'compare' => $compare,
        ]);
    }
    public function add(Request $request)
    {
        $product = Product::find($request->id);
        // add product to shopping cart
        $compare = session()->get('compare');

        // if compare is empty then this is the first product of the compare
        if (!$compare) {
            $compare = [
                $request->id => [
                    'product_name' => $product->name,
                    'product_image' => $product->image,
                    'product_description' => $product->description,
                    'product_quantity' => $product->quantity,
                    'product_description' => $product->description,
                    'product_remaining' => $product->remaining,
                    'product_rating' => $product->rating,
                    'product_price' => $product->price,
                    'product_discount' => $product->discount,
                ]
            ];
            session()->put('compare', $compare);
            return response()->json([
                'error' => false,
                'message' => 'The product ' . $product->name . ' was added to the comparation.'
            ]);
        }

        //if product not exist in compare then add product into compare
        $compare[$request->id] = [
            'product_name' => $product->name,
            'product_image' => $product->image,
            'product_quantity' => $product->quantity,
            'product_description' => $product->description,
            'product_remaining' => $product->remaining,
            'product_rating' => $product->rating,
            'product_price' => $product->price,
            'product_discount' => $product->discount,
        ];
        session()->put('compare', $compare);
        return response()->json([
            'error' => false,
            'message' => 'The product ' . $product->name . ' was added to the comparation.'
        ]);
    }
    public function remove(Request $request)
    {
        $compare = session()->get('compare');
        $product = Product::find($request->id);
        if (isset($compare[$request->id])) {
            unset($compare[$request->id]);
            session()->put('compare', $compare);
            return response()->json([
                'error' => false,
                'message' => 'Product ' . $product->name . ' has been removed from your comparation.',
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Product id is invalid!',
            ]);
        }
    }
    public function delete()
    {
        if (session()->forget('compare'))
            return response()->json([
                'error' => false,
                'message' => 'Error occoured!',
            ]);
        else {
            return response()->json([
                'error' => true,
                'message' => 'The entire comparition has been removed.',
            ]);
        }
    }
}
