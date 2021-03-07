<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Admin;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        $this->middleware('auth:admin');
    }

    public function index()
    {
        // order
        $user = Auth::guard('admin')->user();
        return view('pages.admin.profile.password', [
            // user
            'current_user' => $user,
            // cart


        ]);
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $user_password = Auth::user()->password;
        if (Hash::check($old_password, $user_password)) {
            $user_id = Auth::guard('admin')->user()->id;
            $admin = $this->admin->find($user_id);
            $result = $admin->update(['password' => Hash::make($new_password)]);
            if ($result)
                return back()->withSuccess('Đổi mật khẩu thành công');
            else
                return back()->withError('Có lỗi xảy ra khi đổi mật khẩu');
        } else {
            return back()->withError('Mật khẩu cũ không hợp lệ');
        }
    }
}
