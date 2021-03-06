<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Models\Category;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Producer;


class LoginController extends Controller
{
    public function __construct(Category $category, Product $product, Collection $collection, Producer $producer)
    {
        $this->category = $category;
        $this->product = $product;
        $this->collection = $collection;
        $this->producer = $producer;
    }
    public function index()
    {
        //all categories
        $categories = $this->category->active()->get();
        // all collections
        $collections = $this->collection->active()->get();
        //all producers
        $producers = $this->producer->active()->get();
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
        return view('pages.customer.login', [
            // necessary
            'categories' => $categories,
            'producers' => $producers,
            'collections' => $collections,
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
        ]);
    }

    public function showAdminLogin() {
        return view('pages.admin.auth.login', [
        ]);
    }
    public function adminLogin(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $login = Auth::guard('admin')->attempt(['email' => $email, 'password' => $password, 'verified' => 1]);
        if ($login) {
            return redirect(route('admin.index'));
        } else {
            return back()->withError('Tài khoản hoặc mật khẩu không chính xác');
        }
    }
    public function customerLogin(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $login = Auth::guard('web')->attempt(['email' => $email, 'password' => $password, 'verified' => 1]);
        if ($login) {
            return back()->withSuccess('Đăng nhập thành công');
        } else {
            return back()->withError('Tài khoản hoặc mật khẩu không chính xác');
        }
    }

}
