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

    public function adminLogin(Request $request)
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
            $admin = DB::table('tbl_user')
                ->leftJoin('company', 'company.company_id', '=', 'tbl_user.company_id')
                ->select('tbl_user.*', 'company.company_name', 'company.company_logo')
                ->where('tbl_user.user_name', $request->user_name)
                ->where('tbl_user.admin_type', 1)
                ->where('tbl_user.is_delete', 0)
                ->where('tbl_user.isActive', 1)
                ->get();
            if (count($admin) > 1) {
                $mLogData['user_name'] = $request->user_name;
                $mLogData['password'] = $request->password;
                Session::put('multiLogData', $mLogData);
                Session::put('multiComData', $admin);
                return redirect('/admin-multi-company');
            } else if (count($admin) == 1) {
                if (Hash::check($request->password, $admin[0]->password)) {
                    $otp = rand(100000, 999999);
                    $credential['user_name'] = $request->user_name;
                    $credential['password'] = $request->password;
                    $credential['id'] = $admin[0]->user_id;
                    Session::put('credentials', $credential);
                    DB::table('tbl_user')
                        ->where('user_id', $admin[0]->user_id)
                        ->where('admin_type', 1)
                        ->update(['login_otp' => $otp]);
                    $administrators = DB::table('tbl_user')
                        ->where('user_id', $admin[0]->user_id)
                        ->first();
                    $companyDetail = DB::table('company')
                        ->select('company.*')
                        ->where('company.company_id', $admin[0]->company_id)
                        ->first();
                    if (isset($administrators)) {
                        $mailData['companyDetail'] = $companyDetail;
                        $mailData['firstName_txt'] = $administrators->firstName_txt;
                        $mailData['surname_txt'] = $administrators->surname_txt;
                        $mailData['mail'] = $administrators->user_name;
                        $mailData['login_otp'] = $administrators->login_otp;
                        $myVar = new AlertController();
                        if ($myVar->adminOtpMail($mailData)) {
                            return redirect('/adminOtp')->with('admSuccess', 'An OTP has been sent to your registered email address.');
                        } else {
                            return back()->withInput($request->only('user_name', 'remember'))->with('loginError', "Something went wrong !");
                        }
                    }
                } else {
                    return redirect()->back()->withInput($request->only('user_name', 'remember'))->with('loginError', "Username or password is incorrect");
                }
            } else {
                return redirect()->back()->withInput($request->only('user_name', 'remember'))->with('loginError', "Username or password is incorrect");
            }
        }
    }

    public function processLogin(Request $request)
    {

        $validator = Validator::make(
            array(
                'otp' => $request->otp,
            ),
            array(
                'otp' => 'required',
            )
        );
        //check validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if (Session::has('credentials')) {
                $credentials = Session::get('credentials');
                $admin = DB::table('tbl_user')
                    ->where('login_otp', $request->otp)
                    ->where('user_id', $credentials['id'])
                    ->first();
                if (isset($admin)) {
                    Session::forget(['credentials']);
                    if (Auth::guard('subadmin')->attempt(['user_id' => $credentials['id'], 'user_name' => $credentials['user_name'], 'password' => $credentials['password'], 'admin_type' => 1, 'isActive' => 1, 'is_delete' => 0], $request->get('remember'))) {
                        $admin = Auth::guard('subadmin')->user();
                        DB::table('tbl_user')
                            ->where('login_otp', $request->otp)
                            ->update(['login_otp' => null]);
                        $administrators = DB::table('tbl_user')
                            ->LeftJoin('company', 'company.company_id', '=', 'tbl_user.company_id')
                            ->select('tbl_user.*', 'company.company_name', 'company.company_logo')
                            ->where('tbl_user.user_id', $admin->user_id)
                            ->get();
                        Session::put('webUserLoginData', $administrators[0]);
                        Session::forget(['multiLogData']);
                        Session::forget(['multiComData']);
                        // dd($admin);
                        return redirect()->intended('/dashboard')->with('administrators', $administrators[0]);
                    } else {
                        return redirect()->back()->withInput($request->only('user_name', 'remember'))->with('error', "Incorrect OTP");
                    }
                } else {
                    return redirect()->back()->withInput($request->only('user_name', 'remember'))->with('error', "Incorrect OTP");
                }
            } else {
                return redirect('/');
            }
        }
    }

    public function adminMultiCompany()
    {
        $multiComData = Session::get('multiComData');
        $multiLogData = Session::get('multiLogData');
        if ($multiComData && $multiLogData) {
            return view('auth.admin_multi_com', ['multiComData' => $multiComData]);
        } else {
            return redirect('/');
        }
    }

    public function processMultiCom(Request $request)
    {
        $multiComData = Session::get('multiComData');
        $multiLogData = Session::get('multiLogData');
        $admin = DB::table('tbl_user')
            ->leftJoin('company', 'company.company_id', '=', 'tbl_user.company_id')
            ->select('tbl_user.*', 'company.company_name', 'company.company_logo')
            ->where('tbl_user.user_name', $multiLogData['user_name'])
            ->where('tbl_user.company_id', $request->company_id)
            ->where('tbl_user.admin_type', 1)
            ->where('tbl_user.is_delete', 0)
            ->where('tbl_user.isActive', 1)
            ->first();
        if ($admin) {
            if (Hash::check($multiLogData['password'], $admin->password)) {
                $otp = rand(100000, 999999);
                $credential['user_name'] = $multiLogData['user_name'];
                $credential['password'] = $multiLogData['password'];
                $credential['id'] = $admin->user_id;
                Session::put('credentials', $credential);
                DB::table('tbl_user')
                    ->where('user_id', $admin->user_id)
                    ->where('admin_type', 1)
                    ->update(['login_otp' => $otp]);
                $administrators = DB::table('tbl_user')
                    ->where('user_id', $admin->user_id)
                    ->first();
                $companyDetail = DB::table('company')
                    ->select('company.*')
                    ->where('company.company_id', $admin->company_id)
                    ->first();
                if (isset($administrators)) {
                    $mailData['companyDetail'] = $companyDetail;
                    $mailData['firstName_txt'] = $administrators->firstName_txt;
                    $mailData['surname_txt'] = $administrators->surname_txt;
                    $mailData['mail'] = $administrators->user_name;
                    $mailData['login_otp'] = $administrators->login_otp;
                    $myVar = new AlertController();
                    if ($myVar->adminOtpMail($mailData)) {
                        return redirect('/adminOtp')->with('admSuccess', 'An OTP has been sent to your registered email address.');
                    } else {
                        return redirect()->back()->withInput($request->only('user_name', 'remember'))->with('loginError', "Something went wrong !");
                    }
                }
            } else {
                return redirect('/')->withInput($request->only('user_name', 'remember'))->with('loginError', "Password is incorrect");
            }
        } else {
            return redirect('/')->with('loginError', "Something went wrong please try again");
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
            return redirect('/system-login')->withErrors($validator)->withInput();
        } else {
            $superadmin = DB::table('tbl_user')
                ->where('user_name', $request->user_name)
                ->where('admin_type', 5)
                ->where('is_delete', 0)
                ->where('isActive', 1)
                ->first();
            if ($superadmin) {
                if (Hash::check($request->password, $superadmin->password)) {
                    $credential['user_name'] = $request->user_name;
                    $credential['password'] = $request->password;
                    $credential['id'] = $superadmin->user_id;
                    Session::put('credentials', $credential);
                    $otp = rand(100000, 999999);

                    DB::table('tbl_user')
                        ->where('user_id', $superadmin->user_id)
                        ->update(['login_otp' => $otp]);
                    $administrators = DB::table('tbl_user')
                        ->where('user_id', $superadmin->user_id)
                        ->first();
                    // dd($administrators);
                    if (isset($administrators)) {
                        $mailData['firstName_txt'] = $administrators->firstName_txt;
                        $mailData['surname_txt'] = $administrators->surname_txt;
                        $mailData['mail'] = $administrators->user_name;
                        $mailData['login_otp'] = $administrators->login_otp;
                        $myVar = new AlertController();
                        if ($myVar->superadminOtpMail($mailData)) {
                            return redirect('/otpVerification')->with('sAdminSuccess', 'An OTP has been sent to your registered email address.');
                        } else {
                            return back()->withInput($request->only('user_name', 'remember'))->with('loginError', "Something went wrong !");
                        }
                    }
                } else {
                    return back()->withInput($request->only('user_name', 'remember'))->with('loginError', "Username or password is incorrect");
                }
            } else {
                return back()->with(['error' => 'Invalid User Name or Password']);
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
            if (Session::has('credentials')) {
                $credentials = Session::get('credentials');
                $superadmin = DB::table('tbl_user')
                    ->where('login_otp', $request->otp)
                    ->where('user_id', $credentials['id'])
                    ->first();
                if (isset($superadmin)) {
                    Session::forget(['credentials']);
                    if (Auth::guard('superadmin')->attempt(['user_id' => $credentials['id'], 'user_name' => $credentials['user_name'], 'password' => $credentials['password'], 'admin_type' => 5, 'isActive' => 1, 'is_delete' => 0], $request->get('remember'))) {
                        $superadmin = Auth::guard('superadmin')->user();
                        DB::table('tbl_user')
                            ->where('login_otp', $request->otp)
                            ->update(['login_otp' => null]);
                        $administrators = DB::table('tbl_user')
                            ->where('user_id', $superadmin->user_id)
                            ->get();
                        Session::put('superadmin', $administrators[0]);
                        // dd($admin);
                        return redirect()->intended('/superAdminDashboard')->with('administrators', $administrators[0]);
                    } else {
                        return back()->withInput($request->only('user_name', 'remember'))->with('error', "Incorrect OTP");
                    }
                } else {
                    return redirect()->back()->with('error', 'OTP not matched !');
                }
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
        return redirect('/system-login');
    }

    public function adminOtp()
    {
        return view('auth.adminOtp');
    }

    public function adminforgetPassword()
    {
        $title = array('pageTitle' => "Forgot Password");
        return view('auth.adminForgetPassword', ['title' => $title]);
    }

    public function adminforgetPasswordSendOtp(Request $request)
    {
        $validator = Validator::make(
            array(
                'email' => $request->email
            ),
            array(
                'email' => 'required'
            )
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $email = $request->email;
            $userExist = DB::table('tbl_user')
                ->where('is_delete', "=", 0)
                ->where('isActive', "=", 1)
                ->where('admin_type', "=", 1)
                ->where('user_name', '=', $email)
                ->first();

            if (isset($userExist)) {
                // $rand_otp = 1234;
                $rand_otp = mt_rand(100000, 999999);
                $userExist->otp_check = $rand_otp;

                DB::table('tbl_user')->where('user_id', $userExist->user_id)->update(['login_otp' => $rand_otp]);

                $companyDetail = DB::table('company')
                    ->select('company.*')
                    ->where('company.company_id', $userExist->company_id)
                    ->first();

                /************/
                $mailData['companyDetail'] = $companyDetail;
                $mailData['userExist'] = $userExist;
                $mailData['rand_otp'] = $rand_otp;
                $mailData['mail'] = $email;
                $myVar = new AlertController();
                $alertSetting = $myVar->adminForgotPasswordOtp($mailData);

                if ($alertSetting) {
                    Session::put('forget_pass_admin_id', $userExist->user_id);

                    return redirect('/admin-Forget-Password-otp')->with('otp_success', "An OTP has been sent to your mail address.");
                } else {
                    return redirect()->back()->with('loginError', "Some thing went wrong please try again !");
                }
            } else {
                return redirect()->back()->with('loginError', "Email address does not exist.");
            }
        }
    }

    public function adminforgetPasswordOtp()
    {
        $title = array('pageTitle' => "Forgot Password Otp");

        return view("auth.adminforgotpasswordotp", ['title' => $title]);
    }

    public function adminfPasswordOtpVerify(Request $request)
    {
        $validator = Validator::make(
            array(
                'f_pass_otp' => $request->f_pass_otp
            ),
            array(
                'f_pass_otp' => 'required'
            )
        );
        if ($validator->fails()) {
            return redirect()->back()->with('otp_error', $validator);
        } else {
            $f_pass_otp = $request->f_pass_otp;
            $admin_id = '';
            if (Session::has('forget_pass_admin_id')) {
                $admin_id = session('forget_pass_admin_id');
            } else {
                return redirect('/adminForgetPassword')->with('error', "Something went wrong please try again");
            }

            $userExist = DB::table('tbl_user')
                ->where('login_otp', '=', $f_pass_otp)
                ->where('user_id', '=', $admin_id)
                ->get();

            if (count($userExist) > 0) {
                return redirect('/admin-Forget-Password-generate')->with('up_password_success', "OTP matched. Please generate new password.");
            } else {
                return redirect()->back()->with('otp_error', "OTP does not match. Please try again.");
            }
        }
    }

    public function adminfPasswordGenerate()
    {
        $title = array('pageTitle' => "Forgot Password Otp");

        return view("auth.admin_forget_password_generate", ['title' => $title]);
    }

    public function adminfPasswordUpdate(Request $request)
    {
        $password = $request->password;
        $confirm_password = $request->confirm_password;
        $admin_id = '';
        if (Session::has('forget_pass_admin_id')) {
            $admin_id = session('forget_pass_admin_id');
        } else {
            return redirect('/adminForgetPassword')->with('error', "Something went wrong please try again");
        }

        if ($password != $confirm_password) {
            return redirect()->back()->with('up_password_error', "Confirm password not match. Please try again.")->with('user_id', $admin_id);
        } else {
            Session::forget('forget_pass_admin_id');
            $hash_pass = Hash::make($password);
            DB::table('tbl_user')
                ->where('user_id', $admin_id)
                ->update([
                    'login_otp' => null,
                    'password' => $hash_pass,
                    'password_txt' => $request->password
                ]);
            return redirect('/')->with('success', "Password has been updated.");
        }
    }

    public function supadminforgetPassword()
    {
        $title = array('pageTitle' => "Forgot Password");
        return view('web.superAdmin.supadminForgetPassword', ['title' => $title]);
    }

    public function supAdminforgetPasswordSendOtp(Request $request)
    {
        $validator = Validator::make(
            array(
                'email' => $request->email
            ),
            array(
                'email' => 'required'
            )
        );
        if ($validator->fails()) {
            return redirect()->back()->with('fp_error', $validator);
        } else {
            $email = $request->email;
            $userExist = DB::table('tbl_user')
                ->where('is_delete', "=", 0)
                ->where('isActive', "=", 1)
                ->where('admin_type', "=", 5)
                ->where('user_name', '=', $email)
                ->first();

            if (isset($userExist)) {
                // $rand_otp = 1234;
                $rand_otp = mt_rand(100000, 999999);
                $userExist->otp_check = $rand_otp;

                DB::table('tbl_user')->where('user_id', $userExist->user_id)->update(['login_otp' => $rand_otp]);

                /************/
                $mailData['userExist'] = $userExist;
                $mailData['rand_otp'] = $rand_otp;
                $mailData['mail'] = $email;
                $myVar = new AlertController();
                $alertSetting = $myVar->supAdminForgotPasswordOtp($mailData);
                if ($alertSetting) {
                    Session::put('forget_pass_supadmin_id', $userExist->user_id);

                    return redirect('/system-Forget-Password-otp')->with('otp_success', "An OTP has been sent to your mail address.");
                } else {
                    return redirect()->back()->with('fp_error', "Something went wrong");
                }
            } else {
                return redirect()->back()->with('fp_error', "Email address does not exist.");
            }
        }
    }

    public function supAdminforgetPasswordOtp()
    {
        $title = array('pageTitle' => "Forgot Password Otp");
        return view("web.superAdmin.supAdminforgotpasswordotp", ['title' => $title]);
    }

    public function supAdminfPasswordOtpVerify(Request $request)
    {
        $validator = Validator::make(
            array(
                'f_pass_otp' => $request->f_pass_otp
            ),
            array(
                'f_pass_otp' => 'required'
            )
        );
        if ($validator->fails()) {
            return redirect()->back()->with('otp_error', $validator);
        } else {
            $f_pass_otp = $request->f_pass_otp;
            $admin_id = '';
            if (Session::has('forget_pass_supadmin_id')) {
                $admin_id = session('forget_pass_supadmin_id');
            } else {
                return redirect('/systemForgetPassword')->with('error', "Something went wrong please try again");
            }

            $userExist = DB::table('tbl_user')
                ->where('login_otp', '=', $f_pass_otp)
                ->where('user_id', '=', $admin_id)
                ->get();
            if (count($userExist) > 0) {
                return redirect('/system-Forget-Password-generate')->with('up_password_success', "OTP matched. Please generate new password.");
            } else {
                return redirect()->back()->with('otp_error', "OTP does not match. Please try again.");
            }
        }
    }

    public function supAdminfPasswordGenerate(Request $request)
    {
        $title = array('pageTitle' => "Forgot Password Otp");

        return view("web.superAdmin.supAdmin_forget_password_generate", ['title' => $title]);
    }

    public function supAdminfPasswordUpdate(Request $request)
    {
        $password = $request->password;
        $confirm_password = $request->confirm_password;
        $admin_id = '';
        if (Session::has('forget_pass_supadmin_id')) {
            $admin_id = session('forget_pass_supadmin_id');
        } else {
            return redirect('/systemForgetPassword')->with('error', "Something went wrong please try again");
        }

        if ($password != $confirm_password) {
            return redirect()->back()->with('up_password_error', "Confirm password not match. Please try again.")->with('user_id', $admin_id);
        } else {
            Session::forget('forget_pass_admin_id');
            $hash_pass = Hash::make($password);
            DB::table('tbl_user')
                ->where('user_id', $admin_id)
                ->update([
                    'login_otp' => null,
                    'password' => $hash_pass,
                    'password_txt' => $request->password
                ]);
            return redirect('/system-login')->with('success', "Password has been updated.");
        }
    }
}
