<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RemoveImage;
use App\Http\Helpers\UploadImage;
use App\Http\Requests\GeneralRequest;
use App\Http\Requests\ProducerRequest;
use App\Models\Producer;
use Illuminate\Http\Request;

class ProducerController extends Controller
{
    // contructor
    public function __construct(Producer $producer)
    {
        $this->middleware('auth:admin');
        $this->producer = $producer;
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
        $producers = $this->producer->search($request)->sortId($request)->status($request);
        $producers_count = $producers->count();
        $producers = $producers->paginate($view);
        return view('pages.admin.producer.index', [
            'producers' => $producers,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'producers_count' => $producers_count,
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
        $verify = $this->producer->find($id)->update([
            'verified' => $verified,
        ]);
        if ($verified == 0)
            return back()->with('success', 'Hãng #' . $id . ' đã được tắt .');
        else
            return back()->with('success', 'Hãng #' . $id . ' đã được bật.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.admin.producer.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProducerRequest $request, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        if ($request->hasFile('image')) {
            $avatar = $this->producer->uploadImage($request->image, $uploadImage);
        }
        $result = $this->producer->create([
            'name' => $request->name,
            'image' => $avatar,
        ]);
        return $result ? back()->with('success', 'Hãng mới được khởi tạo thành công.') : back()->with('error', 'Lỗi xảy ra trong quá trình khởi tạo Hãng mới.');
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
        $producer = $this->producer->find($id);
        return view('pages.admin.producer.edit', [
            'producer' => $producer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProducerRequest $request, $id, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        $producer = $this->producer->find($id);
        if ($request->hasFile('image')) {
            $avatar = $this->producer->uploadImage($request->image, $uploadImage);
        } else {
            $avatar = $producer->image;
        }
        $result = $producer->update([
            'name' => $request->name,
            'image' => $avatar,
        ]);
        return $result ? back()->with('success', 'Hãng #' . $producer->id . ' đã được cập nhật.') : back()->with('error', 'Lỗi xảy ra khi cập nhật Hãng #' . $id);
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $producer = $this->producer->find($id);
        $result = $producer->delete();
        return $result ? back()->withSuccess('Hãng #' . $id . ' đã bị loại bỏ.') : back()->withError('Xảy ra lỗi khi loại bỏ Hãng #' . $id);
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
        $producers = $this->producer->onlyTrashed()->search($request)->sortId($request)->status($request);
        $producers_count = $producers->count();
        $producers = $producers->paginate($view);
        return view('pages.admin.producer.recycle', [
            'producers' => $producers,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'producers_count' => $producers_count,
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
        $result = $this->producer->onlyTrashed()->find($id)->restore();
        return $result ? back()->withSuccess('Hãng #' . $id . ' đã được phục hồi.') : back()->withError('Lỗi xảy ra trong quá trình khôi phục Hãng #' . $id);
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
        $producer = $this->producer->onlyTrashed()->find($id);
        $this->producer->removeImage($producer->image, $removeImage);
        $result = $producer->forceDelete();
        return $result ? back()->with('success', 'Hãng #' . $id . ' đã được xóa vĩnh viễn.') : back()->withError('Lỗi xảy trong quá trình xóa vĩnh viễn Hãng #' . $id);
    }

    public function bulk_action(Request $request, RemoveImage $removeImage)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('producer_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Hãng ';
                        foreach ($request->producer_id_list as $producer_id) {
                            $producer = $this->producer->find($producer_id);
                            $verify = $producer->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $producer->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi tắt Hãng #' . $producer->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Hãng ';
                        foreach ($request->producer_id_list as $producer_id) {
                            $producer = $this->producer->find($producer_id);
                            $verify = $producer->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $producer->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi bật Hãng #' . $producer->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // remove
                        $message = 'Hãng';
                        foreach ($request->producer_id_list as $producer_id) {
                            $producer = null;
                            $producer = $this->producer->find($producer_id);
                            $result = $producer->delete();
                            if ($result) {
                                $message .= ' #' . $producer->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ Hãng #' . $producer->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 3: // restore
                        $message = 'Hãng';
                        foreach ($request->producer_id_list as $producer_id) {
                            $producer = null;
                            $producer = $this->producer->onlyTrashed()->find($producer_id);
                            $result = $producer->restore();
                            if ($result) {
                                $message .= ' #' . $producer->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục Hãng #' . $producer->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 4: // delete
                        $message = 'Hãng';
                        foreach ($request->producer_id_list as $producer_id) {
                            $producer = null;
                            $producer = $this->producer->onlyTrashed()->find($producer_id);
                            $this->producer->removeImage($producer->image, $removeImage);
                            $result = $producer->forceDelete();
                            if ($result) {
                                $message .= ' #' . $producer->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn Hãng #' . $producer->id . '.';
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
                return back()->withError('Hãy chọn ít nhất 1 Hãng để thực hiện thao tác!');
            }
        } else {
            return back()->withError('Hãy chọn 1 thao tác cụ thể!');
        }
    }
}
