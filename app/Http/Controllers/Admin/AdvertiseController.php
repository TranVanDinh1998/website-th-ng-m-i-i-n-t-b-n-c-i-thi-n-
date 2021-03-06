<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RemoveImage;
use App\Http\Helpers\UploadImage;
use App\Http\Requests\GeneralRequest;
use App\Http\Requests\AdvertiseRequest;
use App\Models\Advertise;
use App\Models\Product;
use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    // contructor
    public function __construct(Advertise $advertise, Product $product)
    {
        $this->advertise = $advertise;
        $this->middleware('auth:admin');
        $this->product = $product;
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
        $status = $request->status;
        // search
        $search = $request->search;
        // view
        $view = $request->has('view') ? $request->view : 10;
        // data
        $advertises = $this->advertise->withoutTrashed();
        $advertises_count = $advertises->count();
        $advertises = $advertises->paginate($view);
        return view('pages.admin.advertise.index', [
            'advertises' => $advertises,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'advertises_count' => $advertises_count,
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
        $verify = $this->advertise->find($id)->update([
            'verified' => $verified,
        ]);
        if ($verified == 0)
            return back()->with('success', 'Quảng cáo #' . $id . ' đã được tắt .');
        else
            return back()->with('success', 'Quảng cáo #' . $id . ' đã được bật.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $products = $this->product->all();
        return view('pages.admin.advertise.create', [
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertiseRequest $request, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        if ($request->hasFile('image')) {
            $avatar = $this->advertise->uploadImage($request->image, $uploadImage);
        }
        $result = $this->advertise->create([
            'name' => $request->name,
            'summary' => $request->summary,
            'description' => $request->description,
            'product_id' => $request->product_id,
            'image' => $avatar,
        ]);
        return $result ? back()->with('success', 'Quảng cáo mới được khởi tạo thành công.') : back()->with('error', 'Lỗi xảy ra trong quá trình khởi tạo Quảng cáo mới.');
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
    public function edit($id)
    {
        //
        $products = $this->product->all();
        $advertise = $this->advertise->find($id);
        return view('pages.admin.advertise.edit', [
            'advertise' => $advertise,
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
    public function update(AdvertiseRequest $request, $id, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        $advertise = $this->advertise->find($id);
        if ($request->hasFile('image')) {
            $avatar = $this->advertise->uploadImage($request->image, $uploadImage);
        } else {
            $avatar = $advertise->image;
        }
        $result = $advertise->update([
            'name' => $request->name,
            'summary' => $request->summary,
            'description' => $request->description,
            'product_id' => $request->product_id,
            'image' => $avatar,
        ]);
        return $result ? back()->with('success', 'Quảng cáo #' . $advertise->id . ' đã được cập nhật.') : back()->with('error', 'Lỗi xảy ra khi cập nhật Quảng cáo #' . $id);
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $advertise = $this->advertise->find($id);
        $result = $advertise->delete();
        return $result ? back()->withSuccess('Quảng cáo #' . $id . ' đã bị loại bỏ.') : back()->withError('Xảy ra lỗi khi loại bỏ Quảng cáo #' . $id);
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
        $status = $request->status;
        // search
        $search = $request->search;
        // view
        $view = $request->has('view') ? $request->view : 10;
        // data
        $advertises = $this->advertise->onlyTrashed();
        $advertises_count = $advertises->count();
        $advertises = $advertises->paginate($view);
        return view('pages.admin.advertise.recycle', [
            'advertises' => $advertises,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'advertises_count' => $advertises_count,
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
        $result = $this->advertise->onlyTrashed()->find($id)->restore();
        return $result ? back()->withSuccess('Quảng cáo #' . $id . ' đã được phục hồi.') : back()->withError('Lỗi xảy ra trong quá trình khôi phục Quảng cáo #' . $id);
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
        $advertise = $this->advertise->onlyTrashed()->find($id);
        $this->advertise->removeImage($advertise->image, $removeImage);
        $result = $advertise->forceDelete();
        return $result ? back()->with('success', 'Quảng cáo #' . $id . ' đã được xóa vĩnh viễn.') : back()->withError('Lỗi xảy trong quá trình xóa vĩnh viễn Quảng cáo #' . $id);
    }

    public function bulk_action(Request $request, RemoveImage $removeImage)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('advertise_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Quảng cáo ';
                        foreach ($request->advertise_id_list as $advertise_id) {
                            $advertise = $this->advertise->find($advertise_id);
                            $verify = $advertise->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $advertise->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi tắt Quảng cáo #' . $advertise->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Quảng cáo ';
                        foreach ($request->advertise_id_list as $advertise_id) {
                            $advertise = $this->advertise->find($advertise_id);
                            $verify = $advertise->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $advertise->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi bật Quảng cáo #' . $advertise->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // remove
                        $message = 'Quảng cáo';
                        foreach ($request->advertise_id_list as $advertise_id) {
                            $advertise = null;
                            $advertise = $this->advertise->find($advertise_id);
                            $result = $advertise->delete();
                            if ($result) {
                                $message .= ' #' . $advertise->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ Quảng cáo #' . $advertise->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 3: // restore
                        $message = 'Quảng cáo';
                        foreach ($request->advertise_id_list as $advertise_id) {
                            $advertise = null;
                            $advertise = $this->advertise->onlyTrashed()->find($advertise_id);
                            $result = $advertise->restore();
                            if ($result) {
                                $message .= ' #' . $advertise->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục Quảng cáo #' . $advertise->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 4: // delete
                        $message = 'Quảng cáo';
                        foreach ($request->advertise_id_list as $advertise_id) {
                            $advertise = null;
                            $advertise = $this->advertise->onlyTrashed()->find($advertise_id);
                            $this->advertise->removeImage($advertise->image, $removeImage);
                            $result = $advertise->forceDelete();
                            if ($result) {
                                $message .= ' #' . $advertise->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn Quảng cáo #' . $advertise->id . '.';
                            }
                        }
                        $message .= 'đã được xóa vĩnh viễn.';
                        break;
                }
                if ($errors != null) {
                    return back()->withSuccess($message)->withErrors($errors);
                }
                else {
                    return back()->withSuccess($message);
                }
            } else {
                return back()->withError('Hãy chọn ít nhất 1 Quảng cáo để thực hiện thao tác!');
            }
        } else {
            return back()->withError('Hãy chọn 1 thao tác cụ thể!');
        }
    }
}
