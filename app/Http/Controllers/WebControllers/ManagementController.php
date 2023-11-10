<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MetricsExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ManagementController extends Controller
{
    public function management()
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Management");
            $headerTitle = "Management";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $studentList = DB::table('tbl_student')
                ->select('tbl_student.*', DB::raw("CONCAT(firstName_txt, ' ', surname_txt) AS studentName_txt"), DB::raw("IF(isCurrent_ysn = -1, 'Y', 'N') AS isCurrent_txt"))
                ->where('tbl_student.is_delete', 0)
                ->orderBy('student_id', 'DESC')
                ->get();

            $now = Carbon::now();
            $startOfMonth = $now->startOfMonth()->format('Y-m-d');
            $endOfMonth = $now->endOfMonth()->format('Y-m-d');

            $asnSubquery = DB::table('tbl_asn')
                ->selectRaw('CAST(SUM(dayPercent_dec) AS DECIMAL(9,1)) AS daysThisPeriod_dec')
                ->selectRaw('CAST(SUM((tbl_asnItem.charge_dec - tbl_asnItem.cost_dec) * dayPercent_dec) AS DECIMAL(9,2)) AS predictedGP_dec')
                ->selectRaw('COUNT(DISTINCT tbl_asn.teacher_id) AS teachersWorking_int')
                ->selectRaw('COUNT(DISTINCT tbl_asn.school_id) AS schoolsUsing_int')
                ->leftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->where('tbl_asn.status_int', 3)
                ->where('tbl_asn.company_id', $company_id)
                ->whereBetween('tbl_asnItem.asnDate_dte', [$startOfMonth, $endOfMonth])
                ->first();

            $invoiceSubquery = DB::table('tbl_invoice')
                ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualGP_dec')
                ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_school.company_id', $company_id)
                ->whereBetween('tbl_invoice.invoiceDate_dte', [$startOfMonth, $endOfMonth])
                ->first();

            $billedSubquery = DB::table('tbl_invoice')
                ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualBilled_dec')
                ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_school.company_id', $company_id)
                ->whereBetween('tbl_invoiceItem.dateFor_dte', [$startOfMonth, $endOfMonth])
                ->first();

            // $metricsDetail = DB::table(DB::raw("({$asnSubquery->toSql()}) AS t_asn"))
            //     ->mergeBindings($asnSubquery)
            //     ->join(DB::raw("({$invoiceSubquery->toSql()}) AS t_invoice"), function ($join) {
            //         $join->whereRaw('1 = 1');
            //     })
            //     ->mergeBindings($invoiceSubquery)
            //     ->join(DB::raw("({$billedSubquery->toSql()}) AS t_billed"), function ($join) {
            //         $join->whereRaw('1 = 1');
            //     })
            //     ->mergeBindings($billedSubquery)
            //     ->select([
            //         't_asn.daysThisPeriod_dec',
            //         't_asn.predictedGP_dec',
            //         't_asn.teachersWorking_int',
            //         't_asn.schoolsUsing_int',
            //         't_invoice.actualGP_dec',
            //         't_billed.actualBilled_dec',
            //     ])
            //     ->first();
            $companyDetail = DB::table('company')
                ->select('company.*')
                ->where('company.company_id', $company_id)
                ->first();

            return view("web.management.index", ['title' => $title, 'headerTitle' => $headerTitle, 'studentList' => $studentList, 'startOfMonth' => $startOfMonth, 'endOfMonth' => $endOfMonth, 'asnSubquery' => $asnSubquery, 'invoiceSubquery' => $invoiceSubquery, 'billedSubquery' => $billedSubquery, 'companyDetail' => $companyDetail]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function viewMetricsAjax(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $startOfMonth = date("Y-m-d", strtotime(str_replace('/', '-', $request->metricStartDate)));
            $endOfMonth = date("Y-m-d", strtotime(str_replace('/', '-', $request->metricEndDate)));

            $asnSubquery = DB::table('tbl_asn')
                ->selectRaw('CAST(SUM(dayPercent_dec) AS DECIMAL(9,1)) AS daysThisPeriod_dec')
                ->selectRaw('CAST(SUM((tbl_asnItem.charge_dec - tbl_asnItem.cost_dec) * dayPercent_dec) AS DECIMAL(9,2)) AS predictedGP_dec')
                ->selectRaw('COUNT(DISTINCT tbl_asn.teacher_id) AS teachersWorking_int')
                ->selectRaw('COUNT(DISTINCT tbl_asn.school_id) AS schoolsUsing_int')
                ->leftJoin('tbl_asnItem', 'tbl_asn.asn_id', '=', 'tbl_asnItem.asn_id')
                ->where('tbl_asn.status_int', 3)
                ->where('tbl_asn.company_id', $company_id)
                ->whereBetween('tbl_asnItem.asnDate_dte', [$startOfMonth, $endOfMonth])
                ->first();

            $invoiceSubquery = DB::table('tbl_invoice')
                ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualGP_dec')
                ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_school.company_id', $company_id)
                ->whereBetween('tbl_invoice.invoiceDate_dte', [$startOfMonth, $endOfMonth])
                ->first();

            $billedSubquery = DB::table('tbl_invoice')
                ->selectRaw('IFNULL(CAST(SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.charge_dec) - SUM(tbl_invoiceItem.numItems_dec * tbl_invoiceItem.cost_dec) AS DECIMAL(9,2)), 0) AS actualBilled_dec')
                ->leftJoin('tbl_invoiceItem', 'tbl_invoice.invoice_id', '=', 'tbl_invoiceItem.invoice_id')
                ->join('tbl_school', 'tbl_invoice.school_id', '=', 'tbl_school.school_id')
                ->where('tbl_school.company_id', $company_id)
                ->whereBetween('tbl_invoiceItem.dateFor_dte', [$startOfMonth, $endOfMonth])
                ->first();

            // $metricsDetail = DB::table(DB::raw("({$asnSubquery->toSql()}) AS t_asn"))
            //     ->mergeBindings($asnSubquery)
            //     ->join(DB::raw("({$invoiceSubquery->toSql()}) AS t_invoice"), function ($join) {
            //         $join->whereRaw('1 = 1');
            //     })
            //     ->mergeBindings($invoiceSubquery)
            //     ->join(DB::raw("({$billedSubquery->toSql()}) AS t_billed"), function ($join) {
            //         $join->whereRaw('1 = 1');
            //     })
            //     ->mergeBindings($billedSubquery)
            //     ->select([
            //         't_asn.daysThisPeriod_dec',
            //         't_asn.predictedGP_dec',
            //         't_asn.teachersWorking_int',
            //         't_asn.schoolsUsing_int',
            //         't_invoice.actualGP_dec',
            //         't_billed.actualBilled_dec',
            //     ])
            //     ->first();

            return response()->json(['asnSubquery' => $asnSubquery, 'invoiceSubquery' => $invoiceSubquery, 'billedSubquery' => $billedSubquery]);
        } else {
            return 'login';
        }
    }

    public function viewMetricsExport(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;
            $startOfMonth = date("Y-m-d", strtotime(str_replace('/', '-', $request->start_date)));
            $endOfMonth = date("Y-m-d", strtotime(str_replace('/', '-', $request->end_date)));

            $fileName = 'MetricsReport' . time() . '.xlsx';

            return Excel::download(new MetricsExport($company_id, $startOfMonth, $endOfMonth), $fileName);
        } else {
            return redirect()->intended('/');
        }
    }

    public function studentInsert(Request $request)
    {
        $student_id = DB::table('tbl_student')
            ->insertGetId([
                'firstName_txt' => $request->firstName_txt,
                'surname_txt' => $request->surname_txt,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);

        $studentList = DB::table('tbl_student')
            ->select('tbl_student.*', DB::raw("CONCAT(firstName_txt, ' ', surname_txt) AS studentName_txt"), DB::raw("IF(isCurrent_ysn = -1, 'Y', 'N') AS isCurrent_txt"))
            ->where('tbl_student.is_delete', 0)
            ->orderBy('student_id', 'DESC')
            ->get();

        $html = '';
        if (count($studentList) > 0) {
            foreach ($studentList as $key => $student) {
                $html .= "<tr class='school-detail-table-data selectStudentRow'
                            id='selectStudentRow$student->student_id' studentId='$student->student_id' firstName='$student->firstName_txt' surname='$student->surname_txt' isCurrent='$student->isCurrent_ysn'>
                            <td>$student->studentName_txt</td>
                            <td>$student->isCurrent_txt</td>
                        </tr>";
            }
        }

        return response()->json(['html' => $html]);
    }

    public function studentUpdate(Request $request)
    {
        $isCurrent_ysn = 0;
        if ($request->isCurrent_ysn) {
            $isCurrent_ysn = -1;
        }
        DB::table('tbl_student')
            ->where('student_id', $request->student_id)
            ->update([
                'firstName_txt' => $request->firstName_txt,
                'surname_txt' => $request->surname_txt,
                'isCurrent_ysn' => $isCurrent_ysn
            ]);

        $studentList = DB::table('tbl_student')
            ->select('tbl_student.*', DB::raw("CONCAT(firstName_txt, ' ', surname_txt) AS studentName_txt"), DB::raw("IF(isCurrent_ysn = -1, 'Y', 'N') AS isCurrent_txt"))
            ->where('tbl_student.is_delete', 0)
            ->orderBy('student_id', 'DESC')
            ->get();

        $html = '';
        if (count($studentList) > 0) {
            foreach ($studentList as $key => $student) {
                $html .= "<tr class='school-detail-table-data selectStudentRow'
                            id='selectStudentRow$student->student_id' studentId='$student->student_id' firstName='$student->firstName_txt' surname='$student->surname_txt' isCurrent='$student->isCurrent_ysn'>
                            <td>$student->studentName_txt</td>
                            <td>$student->isCurrent_txt</td>
                        </tr>";
            }
        }

        return response()->json(['html' => $html]);
    }

    public function studentDelete(Request $request)
    {
        DB::table('tbl_student')
            ->where('student_id', $request->studentId)
            ->update([
                'is_delete' => 1
            ]);

        $studentList = DB::table('tbl_student')
            ->select('tbl_student.*', DB::raw("CONCAT(firstName_txt, ' ', surname_txt) AS studentName_txt"), DB::raw("IF(isCurrent_ysn = -1, 'Y', 'N') AS isCurrent_txt"))
            ->where('tbl_student.is_delete', 0)
            ->orderBy('student_id', 'DESC')
            ->get();

        $html = '';
        if (count($studentList) > 0) {
            foreach ($studentList as $key => $student) {
                $html .= "<tr class='school-detail-table-data selectStudentRow'
                            id='selectStudentRow$student->student_id' studentId='$student->student_id' firstName='$student->firstName_txt' surname='$student->surname_txt' isCurrent='$student->isCurrent_ysn'>
                            <td>$student->studentName_txt</td>
                            <td>$student->isCurrent_txt</td>
                        </tr>";
            }
        }

        return response()->json(['html' => $html]);
    }

    public function managementUser()
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Management User";

        return view("web.management.user", ['title' => $title, 'headerTitle' => $headerTitle]);
    }

    public function managementMailshot()
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Management Mailshot";

        return view("web.management.mailshot", ['title' => $title, 'headerTitle' => $headerTitle]);
    }

    public function adminUsers()
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $title = array('pageTitle' => "Management");
            $headerTitle = "Management";
            $company_id = $webUserLoginData->company_id;
            $user_id = $webUserLoginData->user_id;

            $userAdmins = DB::table("tbl_user")
                ->where('company_id', $company_id)
                ->where('admin_type', '=', 1)
                ->get();

            return view("web.management.adminUsers", ['title' => $title, 'headerTitle' => $headerTitle, 'userAdmins' => $userAdmins]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function InsertAdminUsers(Request $request)
    {
        $request->validate([
            'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'admin_email' => 'required|unique:tbl_user,user_name'
        ]);

        $image = $request->file('profileImage');
        $extension = $image->extension();
        $file_name = mt_rand(100000, 999999);
        $rand = mt_rand(100000, 999999);
        $filename = time() . "_" . $rand . "_" . $file_name . '.' . $extension;
        $image->move(public_path('images/userimages'), $filename);

        $webUserLoginData = Session::get('webUserLoginData');

        $adminUserId = DB::table('tbl_user')
            ->insertGetId([
                'company_id' => $webUserLoginData->company_id,
                'admin_type' => 1,
                'firstName_txt' => $request->admin_firstName,
                'surname_txt' => $request->admin_surName,
                'password' => Hash::make($request->admin_password),
                'password_txt' => $request->admin_password,
                'user_name' => $request->admin_username,
                'profileImage' => $filename,
                'profileImageLocation_txt' => 'images/userimages',
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        // return response()->json(['status' => 'success']);
        $companyDetail = DB::table('company')
            ->select('company.*')
            ->where('company.company_id', $webUserLoginData->company_id)
            ->first();

        if ($request->admin_username && $request->admin_password) {
            $mailData['companyDetail'] = $companyDetail;
            $mailData['firstName_txt'] = $request->admin_firstName;
            $mailData['surname_txt'] = $request->admin_surName;
            $mailData['mail'] = $request->admin_username;
            $mailData['password'] = $request->admin_password;
            $myVar = new AlertController();
            $myVar->adminUserAddMail($mailData);
        }

        return redirect('/adminUsers');
    }

    public function getAdminUser(Request $request)
    {
        $user_id = $request->adminId;

        $user = DB::table('tbl_user')->where('user_id', $user_id)->first();
        $imagePath = public_path($user->profileImageLocation_txt . '/' . $user->profileImage);
        if ($user->profileImage != '') {
            if (File::exists($imagePath)) {
                $image = asset($user->profileImageLocation_txt . '/' . $user->profileImage);
            } else {
                $image = '';
            }
        } else {
            $image = '';
        }


        return response()->json(['userAdmin' => $user,'image' => $image]);
    }

    public function updateAdminUsers(Request $request)
    {
        $request->validate([
            'edit_profileImage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $webUserLoginData = Session::get('webUserLoginData');
        $adminUser = DB::table('tbl_user')->where('user_id', $request->adminUserId)->first();

        $password = '';
        if ($request->edit_admin_password) {
            $password = $request->edit_admin_password;
        } else {
            $password = $adminUser->password_txt;
        }

        if ($request->file('edit_profileImage')) {
            $imagePath = public_path($adminUser->profileImageLocation_txt . '/' . $adminUser->profileImage);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $image = $request->file('edit_profileImage');
            $extension = $image->extension();
            $file_name = mt_rand(100000, 999999);
            $rand = mt_rand(100000, 999999);
            $filename = time() . "_" . $rand . "_" . $file_name . '.' . $extension;
            $image->move(public_path('images/userimages'), $filename);
        } else {
            $filename = $request->old_image;
        }

        $user = DB::table('tbl_user')
            ->where('user_id', $request->adminUserId)
            ->update([
                'firstName_txt' => $request->edit_admin_firstName,
                'surname_txt' => $request->edit_admin_surName,
                'password' => Hash::make($password),
                'password_txt' => $password,
                'user_name' => $request->edit_admin_username,
                'profileImageLocation_txt' => 'images/userimages',
                'profileImage' => $filename,
            ]);

        return redirect('/adminUsers');
    }

    public function companyDetailsEdit()
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Management";
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $company = DB::table('company')->where('company_id', $company_id)->first();
            // dd($company);
            return view('web.management.company_details_edit', ['title' => $title, 'headerTitle' => $headerTitle, 'company' => $company]);
        } else {
            return redirect()->intended('/');
        }
    }

    public function updateCompanyDetails(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');

        if ($webUserLoginData) {
            $company_id = $webUserLoginData->company_id;
            $company = DB::table('company')->where('company_id', $company_id)->first();

            if ($request->file('company_logo')) {

                if (File::exists(public_path($company->company_logo))) {
                    File::delete(public_path($company->company_logo));
                }
                $image = $request->file('company_logo');
                $extension = $image->extension();
                $file_name = mt_rand(100000, 999999);
                $rand = mt_rand(100000, 999999);
                $filename = time() . "_" . $rand . "_" . $file_name . '.' . $extension;
                $image->move(public_path('web/company_logo'), $filename);
            } else {
                $filename = $company->company_logo;
            }
            DB::table('company')
                ->where('company_id', $company_id)
                ->update([
                    'company_phone' => $request->company_phone,
                    'company_logo' => $filename,
                    'vat_registration' => $request->vat_registration,
                    'address1_txt' => $request->address1_txt,
                    'address2_txt' => $request->address2_txt,
                    'address3_txt' => $request->address3_txt,
                    'address4_txt' => $request->address4_txt,
                    'postcode_txt' => $request->postcode_txt,
                ]);
            return redirect('/management');
        } else {
            return redirect()->intended('/');
        }
    }

    public function deleteAdminUsers(Request $request)
    {
        $webUserLoginData = Session::get('webUserLoginData');
        if ($webUserLoginData) {
            DB::table('tbl_user')->where('user_id', $request->adminId)->delete();
            return redirect('/adminUsers');
        } else {
            return redirect()->intended('/');
        }
    }

    public function checkAdminUserMailExist(Request $request)
    {
        $loginMail = $request->loginMail;
        if (isset($request->adminUserId)) {
            $count = DB::table('tbl_user')
                ->select('tbl_user.*')
                ->where('user_name', $loginMail)
                ->where('user_id', '!=', $request->adminUserId)
                ->get();
            if (count($count) > 0) {
                return "Yes";
            } else {
                return "No";
            }
        } else {
            $count = DB::table('tbl_user')
                ->select('tbl_user.*')
                ->where('user_name', $loginMail)
                ->get();
            if (count($count) > 0) {
                return "Yes";
            } else {
                return "No";
            }
        }

    }


}
