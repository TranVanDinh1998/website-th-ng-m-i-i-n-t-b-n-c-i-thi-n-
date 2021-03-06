<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RemoveImage;
use App\Http\Helpers\UploadImage;
use App\Http\Requests\GeneralRequest;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Models\category;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // contructor
    public function __construct(Tag $tag, Category $category)
    {
        $this->tag = $tag;
        $this->middleware('auth:admin');
        $this->category = $category;
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
        $tags = $this->tag->withoutTrashed();
        $tags_count = $tags->count();
        $tags = $tags->paginate($view);
        return view('pages.admin.tag.index', [
            'tags' => $tags,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'tags_count' => $tags_count,
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
        $verify = $this->tag->find($id)->update([
            'verified' => $verified,
        ]);
        if ($verified == 0)
            return back()->with('success', 'Thẻ #' . $id . ' đã được tắt .');
        else
            return back()->with('success', 'Thẻ #' . $id . ' đã được bật.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.admin.tag.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneralRequest $request, UploadImage $uploadImage)
    {
        //
        $result = $this->tag->create([
            'name' => $request->name,
        ]);
        return $result ? back()->with('success', 'Thẻ mới được khởi tạo thành công.') : back()->with('error', 'Lỗi xảy ra trong quá trình khởi tạo Thẻ mới.');
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
        $tag = $this->tag->find($id);
        return view('pages.admin.tag.edit', [
            'tag' => $tag,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GeneralRequest $request, $id)
    {
        //
        $tag = $this->tag->find($id);
        $result = $tag->update([
            'name' => $request->name,
        ]);
        return $result ? back()->with('success', 'Thẻ #' . $tag->id . ' đã được cập nhật.') : back()->with('error', 'Lỗi xảy ra khi cập nhật Thẻ #' . $id);
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $tag = $this->tag->find($id);
        $result = $tag->delete();
        return $result ? back()->withSuccess('Thẻ #' . $id . ' đã bị loại bỏ.') : back()->withError('Xảy ra lỗi khi loại bỏ Thẻ #' . $id);
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
        $tags = $this->tag->onlyTrashed();
        $tags_count = $tags->count();
        $tags = $tags->paginate($view);
        return view('pages.admin.tag.recycle', [
            'tags' => $tags,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'tags_count' => $tags_count,
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
        $result = $this->tag->onlyTrashed()->find($id)->restore();
        return $result ? back()->withSuccess('Thẻ #' . $id . ' đã được phục hồi.') : back()->withError('Lỗi xảy ra trong quá trình khôi phục Thẻ #' . $id);
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
        $tag = $this->tag->onlyTrashed()->find($id);
        $result = $tag->forceDelete();
        return $result ? back()->with('success', 'Thẻ #' . $id . ' đã được xóa vĩnh viễn.') : back()->withError('Lỗi xảy trong quá trình xóa vĩnh viễn Thẻ #' . $id);
    }

    public function bulk_action(Request $request, RemoveImage $removeImage)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('tag_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Thẻ ';
                        foreach ($request->tag_id_list as $tag_id) {
                            $tag = $this->tag->find($tag_id);
                            $verify = $tag->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $tag->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi tắt Thẻ #' . $tag->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Thẻ ';
                        foreach ($request->tag_id_list as $tag_id) {
                            $tag = $this->tag->find($tag_id);
                            $verify = $tag->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $tag->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi bật Thẻ #' . $tag->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // remove
                        $message = 'Thẻ';
                        foreach ($request->tag_id_list as $tag_id) {
                            $tag = null;
                            $tag = $this->tag->find($tag_id);
                            $result = $tag->delete();
                            if ($result) {
                                $message .= ' #' . $tag->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ Thẻ #' . $tag->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 3: // restore
                        $message = 'Thẻ';
                        foreach ($request->tag_id_list as $tag_id) {
                            $tag = null;
                            $tag = $this->tag->onlyTrashed()->find($tag_id);
                            $result = $tag->restore();
                            if ($result) {
                                $message .= ' #' . $tag->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục Thẻ #' . $tag->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 4: // delete
                        $message = 'Thẻ';
                        foreach ($request->tag_id_list as $tag_id) {
                            $tag = null;
                            $tag = $this->tag->onlyTrashed()->find($tag_id);
                            $result = $tag->forceDelete();
                            if ($result) {
                                $message .= ' #' . $tag->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn Thẻ #' . $tag->id . '.';
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
                return back()->withError('Hãy chọn ít nhất 1 Thẻ để thực hiện thao tác!');
            }
        } else {
            return back()->withError('Hãy chọn 1 thao tác cụ thể!');
        }
    }
}
