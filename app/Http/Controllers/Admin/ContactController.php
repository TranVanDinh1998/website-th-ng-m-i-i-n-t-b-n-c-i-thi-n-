<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\RemoveImage;
use App\Http\Helpers\UploadImage;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // contructor
    public function __construct(Contact $contact)
    {
        $this->middleware('auth:admin');
        $this->contact = $contact;
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
        $contacts = $this->contact->sortId($request)->status($request)->latest();
        $contacts_count = $contacts->count();
        $contacts = $contacts->paginate($view);
        return view('pages.admin.contact.index', [
            'contacts' => $contacts,
            // parameter
            'sort_id' => $sort_id,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'contacts_count' => $contacts_count,
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
        $verify = $this->contact->find($id)->update([
            'verified' => $verified,
        ]);
        if ($verified == 0)
            return back()->with('success', 'Liên lạc #' . $id . ' chưa được đọc .');
        else
            return back()->with('success', 'Liên lạc #' . $id . ' đã được đọc.');
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
        $contact = $this->contact->find($id);
        $contact->update(['verified'=>1]);
        return view('pages.admin.contact.detail', [
            'contact' => $contact,
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
    public function update(Request $request, $id, UploadImage $uploadImage)
    {
        //
        $contact = $this->contact->find($id);
        $result = $contact->update([
            'name' => $request->name,
            'verified' => $request->verfied,
        ]);
        return $result ? back()->with('success', 'Liên lạc #' . $contact->id . ' đã được cập nhật.') : back()->with('error', 'Lỗi xảy ra khi cập nhật Liên lạc #' . $id);
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $contact = $this->contact->find($id);
        $result = $contact->delete();
        return $result ? back()->withSuccess('Liên lạc #' . $id . ' đã bị loại bỏ.') : back()->withError('Xảy ra lỗi khi loại bỏ Liên lạc #' . $id);
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
        $contacts = $this->contact->onlyTrashed()->sortId($request)->status($request)->latest();
        $contacts_count = $contacts->count();
        $contacts = $contacts->paginate($view);
        return view('pages.admin.contact.recycle', [
            'contacts' => $contacts,
            // parameter
            'sort_id' => $sort_id,
            'status' => $status,
            'search' => $search,
            'view' => $view,
            'contacts_count' => $contacts_count,
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
        $result = $this->contact->onlyTrashed()->find($id)->restore();
        return $result ? back()->withSuccess('Liên lạc #' . $id . ' đã được phục hồi.') : back()->withError('Lỗi xảy ra trong quá trình khôi phục Liên lạc #' . $id);
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
        $contact = $this->contact->onlyTrashed()->find($id);
        $result = $contact->forceDelete();
        return $result ? back()->with('success', 'Liên lạc #' . $id . ' đã được xóa vĩnh viễn.') : back()->withError('Lỗi xảy trong quá trình xóa vĩnh viễn Liên lạc #' . $id);
    }

    public function bulk_action(Request $request)
    {
        if ($request->has('bulk_action')) {
            if ($request->has('contact_id_list')) {
                $message = null;
                $errors = null;
                switch ($request->bulk_action) {
                    case 0: // deactivate
                        $message = 'Liên lạc ';
                        foreach ($request->contact_id_list as $contact_id) {
                            $contact = $this->contact->find($contact_id);
                            $verify = $contact->update([
                                'verified' => 0,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $contact->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi được đánh dấu là chưa đọc Liên lạc #' . $contact->id . '.';
                            }
                        }
                        $message .= 'đã được tắt.';
                        break;
                    case 1: // activate
                        $message = 'Liên lạc ';
                        foreach ($request->contact_id_list as $contact_id) {
                            $contact = $this->contact->find($contact_id);
                            $verify = $contact->update([
                                'verified' => 1,
                            ]);
                            if ($verify) {
                                $message .= ' #' . $contact->id . ', ';
                            } else {
                                $errors[] = 'Lỗi xảy ra khi được đánh dấu là đã đọc Liên lạc #' . $contact->id . '.';
                            }
                        }
                        $message .= 'đã được bật.';
                        break;
                    case 2: // remove
                        $message = 'Liên lạc';
                        foreach ($request->contact_id_list as $contact_id) {
                            $contact = null;
                            $contact = $this->contact->find($contact_id);
                            $result = $contact->delete();
                            if ($result) {
                                $message .= ' #' . $contact->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi loại bỏ Liên lạc #' . $contact->id . '.';
                            }
                        }
                        $message .= 'đã được loại bỏ.';
                        break;
                    case 3: // restore
                        $message = 'Liên lạc';
                        foreach ($request->contact_id_list as $contact_id) {
                            $contact = null;
                            $contact = $this->contact->onlyTrashed()->find($contact_id);
                            $result = $contact->restore();
                            if ($result) {
                                $message .= ' #' . $contact->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi khôi phục Liên lạc #' . $contact->id . '.';
                            }
                        }
                        $message .= 'đã được khôi phục.';
                        break;
                    case 4: // delete
                        $message = 'Liên lạc';
                        foreach ($request->contact_id_list as $contact_id) {
                            $contact = null;
                            $contact = $this->contact->onlyTrashed()->find($contact_id);
                            $result = $contact->forceDelete();
                            if ($result) {
                                $message .= ' #' . $contact->id . ', ';
                            }
                            else {
                                $errors[] = 'Lỗi xảy ra khi xóa vĩnh viễn Liên lạc #' . $contact->id . '.';
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
                return back()->withError('Hãy chọn ít nhất 1 Liên lạc để thực hiện thao tác!');
            }
        } else {
            return back()->withError('Hãy chọn 1 thao tác cụ thể!');
        }
    }
}
