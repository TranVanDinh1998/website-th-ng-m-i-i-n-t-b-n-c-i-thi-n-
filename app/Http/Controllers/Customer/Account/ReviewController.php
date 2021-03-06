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

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // review
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
        // user
        $user = Auth::user();
        // review
        $reviews = Review::where('user_id', $user->id)->orderByDesc('create_date')->paginate(10);
        $reviews_array = array();
        foreach ($reviews as $review) {
            $reviews_array[] = $review->product_id;
        }
        $review_products = Product::where('is_deleted', 0)->whereIn('id', $reviews_array)->get();

        return view('pages.account.reviews', [
            // user
            'user' => $user,
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // review
            'reviews' => $reviews,
            'review_products' => $review_products,

        ]);
    }

    public function doReview(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'description' => 'required',
                'summary' => 'required',
                'product_id' => 'required',
                'price_rate' => 'required|min:1|max:5',
                'value_rate' => 'required|min:1|max:5',
                'quality_rate' => 'required|min:1|max:5',

            ],
            [
                'required' => ':attribute must be filled',
                'min' => ':attribute must has at least :min value',
                'max' => ':attribute must has at most :max value',
            ]
        );
        if ($validate->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validate->errors(),
            ]);
        } else {
            //
            $orders = Order::where('is_actived', 1)->where('user_id', Auth::user()->id)->get();
            $orders_array = array();
            foreach ($orders as $order) {
                $orders_array[] = $order->id;
            }
            $order_details = OrderDetail::whereIn('order_id', $orders_array)->where('product_id', $request->product_id)->get();
            if (count($order_details) > 0) {
                $review = new Review();
                $review->description = $request->description;
                $review->summary = $request->summary;
                $review->price_rate = $request->price_rate;
                $review->value_rate = $request->value_rate;
                $review->quality_rate = $request->quality_rate;
                $review->product_id = $request->product_id;
                $review->user_id = Auth::user()->id;
                $result = $review->save();
                if ($result) {
                    $product_reviews = Review::where('is_deleted', 0)->where('product_id', $request->product_id)->get();
                    $sum = 0;
                    foreach ($product_reviews as $review) {
                        $sum += $review->price_rate + $review->value_rate + $review->quality_rate;
                    }
                    $rating = $sum / (3 * 5);
                    $product = Product::find($request->product_id);
                    $product->rating = $rating;
                    $result2 = $product->save();
                    if ($result2) {
                        return response()->json([
                            'error' => false,
                            'message' => 'Your Review has been uploaded.'
                        ]);
                    } else {
                        $error = new MessageBag(['errorProduct' => 'Error occurred!']);
                        return response()->json([
                            'error' => true,
                            'message' => $error,
                        ]);
                    }
                } else {
                    $error = new MessageBag(['errorReview' => 'Error occurred!']);
                    return response()->json([
                        'error' => true,
                        'message' => $error,
                    ]);
                }
            } else {
                $error = new MessageBag(['errorQualify' => 'You need to purchase this product in order to review!']);
                return response()->json([
                    'error' => true,
                    'message' => $error,
                ]);
            }
        }
    }

}
