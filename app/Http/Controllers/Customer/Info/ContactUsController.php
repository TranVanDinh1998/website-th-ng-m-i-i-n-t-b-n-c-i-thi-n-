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
use App\Contact;
use App\Producer;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{

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
        $user = null;
        $user = Auth::user();

        return view('pages.information.contact_us', [
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // user
            'user' => $user,
        ]);
    }

    public function doContact(Request $request)
    {
        // $parameter = $request->all();
        // print_r($parameter);
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'number' => 'required',
                'comment' => 'required',

            ],
            [
                'required' => ':attribute must be filled',
                'email' => ':attribute email format is incorrect',
            ]
        );
        if ($validate->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validate->errors(),
            ]);
        } else {
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->number = $request->number;
            $contact->comment = $request->comment;
            $contact->create_date = date('Y-m-d');
            $result = $contact->save();
            if ($result) {
                return response()->json([
                    'error' => false,
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => new MessageBag(['errorContact' => 'Error occurred!'])
                ]);
            }
        }
    }
}
