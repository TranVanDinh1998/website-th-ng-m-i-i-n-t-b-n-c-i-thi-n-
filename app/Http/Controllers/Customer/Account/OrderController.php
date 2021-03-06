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

class OrderController extends Controller
{
    public function __construct(Order $order, OrderDetail $orderDetail, User $user)
    {
        $this->middleware('auth');
        $this->order = $order;
        $this->user = $user;
        $this->orderDetail = $orderDetail;
    }

    // order
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
        // order
        $user = Auth::user();
        $all_orders = $this->order->whereUser_id($user->id);
        $orders_count = $all_orders->count();
        $view = $request->has('view') ? $request->view : 10;
        $all_orders = $all_orders->paginate($view);

        return view('pages.customer.account.order.index', [
            // user
            'user' => $user,
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // order
            'all_orders' => $all_orders,
            // view
            'orders_count' => $orders_count,
            'view' => $view,
        ]);
    }

    public function detail($id)
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
        // order
        $order = $this->order->find($id);
        $order_details = $order->orderDetails;
        $user = Auth::user();

        return view('pages.customer.account.order.details', [
            // user
            'user' => $user,
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // order
            'order' => $order,
            'order_details' => $order_details,
        ]);
    }

    public function cancel($id)
    {
        $order = $this->order->find($id);
        if ($order->status < 1) {
            if ($order->paid == 0) {
                $order = $order->update(['verified' => 0]);
                if ($order)
                    return back()->with('success', 'Đơn hàng #' . $id . ' đã được hủy.');
                else
                    return back()->with('error', 'Lỗi xảy ra khi hủy đơn hàng #' . $id);
            } else {
                return  back()->with('error', 'Đơn hàng #' . $id . ' đã được thanh toán, không thể hủy.');
            }
        } else {
            return  back()->with('error', 'Đơn hàng #' . $id . ' đang nằm trong quá trình vận chuyển, không thể hủy.');
        }
    }

    public function reOrder($id)
    {
        $order = $this->order->find($id);

        foreach ($order->orderDetails as $detail) {
            // add product to shopping cart
            if ($detail->product->remaining == 0 || $detail->product->verified == 0) {
                return back()->with('error', 'Sản phẩm ' . $detail->product->name . ' đã hết hàng!');
            } else {
                $cart = session()->get('cart');
                // if cart is empty then this is the first product of the cart
                if (!$cart) {
                    $cart = [
                        $detail->product_id => [
                            'product_name' => $detail->product->name,
                            'product_image' => $detail->product->image,
                            'product_quantity' => $detail->quantity,
                            'product_price' => $detail->product->price,
                            'product_discount' => $detail->product->discount,
                        ]
                    ];
                    session()->put('cart', $cart);
                }
                // if cart is not empty then check if this product exist before then change the chapter
                if (isset($cart[$detail->product_id])) {
                    $cart[$detail->product_id]['product_quantity'] += $detail->quantity;
                    session()->put('cart', $cart);
                }
                //if product not exist in cart then add product into cart
                $cart[$detail->product_id] = [
                    'product_name' => $detail->product->name,
                    'product_image' => $detail->product->image,
                    'product_quantity' => $detail->quantity,
                    'product_price' => $detail->product->price,
                    'product_discount' => $detail->product->discount,
                ];
                session()->put('cart', $cart);
            }
        }
        return back()->with('success', 'Tất cả sản phẩm trong đơn hàng #' . $order->id . ' đã được thêm vào giỏ hàng.');
    }
}
