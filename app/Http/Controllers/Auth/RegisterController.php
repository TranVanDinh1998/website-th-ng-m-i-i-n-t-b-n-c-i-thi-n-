<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Requests\RegisterRequest;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function register(RegisterRequest $request)
    {
        $result = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return $result ? back()->with('success', 'Tài khoản được khởi tạo thành công và sẵn sàng đăng nhập.') : back()->withError('Lỗi xảy ra trong quá trình khởi tạo tài khoản.');

    }
}
