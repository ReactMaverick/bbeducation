<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Auth;
use DB;
use Session;

class LoginController extends Controller
{
    public function login()
    {
        $webUserLoginData = Session::get('webUserLoginData');
        // if (Auth::guard('subadmin')->check()) {
        if ($webUserLoginData) {
            return redirect()->intended('/dashboard');
        } else {
            $title = array('pageTitle' => "Login");
            return view("web.login", ['title' => $title]);
        }
    }

    public function processLogin(Request $request)
    {
        $validator = Validator::make(
            array(
                'user_name'    => $request->user_name,
                'password' => $request->password
            ),
            array(
                'user_name'    => 'required',
                'password' => 'required',
            )
        );
        //check validation
        if ($validator->fails()) {
            return redirect('/')->withErrors($validator)->withInput();
        } else {

            if (Auth::guard('subadmin')->attempt(['user_name' => $request->user_name, 'password' => $request->password], $request->get('remember'))) {
                $admin = Auth::guard('subadmin')->user();

                $administrators = DB::table('tbl_user')->where('user_id', $admin->user_id)->get();
                Session::put('webUserLoginData', $administrators[0]);
                // dd($admin);
                return redirect()->intended('/dashboard')->with('administrators', $administrators[0]);
            } else {
                return back()->withInput($request->only('user_name', 'remember'))->with('loginError', "Username or password is incorrect");
            }
        }
    }

    public function logout()
    {
        Auth::guard('subadmin')->logout();
        Session::forget('webUserLoginData');
        return redirect('/');
    }

    public function profile()
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Profile");
            $headerTitle = "Profile";

            return view("web.profile", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }
}
