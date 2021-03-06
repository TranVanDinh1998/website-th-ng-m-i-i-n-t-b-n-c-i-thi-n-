<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RemoveImage;
use App\Http\Helpers\UploadImage;
use App\Http\Requests\GeneralRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Collection;
use App\Models\CollectionProduct;
use App\Models\Producer;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tag;
use App\Models\TagProduct;

class ProductController extends Controller
{
    // contructor
    public function __construct(Product $product, Category $category, Producer $producer, Tag $tag, Collection $collection, TagProduct $tag_product, CollectionProduct $collection_product)
    {
        $this->product = $product;
        $this->category = $category;
        $this->producer = $producer;
        $this->tag = $tag;
        $this->collection = $collection;
        $this->tag_product = $tag_product;
        $this->collection_product = $collection_product;
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // parameter
        $sort_id = $request->sort_id;
        $search = $request->search;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $price_from = $request->price_from;
        $price_to = $request->price_to;
        $remaining = $request->remaining;
        $category_id = $request->category_id;
        $producer_id = $request->producer_id;
        $status = $request->status;
        $search = $request->search;
        // view
        $view = $request->has('view') ? $request->view : 10;
        // data
        $products = $this->product->sortId($request)->search($request)
            ->date($request)->price($request)->remaining($request)
            ->category($request)->producer($request)->status($request);
        $products_count = $products->count();
        $products = $products->paginate($view);
        //
        $categories = $this->category->all();
        $producers = $this->producer->all();
        $tags = $this->tag->all();
        $collections = $this->collection->all();

        return view('pages.admin.product.index', [
            'tags' => $tags,
            'collections' => $collections,
            'products' => $products,
            'categories' => $categories,
            'producers' => $producers,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'price_from' => $price_from,
            'price_to' => $price_to,
            'remaining' => $remaining,
            'category_id' => $category_id,
            'producer_id' => $producer_id,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'products_count' => $products_count,
        ]);
    }

