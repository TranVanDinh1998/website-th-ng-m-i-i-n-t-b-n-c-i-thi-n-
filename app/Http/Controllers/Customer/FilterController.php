<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Producer;
use App\Models\Category;
use App\Models\CollectionProduct;
use Illuminate\Http\Request;
use App\Models\Tag;

class FilterController extends Controller
{
    public function __construct(Category $category, Product $product, Collection $collection, Producer $producer, Tag $tag)
    {
        $this->category = $category;
        $this->product = $product;
        $this->collection = $collection;
        $this->producer = $producer;
        $this->tag = $tag;
    }
    public function index(Request $request, $category_id, $collection_id = null)
    {

        // tags
        $tags = $this->tag->orderByDesc('view')->limit(10)->get();
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
        // view
        $recent_views = session()->get('recent_views');

        // current category
        $category = null;
        $category = Category::find($category_id);
        $category_id = null;
        $category_id = $category->id;

        // products and collection
        // $products = null;
        $collection = null;
        if ($collection_id == null) {
            $products = $this->product->active()->whereCategory_id($category_id)->sort($request)->price($request)->producer($request);
        } else {
            $collection = $this->collection->find($collection_id);
            $collection_id = $collection->id;
            $collection_array = array();
            foreach ($collection->collectionProducts as $detail) {
                $collection_array[] = $detail->product_id;
            }
            $products = $this->product->active()->whereIn('id', $collection_array)->sort($request)->price($request)->producer($request);
        }

        //producer
        $producers_record_count = array();
        $producers = $this->producer->active()->get();

        foreach ($producers as $producer) {
            $producers_record_count[$producer->id] = 0;
        }
        $search_products = $products->get();
        $search_producers_record_count = array();
        foreach ($search_products as $product) {
            if (isset($search_producers_record_count[$product->producer_id])) {
                $search_producers_record_count[$product->producer_id] += 1;
            } else {
                $search_producers_record_count[$product->producer_id] = 1;
            }
        }
        foreach ($producers_record_count as $producer_id => $count) {
            foreach ($search_producers_record_count as $search_producer_id => $search_count) {
                if ($producer_id == $search_producer_id) {
                    $producers_record_count[$producer_id] = $search_count;
                }
            }
        }

        // paginate
        $products = $request->has('view') ? $products->paginate($request->view) : $products->paginate(12);

        // filter
        $sort = null;
        $view = null;
        $producer_id = null;
        $price_from = null;
        $price_to = null;
        $sort = $request->sort;
        $view = $request->view;
        $producer_id = $request->producer_id;
        $price_from = $request->price_from;
        $price_to = $request->price_to;

        // compare
        $compare = session()->get('compare');
        $count_compare = null;
        if (isset($compare)) {
            foreach ($compare as $product_id => $info) {
                $count_compare += 1;
            }
        }

        return view('pages.customer.filter', [

            'tags' => $tags,
            // cart
            'shopping_carts' => $shopping_carts,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart,
            'discount_cart' => $discount_cart,
            // category
            'category' => $category,
            'category_id' => $category_id,
            'collection' => $collection,
            'collection_id' => $collection_id,
            // product
            'products' => $products,
            //producer
            'producers_record_count' => $producers_record_count,
            // filter
            'sort' => $sort,
            'view' => $view,
            'producer_id' => $producer_id,
            'price_from' => $price_from,
            'price_to' => $price_to,
            // view
            'recent_views' => $recent_views,
            // page
            'page' => 'filter',

            // compare
            'compare' => $compare,
            'count_compare' => $count_compare,

        ]);
    }
}
