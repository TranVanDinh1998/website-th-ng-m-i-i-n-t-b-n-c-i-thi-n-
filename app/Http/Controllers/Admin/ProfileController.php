<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\UploadImage;
use App\Http\Requests\InforRequest;
use App\Models\Admin;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct(Admin $admin )
    {
        $this->admin = $admin;
        $this->middleware('auth:admin');
    }

    public function index()
    {
        // user
        $user = Auth::guard('admin')->user();
        $current_user = $user;
        return view('pages.admin.profile.index', [
            // user
            'user' => $user,
            'current_user' => $current_user,
        ]);
    }

    public function update(InforRequest $request, UploadImage $uploadImage)
    {
        $avatar = null;
        $admin = $this->admin->find( Auth::guard('admin')->user()->id);
        if ($request->hasFile('image')) {
            $avatar = $this->admin->uploadImage($request->image, $uploadImage);
        } else {
            $avatar = $admin->image;
        }
        $result = $admin->update([
            'name' => $request->name,
            'image' => $avatar,
        ]);
        return $result ? back()->withSuccess('Tài khoản #' . Auth::guard('admin')->user()->id . ' đã được cập nhật.') : back()->withError('Lỗi xảy ra khi cập nhật Tài khoản #' . Auth::guard('admin')->user()->id);
    }

}
