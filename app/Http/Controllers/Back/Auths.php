<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Auths extends Controller
{
    public function login()
    {
        return view('back.auth.login');
    }

    public function loginPost(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            
            return redirect()->route('admin.dashboard');
            
        } else {
            return redirect()->route('admin.giris')->withErrors('Email Adresi Veya Şifre Hatalı');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.giris');
    }
}
