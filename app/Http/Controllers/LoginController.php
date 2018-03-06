<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        /** @var \Illuminate\Http\Request $request */
        if ($request->has('submit')) {
            $username = $request->get('user');
            $password = $request->get('password');

            if (($username === env('ADMIN') && $password === env('PASSWORD'))) {
                session(['admin' => $username]);
                return redirect('/products');
            }
        }

        return view('login');

    }

    public function logout()
    {
        if(session()->has('admin'))
        {
            session()->forget('admin');
            $msg = __('You are logged out !');
        }else{
            $msg = __('You are already logged out !');
        }

        return view('logout', compact('msg'));

    }

}
