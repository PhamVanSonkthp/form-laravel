<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function auth;
use function redirect;
use function view;

class AdminController extends Controller
{
    public function loginAdmin()
    {

        if (auth()->check()) {
            if (optional(auth()->user())->is_admin == 0) return view('administrator.login.index');
            return redirect()->route('administrator.dashboard.index');
        }

        return view('administrator.login.index');
    }

    public function postLoginAdmin(Request $request)
    {
//        $zxc = 'đâsdasdasd';
        $remember = $request->has('remember_me') ? true : false;
        if (auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $remember)) {
            if (optional(auth()->user())->is_admin == 0) return view('administrator.login.index');
            return redirect()->route('administrator.dashboard.index');
        }

        Session::flash("message", "Sai tài khoản hoặc mật khẩu");
        return back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin');
    }

}
