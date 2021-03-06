<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Producer;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailController extends Controller
{
    public function __construct(Product $product, ProductImage $productImage, Category $category, Producer $producer, Collection $collection)
    {
        $this->product = $product;
        $this->productImage = $productImage;
        $this->category = $category;
        $this->producer = $producer;
        $this->collection = $collection;
    }

    public function index($id)
    {
        // detail of the product
        $product = $this->product->find($id);
        $product->increment('view');
        // relative category
        $relative_category = $product->category;

        //relative collection
        $relative_collection = $product->collectionProducts->first()->collection;

        // images of product
        $product_images = $product->images();
        $count_images = $product_images->count();

        // products in same category
        $same_category_products = $relative_category->products;
        $same_collection_products = DB::table('products')->join('collection_products', 'products.id', '=', 'collection_products.product_id')
            ->select(DB::raw('products.id, products.name,products.image, products.price, products.quantity, products.remaining, products.rating, products.category_id, products.producer_id, products.discount, collection_products.collection_id'))
            ->where('collection_products.collection_id', $relative_collection->id)
            ->get();
        // review
        $reviews = $product->reviews;

        // save product to session view
        // add product to view
        $view = session()->get('recent_views');
        // if cart is empty then this is the first product of the cart
        if (!$view) {
            $view = [
                $product->id => [
                    'product_name' => $product->name,
                    'product_image' => $product->image,
                ]
            ];
        }
        // if view is not empty then check if this product exist before then change the chapter
        if (isset($view[$product->id])) {
            session()->put('recent_views', $view);
        }
        //if product not exist in view then add product into view
        $view[$product->id] = [
            'product_name' => $product->name,
            'product_image' => $product->image,
        ];
        session()->put('recent_views', $view);


        // cart
        $shopping_carts = session()->get('cart');
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
        return view('pages.customer.details', [
            // product
            'product' => $product,
            'relative_category' => $relative_category,
            'relative_collection' => $relative_collection,
            'product_images' => $product_images,
            'count_images' => $count_images,
            'same_category_products' => $same_category_products,
            'same_collection_products' => $same_collection_products,

            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            // review
            'reviews' => $reviews,

        ]);
    }

    public function quick_view(Request $request)
    {
        // product
        $quick_view_product = $this->product->find($request->id);
        // images of product
        $quick_view_product_images = $quick_view_product->images;
        $quick_view_count_images = $quick_view_product_images->count();
        // review
        return view('pages.quick_view', [
            // product
            'quick_view_product' => $quick_view_product,
            'quick_view_product_images' => $quick_view_product_images,
            'quick_view_count_images' => $quick_view_count_images,
            // review
            // 
            'quick_view' => true,
        ]);
    }
}
