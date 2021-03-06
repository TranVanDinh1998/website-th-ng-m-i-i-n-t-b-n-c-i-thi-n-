<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RemoveImage;
use App\Http\Helpers\UploadImage;
use App\Http\Requests\GeneralRequest;
use App\Http\Requests\ImageRequest;
use App\Models\Collection;
use App\Models\CollectionProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class CollectionProductController extends Controller
{
    // contructor
    public function __construct(Collection $collection, CollectionProduct $collectionProduct, Product $product)
    {
        $this->product = $product;
        $this->middleware('auth:admin');
        $this->collection = $collection;
        $this->collectionProduct = $collectionProduct;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {
        // parameter
        $sort_id = $request->sort_id;
        $status = $request->status;
        // search
        $search = $request->search;
        // view
        $view = $request->has('view') ? $request->view : 10;
        // data
        $collection = $this->collection->find($id);
        $collectionProducts = $collection->collectionProducts()->withoutTrashed();
        $collectionProducts_count = $collectionProducts->count();
        $collectionProducts = $collectionProducts->paginate($view);
        return view('pages.admin.collection.product.index', [
            'collectionProducts' => $collectionProducts,
            'collection' => $collection,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'collectionProducts_count' => $collectionProducts_count,
        ]);
    }

    /**
     * Verify an item.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify($id, $product_id, $verified)
    {
        //
        $verify = $this->collectionProduct->find($product_id)->update([
            'verified' => $verified,
        ]);
        if ($verified == 0)
            return back()->with('success', 'Sản phẩm #' . $product_id . ' đã được tắt .');
        else
            return back()->with('success', 'Sản phẩm #' . $product_id . ' đã được bật.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $collection = $this->collection->find($id);
        $products = $this->product->all();
        return view('pages.admin.collection.product.create', [
            'products' => $products,
            'collection' => $collection,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        //
        $result = $this->collectionProduct->create([
            'collection_id' => $id,
            'product_id' => $request->product_id,
        ]);
        return $result ? back()->with('success', 'Sản phẩm mới được thêm vào bộ sưu tập thành công.') : back()->with('error', 'Lỗi xảy ra trong quá trình thêm Sản phẩm vào bộ sưu tập');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $product_id)
    {
        //
        $collection = $this->collection->find($id);
        $products = $this->product->all();
        $collectionProduct = $this->collectionProduct->find($product_id);
        return view('pages.admin.collection.product.edit', [
            'collection' => $collection,
            'collectionProduct' => $collectionProduct,
            'products' => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $product_id, UploadImage $uploadImage)
    {
        //
        $collectionProduct = $this->collectionProduct->find($product_id);
        $result = $collectionProduct->update([
            'collection_id' => $id,
            'product_id' => $request->product_id,
        ]);
        return $result ? back()->with('success', 'Sản phẩm #' . $product_id . ' đã được cập nhật trong bộ sưu tập.') : back()->with('error', 'Lỗi xảy ra khi cập nhật Sản phẩm #' . $product_id);
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id, $product_id)
    {
        $collectionProduct = $this->collectionProduct->find($product_id);
        $result = $collectionProduct->delete();
        return $result ? back()->withSuccess('Sản phẩm #' . $product_id . ' đã bị loại bỏ.') : back()->withError('Xảy ra lỗi khi loại bỏ Sản phẩm #' . $product_id);
    }


    /**
     * Display a listing of the softdeleted resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recycle($id, Request $request)
    {
        // parameter
        $sort_id = $request->sort_id;
        $status = $request->status;
        // search
        $search = $request->search;
        // view
        $view = $request->has('view') ? $request->view : 10;
        // data
        $collection = $this->collection->find($id);
        $collectionProducts = $collection->collectionProducts()->onlyTrashed();
        $collectionProducts_count = $collectionProducts->count();
        $collectionProducts = $collectionProducts->paginate($view);
        return view('pages.admin.collection.product.recycle', [
            'collectionProducts' => $collectionProducts,
            'collection' => $collection,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'collectionProducts_count' => $collectionProducts_count,
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id, $product_id)
    {
        $result = $this->collectionProduct->onlyTrashed()->find($product_id)->restore();
        return $result ? back()->withSuccess('Sản phẩm #' . $product_id . ' đã được phục hồi.') : back()->withError('Lỗi xảy ra trong quá trình khôi phục Sản phẩm #' . $product_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $product_id)
    {
        //
        $collectionProduct = $this->collectionProduct->onlyTrashed()->find($product_id);
        $result = $collectionProduct->forceDelete();
        return $result ? back()->with('success', 'Sản phẩm #' . $product_id . ' đã được xóa vĩnh viễn.') : back()->withError('Lỗi xảy trong quá trình xóa vĩnh viễn Sản phẩm #' . $product_id);
    }

    public function bulk_action($id, Request $request)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('collectionProduct_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Sản phẩm ';
                        foreach ($request->collectionProduct_id_list as $collectionProduct_id) {
                            $collectionProduct = $this->collectionProduct->find($collectionProduct_id);
                            $verify = $collectionProduct->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $collectionProduct->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi tắt Sản phẩm #' . $collectionProduct->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Sản phẩm ';
                        foreach ($request->collectionProduct_id_list as $collectionProduct_id) {
                            $collectionProduct = $this->collectionProduct->find($collectionProduct_id);
                            $verify = $collectionProduct->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $collectionProduct->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi bật Sản phẩm #' . $collectionProduct->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // remove
                        $message = 'Sản phẩm';
                        foreach ($request->collectionProduct_id_list as $collectionProduct_id) {
                            $collectionProduct = null;
                            $collectionProduct = $this->collectionProduct->find($collectionProduct_id);
                            $result = $collectionProduct->delete();
                            if ($result) {
                                $message .= ' #' . $collectionProduct->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ Sản phẩm #' . $collectionProduct->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 3: // restore
                        $message = 'Sản phẩm';
                        foreach ($request->collectionProduct_id_list as $collectionProduct_id) {
                            $collectionProduct = null;
                            $collectionProduct = $this->collectionProduct->onlyTrashed()->find($collectionProduct_id);
                            $result = $collectionProduct->restore();
                            if ($result) {
                                $message .= ' #' . $collectionProduct->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục Sản phẩm #' . $collectionProduct->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 4: // delete
                        $message = 'Sản phẩm';
                        foreach ($request->collectionProduct_id_list as $collectionProduct_id) {
                            $collectionProduct = null;
                            $collectionProduct = $this->collectionProduct->onlyTrashed()->find($collectionProduct_id);
                            $result = $collectionProduct->forceDelete();
                            if ($result) {
                                $message .= ' #' . $collectionProduct->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn Sản phẩm #' . $collectionProduct->id . '.';
                            }
                        }
                        $message .= 'đã được xóa vĩnh viễn.';
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
