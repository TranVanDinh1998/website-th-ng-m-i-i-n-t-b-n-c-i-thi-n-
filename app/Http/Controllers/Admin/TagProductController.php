<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RemoveImage;
use App\Http\Helpers\UploadImage;
use App\Http\Requests\GeneralRequest;
use App\Http\Requests\ImageRequest;
use App\Models\tag;
use App\Models\TagProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class TagProductController extends Controller
{
    // contructor
    public function __construct(tag $tag, TagProduct $tagProduct, Product $product)
    {
        $this->product = $product;
        $this->tag = $tag;
        $this->middleware('auth:admin');
        $this->tagProduct = $tagProduct;
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
        $tag = $this->tag->find($id);
        $tagProducts = $tag->TagProducts()->withoutTrashed();
        $tagProducts_count = $tagProducts->count();
        $tagProducts = $tagProducts->paginate($view);
        return view('pages.admin.tag.product.index', [
            'tagProducts' => $tagProducts,
            'tag' => $tag,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'tagProducts_count' => $tagProducts_count,
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
        $verify = $this->tagProduct->find($product_id)->update([
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
        $tag = $this->tag->find($id);
        $products = $this->product->all();
        return view('pages.admin.tag.product.create', [
            'products' => $products,
            'tag' => $tag,
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
        $result = $this->tagProduct->create([
            'tag_id' => $id,
            'product_id' => $request->product_id,
        ]);
        return $result ? back()->with('success', 'Sản phẩm mới được gắn thẻ thành công.') : back()->with('error', 'Lỗi xảy ra trong quá trình thêm Sản phẩm vào thẻ');
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
        $tag = $this->tag->find($id);
        $products = $this->product->all();
        $tagProduct = $this->tagProduct->find($product_id);
        return view('pages.admin.tag.product.edit', [
            'tag' => $tag,
            'tagProduct' => $tagProduct,
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
    public function update(Request $request, $id, $product_id)
    {
        //
        $tagProduct = $this->tagProduct->find($product_id);
        $result = $tagProduct->update([
            'tag_id' => $id,
            'product_id' => $request->product_id,
        ]);
        return $result ? back()->with('success', 'Sản phẩm #' . $product_id . ' đã được cập nhật thẻ.') : back()->with('error', 'Lỗi xảy ra khi cập nhật Sản phẩm #' . $product_id);
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id, $product_id)
    {
        $tagProduct = $this->tagProduct->find($product_id);
        $result = $tagProduct->delete();
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
        $tag = $this->tag->find($id);
        $tagProducts = $tag->TagProducts()->onlyTrashed();
        $tagProducts_count = $tagProducts->count();
        $tagProducts = $tagProducts->paginate($view);
        return view('pages.admin.tag.product.recycle', [
            'tagProducts' => $tagProducts,
            'tag' => $tag,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'tagProducts_count' => $tagProducts_count,
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
        $result = $this->tagProduct->onlyTrashed()->find($product_id)->restore();
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
        $tagProduct = $this->tagProduct->onlyTrashed()->find($product_id);
        $result = $tagProduct->forceDelete();
        return $result ? back()->with('success', 'Sản phẩm #' . $product_id . ' đã được xóa vĩnh viễn.') : back()->withError('Lỗi xảy trong quá trình xóa vĩnh viễn Sản phẩm #' . $product_id);
    }

    public function bulk_action($id, Request $request)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('tagProduct_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Sản phẩm ';
                        foreach ($request->tagProduct_id_list as $tagProduct_id) {
                            $tagProduct = $this->tagProduct->find($tagProduct_id);
                            $verify = $tagProduct->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $tagProduct->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi tắt Sản phẩm #' . $tagProduct->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Sản phẩm ';
                        foreach ($request->tagProduct_id_list as $tagProduct_id) {
                            $tagProduct = $this->tagProduct->find($tagProduct_id);
                            $verify = $tagProduct->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $tagProduct->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi bật Sản phẩm #' . $tagProduct->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // remove
                        $message = 'Sản phẩm';
                        foreach ($request->tagProduct_id_list as $tagProduct_id) {
                            $tagProduct = null;
                            $tagProduct = $this->tagProduct->find($tagProduct_id);
                            $result = $tagProduct->delete();
                            if ($result) {
                                $message .= ' #' . $tagProduct->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ Sản phẩm #' . $tagProduct->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 3: // restore
                        $message = 'Sản phẩm';
                        foreach ($request->tagProduct_id_list as $tagProduct_id) {
                            $tagProduct = null;
                            $tagProduct = $this->tagProduct->onlyTrashed()->find($tagProduct_id);
                            $result = $tagProduct->restore();
                            if ($result) {
                                $message .= ' #' . $tagProduct->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục Sản phẩm #' . $tagProduct->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 4: // delete
                        $message = 'Sản phẩm';
                        foreach ($request->tagProduct_id_list as $tagProduct_id) {
                            $tagProduct = null;
                            $tagProduct = $this->tagProduct->onlyTrashed()->find($tagProduct_id);
                            $result = $tagProduct->forceDelete();
                            if ($result) {
                                $message .= ' #' . $tagProduct->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn Sản phẩm #' . $tagProduct->id . '.';
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
