<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RemoveImage;
use App\Http\Helpers\UploadImage;
use App\Models\Review;
use Illuminate\Http\Request;

class reviewController extends Controller
{
    // contructor
    public function __construct(Review $review)
    {
        $this->middleware('auth:admin');
        $this->review = $review;
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
        $status = $request->status;
        // search
        $search = $request->search;
        // view
        $view = $request->has('view') ? $request->view : 10;
        // data
        $reviews = $this->review->sortId($request)->status($request)->latest();
        $reviews_count = $reviews->count();
        $reviews = $reviews->paginate($view);
        return view('pages.admin.review.index', [
            'reviews' => $reviews,
            // parameter
            'sort_id' => $sort_id,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'reviews_count' => $reviews_count,
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
        $verify = $this->review->find($id)->update([
            'verified' => $verified,
        ]);
        if ($verified == 0)
            return back()->with('success', 'Đánh giá #' . $id . ' đã được bật .');
        else
            return back()->with('success', 'Đánh giá #' . $id . ' đã được tắt.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
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
        $review = $this->review->find($id);
        return view('pages.admin.review.detail', [
            'review' => $review,
        ]);
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $review = $this->review->find($id);
        $result = $review->delete();
        return $result ? back()->withSuccess('Đánh giá #' . $id . ' đã bị loại bỏ.') : back()->withError('Xảy ra lỗi khi loại bỏ Đánh giá #' . $id);
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
        $status = $request->status;
        // search
        $search = $request->search;
        // view
        $view = $request->has('view') ? $request->view : 10;
        // data
        $reviews = $this->review->onlyTrashed()->sortId($request)->status($request)->latest();
        $reviews_count = $reviews->count();
        $reviews = $reviews->paginate($view);
        return view('pages.admin.review.recycle', [
            'reviews' => $reviews,
            // parameter
            'sort_id' => $sort_id,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'reviews_count' => $reviews_count,
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
        $result = $this->review->onlyTrashed()->find($id)->restore();
        return $result ? back()->withSuccess('Đánh giá #' . $id . ' đã được phục hồi.') : back()->withError('Lỗi xảy ra trong quá trình khôi phục Đánh giá #' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $review = $this->review->onlyTrashed()->find($id);
        $result = $review->forceDelete();
        return $result ? back()->with('success', 'Đánh giá #' . $id . ' đã được xóa vĩnh viễn.') : back()->withError('Lỗi xảy trong quá trình xóa vĩnh viễn Đánh giá #' . $id);
    }

    public function bulk_action(Request $request)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('review_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Đánh giá ';
                        foreach ($request->review_id_list as $review_id) {
                            $review = $this->review->find($review_id);
                            $verify = $review->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $review->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi được đánh dấu là chưa đọc Đánh giá #' . $review->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Đánh giá ';
                        foreach ($request->review_id_list as $review_id) {
                            $review = $this->review->find($review_id);
                            $verify = $review->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $review->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi được đánh dấu là đã đọc Đánh giá #' . $review->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // remove
                        $message = 'Đánh giá';
                        foreach ($request->review_id_list as $review_id) {
                            $review = null;
                            $review = $this->review->find($review_id);
                            $result = $review->delete();
                            if ($result) {
                                $message .= ' #' . $review->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ Đánh giá #' . $review->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 3: // restore
                        $message = 'Đánh giá';
                        foreach ($request->review_id_list as $review_id) {
                            $review = null;
                            $review = $this->review->onlyTrashed()->find($review_id);
                            $result = $review->restore();
                            if ($result) {
                                $message .= ' #' . $review->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục Đánh giá #' . $review->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 4: // delete
                        $message = 'Đánh giá';
                        foreach ($request->review_id_list as $review_id) {
                            $review = null;
                            $review = $this->review->onlyTrashed()->find($review_id);
                            $result = $review->forceDelete();
                            if ($result) {
                                $message .= ' #' . $review->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn Đánh giá #' . $review->id . '.';
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
                return back()->withError('Hãy chọn ít nhất 1 Đánh giá để thực hiện thao tác!');
            }
        } else {
            return back()->withError('Hãy chọn 1 thao tác cụ thể!');
        }
    }
}
