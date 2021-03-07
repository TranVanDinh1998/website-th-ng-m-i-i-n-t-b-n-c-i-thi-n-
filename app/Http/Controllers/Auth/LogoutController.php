<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function customerLogout()
    {
        Auth::logout();
        return back();
    }
    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        // session()->flush();
        return back();
    }
}
