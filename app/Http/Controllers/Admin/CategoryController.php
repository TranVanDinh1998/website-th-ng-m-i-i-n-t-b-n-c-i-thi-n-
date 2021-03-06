<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RemoveImage;
use App\Http\Helpers\UploadImage;
use App\Http\Requests\GeneralRequest;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // contructor
    public function __construct(Category $category)
    {
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
        $categories = $this->category->search($request)->sortId($request)->status($request);
        $categories_count = $categories->count();
        $categories = $categories->paginate($view);
        return view('pages.admin.category.index', [
            'categories' => $categories,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'categories_count' => $categories_count,
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
        $verify = $this->category->find($id)->update([
            'verified' => $verified,
        ]);
        if ($verified == 0)
            return back()->with('success', 'Thể loại #' . $id . ' đã được tắt .');
        else
            return back()->with('success', 'Thể loại #' . $id . ' đã được bật.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.admin.category.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        if ($request->hasFile('image')) {
            $avatar = $this->category->uploadImage($request->image, $uploadImage);
        }
        $result = $this->category->create([
            'name' => $request->name,
            'image' => $avatar,
            'description' => $request->description,
        ]);
        return $result ? back()->with('success', 'Thể loại mới được khởi tạo thành công.') : back()->with('error', 'Lỗi xảy ra trong quá trình khởi tạo thể loại mới.');
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
        $category = $this->category->find($id);
        return view('pages.admin.category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id, UploadImage $uploadImage)
    {
        //
        $avatar = null;
        $category = $this->category->find($id);
        if ($request->hasFile('image')) {
            $avatar = $this->category->uploadImage($request->image, $uploadImage);
        } else {
            $avatar = $category->image;
        }
        $result = $category->update([
            'name' => $request->name,
            'image' => $avatar,
            'description' => $request->description,
        ]);
        return $result ? back()->with('success', 'Thể loại #' . $category->id . ' đã được cập nhật.') : back()->with('error', 'Lỗi xảy ra khi cập nhật thể loại #' . $id);
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $category = $this->category->find($id);
        $result = $category->delete();
        return $result ? back()->withSuccess('Thể loại #' . $id . ' đã bị loại bỏ.') : back()->withError('Xảy ra lỗi khi loại bỏ thể loại #' . $id);
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
        $categories = $this->category->onlyTrashed()->search($request)->sortId($request)->status($request);
        $categories_count = $categories->count();
        $categories = $categories->paginate($view);
        return view('pages.admin.category.recycle', [
            'categories' => $categories,
            // parameter
            'sort_id' => $sort_id,
            'search' => $search,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'categories_count' => $categories_count,
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
        $result = $this->category->onlyTrashed()->find($id)->restore();
        return $result ? back()->withSuccess('Thể loại #' . $id . ' đã được phục hồi.') : back()->withError('Lỗi xảy ra trong quá trình khôi phục thể loại #' . $id);
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
        $category = $this->category->onlyTrashed()->find($id);
        $this->category->removeImage($category->image, $removeImage);
        $result = $category->forceDelete();
        return $result ? back()->with('success', 'Thể loại #' . $id . ' đã được xóa vĩnh viễn.') : back()->withError('Lỗi xảy trong quá trình xóa vĩnh viễn thể loại #' . $id);
    }

    public function bulk_action(Request $request, RemoveImage $removeImage)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('category_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Thể loại ';
                        foreach ($request->category_id_list as $category_id) {
                            $category = $this->category->find($category_id);
                            $verify = $category->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $category->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi tắt thể loại #' . $category->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Thể loại ';
                        foreach ($request->category_id_list as $category_id) {
                            $category = $this->category->find($category_id);
                            $verify = $category->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $category->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi bật thể loại #' . $category->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // remove
                        $message = 'Thể loại';
                        foreach ($request->category_id_list as $category_id) {
                            $category = null;
                            $category = $this->category->find($category_id);
                            $result = $category->delete();
                            if ($result) {
                                $message .= ' #' . $category->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ thể loại #' . $category->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 3: // restore
                        $message = 'Thể loại';
                        foreach ($request->category_id_list as $category_id) {
                            $category = null;
                            $category = $this->category->onlyTrashed()->find($category_id);
                            $result = $category->restore();
                            if ($result) {
                                $message .= ' #' . $category->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục thể loại #' . $category->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 4: // delete
                        $message = 'Thể loại';
                        foreach ($request->category_id_list as $category_id) {
                            $category = null;
                            $category = $this->category->onlyTrashed()->find($category_id);
                            $this->category->removeImage($category->image, $removeImage);
                            $result = $category->forceDelete();
                            if ($result) {
                                $message .= ' #' . $category->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn thể loại #' . $category->id . '.';
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
                return back()->withError('Hãy chọn ít nhất 1 thể loại để thực hiện thao tác!');
            }
        } else {
            return back()->withError('Hãy chọn 1 thao tác cụ thể!');
        }
    }
}
