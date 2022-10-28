<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Auth;
use DB;

class LoginController extends Controller
{
    public function login()
    {
        $title = array('pageTitle' => "Login");
        $userList = DB::table('tbl_user')
            ->select('tbl_user.*')
            ->get();
        return view("login", ['title' => $title, 'userList' => $userList]);
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

            // $adminInfo = array("user_id" => $request->user_name, "password_txt" => $request->password);
            $userList = DB::table('tbl_user')
                ->where('user_id', '=', $request->user_name)
                ->where('password_txt', '=', $request->password)
                ->select('tbl_user.*')
                ->get();

            // if(auth()->attempt($adminInfo)) {
            if (count($userList) > 0) {
                // $admin = auth()->user();

                // $administrators = DB::table('users')->where('user_id', $admin->user_id)->get();

                return redirect()->intended('/dashboard')->with('administrators', $userList[0]);
            } else {
                return redirect('/')->with('loginError', "Password is incorrect");
            }
        }
    }

    public function dashboard()
    {
        $title = array('pageTitle' => "Dashboard");

        return view("dashboard", ['title' => $title]);
    }
}
