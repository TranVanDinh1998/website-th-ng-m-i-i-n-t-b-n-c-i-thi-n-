<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RemoveImage;
use App\Http\Helpers\UploadImage;
use App\Http\Requests\GeneralRequest;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    // contructor
    public function __construct(Coupon $coupon)
    {
        $this->middleware('auth:admin');
        $this->coupon = $coupon;
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
        $coupons = $this->coupon->search($request)->sortId($request)->status($request);
        $coupons_count = $coupons->count();
        $coupons = $coupons->paginate($view);
        return view('pages.admin.coupon.index', [
            'coupons' => $coupons,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'coupons_count' => $coupons_count,
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
        $verify = $this->coupon->find($id)->update([
            'verified' => $verified,
        ]);
        if ($verified == 0)
            return back()->with('success', 'Mã giảm giá #' . $id . ' đã được tắt .');
        else
            return back()->with('success', 'Mã giảm giá #' . $id . ' đã được bật.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.admin.coupon.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        if ($request->hasFile('image')) {
            $avatar = $this->coupon->uploadImage($request->image, $uploadImage);
        }
        $result = $this->coupon->create([
            'name' => $request->name,
            'image' => $avatar,
            'code' => $request->code,
            'quantity' => $request->quantity,
            'remaining' => $request->quantity,
            'minimum_order_value' => $request->minimum_order_value,
            'type' => $request->type,
            'discount' => $request->discount,
            'expired_at' => $request->expired_at,
        ]);
        return $result ? back()->with('success', 'Mã giảm giá mới được khởi tạo thành công.') : back()->with('error', 'Lỗi xảy ra trong quá trình khởi tạo Mã giảm giá mới.');
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
        $coupon = $this->coupon->find($id);
        return view('pages.admin.coupon.edit', [
            'coupon' => $coupon,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, $id, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        $coupon = $this->coupon->find($id);
        if ($request->hasFile('image')) {
            $avatar = $this->coupon->uploadImage($request->image, $uploadImage);
        } else {
            $avatar = $coupon->image;
        }
        $result = $coupon->update([
            'name' => $request->name,
            'image' => $avatar,
            'code' => $request->code,
            'quantity' => $request->quantity,
            'remaining' => $request->remaining,
            'minimum_order_value' => $request->minimum_order_value,
            'type' => $request->type,
            'discount' => $request->discount,
            'expired_at' => $request->expired_at,
        ]);
        return $result ? back()->with('success', 'Mã giảm giá #' . $coupon->id . ' đã được cập nhật.') : back()->with('error', 'Lỗi xảy ra khi cập nhật Mã giảm giá #' . $id);
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $coupon = $this->coupon->find($id);
        $result = $coupon->delete();
        return $result ? back()->withSuccess('Mã giảm giá #' . $id . ' đã bị loại bỏ.') : back()->withError('Xảy ra lỗi khi loại bỏ Mã giảm giá #' . $id);
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
        $coupons = $this->coupon->onlyTrashed()->search($request)->sortId($request)->status($request);
        $coupons_count = $coupons->count();
        $coupons = $coupons->paginate($view);
        return view('pages.admin.coupon.recycle', [
            'coupons' => $coupons,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'coupons_count' => $coupons_count,
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
        $result = $this->coupon->onlyTrashed()->find($id)->restore();
        return $result ? back()->withSuccess('Mã giảm giá #' . $id . ' đã được phục hồi.') : back()->withError('Lỗi xảy ra trong quá trình khôi phục Mã giảm giá #' . $id);
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
        $coupon = $this->coupon->onlyTrashed()->find($id);
        $this->coupon->removeImage($coupon->image, $removeImage);
        $result = $coupon->forceDelete();
        return $result ? back()->with('success', 'Mã giảm giá #' . $id . ' đã được xóa vĩnh viễn.') : back()->withError('Lỗi xảy trong quá trình xóa vĩnh viễn Mã giảm giá #' . $id);
    }

    public function bulk_action(Request $request, RemoveImage $removeImage)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('coupon_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Mã giảm giá ';
                        foreach ($request->coupon_id_list as $coupon_id) {
                            $coupon = $this->coupon->find($coupon_id);
                            $verify = $coupon->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $coupon->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi tắt Mã giảm giá #' . $coupon->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Mã giảm giá ';
                        foreach ($request->coupon_id_list as $coupon_id) {
                            $coupon = $this->coupon->find($coupon_id);
                            $verify = $coupon->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $coupon->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi bật Mã giảm giá #' . $coupon->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // remove
                        $message = 'Mã giảm giá';
                        foreach ($request->coupon_id_list as $coupon_id) {
                            $coupon = null;
                            $coupon = $this->coupon->find($coupon_id);
                            $result = $coupon->delete();
                            if ($result) {
                                $message .= ' #' . $coupon->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ Mã giảm giá #' . $coupon->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 3: // restore
                        $message = 'Mã giảm giá';
                        foreach ($request->coupon_id_list as $coupon_id) {
                            $coupon = null;
                            $coupon = $this->coupon->onlyTrashed()->find($coupon_id);
                            $result = $coupon->restore();
                            if ($result) {
                                $message .= ' #' . $coupon->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục Mã giảm giá #' . $coupon->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 4: // delete
                        $message = 'Mã giảm giá';
                        foreach ($request->coupon_id_list as $coupon_id) {
                            $coupon = null;
                            $coupon = $this->coupon->onlyTrashed()->find($coupon_id);
                            $this->coupon->removeImage($coupon->image, $removeImage);
                            $result = $coupon->forceDelete();
                            if ($result) {
                                $message .= ' #' . $coupon->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn Mã giảm giá #' . $coupon->id . '.';
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
                return back()->withError('Hãy chọn ít nhất 1 Mã giảm giá để thực hiện thao tác!');
            }
        } else {
            return back()->withError('Hãy chọn 1 thao tác cụ thể!');
        }
    }
}
