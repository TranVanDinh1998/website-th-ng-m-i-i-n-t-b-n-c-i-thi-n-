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
use App\Http\Requests\ChangePasswordRequest;
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

class PasswordController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('auth');
    }

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
        // order
        $user = Auth::user();
        return view('pages.customer.account.password', [
            // user
            'user' => $user,
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,

        ]);
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $user_password = Auth::user()->password;
        if (Hash::check($old_password, $user_password)) {
            $user_id = Auth::user()->id;
            $user = $this->user->find($user_id);
            $result = $user->update(['password' => Hash::make($new_password)]);
            if ($result)
                return back()->withSuccess('Đổi mật khẩu thành công');
            else
                return back()->withError('Có lỗi xảy ra khi đổi mật khẩu');
        } else {
            return back()->withError('Mật khẩu cũ không hợp lệ');
        }
    }
}
