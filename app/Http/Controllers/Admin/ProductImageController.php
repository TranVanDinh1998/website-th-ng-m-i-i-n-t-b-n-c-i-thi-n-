<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RemoveImage;
use App\Http\Helpers\UploadImage;
use App\Http\Requests\GeneralRequest;
use App\Http\Requests\ImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    // contructor
    public function __construct(Product $product, ProductImage $productImage)
    {
        $this->product = $product;
        $this->middleware('auth:admin');
        $this->productImage = $productImage;
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
        $product = $this->product->find($id);
        $productImages = $product->images()->withoutTrashed();
        $productImages_count = $productImages->count();
        $productImages = $productImages->paginate($view);
        return view('pages.admin.gallery.index', [
            'productImages' => $productImages,
            'product' => $product,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'productImages_count' => $productImages_count,
        ]);
    }

    /**
     * Verify an item.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify($id,$image_id, $verified)
    {
        //
        $verify = $this->productImage->find($image_id)->update([
            'verified' => $verified,
        ]);
        if ($verified == 0)
            return back()->with('success', 'Hình ảnh #' . $image_id . ' đã được tắt .');
        else
            return back()->with('success', 'Hình ảnh #' . $image_id . ' đã được bật.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $product = $this->product->find($id);
        return view('pages.admin.gallery.create', [
            'product' => $product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id,ImageRequest $request, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        if ($request->hasFile('image')) {
            $avatar = $this->productImage->uploadImage($request->image, $uploadImage);
        }
        $result = $this->productImage->create([
            'product_id' => $id,
            'image' => $avatar,
        ]);
        return $result ? back()->with('success', 'Hình ảnh mới được khởi tạo thành công.') : back()->with('error', 'Lỗi xảy ra trong quá trình khởi tạo Hình ảnh mới.');
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
    public function edit($id,$image_id)
    {
        //
        $product = $this->product->find($id);
        $productImage = $this->productImage->find($image_id);
        return view('pages.admin.gallery.edit', [
            'productImage' => $productImage,
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImageRequest $request, $id,$image_id, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        $productImage = $this->productImage->find($image_id);
        if ($request->hasFile('image')) {
            $avatar = $this->productImage->uploadImage($request->image, $uploadImage);
        } else {
            $avatar = $productImage->image;
        }
        $result = $productImage->update([
            'image' => $avatar,
        ]);
        return $result ? back()->with('success', 'Hình ảnh #' . $image_id . ' đã được cập nhật.') : back()->with('error', 'Lỗi xảy ra khi cập nhật Hình ảnh #' . $image_id);
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id,$image_id)
    {
        $productImage = $this->productImage->find($image_id);
        $result = $productImage->delete();
        return $result ? back()->withSuccess('Hình ảnh #' . $image_id . ' đã bị loại bỏ.') : back()->withError('Xảy ra lỗi khi loại bỏ Hình ảnh #' . $image_id);
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
        $product = $this->product->find($id);
        $productImages = $product->images()->onlyTrashed();
        $productImages_count = $productImages->count();
        $productImages = $productImages->paginate($view);
        return view('pages.admin.gallery.recycle', [
            'productImages' => $productImages,
            'product' => $product,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'productImages_count' => $productImages_count,
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id,$image_id)
    {
        $result = $this->productImage->onlyTrashed()->find($image_id)->restore();
        return $result ? back()->withSuccess('Hình ảnh #' . $image_id . ' đã được phục hồi.') : back()->withError('Lỗi xảy ra trong quá trình khôi phục Hình ảnh #' . $image_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$image_id, RemoveImage $removeImage)
    {
        //
        $productImage = $this->productImage->onlyTrashed()->find($image_id);
        $this->productImage->removeImage($productImage->image, $removeImage);
        $result = $productImage->forceDelete();
        return $result ? back()->with('success', 'Hình ảnh #' . $image_id . ' đã được xóa vĩnh viễn.') : back()->withError('Lỗi xảy trong quá trình xóa vĩnh viễn Hình ảnh #' . $image_id);
    }

    public function bulk_action($id,Request $request, RemoveImage $removeImage)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('productImage_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Hình ảnh ';
                        foreach ($request->productImage_id_list as $productImage_id) {
                            $productImage = $this->productImage->find($productImage_id);
                            $verify = $productImage->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $productImage->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi tắt Hình ảnh #' . $productImage->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Hình ảnh ';
                        foreach ($request->productImage_id_list as $productImage_id) {
                            $productImage = $this->productImage->find($productImage_id);
                            $verify = $productImage->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $productImage->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi bật Hình ảnh #' . $productImage->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // remove
                        $message = 'Hình ảnh';
                        foreach ($request->productImage_id_list as $productImage_id) {
                            $productImage = null;
                            $productImage = $this->productImage->find($productImage_id);
                            $result = $productImage->delete();
                            if ($result) {
                                $message .= ' #' . $productImage->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ Hình ảnh #' . $productImage->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 3: // restore
                        $message = 'Hình ảnh';
                        foreach ($request->productImage_id_list as $productImage_id) {
                            $productImage = null;
                            $productImage = $this->productImage->onlyTrashed()->find($productImage_id);
                            $result = $productImage->restore();
                            if ($result) {
                                $message .= ' #' . $productImage->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục Hình ảnh #' . $productImage->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 4: // delete
                        $message = 'Hình ảnh';
                        foreach ($request->productImage_id_list as $productImage_id) {
                            $productImage = null;
                            $productImage = $this->productImage->onlyTrashed()->find($productImage_id);
                            $this->productImage->removeImage($productImage->image, $removeImage);
                            $result = $productImage->forceDelete();
                            if ($result) {
                                $message .= ' #' . $productImage->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn Hình ảnh #' . $productImage->id . '.';
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
                return back()->withError('Hãy chọn ít nhất 1 Hình ảnh để thực hiện thao tác!');
            }
        } else {
            return back()->withError('Hãy chọn 1 thao tác cụ thể!');
        }
    }
}