    /**
     * Verify an item.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify($id, $verified)
    {
        //
        $verify = $this->product->find($id)->update([
            'verified' => $verified,
        ]);
        if ($verified == 0)
            return back()->with('success', 'Sản phẩm #' . $id . ' đã được tắt .');
        else
            return back()->with('success', 'Sản phẩm #' . $id . ' đã được bật.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = $this->category->all();
        $producers = $this->producer->all();
        return view('pages.admin.product.create', [
            'categories' => $categories,
            'producers' => $producers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        if ($request->hasFile('image')) {
            $avatar = $this->product->uploadImage($request->image, $uploadImage);
        }
        $result = $this->product->create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $avatar,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'remaining' => $request->quantity,
            'category_id' => $request->category_id,
            'producer_id' => $request->producer_id,
            'discount' => $request->discount,
        ]);
        return $result ? back()->with('success', 'Sản phẩm mới được khởi tạo thành công.') : back()->withError('Lỗi xảy ra trong quá trình khởi tạo sản phẩm mới.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function import(Request $request)
    {   
        $successes = array();
        $errors = array();
        foreach ($request->import as $import) {
            $product = null;
            $product = $this->product->find($import['product_id']);
            $result = $product->update([
                'quantity' => $product->quantity + $import['quantity'],
                'remaining' => $product->remaining + $import['quantity'],
            ]);
            if ($result)
                $successes[] = 'Sản phẩm #' . $import['product_id'] . ' nhập thêm ' . $import['quantity'] . ' đơn vị';
            else
                $errors[] = 'Lỗi xảy ra khi nhập thêm ' . $import['quantity'] . ' đơn vị đối với sản phẩm #' . $import['quantity'];
        }
        return back()->withSuccesses($successes)->withErrors($errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = $this->product->find($id);
        $categories = $this->category->all();
        $producers = $this->producer->all();
        return view('pages.admin.product.edit', [
            'product' => $product,
            'categories' => $categories,
            'producers' => $producers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        $product = $this->product->find($id);
        if ($request->hasFile('image')) {
            $avatar = $this->product->uploadImage($request->image, $uploadImage);
        } else {
            $avatar = $product->image;
        }
        $result = $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $avatar,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'remaining' => $request->remaining,
            'category_id' => $request->category_id,
            'producer_id' => $request->producer_id,
            'discount' => $request->discount,
        ]);
        return $result ? back()->withSuccess('Sản phẩm #' . $product->id . ' đã được cập nhật.') : back()->withError('Lỗi xảy ra khi cập nhật sản phẩm #' . $id);
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $product = $this->product->find($id)->delete();
        return back()->with('success', 'Sản phẩm #' . $id . ' đã được loại bỏ.');
    }

    /**
     * Display a listing of the softdeleted resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recycle(Request $request)
    {

        // parameter
        $sort_id = $request->sort_id;
        $search = $request->search;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $price_from = $request->price_from;
        $price_to = $request->price_to;
        $remaining = $request->remaining;
        $category_id = $request->category_id;
        $producer_id = $request->producer_id;
        $status = $request->status;
        // search
        $search = $request->search;
        // view
        $view = $request->has('view') ? $request->view : 10;
        // data
        $products = $this->product->onlyTrashed()->sortId($request)->search($request)
            ->date($request)->price($request)->remaining($request)
            ->category($request)->producer($request)->status($request);
        $products_count = $products->count();
        $products = $products->paginate($view);
        $categories = $this->category->all();
        $producers = $this->producer->all();
        return view('pages.admin.product.recycle', [
            'products' => $products,
            'categories' => $categories,
            'producers' => $producers,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'price_from' => $price_from,
            'price_to' => $price_to,
            'remaining' => $remaining,
            'category_id' => $category_id,
            'producer_id' => $producer_id,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'products_count' => $products_count,
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $product = $this->product->onlyTrashed()->find($id)->restore();
        return back()->with('success', 'Sản phẩm #' . $id . ' đã được khôi phục.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, RemoveImage $removeImage)
    {
        //
        $product = $this->product->onlyTrashed()->find($id);
        $this->product->removeImage($product->image, $removeImage);
        $product->forceDelete();
        return back()->with('success', 'Sản phẩm #' . $id . ' đã được xóa vĩnh viễn.');
    }

    public function bulk_action(Request $request, RemoveImage $removeImage)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('product_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Sản phẩm ';
                        foreach ($request->product_id_list as $product_id) {
                            $product = $this->product->find($product_id);
                            $verify = $product->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $product->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi tắt Sản phẩm #' . $product->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Sản phẩm ';
                        foreach ($request->product_id_list as $product_id) {
                            $product = $this->product->find($product_id);
                            $verify = $product->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $product->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi bật Sản phẩm #' . $product->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // remove
                        $message = 'Sản phẩm';
                        foreach ($request->product_id_list as $product_id) {
                            $product = null;
                            $product = $this->product->find($product_id);
                            $result = $product->delete();
                            if ($result) {
                                $message .= ' #' . $product->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ Sản phẩm #' . $product->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 3: // restore
                        $message = 'Sản phẩm';
                        foreach ($request->product_id_list as $product_id) {
                            $product = null;
                            $product = $this->product->onlyTrashed()->find($product_id);
                            $result = $product->restore();
                            if ($result) {
                                $message .= ' #' . $product->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục Sản phẩm #' . $product->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 4: // delete
                        $message = 'Sản phẩm';
                        foreach ($request->product_id_list as $product_id) {
                            $product = null;
                            $product = $this->product->onlyTrashed()->find($product_id);
                            $this->product->removeImage($product->image, $removeImage);
                            $result = $product->forceDelete();
                            if ($result) {
                                $message .= ' #' . $product->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn Sản phẩm #' . $product->id . '.';
                            }
                        }
                        $message .= 'đã được xóa vĩnh viễn.';
                        break;
                    case 5: // import
                        $products = $this->product->whereIn('id', $request->product_id_list)->get();
                        return view('pages.admin.product.import', [
                            'products' => $products,
                            'count' => count($products),
                        ]);
                        break;
                        break;
                    case 6: // add tag to product
                        if ($request->tag_id_list == null) {
                            return back()->with('error', 'Hãy lựa chọn ít nhất 1 thẻ để gắn!');
                        } else {
                            foreach ($request->product_id_list as $product_id) {
                                foreach ($request->tag_id_list as $tag_id) {
                                    if ($this->tag_product->where('tag_id', $tag_id)->where('product_id', $product_id)->count() > 0) {
                                        continue;
                                    } else {
                                        $message .= 'Thẻ';
                                        $result = $this->tag_product->create([
                                            'tag_id' => $tag_id,
                                            'product_id' => $product_id,
                                        ]);
                                        if ($result) {
                                            $message .= ' #' . $tag_id . ' ';
                                        } else {
                                            $errors[] = 'Lỗi xảy ra khi gắn thẻ #' . $tag_id . ' vào sản phẩm #' . $product_id . '.';
                                        }
                                    }
                                    $message .= 'đã được gắn vào sản phẩm #' . $product_id . '. ';
                                }
                            }
                        }
                        break;
                    case 7: // add product to collection
                        if ($request->collection_id_list == null) {
                            return back()->with('error', 'Hãy lựa chọn ít nhất 1 bộ sưu tập để thêm sản phẩm!');
                        } else {
                            foreach ($request->product_id_list as $product_id) {
                                foreach ($request->collection_id_list as $collection_id) {
                                    if ($this->collection_product->where('collection_id', $collection_id)->where('product_id', $product_id)->count() > 0) {
                                        continue;
                                    } else {
                                        $message .= 'Bộ sưu tập';
                                        $result = $this->collection_product->create([
                                            'collection_id' => $collection_id,
                                            'product_id' => $product_id,
                                        ]);
                                        if ($result) {
                                            $message .= ' #' . $collection_id . ' ';
                                        } else {
                                            $errors[] = 'Lỗi xảy ra khi thêm sản phẩm #' . $product_id . ' vào bộ sưu tập ' . $collection_id . '.';
                                        }
                                    }
                                    $message .= 'đã thêm vào sản phẩm #' . $product_id . '. ';
                                }
                            }
                        }
                        break;
                }
                if ($errors != null) {
                    return back()->withSuccess($message)->withErrors($errors);
                } else {
                    return back()->withSuccess($message);
                }
            } else {
                return back()->withError('Hãy chọn ít nhất 1 Sản phẩm để thực hiện thao tác!');
            }
        } else {
            return back()->withError('Hãy chọn 1 thao tác cụ thể!');
        }
    }
}
