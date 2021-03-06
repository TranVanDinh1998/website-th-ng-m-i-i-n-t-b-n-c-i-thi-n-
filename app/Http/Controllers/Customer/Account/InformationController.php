<?php

namespace App\Http\Controllers\Customer\Account;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UploadImage;
use App\Http\Requests\InforRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Producer;
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

class InformationController extends Controller
{
    public function __construct(User $user,Category $category, Product $product, Collection $collection, Producer $producer)
    {
        $this->product = $product;
        $this->middleware('auth');
        $this->user = $user;
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

        // user
        $user = Auth::user();

        return view('pages.customer.account.information', [

            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // user
            'user' => $user,
        ]);
    }

    public function update(InforRequest $request, $id, UploadImage $uploadImage)
    {
        $avatar = null;
        $user = $this->user->find($id);
        if ($request->hasFile('image')) {
            $avatar = $this->user->uploadImage($request->image, $uploadImage);
        } else {
            $avatar = $user->image;
        }
        $result = $user->update([
            'name' => $request->name,
            'image' => $avatar,
        ]);
        return $result ? back()->withSuccess('Tài khoản #' . $user->id . ' đã được cập nhật.') : back()->withError('Lỗi xảy ra khi cập nhật Tài khoản #' . $id);
    }
}
