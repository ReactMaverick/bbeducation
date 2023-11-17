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
                'user_name' => $request->user_name,
                'password' => $request->password
            ),
            array(
                'user_name' => 'required',
                'password' => 'required',
            )
        );
        //check validation
        if ($validator->fails()) {
            return redirect('/')->withErrors($validator)->withInput();
        } else {

            if (Auth::guard('subadmin')->attempt(['user_name' => $request->user_name, 'password' => $request->password, 'admin_type' => 1, 'isActive' => 1, 'is_delete' => 0], $request->get('remember'))) {
                $admin = Auth::guard('subadmin')->user();

                $administrators = DB::table('tbl_user')
                    ->LeftJoin('company', 'company.company_id', '=', 'tbl_user.company_id')
                    ->select('tbl_user.*', 'company.company_name', 'company.company_logo')
                    ->where('tbl_user.user_id', $admin->user_id)
                    ->get();
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

            return view("web.user.profile", ['title' => $title, 'headerTitle' => $headerTitle]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function superAdminLogin()
    {
        $title = array('pageTitle' => "Login");
        return view("web.superAdmin.login", ['title' => $title]);
    }

    public function superAdminLoginAttempt(Request $request)
    {
        $validator = Validator::make(
            array(
                'user_name' => $request->user_name,
                'password' => $request->password
            ),
            array(
                'user_name' => 'required',
                'password' => 'required',
            )
        );
        //check validation
        if ($validator->fails()) {
            return redirect('/super-admin-login')->withErrors($validator)->withInput();
        } else {
            
            if (Auth::guard('superadmin')->attempt(['user_name' => $request->user_name, 'password' => $request->password, 'admin_type' => 5, 'isActive' => 1, 'is_delete' => 0], $request->get('remember'))) {
                $admin = Auth::guard('superadmin')->user();
                $otp = rand(100000, 999999);

                DB::table('tbl_user')
                    ->where('user_id', $admin->user_id)
                    ->update(['login_otp' => $otp]);
                $administrators = DB::table('tbl_user')
                    ->where('user_id', $admin->user_id)
                    ->first();
                // dd($administrators);
                if (isset($administrators)) {
                    $mailData['firstName_txt'] = $administrators->firstName_txt;
                    $mailData['surname_txt'] = $administrators->surname_txt;
                    $mailData['mail'] = $administrators->user_name;
                    $mailData['login_otp'] = $administrators->login_otp;
                    $myVar = new AlertController();
                    if($myVar->superadminOtpMail($mailData)){
                        return redirect('/otpVerification')->with('success', 'And OTP has been sent to your registered email address.');
                    } else {
                        return back()->withInput($request->only('user_name', 'remember'))->with('loginError', "Something went wrong !");
                    }
                }
            } else {
                return back()->withInput($request->only('user_name', 'remember'))->with('loginError', "Username or password is incorrect");
            }
        }
    }

    public function superAdminOtpVerify(Request $request)
    {
        $validator = Validator::make(
            array(
                'otp' => $request->otp,
            ),
            array(
                'otp' => 'required|size:6',
            )
        );
        //check validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $admin = DB::table('tbl_user')->where('login_otp', $request->otp)->first();

            if (isset($admin)) {
                if($admin->admin_type == 5){
                    // DB::table('tbl_user')->where('login_otp', $request->otp)->update(['login_otp', null]);
                    Session::put('superadmin', $admin);
                    return redirect('/superAdminDashboard');
                }
            } 
            else {
                return redirect('/otpVerification')->with('error', 'OTP not matched !');
            }
        }
    }

    public function otpVerification()
    {
        return view('web.superAdmin.otp_verification');
    }

    public function superAdminlogout()
    {
        Auth::guard('superadmin')->logout();
        Session::forget('superadmin');
        return redirect('/super-admin-login');
    }
}
