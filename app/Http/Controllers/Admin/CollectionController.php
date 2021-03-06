<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RemoveImage;
use App\Http\Helpers\UploadImage;
use App\Http\Requests\GeneralRequest;
use App\Http\Requests\CollectionRequest;
use App\Models\Collection;
use App\Models\category;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    // contructor
    public function __construct(Collection $collection, Category $category)
    {
        $this->collection = $collection;
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
        $collections = $this->collection->search($request)->sortId($request)->status($request);
        $collections_count = $collections->count();
        $collections = $collections->paginate($view);
        return view('pages.admin.collection.index', [
            'collections' => $collections,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'collections_count' => $collections_count,
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
        $verify = $this->collection->find($id)->update([
            'verified' => $verified,
        ]);
        if ($verified == 0)
            return back()->with('success', 'Bộ sưu tập #' . $id . ' đã được tắt .');
        else
            return back()->with('success', 'Bộ sưu tập #' . $id . ' đã được bật.');
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
        return view('pages.admin.collection.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollectionRequest $request, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        if ($request->hasFile('image')) {
            $avatar = $this->collection->uploadImage($request->image, $uploadImage);
        }
        $result = $this->collection->create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $avatar,
            'category_id' => $request->category_id,
            'priority' => $request->priority,
        ]);
        return $result ? back()->with('success', 'Bộ sưu tập mới được khởi tạo thành công.') : back()->with('error', 'Lỗi xảy ra trong quá trình khởi tạo Bộ sưu tập mới.');
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
        $categories = $this->category->all();
        $collection = $this->collection->find($id);
        return view('pages.admin.collection.edit', [
            'collection' => $collection,
            'categories' => $categories,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CollectionRequest $request, $id, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        $collection = $this->collection->find($id);
        if ($request->hasFile('image')) {
            $avatar = $this->collection->uploadImage($request->image, $uploadImage);
        } else {
            $avatar = $collection->image;
        }
        $result = $collection->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $avatar,
            'category_id' => $request->category_id,
            'priority' => $request->priority,
        ]);
        return $result ? back()->with('success', 'Bộ sưu tập #' . $collection->id . ' đã được cập nhật.') : back()->with('error', 'Lỗi xảy ra khi cập nhật Bộ sưu tập #' . $id);
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $collection = $this->collection->find($id);
        $result = $collection->delete();
        return $result ? back()->withSuccess('Bộ sưu tập #' . $id . ' đã bị loại bỏ.') : back()->withError('Xảy ra lỗi khi loại bỏ Bộ sưu tập #' . $id);
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
        $collections = $this->collection->onlyTrashed()->search($request)->sortId($request)->status($request);
        $collections_count = $collections->count();
        $collections = $collections->paginate($view);
        return view('pages.admin.collection.recycle', [
            'collections' => $collections,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'collections_count' => $collections_count,
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
        $result = $this->collection->onlyTrashed()->find($id)->restore();
        return $result ? back()->withSuccess('Bộ sưu tập #' . $id . ' đã được phục hồi.') : back()->withError('Lỗi xảy ra trong quá trình khôi phục Bộ sưu tập #' . $id);
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
        $collection = $this->collection->onlyTrashed()->find($id);
        $this->collection->removeImage($collection->image, $removeImage);
        $result = $collection->forceDelete();
        return $result ? back()->with('success', 'Bộ sưu tập #' . $id . ' đã được xóa vĩnh viễn.') : back()->withError('Lỗi xảy trong quá trình xóa vĩnh viễn Bộ sưu tập #' . $id);
    }

    public function bulk_action(Request $request, RemoveImage $removeImage)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('collection_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Bộ sưu tập ';
                        foreach ($request->collection_id_list as $collection_id) {
                            $collection = $this->collection->find($collection_id);
                            $verify = $collection->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $collection->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi tắt Bộ sưu tập #' . $collection->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Bộ sưu tập ';
                        foreach ($request->collection_id_list as $collection_id) {
                            $collection = $this->collection->find($collection_id);
                            $verify = $collection->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $collection->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi bật Bộ sưu tập #' . $collection->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // remove
                        $message = 'Bộ sưu tập';
                        foreach ($request->collection_id_list as $collection_id) {
                            $collection = null;
                            $collection = $this->collection->find($collection_id);
                            $result = $collection->delete();
                            if ($result) {
                                $message .= ' #' . $collection->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ Bộ sưu tập #' . $collection->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 3: // restore
                        $message = 'Bộ sưu tập';
                        foreach ($request->collection_id_list as $collection_id) {
                            $collection = null;
                            $collection = $this->collection->onlyTrashed()->find($collection_id);
                            $result = $collection->restore();
                            if ($result) {
                                $message .= ' #' . $collection->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục Bộ sưu tập #' . $collection->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 4: // delete
                        $message = 'Bộ sưu tập';
                        foreach ($request->collection_id_list as $collection_id) {
                            $collection = null;
                            $collection = $this->collection->onlyTrashed()->find($collection_id);
                            $this->collection->removeImage($collection->image, $removeImage);
                            $result = $collection->forceDelete();
                            if ($result) {
                                $message .= ' #' . $collection->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn Bộ sưu tập #' . $collection->id . '.';
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
                return back()->withError('Hãy chọn ít nhất 1 Bộ sưu tập để thực hiện thao tác!');
            }
        } else {
            return back()->withError('Hãy chọn 1 thao tác cụ thể!');
        }
    }
}
